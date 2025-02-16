<?php
session_start();

// autoload
require_once "autoload.php";


$page = $_GET["page"] ?? "login" ;



$routes = [
    "Edit" => "Controller/Edit.php",
    "import" => "Config/import.php",
    "Login" => "Controller/Login.php",
    "Register" => "Controller/Register.php",
    "SearchChat" => "Controller/SearchChat.php",
    "Message" => "Controller/Message.php",
    "Redirect" => "Helper/Redirect.php",
    "GenericModel" => "Model/GenericModel.php",
    "InsertRow" => "Model/InsertRow.php",
    "account" => "View/content/account.php",
    "chat" => "View/content/chat.php",
    "search_chat" => "View/content/search_chat.php",
    "search" => "View/content/search.php",
    "login" => "View/login.php",
    "register" => "View/register.php",
    "test" => "test.php",
    
];


if (array_key_exists($page, $routes)):?>
    <?php require_once $routes[$page];

else: ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 error</title>

        <link rel="stylesheet" href="View/css/global/main.css">
        <link rel="stylesheet" href="View/css/global/responsive.css">
    </head>
    <body>
        <img src="View/assets/404.png" alt="404">
    </body>
    </html>
<?php endif;?>
