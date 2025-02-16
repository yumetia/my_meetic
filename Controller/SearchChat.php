<?php

class SearchChat extends GenericModel{
    public function search_users($email) {

        $sql = "SELECT email FROM user WHERE email LIKE :email";
        $stmt = $this->database->prepare($sql);
        $stmt->execute(["email" => "%$email%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");

    $search = new SearchChat();
    $users = $search->search_users($email); 

    if (!empty($users)) {
        echo json_encode(["success" => true, "data" => $users]);
    } else {
        echo json_encode(["success" => false, "data" => []]);
    }
    exit;
}

// help debugg
echo json_encode(["success" => false, "data" => []]);
