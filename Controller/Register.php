<?php

$data = json_decode(file_get_contents("php://input"), true);



class Register extends InsertRow {
    
    public function does_user_exist($email) {
        $row = $this->getRow("user", "email", $email);
        return is_array($row); 
    }

    public function add_user_to_db($firstname,$lastname,$birthdate,$city,$email, $password, $gender,$hobbies) {

        if ($this->does_user_exist($email)) {
            echo json_encode(["status" => "error", "message" => "User already exists"]);
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // loisirs 

        $this->addRow([
            "table"=>"loisirs",
            "nom_loisir"=>$hobbies
        ]);

       
        // looping to search immediately the hobbie
        $row = $this->getRowLike("loisirs","nom_loisir",$hobbies);
        
        $_SESSION["user_hobbies"] = $row;

        $this->addRow([
            "table"=>"user",
            "prenom"=>$firstname,
            "nom"=>$lastname,
            "date_naissance"=>$birthdate,
            "ville"=>$city,
            "email" => $email,
            "mot_de_passe" => $hashedPassword,
            "genre" => $gender,
        ]);

      
        echo json_encode(["status" => "success", "message" => "User registered"]);

        $_SESSION["user_firstname"]=$firstname;
        $_SESSION["user_lastname"]=$lastname;

        $_SESSION["user_birthdate"]=$birthdate;
        $_SESSION["user_city"]=$city;

        $_SESSION["user_email"]=$email;
        $_SESSION["user_password"]=$password;
        $_SESSION["user_hPassword"]=$hashedPassword;
        $_SESSION["user_gender"]=$gender;
        $_SESSION["user_hobbies"]=$hobbies;



        
        $_SESSION["LOGGED_USER"]=true;
    }
}


$register = new Register();
$register->add_user_to_db(
    $data["firstname"], 
    $data["lastname"], 
    $data["birthdate"], 
    $data["city"], 
    $data["email"], 
    $data["password"], 
    $data["gender"],
    $data["hobbies"]
);
