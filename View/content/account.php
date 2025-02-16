<?php

if (!isset($_SESSION["LOGGED_USER"])){
    (new Redirect)->logout("index.php?page=login");
}

$id_user = new Edit();
$id_user = $id_user->getIdUser($_SESSION["user_email"]); 
$_SESSION["user_id"] = $id_user;



$loisir = new GenericModel();
$loisir = $loisir->getRowLike("loisirs","id_loisir",$id_user);
$_SESSION["user_hobbies"] = $loisir["nom_loisir"];

// reset password edit 

$password = (new GenericModel)->getRow("user","email",$_SESSION["user_email"]);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="View/css/components/header.css">
    <link rel="stylesheet" href="View/css/components/footer.css">
    
    <link rel="stylesheet" href="View/css/global/main.css">
    <link rel="stylesheet" href="View/css/global/responsive.css">

    <link rel="stylesheet" href="View/css/pages/account.css">

    <title>Mon compte</title>
    <script src="View/js/pages/editInfos.js" defer></script>

</head>
<body>
    <?php echo (new HtmlHelper())->renderHeader();?>

    <!-- birthdate and gender error handle container -->

    <?php if (
    isset($_SESSION["wrong_email"]) ||
    isset($_SESSION["wrong_password"]) ||
    isset($_SESSION["wrong_gender"]) ||
    isset($_SESSION["wrong_birthdate"])): ?>
    <div class="wrong-editInfos__container">
        <h3>Type d'informations incorrect !</h3>
        <p>
            <?= $_SESSION["wrong_email"] 
                ?? $_SESSION["wrong_password"]
                ?? $_SESSION["wrong_gender"]
                ?? $_SESSION["wrong_birthdate"]; ?>
        </p>
    </div>
    <?php
        unset($_SESSION["wrong_email"]);
        unset($_SESSION["wrong_password"]);
        unset($_SESSION["wrong_gender"]);
        unset($_SESSION["wrong_birthdate"]);
    ?>
    <?php endif; ?>


        <!-- --------------------------------- -->

    <div class="account-container">
        <header>
            <div class="pp-user__container">

                <!-- search in db if the user has already a pp  -->
                 <?php $row = new GenericModel();

                 $row = $row->getRow("user","id_user",$_SESSION["user_id"]);
                 if ($row){
                    if ($row["profile_image"]){
                        $_SESSION["user_imgName"] = "custom_image.png";
                        $imgName = $_SESSION["user_imgName"];
                        file_put_contents("View/assets/$imgName",$row["profile_image"]);
                    }
                    else {
                       // check if its a women or men to display
                       // corresponding pp
                       $gender = $_SESSION["user_gender"];
                       if (strtolower($gender)=="femme"){
                            $imgDefault = "woman_default.png";
                        } elseif(strtolower($gender)=="homme"){
                           $imgDefault = "man_default.png";
                        } else {
                            $imgDefault = "neutral_avatar.png";
                        }
                    }
                 }

                 ?>

                <?php if (isset($_SESSION["user_imgName"])):?>
            
                    <img class="pp_user" src="View/assets/<?=$imgName;?>" alt="custom profile">
                <?php else: ?>
                
                <img class="pp_user" src="View/assets/<?= $imgDefault;?>" alt="default profile">
                <?php endif;?>
                <div class="pp-user__edit">
                </div>

    
                <h2>Bienvenue, <?php echo $_SESSION["user_firstname"] . " " . $_SESSION["user_lastname"]; ?></h2>
            </div>

            <?php echo (new HtmlHelper())->renderLogoutForm();?>

        </header>
        <section class="profile-info">
            <p>
                <strong>Email:</strong>
                <span id="user_email"><?php echo $_SESSION["user_email"]; ?></span>
                <button class="edit-btn" data-field="email">Edit</button>
            </p>
            <p>
                <strong>Mot de passe:</strong>
                <span id="user_mot_de_passe"><?php echo str_repeat("*", strlen($_SESSION["user_password"])); ?></span>
                <button class="edit-btn" data-field="mot_de_passe">Edit</button>
            </p>
            <p>
                <strong>Ville:</strong>
                <span id="user_ville"><?php echo $_SESSION["user_city"]; ?></span>
                <button class="edit-btn" data-field="ville">Edit</button>
            </p>
            <p>
                <strong>Genre:</strong>
                <span id="user_genre"><?php echo $_SESSION["user_gender"]; ?></span>
                <button class="edit-btn" data-field="genre">Edit</button>
            </p>
            <p>
                <strong>Date de naissance:</strong>
                <span id="user_date_naissance"><?php echo $_SESSION["user_birthdate"]; ?></span>
                <button class="edit-btn" data-field="date_naissance">Edit</button>
            </p>
            <p>
                <strong>Loisirs:</strong>
                <span id="user_nom_loisir"><?php echo $_SESSION["user_hobbies"]; ?></span>
                <button class="edit-btn" data-field="nom_loisir">Edit</button>
            </p>
        </section>

        <section class="search-users">
            <button onclick="window.location.href='index?page=search'" class="search-button">Rechercher d'autres utilisateurs</button>
        </section>
    </div>
<!-- footer -->
 <?php echo (new HtmlHelper())->renderFooter(); ?>
</body>
</html>
