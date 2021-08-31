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
        <?php
            if (isset($_POST["details"])) {
                $numero = $_POST["numero"];
                $sql = "SELECT ca.id_article, ca.id_commande, ca.quantite, a.id, a.nom, a.image, a.prix AS prix_article, c.date_commande, c.prix AS prix_total
                            FROM commande_articles AS ca 
                        INNER JOIN articles AS a 
                            ON ca.id_article = a.id 
                        INNER JOIN commandes AS c 
                            ON ca.id_commande = c.id 
                        WHERE c.numero = '$numero'";
                $statement = $connection->prepare($sql);
                $statement->execute();
                $details = $statement->fetchAll(PDO::FETCH_ASSOC);
                echo "
                    <div class=\"col-12 text-center mb-5\">
                        <h1>Détail de ma commande n°" . $numero . ".</h1>
                        <h2 class=\"mt-3\">". number_format($details[0]["prix_total"], 2, ",", " ") . "€ <small class=\"text-muted\">(frais de port et de livraison inclus)</small></h2>
                        <h5>Passée le ". $details[0]["date_commande"] . "</h5>
                    </div>
                    ";
            }
        ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php foreach($details as $detail): // $film est une variable locale?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-2 align-self-center">
                        <div class="card-body">
                            <img src="<?= $detail["image"] ?>" class="card-img-top mx-auto" alt="image produit" style="max-width: 100px;">
                        </div>
                    </div>
                    <div class="col-md-3 align-self-center text-start">
                        <div class="card-body">
                            <p class="card-title"><?= $detail["nom"] ?></p>
                        </div>
                    </div>

                    <div class="col-md-2 align-self-center text-start">
                        <div class="card-body">
                            <p class="card-text">Quantité : <?= $detail["quantite"] ?></p>
                        </div>
                    </div>
                    <div class="col-md-2 align-self-center text-center">
                        <div class="card-body">
                            <p class="card-text"><?= number_format($detail["prix_article"], 2, ",", " ") ?>€</p>
                        </div>
                    </div>
                    <div class="col-md-3 align-self-center text-end">
                        <div class="card-body">
                            <p class="card-text">Total : <?= number_format(($detail["prix_article"] * $detail["quantite"]), 2, ",", " ") ?>€</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="container mt-5 mb-5">
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

