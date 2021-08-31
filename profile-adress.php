<?php
    //Démarrage d'une nouvelle session
    session_start();
    include "./db.php";
    include './functions.php';
    include './components/header.php';

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
            <h1>Mon profil</h1>
            <h3 class="mt-3">Modifier mon adresse</h3>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-5 offset-1 text-center mt-5 mb-5">
            <?php
                displayUserInformations();
            ?>
        </div>
        <div class="col-4 offset-1 text-center mt-5 mb-5">
            <?php
                userModifProfile();
            ?>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col text-center">
            <form action="profile.php">
                <input type="submit" value="Retour à mon profil" class="buttonLargeImpact"/>
            </form>
        </div>
    </div>
</div>

<!-- FOOTER
------------------------------------------------------------------->
<?php
    include './components/footer.php';
?>

