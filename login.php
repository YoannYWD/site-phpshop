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

<div class="container titlePageContainer connection">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Connexion</h1>
        </div>
    </div>
</div>

<?php
    if (isset($_POST["email"]) && $_POST["mot_de_passe"]) {
        logIn();
    }

    //$email = stripcslashes($email);
    //$mot_de_passe = stripcslashes($mot_de_passe);

?>


<div class="col-6 offset-3">
    <form action="login.php" method="post">
        <label>Email</label>
        <input class="form-control" type="email" name="email" required>
        <label>Password</label>
        <input class="form-control" type="password" name="mot_de_passe" required>
        <input type="submit" class="buttonLarge" value="Se connecter">
        <p>Vous n'avez pas de compte ? <a href="register.php">S'enregistrer</a></p>
    </form>
</div>


<!-- FOOTER
------------------------------------------------------------------->
<?php
    include './components/footer.php';
?>

