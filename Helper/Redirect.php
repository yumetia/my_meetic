<?php 


class Redirect extends GenericModel{

    public function redirectPath($path){
        header("Location: $path");
        exit;
    }
    public function logout($path){
        // need path in parameter because path is relative
        session_unset();
        session_destroy();

        $this->redirectPath($path);
    }

    public function disableAcc($path,$id_user){
        $request = "UPDATE user SET is_deleted='1' where user.id_user = '$id_user'";
        $stmt = $this->database->prepare($request);
        $stmt->execute();

        $this->logout($path);
    }
}

if(isset($_POST["logout"])){
    $_SESSION["LOGGED_USER"]=false;
    $logout = new Redirect();
    $logout->logout("index.php?page=login");


}
if(isset($_POST["deleteAcc"])){
    
    $disableAcc = new Redirect();
    $disableAcc->disableAcc("index.php?page=login",$_SESSION["user_id"]);
}