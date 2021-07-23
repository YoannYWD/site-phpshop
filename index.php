<?php
    //Démarrage d'une nouvelle session
    session_start();

    // Import du fichier functions.php
    require './components/functions.php';

    //Si la session n'existe pas, on crée un nouveau panier
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
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
        showArticles();
        ?>
    </div>
</div>


<div class="container-fluid containerCart">
    <div class="row">
        <div class="col-1 offset-11 text-center">
            <div class="col-12 itemCart">
                <p>
                    <i class="fas fa-shopping-cart"></i>
                </p>
                <div class="itemCartQuantity">
                    <p>
                        <?php
                            $totalQuantity=0;
                            totalQuantity($totalQuantity);
                        ?>
                    </p>
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