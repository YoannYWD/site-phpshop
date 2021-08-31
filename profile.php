<?php
    //Démarrage d'une nouvelle session
    session_start();
    include "./db.php";
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
            <h1>Mon profil</h1>
        </div>
    </div>
</div>

<?php
    if (isset($_POST["mod_user"]) 
    or isset($_POST["nom"]) 
    or isset($_POST["prenom"]) 
    or isset($_POST["email"]) 
    or isset($_POST["adresse"]) 
    or isset($_POST["code_postal"])
    or isset($_POST["ville"])) {
        saveUserModifProfile ();
    }
?>


<?php
    displayUserInformations();
    displayProfileBtns();
?>



<!-- FOOTER
------------------------------------------------------------------->
<?php
    include './components/footer.php';
?>

