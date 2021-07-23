<?php
    //Démarrage d'une nouvelle session
    session_start();

    require './components/functions.php';
    require './components/header.php';

    //Si la session n'existe pas, on crée un nouveau panier
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_POST['deleteArticle'])) {
        deleteArticle($_POST['deleteArticle']);
    }
    if (isset($_POST['id'])) {
        $id = $_POST['id']; //ID, paramètre de la fonction getArticle($id) dans functions.php
        $article = getArticle($id); //ARTICLE, paramètre de la fonction showArticle($article) dans functions.php
        addToCart($article);
    }
    if (isset($_POST['deleteAllArticles'])) {
        deleteAllArticles();
    }
    if (isset($_POST['changeQuantity']) && isset($_POST['changeQuantityId'])) {
        changeQuantity($_POST['changeQuantity'], ($_POST['changeQuantityId']));
    }
    if (isset($_POST['validateAndDeleteAllArticles'])) {
        validateShoppingCart();
    }
?>


<!-- AFFICHAGE DU OU DES PRODUITS
------------------------------------------------------------------->
<div class="container titlePageContainer">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Valider votre commande</h1>
        </div>
    </div>
</div>


<div class="container mainContainer">
    <div class="row">
        <div class="col-12 summary">
            <div class="card mb-3 p-2">

                <?php

                // calcul du prix final et de la quantité totale d'article
                $total=0;
                $totalQuantity=0;
                finalTotalPrice($total, $totalQuantity);
                
                // Prix avec frais de port
                $total = 0;
                $totalWithShippingFees = 0;
                $totalQuantity=0;
                priceWithShippingFees($total, $totalWithShippingFees, $totalQuantity);

                // bouton supprimer tous les articles
                deleteAllBtn();

                ?>
            </div>
        </div>
        <div class="col-12 text-center">
        <?php
        validateShoppingCart();
        ?>
        </div>
        <div class="col-12">
            <?php
            displayFinalCart();
            backToArticles();
            ?>     
        </div>
    </div>
</div>


<!-- FOOTER
------------------------------------------------------------------->
<?php
require './components/footer.php';
?>

