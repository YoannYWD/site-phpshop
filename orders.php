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
        <div class="col-12 text-center">
            <h1>Liste de mes commandes</h1>
        </div>
    </div>
</div>

<?php
    if (isset($_POST["orders"])) {
        $id_client = $_SESSION["idd"];
        $sql = "SELECT c.numero, c.date_commande, c.prix FROM commandes AS c WHERE c.id_client = '$id_client';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<div class="container">
    <div class="row">
        <div class="col-10 offset-1 text-center mt-5 mb-5">
            <?php foreach($orders as $order): // $film est une variable locale?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-5 align-self-center text-start">
                            <div class="card-body">
                                <h5 class="card-title">Commande n°<?= $order["numero"] ?></h5>
                            </div>
                        </div>
                        <div class="col-md-2 align-self-center text-start">
                            <div class="card-body">
                                <p class="card-text"><?= $order["date_commande"] ?></p>
                            </div>
                        </div>
                        <div class="col-md-2 align-self-center text-center">
                            <div class="card-body">
                                <p class="card-text"><?= number_format($order["prix"], 2, ",", " ") ?>€</p>
                            </div>
                        </div>
                        <div class="col-md-3 align-self-center text-center">
                            <div class="card-body">
                                <form action="details.php" method="post">
                                    <input type="hidden" name="numero" value="<?= $order["numero"] ?>">
                                    <input type="submit" class="buttonLarge" name="details" value="Détails">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>



<!-- FOOTER
------------------------------------------------------------------->
<?php
    include './components/footer.php';
?>

