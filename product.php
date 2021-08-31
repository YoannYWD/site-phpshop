<?php
    //Démarrage d'une nouvelle session
    session_start();

    //Si la session n'existe pas, on crée une nouvelle carte
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if(!isset($_SESSION['nom'])){ //if login in session is not set
        header("Location: index.php");
        echo "<div class=\"col-12 text-center\">
                <p>Connectez-vous pour voir les produits en détails.</p>
              </div>
              <script type='text/javascript'>alert(Connectez-vous pour voir les produits en détails.);</script>";
    }

?>

<!-- IMPORT FUNCTIONS
------------------------------------------------------------------->
<?php
    include './functions.php';
?>


<!-- HEADER 
------------------------------------------------------------------->
<?php
    require './components/header.php';
?>


<!-- AFFICHAGE DU OU DES PRODUITS
------------------------------------------------------------------->
<div class="container titlePageContainer">
    <div class="row">
        <div class="col-12 text-center">
            <h1>En détails</h1>
        </div>
    </div>
</div>

<div class="container-fluid containerCart">
    <div class="row">
        <div class="offset-8 col-4 offset-sm-9 col-sm-3 offset-md-10 col-md-2 offset-xxl-11 col-xxl-1">
            <a href="/phpshop/add-to-cart">
                <div class="itemCart text-center">
                    <p class="mt-1 mb-0">Mon panier</p>
                    <p class="m-0 mb-1">
                        <i class="fas fa-shopping-cart"></i>                        
                        <?php
                        if (isset($_SESSION["idd"])) {
                            $totalquantite=0;
                            totalquantite($totalquantite);
                        }
                        ?>
                    </p>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="container mainContainer">
    <div class="row text-center">
        <?php
            //ID, paramètre de la fonction getArticle($id) dans functions.php
            $id = $_POST['id'];
            showArticle($id)
        ?>
    </div>
    <div class="row text-center">
        <?php
            backToMainPage();
        ?>
    </div>
</div>

<!-- FOOTER
------------------------------------------------------------------->
<?php
    include './components/footer.php';
?>
