<?php

if (!isset($_SESSION["LOGGED_USER"])) {
    (new Redirect())->logout("index.php?page=login");
}
$search = new Search();
list($users, $searched) = $search->searchUser();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'utilisateurs</title>
    
    <link rel="stylesheet" href="View/css/components/header.css">
    <link rel="stylesheet" href="View/css/components/footer.css">
    <link rel="stylesheet" href="View/css/components/carousel.css">
    
    <link rel="stylesheet" href="View/css/global/main.css">
    <link rel="stylesheet" href="View/css/global/responsive.css">
    
    <link rel="stylesheet" href="View/css/pages/account.css">
    <link rel="stylesheet" href="View/css/pages/search.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>
    
    <script src="View/js/components/carousel.js" defer></script>
</head>
<body>
    <?php echo (new HtmlHelper())->renderHeader((new HtmlHelper)->renderLogoutButton());?>

    <div class="search-container">
        <h2>Rechercher d'autres utilisateurs</h2>

        <!-- Search bar container -->
        <div class="search-bar-wrapper">
            <form method="POST" class="search-bar">
                <select name="gender">
                    <option value="">Genre</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                    <option value="Autre">Autre</option>
                </select>
                <input type="text" name="city" placeholder="Ville (ex: Paris, Lyon)">
                
                <select name="age_range">
                    <option value="">Tranche d'âge</option>
                    <option value="18-25">18-25 ans</option>
                    <option value="25-35">25-35 ans</option>
                    <option value="35-45">35-45 ans</option>
                    <option value="45+">45 ans et plus</option>
                </select>
                
                <input type="text" name="loisirs" placeholder="Loisirs (ex: Sport, Cinéma)">
                <button type="submit">Rechercher</button>
            </form>
        </div>

        <!-- Large Carousel with Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $index => $user) : ?>
                        <div class="swiper-slide">
                            <div class="slide-image">
                                <?php if ($user["profile_image"]): ?>
                                    <img src="data:image/png;base64,<?= base64_encode($user['profile_image']); ?>" alt="custom profile">
                                <?php elseif (strtolower($user["genre"]) == "homme"): ?>
                                    <img src="View/assets/man_default.png" alt="default man profile">
                                <?php elseif (strtolower($user["genre"]) == "femme"): ?>
                                    <img src="View/assets/woman_default.png" alt="default woman profile">
                                <?php else: ?>
                                    <img src="View/assets/neutral_avatar.png" alt="default profile">
                                <?php endif; ?>
                            </div>
                            <div class="slide-info">
                                <div class="name-contact">
                                    <?php $userEmail = $user["email"];?>
                                    <p><strong><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></strong></p>
                                    <a href="index.php?page=chat&contact=<?= urlencode($userEmail); ?>"><img src="View/assets/contact-icon.png" alt="contact icon" style="width:50px;"></a>
                                </div>
                                
                                <p><?= htmlspecialchars($user['ville']); ?></p>
                                <p><?= htmlspecialchars($user['genre']); ?></p>
                                <p><?= (date('Y') - date('Y', strtotime($user['date_naissance']))) . ' ans'; ?></p>
                                <p>Loisirs : <?= htmlspecialchars($user['nom_loisir']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php if ($searched): ?>
                        <p>Aucun utilisateur trouvé.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
    <?php echo(new HtmlHelper())->renderFooter(); ?>
</body>
</html>
