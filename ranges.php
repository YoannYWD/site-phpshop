<?php
    //Démarrage d'une nouvelle session
    session_start();

    include './functions.php';
    include './components/header.php';
    $connection = getConnection();

    //Si la session n'existe pas, on crée un nouveau panier
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_POST['deleteAllArticles'])) {
        deleteAllArticles();
    }
?>

<div class="container titlePageContainer">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Nos différentes gammes de produits</h1>
        </div>
    </div>
</div>

<?php
    showRanges();

?>

<div class="container">
    <div class="row">

    </div>
</div>
<!-- FOOTER
------------------------------------------------------------------->
<?php
    include './components/footer.php';
?>