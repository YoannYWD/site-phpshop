<?php
    //Démarrage d'une nouvelle session
    session_start();

    //Si la session n'existe pas, on crée une nouvelle carte
    if (empty($_SESSION['cart'])) {
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


<!-- AFFICHAGE DU OU DES PRODUITS
------------------------------------------------------------------->
<?php

//id, paramètre de la fonction getArticle($id) dans functions.php
$id = $_POST['id'];

//product, paramètre de la fonction showArticle($product) dans functions.php
$article = getArticle($id);
addToCart($article);
var_dump($_SESSION['cart']);


?>


<!-- FOOTER
------------------------------------------------------------------->
<?php
require './components/footer.php';
?>

