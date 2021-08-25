<?php
    //Démarrage d'une nouvelle session
    session_start();
    require "./db.php";
    require './components/functions.php';
    require './components/header.php';

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
            <h1>Inscription</h1>
        </div>
    </div>
</div>

<div class="col-6 offset-3">
        <form action="adress.php" method="post">

            <label>Nom</label>
            <input class="form-control" type="text" name="nom" required>

            <label>Prénom</label>
            <input class="form-control" type="text" name="prenom" required>

            <label>Email</label>
            <input class="form-control" type="email" name="email" required>

            <label>Password</label>
            <input class="form-control" type="password" name="mot_de_passe" required>

            <input type="submit" class="buttonLarge" name="reg_user" value="S'inscrire">

            <p>Déjà membre ? <a href="login.php">Se connecter</a></p>
        </form>
</div>


<!-- FOOTER
------------------------------------------------------------------->
<?php
    require './components/footer.php';
?>

