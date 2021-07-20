<?php
    //Démarrage d'une nouvelle session
    session_start();

    //Si la session n'existe pas, on crée une nouvelle carte
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }


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