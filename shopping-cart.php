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
    if(!isset($_SESSION['nom'])){ //if login in session is not set
        header("Location: index.php");
    }

?>


<!-- AFFICHAGE PAGE
------------------------------------------------------------------->
<?php
    if (isset($_SESSION["prenom"]) && $_SESSION["nom"]){
        echo "<div class=\"connection\">
                <p>Vous êtes connecté en tant que " . $_SESSION["prenom"] . " " . $_SESSION["nom"] . ".<p>
                <input type=\"submit\" class=\"buttonLarge\" name=\"reg_user\" value=\"Se déconnecter\">
              </div>";
    }
?>

<div class="container titlePageContainer">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Validation de votre commande</h1>
        </div>
    </div>
</div>

<div class="container routContainer">
    <div class="row">
        <div class="col-6 col-md-3 mt-3 text-center">
            <h6><i class="fas fa-shopping-cart"></i><span>01.</span>Panier</h6>
        </div>
        <div class="col-6 col-md-3 text-center">
            <div class="activePage">
                <h6><i class="fas fa-check-double"></i><span>02.</span>Validation</h6>
            </div>
        </div>
        <div class="col-6 col-md-3 mt-3 text-center">
            <h6><i class="fas fa-truck"></i><span>03.</span>Livraison</h6>
        </div>
        <div class="col-6 col-md-3 mt-3 text-center">
            <h6><i class="far fa-credit-card"></i><span>04.</span>Paiement</h6>
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
                deleteAllBtnSc();
                ?>
            </div>
        </div>
        <div class="col-12 mb-5 text-center">
            <!-- <form action="delivery.php" method="post">
                    <?php
                        //$deliveryValues = [10, 5];
                        //displayDelivery($deliveryValues); 
                    ?>
            </form> -->
            <?php
                goToDelivery();
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

