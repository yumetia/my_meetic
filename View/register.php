<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="View/css/global/main.css">
    <link rel="stylesheet" href="View/css/global/responsive.css">

    <link rel="stylesheet" href="View/css/pages/auth.css">


    <title>Inscription</title>
    <script src="View/js/pages/register.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <form id="registerForm">
            
            <input id="lastname" type="text" name="lastname" placeholder="Nom" required>
            <input id="firstname" type="text" name="firstname" placeholder="Prenom" required>

            <input type="date" name="birthdate" id="birthdate" required placeholder="birthdate">
            <input id="city" type="text" placeholder="Ville">

            <input type="email" name="email" placeholder="Email" required>

            <input id="pswd" type="password" name="password" placeholder="Mot de passe" required>
            <input id="pswdc" type="password" name="passwordConfirm" placeholder="Confirmez votre mot de passe" required>
            
            <select name="gender" required>
                <option value="" disabled selected>Genre</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
            </select>

            <input id="hobbies" type="text" placeholder="Loisirs (au moins un)">
            <button type="submit">S'inscrire</button>

        </form>
        <p>Deja un compte ? <strong><a href="index?page=login" style="color:green;">Connecte toi ici !</a></strong></p>
    </div>
</body>
</html>
