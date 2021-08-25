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
    if (isset($_POST["mod_user"]) 
        && isset($_POST["nom"]) 
        && isset($_POST["prenom"]) 
        && isset($_POST["email"]) 
        && isset($_POST["adresse"]) 
        && isset($_POST["code_postal"])
        && isset($_POST["ville"])) {
            $id = $_SESSION["idd"];
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $email = $_POST["email"];
            $adresse = $_POST["adresse"];
            $code_postal = $_POST["code_postal"];
            $ville = $_POST["ville"];
            $sql = "UPDATE clients INNER JOIN adresses 
                    SET clients.nom = '$nom', 
                        clients.prenom = '$prenom', 
                        clients.email = '$email', 
                        adresses.adresse = '$adresse',
                        adresses.code_postal = '$code_postal',
                        adresses.ville = '$ville'
                    WHERE adresses.id_client = '$id' AND clients.id = '$id'; ";
            $statement = $connection->prepare($sql);
            $statement->execute();
            $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
            echo "<p class=\"text-center text-decoration-underline\">Les modifications ont été prises en compte.</p>";
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
        $id = $_SESSION["idd"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $adresse = $_POST["adresse"];
        $code_postal = $_POST["code_postal"];
        $ville = $_POST["ville"];
        $sql = "UPDATE clients INNER JOIN adresses 
                SET clients.nom = '$nom', 
                    clients.prenom = '$prenom', 
                    clients.email = '$email', 
                    adresses.adresse = '$adresse',
                    adresses.code_postal = '$code_postal',
                    adresses.ville = '$ville'
                WHERE adresses.id_client = '$id' AND clients.id = '$id'; ";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<p class=\"text-center\">Les modifications ont été prises en compte.</p>";
    }

?>

<div class="container">
    <div class="row">
        <div class="col-5 offset-1 text-center mt-5 mb-5">
            <?php
                $nom = $_SESSION["nom"];
                $prenom = $_SESSION["prenom"];
                $id = $_SESSION["idd"];
                $sql = "SELECT c.nom, c.prenom, c.email, a.adresse, a.code_postal, a.ville FROM clients AS c
                        INNER JOIN adresses AS a
                        ON c.id = a.id_client
                        WHERE c.id = '$id';";
                $statement = $connection->prepare($sql);
                $statement->execute();
                $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
                echo "<p class=\"text-decoration-underline\">Mon nom :</p>
                      <p>" . $clientConnecte[0]["nom"] . "</p>
                      <br>
                      <p class=\"text-decoration-underline\">Mon prénom :</p>
                      <p>" . $clientConnecte[0]["prenom"] . "</p>
                      <br>
                      <p class=\"text-decoration-underline\">Mon adresse mail :</p>
                      <p>" . $clientConnecte[0]["email"] . "</p>
                      <br>
                      <p class=\"text-decoration-underline\">Mon adresse :</p>
                      <p>" . $clientConnecte[0]["adresse"] . "</p>
                      <p>" . $clientConnecte[0]["code_postal"] . " " . $clientConnecte[0]["ville"] . "</p>
                      <br>
                      <form action=\"orders.php\" method=\"post\">
                        <input type=\"submit\" value=\"Voir mes commandes\" class=\"buttonLargeImpact\"/>
                      </form>";
            ?>
        </div>
        <div class="col-4 offset-1 text-center mt-5 mb-5">
            <?php
                $nom = $_SESSION["nom"];
                $prenom = $_SESSION["prenom"];
                $id = $_SESSION["idd"];
                $sql = "SELECT c.nom, c.prenom, c.email, a.adresse, a.code_postal, a.ville FROM clients AS c
                        INNER JOIN adresses AS a
                        ON c.id = a.id_client
                        WHERE c.id = '$id';";
                $statement = $connection->prepare($sql);
                $statement->execute();
                $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
                echo "        <form action=\"profile.php\" method=\"post\">
                <p class=\"text-decoration-underline\">Modifier mon nom :</p>
                    <input class=\"form-control\" type=\"text\" name=\"nom\" value=\"" . $clientConnecte[0]["nom"] . "\">
                <br>
                <p class=\"text-decoration-underline\">Modifier mon prénom :</p>
                    <input class=\"form-control\" type=\"text\" name=\"prenom\" value=\"" . $clientConnecte[0]["prenom"] . "\">
                <br>
                <p class=\"text-decoration-underline\">Modifier mon adresse mail :</p>
                    <input class=\"form-control\" type=\"email\" name=\"email\" value=\"" . $clientConnecte[0]["email"] . "\">
                <br>
                <p class=\"text-decoration-underline\">Modifier mon adresse :</p>
                    <input class=\"form-control\" type=\"text\" name=\"adresse\" placeholder=\"Rue, boulevard, impasse...\" value=\"" . $clientConnecte[0]["adresse"] . "\">
                    <input class=\"form-control\" type=\"text\" name=\"code_postal\" placeholder=\"Code postal\" value=\"" . $clientConnecte[0]["code_postal"] . "\">
                    <input class=\"form-control\" type=\"text\" name=\"ville\" placeholder=\"Ville\" value=\"" . $clientConnecte[0]["ville"] . "\">
                <input type=\"submit\" value=\"Valider mes modifications\" name=\"mod_user\" class=\"buttonLarge\"/>
                </form>";
            ?>
        </div>
        <!--
        <div class="col-4 offset-1 text-center mt-5 mb-5">

        <form action="profile.php" method="post">
            <p class="text-decoration-underline">Modifier mon nom :</p>
                <input class="form-control" type="text" name="nom" value="Doe">
            <br>
            <p class="text-decoration-underline">Modifier mon prénom :</p>
                <input class="form-control" type="text" name="prenom" value="">
            <br>
            <p class="text-decoration-underline">Modifier mon adresse mail :</p>
                <input class="form-control" type="email" name="email" value="">
            <br>
            <p class="text-decoration-underline">Modifier mon adresse :</p>
                <input class="form-control" type="text" name="adresse" placeholder="Rue, boulevard, impasse...">
                <input class="form-control" type="text" name="code_postal" placeholder="Code postal">
                <input class="form-control" type="text" name="ville" placeholder="Ville">
            <input type="submit" value="Valider mes modifications" name="mod_user" class="buttonLarge"/>
            </form>

        </div>
-->
    </div>
</div>



<!-- FOOTER
------------------------------------------------------------------->
<?php
    require './components/footer.php';
?>

