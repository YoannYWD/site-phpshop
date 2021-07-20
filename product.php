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

<input type="button" value="Retour" onclick="window.history.back()" />


<!-- AFFICHAGE DU OU DES PRODUITS
------------------------------------------------------------------->


<?php

//ID, paramètre de la fonction getArticle($id) dans functions.php
$id = $_POST['id'];

//PRODUCT, paramètre de la fonction showArticle($product) dans functions.php
$article = getArticle($id);

showArticle($article);

?>


<!-- FOOTER
------------------------------------------------------------------->
<?php
require './components/footer.php';
?>
