<?php
    //Démarrage d'une nouvelle session
    session_start();

    include './functions.php';
    include './components/header.php';
  
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
    if (isset($_POST['changequantite']) && isset($_POST['changequantiteId'])) {
        changequantite($_POST['changequantite'], ($_POST['changequantiteId']));
    }
    if (isset($_POST["validateAndDeleteAllArticles"])) {
        deleteAllArticles();
    }
    if(!isset($_SESSION['nom'])){ //if login in session is not set
        header("Location: index.php");
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
            <h5 class="text-center mt-2 mb-3">Votre adresse</h5>
                    <div class="col-12 text-center mb-5">
                        <?php

                            if (isset($_POST["mod_user"]) 
                            or isset($_POST["adresse"]) 
                            or isset($_POST["code_postal"])
                            or isset($_POST["ville"])) {
                                saveAdress();
                            }
                            displayAdress();
                        ?>
                    </div>
                    <div class="col-6 offset-3 text-center mb-5">
                        <?php
                            modAdress();
                        ?>
                    </div>

                <?php   
                    $deliveryValue = 5;
                    $total = 0;
                    $totalWithShippingFees = 0;
                    $totalquantite=0;
                    priceWithDelivery($total, $totalWithShippingFees, $totalquantite, $deliveryValue);
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
                    </div>
                    <div class="modal-body">
                        <?php
                            displayModal($total, $totalWithShippingFees, $totalquantite, $deliveryValue, $formatTotalWithDelivery, $totalWithDelivery);
                        ?>
                    </div>
                    <div class="modal-footer">
                        <form action="index.php" method="post">
                            <input type="submit" name="validateAndDeleteAllArticles" value="Retour à la page d'accueil" class="buttonLargeImpact"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            
            <?php
                backToArticles();
            ?>     
        </div>
    </div>
</div>


<!-- FOOTER
------------------------------------------------------------------->
<?php
    include './components/footer.php';
?>

