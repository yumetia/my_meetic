

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="View/css/global/main.css">
    <link rel="stylesheet" href="View/css/global/responsive.css">

    <link rel="stylesheet" href="View/css/pages/auth.css">

    <title>Connexion</title>

</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <p>
        <?php if (isset($_SESSION["wrong_infos"])){
            echo $_SESSION["wrong_infos"];
            session_destroy();
        }
        ?>
        </p>
        
        <form id="loginForm" method="post" action="index.php?page=Login">
            <input type="email" name="email" placeholder="Votre email" required>
            <input type="password" name="password" placeholder="Votre mot de passe" required>
            <button >Se connecter</button>
        </form>
        <p>Pas de compte ? <strong><a href="index.php?page=register" style="color:green;">Inscrit-toi ici !</a></strong></p>

    </div>
    
</body>
</html>
