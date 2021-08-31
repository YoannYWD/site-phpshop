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
            <h3 class="mt-3">Modifier mon mot de passe</h3>
        </div>
    </div>
</div>

<?php
    if (isset($_POST["validatePassword"])) {
        updatePassword();
    }
?>

<div class="container">
    <div class="row">
        <div class="col-12 text-center mt-5 mb-5">
            <form action="profile-password.php" method="post">
                <label><p>Ancien mot de passe</p></label>
                <input type="password" class="form-control" name="oldPassword" placeholder="Ancien mot de passe" required>
                <label><p>Nouveau mot de passe</p></label>
                <small class="form-text text-muted">(Entre 8 et 15 caractères, minimum 1 lettre, 1 chiffre et 1 caractère spécial)</small>
                <input type="password" class="form-control" name="newPassword" placeholder="Nouveau mot de passe" required>
                <input type="submit" value="Valider" name="validatePassword" class="buttonLargeImpact"/>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col text-center">
            <form action="profile-password.php">
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


    <?php
        $id = $_SESSION["idd"];
        $sql = "SELECT c.mot_de_passe FROM clients AS c
                WHERE c.id = '$id'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<form action=\"profile.php\" method=\"post\">
                <p class=\"text-decoration-underline\">Modifier mon nom :</p>
                    <input class=\"form-control\" type=\"text\" name=\"nom\" value=\"" . $clientConnecte[0]["mot_de_passe"] . "\">
                <br>
                <p class=\"text-decoration-underline\">Modifier mon adresse mail :</p>
                    <input class=\"form-control\" type=\"email\" name=\"new_password\"\">
                <br>


                <input type=\"submit\" value=\"Valider mes modifications\" name=\"mod_user\" class=\"buttonLarge\"/>
        </form>";
    ?>