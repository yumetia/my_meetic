<?php

class Search extends GenericModel {
    public function searchUser(){
        $users = [];
        $searched = false;
        $id_user = $_SESSION["user_id"];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $searched  = true;
            $gender    = $_POST["gender"] ?? "";
            $city      = $_POST["city"] ?? "";
            $age_range = $_POST["age_range"] ?? "";
            $loisirs   = $_POST["loisirs"] ?? "";

            $query  = "SELECT user.*, loisirs.nom_loisir 
                       FROM user 
                       LEFT JOIN loisirs ON user.id_user = loisirs.id_loisir 
                       WHERE 1=1 AND user.id_user != $id_user";
            $params = [];

            $this->applyGenderFilter($gender, $query, $params);
            $this->applyCityFilter($city, $query, $params);
            $this->applyAgeFilter($age_range, $query);
            $this->applyLoisirsFilter($loisirs, $query, $params);

            $stmt = $this->database->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query  = "SELECT user.*, loisirs.nom_loisir 
                       FROM user
                       LEFT JOIN loisirs ON user.id_user = loisirs.id_loisir 
                       WHERE user.id_user != :id_user";
            $params = [":id_user" => $id_user];
            $stmt = $this->database->prepare($query);
            $stmt->execute($params);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [$users, $searched];
    }

    private function applyGenderFilter($gender, &$query, &$params) {
        if ($gender) {
            $query .= " AND genre = :gender";
            $params[":gender"] = $gender;
        }
    }

    private function applyCityFilter($city, &$query, &$params) {
        if ($city) {
            $cities = array_filter(array_map('trim', explode(',', $city)));
            if (!empty($cities)) {
                $cityClause = [];
                foreach ($cities as $index => $c) {
                    $paramName = ":city_$index";
                    $cityClause[] = "ville LIKE " . $paramName;
                    $params[$paramName] = "%" . $c . "%";
                }
                $query .= " AND (" . implode(" OR ", $cityClause) . ")";
            }
        }
    }

    private function applyAgeFilter($age_range, &$query) {
        if ($age_range) {
            $ageRanges = [
                "18-25" => "date_naissance BETWEEN DATE_SUB(CURDATE(), INTERVAL 25 YEAR) AND DATE_SUB(CURDATE(), INTERVAL 18 YEAR)",
                "25-35" => "date_naissance BETWEEN DATE_SUB(CURDATE(), INTERVAL 35 YEAR) AND DATE_SUB(CURDATE(), INTERVAL 25 YEAR)",
                "35-45" => "date_naissance BETWEEN DATE_SUB(CURDATE(), INTERVAL 45 YEAR) AND DATE_SUB(CURDATE(), INTERVAL 35 YEAR)",
                "45+"   => "date_naissance < DATE_SUB(CURDATE(), INTERVAL 45 YEAR)"
            ];
            if (isset($ageRanges[$age_range])) {
                $query .= " AND " . $ageRanges[$age_range];
            }
        }
    }

    private function applyLoisirsFilter($loisirs, &$query, &$params) {
        if ($loisirs) {
            $query .= " AND loisirs.nom_loisir LIKE :loisirs";
            $params[":loisirs"] = "%" . $loisirs . "%";
        }
    }
}
