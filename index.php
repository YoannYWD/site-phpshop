<?php
    //Démarrage d'une nouvelle session
    session_start();

    // Import du fichier functions.php
    require './components/functions.php';

    //Si la session n'existe pas, on crée un nouveau panier
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_POST["validateAndDeleteAllArticles"])) {
        deleteAllArticles();
    }
    if (isset($_POST["log_out"])) {
        unset($_SESSION["nom"]);
        unset($_SESSION["prenom"]);
        unset($_SESSION["idd"]);
        $_SESSION["cart"] = [];
        header("Location:index.php");
    }

?>

<!-- HEADER 
------------------------------------------------------------------->
<?php
    require './components/header.php';
?>

<div class="container titlePageContainer">
    <div class="row">
        <div class="col-12 text-center">
            <h1>À ne pas rater !</h1>
        </div>
    </div>
</div>

<!-- DISPLAY ARTICLES
------------------------------------------------------------------->
<div class="container mainContainer">
    <div class="row">
        <?php
            showArticles($connection);
        ?>
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
                            $totalQuantity=0;
                            totalQuantity($totalQuantity);
                        ?>
                    </p>
                </div>
            </a>
        </div>
    </div>
</div>



<!-- FOOTER
------------------------------------------------------------------->
<?php
    require './components/footer.php';
?>