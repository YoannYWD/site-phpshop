<?php
    //Démarrage d'une nouvelle session
    session_start();

    require './components/functions.php';
    require './components/header.php';

    //Si la session n'existe pas, on crée un nouveau panier
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_POST['deleteArticle'])) {
        deleteArticle($_POST['deleteArticle']);
    }
    if (isset($_POST['id'])) {
        $id = $_POST['id']; //ID, paramètre de la fonction getArticle($id) dans functions.php
        $article = getArticle($id); //ARTICLE, paramètre de la fonction showArticle($article) dans functions.php
        addToCart($article);
    }
    if (isset($_POST['deleteAllArticles'])) {
        deleteAllArticles();
    }
    if (isset($_POST['changeQuantity']) && isset($_POST['changeQuantityId'])) {
        changeQuantity($_POST['changeQuantity'], ($_POST['changeQuantityId']));
    }
?>


<!-- AFFICHAGE DU OU DES PRODUITS
------------------------------------------------------------------->
<table>
    <thead>
        <tr>
            <td><p>Référence</p></td>
            <td><p>Nom de l'article</p></td>
            <td><p>Prix</p></td>
            <td><p>Quantité</p></td>
            <td><p>Total article</p></td>
        </tr>
    </thead>
    <tbody>
        <?php
        displayFinalCart();
        ?>
    <tbody>
</table>

<?php
deleteAllBtn();

$total=0;
$totalQuantity=0;
totalPrice($total, $totalQuantity);

$total = 0;
$totalWithShippingFees = 0;
$totalQuantity=0;
priceWithShippingFees($total, $totalWithShippingFees, $totalQuantity);

validateShoppingCart();
?>


<!-- FOOTER
------------------------------------------------------------------->
<?php
require './components/footer.php';
?>

