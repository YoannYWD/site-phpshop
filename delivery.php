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
    if (isset($_POST["validateAndDeleteAllArticles"])) {
        deleteAllArticles();
    }
?>


<!-- AFFICHAGE DU OU DES PRODUITS
------------------------------------------------------------------->
<div class="container titlePageContainer">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Choisissez la livraison</h1>
        </div>
    </div>
</div>

<div class="container routContainer">
    <div class="row">
        <div class="col-6 col-md-3 mt-3 text-center">
            <h6><i class="fas fa-shopping-cart"></i><span>01.</span>Panier</h6>
        </div>
        <div class="col-6 col-md-3 mt-3 text-center">
            <h6><i class="fas fa-check-double"></i><span>02.</span>Validation</h6>
        </div>
        <div class="col-6 col-md-3 text-center">
            <div class="activePage">
                <h6><i class="fas fa-truck"></i><span>03.</span>Livraison</h6>
            </div>
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
                    //if (isset($_POST["delivery"])) {
                    //    var_dump($_POST["delivery"]);
                    //}
                                           
                    // Prix avec frais de port
                    $deliveryValue = 0;
                    $total = 0;
                    $totalWithShippingFees = 0;
                    $totalQuantity=0;
                    priceWithDelivery($total, $totalWithShippingFees, $totalQuantity, $deliveryValue);

                    // bouton supprimer tous les articles
                    //deleteAllBtn();
                ?>
            </div>
        </div>
        <!-- MODAL -->
        <div class="col-12 text-center">
            <input type="submit" name="validateAndDeleteAllArticles" value="Valider ma commande" class="buttonLargeImpact inputModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop"/>
        </div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Commande validée !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                        $total = 0;
                        $totalWithShippingFees = 0;
                        $totalQuantity=0;
                        displayModal($total, $totalWithShippingFees, $totalQuantity);
                    ?>
                </div>
                <div class="modal-footer">
                    <?php
                        validateShoppingCart();
                    ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- FOOTER
------------------------------------------------------------------->
<?php
    require './components/footer.php';
?>

