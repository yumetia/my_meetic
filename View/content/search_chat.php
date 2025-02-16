<?php 

if (!isset($_SESSION["LOGGED_USER"])){
    (new Redirect)->logout("index.php?page=login");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recherche de contact</title>
    
    <link rel="stylesheet" href="View/css/components/header.css">
    <link rel="stylesheet" href="View/css/components/footer.css">
    
    <link rel="stylesheet" href="View/css/global/main.css">
    <link rel="stylesheet" href="View/css/global/responsive.css">

    <link rel="stylesheet" href="View/css/pages/chat.css">
    
    <script src="View/js/pages/search_chat.js" defer></script>
</head>
<body>
<?php echo (new HtmlHelper())->renderHeader((new HtmlHelper)->renderLogoutButton());?>


    <div class="container">
        <label for="search_email">Rechercher par email :</label>
        <input type="text" id="search_email" autofocus>
        <ul id="results"></ul>
    </div>
<!-- footer -->
<?php echo (new HtmlHelper())->renderFooter(); ?>

</body>
</html>
