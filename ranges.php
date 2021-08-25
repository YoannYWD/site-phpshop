<?php
    //Démarrage d'une nouvelle session
    session_start();

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
            <h1>Nos différentes gammes de produits</h1>
        </div>
    </div>
</div>

<?php
    $nom = $_SESSION["nom"];
    $prenom = $_SESSION["prenom"];
    $id = $_SESSION["idd"];
    $sql = "SELECT articles.nom, gammes.nom AS gammes FROM articles
            INNER JOIN gammes
            ON articles.id_gamme = gammes.id;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $gammes = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-10 offset-1 text-center mt-5 mb-5">
            <p>Nos produits</p>
            <?php foreach($gammes as $gamme): // $film est une variable locale?>
                <tr>
                    <th scope="row">
                        <?= $gamme["nom"] ?>
                    </th>
                </tr>
            <?php endforeach; ?>
        </div>
        <div class="col-10 offset-1 text-center mt-5 mb-5">
            <p>Nos gammes</p>
            <?php foreach($gammes as $gamme): // $film est une variable locale?>
                <tr>
                    <th scope="row">
                        <?= $gamme["gammes"] ?>
                    </th>
                </tr>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- FOOTER
------------------------------------------------------------------->
<?php
    require './components/footer.php';
?>

"SELECT g.nom, a.nom AS article FROM gammes AS g
            INNER JOIN articles AS a
            ON g.id = a.id_gamme";