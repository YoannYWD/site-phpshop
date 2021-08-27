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
                                $id = $_SESSION["idd"];
                                $adresse = $_POST["adresse"];
                                $code_postal = $_POST["code_postal"];
                                $ville = $_POST["ville"];
                                $sql = "UPDATE clients INNER JOIN adresses 
                                        SET adresses.adresse = '$adresse',
                                            adresses.code_postal = '$code_postal',
                                            adresses.ville = '$ville'
                                        WHERE adresses.id_client = '$id';";
                                $statement = $connection->prepare($sql);
                                $statement->execute();
                                $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
                                echo "<p class=\"text-center\">Les modifications ont été prises en compte :</p>";
                            }
                            $nom = $_SESSION["nom"];
                            $prenom = $_SESSION["prenom"];
                            $id = $_SESSION["idd"];
                            $sql = "SELECT c.nom, c.prenom, c.email, a.adresse, a.code_postal, a.ville FROM clients AS c
                                    INNER JOIN adresses AS a
                                    ON c.id = a.id_client
                                    WHERE c.id = '$id';";
                            $statement = $connection->prepare($sql);
                            $statement->execute();
                            $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
                            echo "
                                <p>" . $clientConnecte[0]["adresse"] . "</p>
                                <p>" . $clientConnecte[0]["code_postal"] . " " . $clientConnecte[0]["ville"] . "</p>";
                        ?>
                    </div>
                    <div class="col-6 offset-3 text-center mb-5">
                        <?php
                            $nom = $_SESSION["nom"];
                            $prenom = $_SESSION["prenom"];
                            $id = $_SESSION["idd"];
                            $sql = "SELECT c.nom, c.prenom, c.email, a.adresse, a.code_postal, a.ville FROM clients AS c
                                    INNER JOIN adresses AS a
                                    ON c.id = a.id_client
                                    WHERE c.id = '$id';";
                            $statement = $connection->prepare($sql);
                            $statement->execute();
                            $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
                            echo "<form action=\"delivery.php\" method=\"post\">
                            <h5 class=\"text-center mt-2 mb-3\">Modifier mon adresse</h5>
                                    <input class=\"form-control\" type=\"text\" name=\"adresse\" placeholder=\"Rue, boulevard, impasse...\" value=\"" . $clientConnecte[0]["adresse"] . "\">
                                    <input class=\"form-control\" type=\"text\" name=\"code_postal\" placeholder=\"Code postal\" value=\"" . $clientConnecte[0]["code_postal"] . "\">
                                    <input class=\"form-control\" type=\"text\" name=\"ville\" placeholder=\"Ville\" value=\"" . $clientConnecte[0]["ville"] . "\">
                                    <input type=\"submit\" value=\"Valider mes modifications\" name=\"mod_user\" class=\"buttonLarge\"/>
                                    </form>";
                        ?>
                    </div>

                <?php   
                    $deliveryValue = 5;
                    $total = 0;
                    $totalWithShippingFees = 0;
                    $totalQuantity=0;
                    priceWithDelivery($total, $totalWithShippingFees, $totalQuantity, $deliveryValue);
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
                            displayModal($total, $totalWithShippingFees, $totalQuantity, $deliveryValue, $formatTotalWithDelivery);
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
        <div class="col-12">
            
            <?php
                displayDeliveryCart();
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

