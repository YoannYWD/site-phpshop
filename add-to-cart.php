<?php
    //Démarrage d'une nouvelle session
    session_start();

    require './components/functions.php';
    require './components/header.php';

    //Si la session n'existe pas, on crée un nouveau panier
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_POST['deleteAllArticles'])) {
        deleteAllArticles();
    }
?>


<!-- AFFICHAGE DU OU DES PRODUITS
------------------------------------------------------------------->
<div class="container titlePageContainer">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Votre panier</h1>
        </div>
    </div>
</div>

<div class="container routContainer">
    <div class="row">
        <div class="col-6 col-md-3 text-center">
            <div class="activePage">
                <h6><i class="fas fa-shopping-cart"></i><span>01.</span>Panier</h6>
            </div>
        </div>
        <div class="col-6 col-md-3 mt-3 text-center">
            <h6><i class="fas fa-check-double"></i><span>02.</span>Validation</h6>
        </div>
        <div class="col-6 col-md-3 mt-3 text-center">
            <h6><i class="fas fa-truck"></i><span>03.</span>Livraison</h6>
        </div>
        <div class="col-6 col-md-3 mt-3 text-center">
            <h6><i class="far fa-credit-card"></i><span>04.</span>Paiement</h6>
        </div>
    </div>
</div>

<?php
    if (isset($_POST['changeQuantity']) && isset($_POST['changeQuantityId'])) {
        changeQuantity($_POST['changeQuantity'], ($_POST['changeQuantityId']));
    }
    if (isset($_POST['deleteArticle'])) {
        deleteArticle($_POST['deleteArticle']);
    }
    if (isset($_POST['id'])) {
        $id = $_POST['id']; //ID, paramètre de la fonction getArticle($id) dans functions.php
        $article = getArticle($id); //ARTICLE, paramètre de la fonction showArticle($article) dans functions.php
        addToCart($article);
    }
?>

<div class="container mainContainer">
    <div class="row">      
        <div class="col-12 col-xl-10">
            <?php
                displayCart();

                // Si panier vide, phrase retour page articles
                backToArticles();
            ?>      
        </div>
        <div class="col-12 col-md-4 offset-md-4 col-xl-2 offset-xl-0 summary">
                <?php
                    // calcul du prix final et de la quantité totale d'article
                    $total=0;
                    $totalQuantity=0;
                    totalPrice($total, $totalQuantity);

                    // bouton supprimer tous les articles
                    deleteAllBtn();
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <?php  
                // Continuer à faire du shopping
                continueShopping();

                // bouton valider le panier
                validateAddToCart();            
            ?>
        </div>
    </div>
</div>

<div class="container mainContainer">
    <?php
        showMoreArticlesTitle();
    ?>
</div>

<div class="container displayArticles">
    <div class="row">
        <?php
            showMoreArticles();
        ?>
    </div>
</div>


<!-- FOOTER
------------------------------------------------------------------->
<?php
    require './components/footer.php';
?>

