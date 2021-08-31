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
            <h1>Mon adresse</h1>
        </div>
    </div>
</div>

<?php
    if(isset($_POST["reg_user"])) {
        saveNewUser();
    }

    if(isset($_POST["adr_user"])) {
        saveUserAdress();
    }
?>


<div class="col-6 offset-3">
    <form action="adress.php" method="post">
        <h5>Complétez votre adresse de livraison :</h5>
        <label>Adresse</label>
        <input class="form-control" type="text" name="adresse" required>
        <label>Code postal</label>
        <input class="form-control" type="number" name="code_postal" required>
        <label>Ville</label>
        <input class="form-control" type="text" name="ville" required>
        <input type="submit" class="buttonLarge" name="adr_user" value="Enregistrer">
    </form>
</div>


<!-- FOOTER
------------------------------------------------------------------->
<?php
    include './components/footer.php';
?>

