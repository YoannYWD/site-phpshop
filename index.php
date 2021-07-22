<?php
    //Démarrage d'une nouvelle session
    session_start();

    //Si la session n'existe pas, on crée un nouveau panier
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
<div class="container">
    <div class="row">
        <?php
        showArticles();
        ?>
    </div>
</div>




<!-- FOOTER
------------------------------------------------------------------->
<?php
require './components/footer.php';
?>