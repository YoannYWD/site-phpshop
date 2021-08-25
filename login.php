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

<div class="container titlePageContainer connection">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Connexion</h1>
        </div>
    </div>
</div>

<?php

    if (isset($_POST["email"]) && $_POST["mot_de_passe"]) {
        $email = $_POST["email"];
        $mot_de_passe = $_POST["mot_de_passe"];
        $sql = "SELECT * FROM clients WHERE email = '$email' AND mot_de_passe = '$mot_de_passe';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clients = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($clients[0]["email"] == $email && $clients[0]["mot_de_passe"] == $mot_de_passe) {
            $_SESSION["nom"] = $clients[0]["nom"];
            $_SESSION["prenom"] = $clients[0]["prenom"];
            $_SESSION["idd"] = $clients[0]["id"];
            echo "<div class=\"col-12 text-center\">
                    <p>Connexion réussie ! Bienvenue " . $clients[0]["prenom"] . " " . $clients[0]["nom"] . ".</p>
                    <form action=\"index.php\" method=\"post\">
                        <input type=\"submit\" value=\"Aller à la page d'accueil\" class=\"buttonLarge\"/>
                    </form>
                  </div>";
        } else {
            echo "<div class=\"col-12 text-center\">
                    <p>Echec de connexion.</p>
                  </div>";
    
        }
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

            <p>
            Vous n'avez pas de compte ? <a href="register.php">S'enregistrer</a>
            </p>
        </form>
</div>


<!-- FOOTER
------------------------------------------------------------------->
<?php
    require './components/footer.php';
?>

<?php
unset($_SESSION["id"]);
unset($_SESSION["name"]);
header("Location:login.php");
?>