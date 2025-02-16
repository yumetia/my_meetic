<?php 


if (!isset($_SESSION["LOGGED_USER"])) {
    (new Redirect)->logout("index.php?page=login");
}

$contactEmail = urldecode($_GET["contact"]);
// check if the contactEmail is correct

$getContactInfos = (new GenericModel)->getRow("user","email",$contactEmail);
if (!$getContactInfos){
    (new Redirect())->redirectPath("index.php?page=search_chat");

}

if ((!isset($_GET["contact"]) || empty($_GET["contact"])) && 
( !isset($_SERVER["CONTENT_TYPE"]) || stripos($_SERVER["CONTENT_TYPE"], "application/json") === false )) {
    (new Redirect())->redirectPath("index.php?page=search_chat");
}

$senderEmail = $_SESSION["user_email"];

// for ajax delete feature, I need to save these datas in Session
// to use it in other files
$_SESSION["contact_email"] = $contactEmail;

$contact = new GenericModel();
$contact = $contact->getRow("user", "email", $contactEmail);

$conv = new GenericModel();
$conv = $conv->getRowParticular(
    "message",
    "(sender_email",
    "'$senderEmail' or sender_email = '$contactEmail') and (recipient_email= '$senderEmail' or recipient_email = '$contactEmail')",
    "id_message,sender_email,date,content,is_deleted"
);

$data = json_decode(file_get_contents("php://input"),true);

if (isset($data["toggle"])){
    (new Message)->displayDltMessage($conv,$senderEmail);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Chat avec <?= htmlspecialchars($contactEmail) ?></title>
    
    <link rel="stylesheet" href="View/css/components/header.css">
    <link rel="stylesheet" href="View/css/components/footer.css">

    <link rel="stylesheet" href="View/css/global/main.css">
    <link rel="stylesheet" href="View/css/global/responsive.css">

    <link rel="stylesheet" href="View/css/pages/chat.css">

    <script src="View/js/pages/chat.js" defer></script>

    <script src="View/js/components/toggleChannel.js" defer></script>

</head>
<body>

<?php echo (new HtmlHelper())->renderHeader((new HtmlHelper)->renderLogoutButton());?>

    <span id="sender-email" style="display:none;"><?= $_SESSION["user_email"]; ?></span>
    
    <div class="chat-container__block">

        <div class="menu-chat__block">
            <div class="menu-chat__container">

                <div class="menu__navbar">
                    <span class="state-show">
                        <!--  -->
                    </span>
                    <div class="menu__list">
                        <p class="menu__item">Messages</p>
                    </div>
                </div>
                
                <div class="menu__navbar">
                    <span class="state">
                        <!--  -->
                    </span>
                    <div class="menu__list" id="deleted-msg">
                        <p class="menu__item">Deleted Messages</p>
                    </div>
                </div>
                <!-- ... -->

            </div>
        </div>

        <div class="container">
            <h2>Chat avec <span id="email_recipient"><?= htmlspecialchars($contactEmail) ?></span></h2>
            <div id="chat-box">
                
                <?php
                    (new Message)->displayMessage($conv,$senderEmail,$contactEmail);
                ?>
                
            </div>
            <div class="show-deleted-msg">

            </div>

            <form id="send-message">
                <input type="hidden" value="<?= $_SESSION["user_email"] ?>">
                <input type="text" id="message" placeholder="Écris un message..." autofocus>
                <button id="submit">Envoyer</button>
            </form>

        </div>

    </div>
<!-- footer -->
<?php echo (new HtmlHelper())->renderFooter(); ?>

</body>
</html>
