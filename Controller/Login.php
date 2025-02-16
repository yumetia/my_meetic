<?php 


class Login extends GenericModel{

    public function checkUser(){
                $email = $_POST["email"];
                $password = htmlspecialchars($_POST["password"]);

                $user_row = $this->getRow("user","email",$email,"prenom,nom,date_naissance,genre,ville,email,mot_de_passe,is_deleted");
                

                $redirect = new Redirect();
                if (is_array($user_row)&&$user_row["email"]===$email&&password_verify($password,$user_row["mot_de_passe"])){
                    // deleted ?
                    if ($user_row["is_deleted"]==0){

                    
                        // connected

                        $firstname = $user_row["prenom"];
                        $lastname = $user_row["nom"];

                        $birthdate = $user_row["date_naissance"];
                        $gender = $user_row["genre"];

                        $city = $user_row["ville"];



                    
                        $_SESSION["user_firstname"]=$firstname;
                        $_SESSION["user_lastname"]=$lastname;

                        $_SESSION["user_birthdate"]=$birthdate;
                        $_SESSION["user_city"]=$city;

                        $_SESSION["user_email"]=$email;
                        $_SESSION["user_password"]=$password;
                        $_SESSION["user_gender"]=$gender;


                        
                        $_SESSION["LOGGED_USER"]=true;

                        $redirect->redirectPath("index.php?page=account");

                    } else {
                        $_SESSION["wrong_infos"] = "<strong style='color:red;'>Account deleted !</strong> <br>$email" ;
                        $redirect->redirectPath("index.php?page=login");
                    }
                } 

                    
                $_SESSION["wrong_infos"] = "<strong style='color:red;'>Please enter correct informations :</strong> <br>$email" ;   
                $redirect->redirectPath("index.php?page=login");

                
            }
    }

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $login = new Login();
    $login = $login->checkUser();
} 
