<?php
    //Démarrage d'une nouvelle session
    session_start();

    //Si la session n'existe pas, on crée une nouvelle carte
    if (empty($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    array_push($_SESSION['cart']);
?>


<!-- IMPORT FUNCTIONS
------------------------------------------------------------------->
<?php
require './components/functions.php';
?>


<!-- HEADER 
------------------------------------------------------------------->
<?php
require './components/header.php';
?>


<!-- DISPLAY ARTICLES
------------------------------------------------------------------->
<?php
showArticles();
?>


<!-- FOOTER
------------------------------------------------------------------->
<?php
require './components/footer.php';
?>