<?php

// goal : generate easily html component that are repeated
//  simply by calling the corresponding methods

class HtmlHelper {

    public function renderHeader($li=""){
        return
        "<header class='header-container'>
            <nav>
                <ul>
                    <li><a href='index?page=account'>Mon Compte</a></li>
                    <li><a href='index?page=search'>Recherche</a></li>
                    <li><a href='index?page=search_chat'>Chat</a></li>
                    $li
                </ul>
            </nav>
        </header>";
    }

    public function renderLogoutForm(){
        return
        '<div class="form_logout__container">
            <form action="index.php?page=Redirect" method="POST">
                <input type="hidden" name="logout">
                <button type="submit" class="logout-button">Déconnexion</button>
            </form>
            <form action="index.php?page=Redirect" method="POST">
                <input type="hidden" name="deleteAcc">
                <button type="submit" class="logout-button">Delete account</button>
            </form>
        </div>';
    }
    public function renderLogoutButton(){
        return
        '<div class="form_logout__container">
            <form action="index.php?page=Redirect" method="POST">
                <input type="hidden" name="logout">
                <button type="submit" class="logout-button-only">Déconnexion</button>
            </form>
        </div>';
    }

    public function renderfooter(){
        return
        '<footer>
            <div class="footer__container">
                <p>MyMeetic by Yumetia</p>
                <p>&copy; 2025 All rights reserved !<p>
            </div>
        </footer>
        ';
    }

}
