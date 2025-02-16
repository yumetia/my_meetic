<?php 


class Edit extends InsertRow {
    
    // get id_user and return it 
    public function getIdUser($email){
        $row = $this->getRow("user","email",$email);
        if ($row){
            return $row["id_user"];
        } 
        return false;
    }
    
    public function setInfoUser($table,$column,$value,$id){

        if ($table == "user"){
            $id_user = ":id_user";
            $request = "UPDATE $table SET `$column` = '$value' WHERE `user`.`id_user` = :id_user";
        } else {
            $id_loisir = ":id_loisir";
            $request = "UPDATE $table SET `$column` = '$value' WHERE `loisirs`.`id_loisir` = :id_loisir";
        }
        $stmt = $this->database->prepare($request);
        $stmt ->bindParam($id_user??$id_loisir,$id,PDO::PARAM_INT);
        $stmt->execute();
        $this->updateInfoUser($table,$column,$value);
    }
    
    public function updateInfoUser($table, $column, $value) {

        if ($table === "user") {
            $user_row = $this->getRow($table, "id_user", $_SESSION["user_id"]);
        } elseif ($table === "loisirs") {
            $user_row = $this->getRow($table, "id_loisir", $_SESSION["user_id"]);
        } else {
            
            return null;
        }
        
        if ($user_row) {
            if ($table === "user") {
                $_SESSION["user_firstname"] = $user_row["prenom"];
                $_SESSION["user_lastname"]  = $user_row["nom"];
                $_SESSION["user_birthdate"] = $user_row["date_naissance"];
                $_SESSION["user_city"]      = $user_row["ville"];
                $_SESSION["user_email"]     = $user_row["email"];
                $_SESSION["user_gender"]    = $user_row["genre"];

            } elseif ($table === "loisirs") {
                $_SESSION["user_hobbies"]   = $user_row["nom_loisir"];
            }
        }
        
        return $user_row;
    }
    

    public function saveImgInfos(){
        
        if(empty($_FILES["profile_image"]["tmp_name"])){
            $fileContent=false;
        } else{
            $fileContent = file_get_contents($_FILES["profile_image"]["tmp_name"]);
        }

        if(!$fileContent){
            $this->updateColumn("user","profile_image",null,"id_user",$_SESSION["user_id"]);
            unlink("View/assets/custom_image.png");
            return false;
        }
        $this->updateColumn("user","profile_image",$fileContent,"id_user",$_SESSION["user_id"]);
        return true;
    }

    public function updateImgInfos(){
        if ($this->saveImgInfos){
            $row = $this->getRow("user","id_user",$_SESSION["user_id"]);
    
            $img = $row["profile_image"];
            $imgName = "custom_image.png";
    
            file_put_contents("View/assets/$imgName",$img);
    
            // put in session 
            $_SESSION["user_imgName"] = $imgName;
            return true;
        }
        unset($_SESSION["user_imgName"]);
        
    }


    
    
}

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    empty($_FILES) &&
    !empty($_POST) && 
    ( !isset($_SERVER["CONTENT_TYPE"]) || stripos($_SERVER["CONTENT_TYPE"], "application/json") === false )
){

    $keys = array_keys($_POST);
    
    $column = $keys[1];

    $pValue = $_POST[$keys[0]];
    $value = $_POST[$keys[1]];
  

    // wrong email
    if($column=="email"){
        $checkEmail = (new CheckInfos())->isValidEmail($value);
        if(!$checkEmail){
            $_SESSION["wrong_email"] = htmlspecialchars($value);
            (new Redirect() )->RedirectPath("index.php?page=account");
        }
    }
    // wrong password
    if($column=="mot_de_passe"){
        $checkPassword = (new CheckInfos())->isValidPassword($value);
        if(!$checkPassword){
            $_SESSION["wrong_password"] = htmlspecialchars($value);
            (new Redirect() )->RedirectPath("index.php?page=account");
        }
    }
    // wrong birthdate
    if($column=="date_naissance"){
        $checkBirthdate = (new CheckInfos())->isValidDate($value);
        if(!$checkBirthdate){
            $_SESSION["wrong_birthdate"] = htmlspecialchars($value);
            (new Redirect() )->RedirectPath("index.php?page=account");
        }
    }
    
    // wrong gender
    if($column=="genre"){
        $checkGender = (new CheckInfos())->isValidGender($column,$value);
        if(!$checkGender){
            $_SESSION["wrong_gender"] = htmlspecialchars($value);
            (new Redirect() )->RedirectPath("index.php?page=account");
        }
    }
    

    if ($column=="mot_de_passe"){
        $_SESSION["user_password"] = $value;
        $value = password_hash($value,PASSWORD_BCRYPT);
    }
    $id = $_SESSION["user_id"];
    
    if($column=="nom_loisir"){
        $table = "loisirs";
    } else {
        $table="user";
    }
    
    
    $update = new Edit();
    $update->setInfoUser($table,$column,$value,$id);

    
    
    
    (new Redirect() )->RedirectPath("index.php?page=account");
    
    
} else {
    if ($_FILES){
        (new Edit() )->saveImgInfos();
       
        (new Edit() )->updateImgInfos();
        (new Redirect() )->RedirectPath("index.php?page=account");
        
    }
}
