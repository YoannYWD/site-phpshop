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
            <h1>Mon adresse</h1>
        </div>
    </div>
</div>

<?php
    if(isset($_POST["reg_user"])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $mot_de_passe = $_POST["mot_de_passe"];

        $sql = "INSERT INTO clients (nom, prenom, email, mot_de_passe) VALUES (?,?,?,?);";
        $statement = $connection->prepare($sql);
        $result = $statement->execute([$nom, $prenom, $email, $mot_de_passe]);
        if($result) {
            echo "<div class=\"col-12 text-center\">
                    <p>Utilisateur enregistré.</p>
                  </div>";
        } else {
            echo "<div class=\"col-12 text-center\">
                    <p>Une erreur s'est produite.</p>
                  </div>"; 
        }
    }

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
        }
    }

    if(isset($_POST["adr_user"])) {
        $adresse = $_POST["adresse"];
        $code_postal = $_POST["code_postal"];
        $ville = $_POST["ville"];
        $nom = $_SESSION["nom"];
        $prenom = $_SESSION["prenom"];
        $id = $_SESSION["idd"];

        $sql = "INSERT INTO adresses (id_client, adresse, code_postal, ville) VALUES (?,?,?,?);";
        $statement = $connection->prepare($sql);
        $result = $statement->execute([$id, $adresse, $code_postal, $ville]);
        if($result) {
            echo "<div class=\"col-12 text-center\">
                    <p>Adresse enregistrée.</p>
                    <form action=\"index.php\" method=\"post\">
                        <input type=\"submit\" value=\"Aller à la page d'accueil\" class=\"buttonLarge\"/>
                    </form>
                  </div>";
        } else {
            echo "<div class=\"col-12 text-center\">
                    <p>Une erreur s'est produite.</p>
                  </div>"; 
        }
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
    require './components/footer.php';
?>

