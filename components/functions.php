<?php

    // CREATION D'UN TABLEAU REGROUPANT LES PRODUITS
    function getArticles() {
        $article1 = [
            "id" => 0,
            "name" => "article1",
            "price" => 10,
            "desc" => "Je suis la description de l'article 1."
        ];
        $article2 = [
            "id" => 1,
            "name" => "article2",
            "price" => 100,
            "desc" => "Je suis la description de l'article 2."
        ];
        $article3 = [
            "id" => 2,
            "name" => "article3",
            "price" => 40,
            "desc" => "Je suis la description de l'article 3."
        ];
        $articles = [];
        array_push($articles, $article1, $article2, $article3);
        return $articles;
    }


    // AFFICHAGE DE L'ENSEMBLE DES PRODUITS
    function showArticles() {
        $articles = getArticles();
        foreach($articles as $article) {
            echo "<p>" . $article['name'] . "</p>";
            echo "<p>" . $article['price'] . "€</p>";
            echo "<form action='add-to-cart.php' method='post'>"
                 . "<input type='hidden' name='name' value='" . $article['name'] . "' />"
                 . "<input type='hidden' name='price' value='" . $article['price'] . "' />"
                 . "<input type='hidden' name='id' value='" . $article['id'] . "' />"
                 . "<input type='submit' value='Ajouter au panier'></form>";
            echo "<form action='product.php' method='post'>"
                 . "<input type='hidden' name='id' value='" . $article['id'] . "' />"
                 . "<input type='submit' value='Voir le produit'></form>";
        }
    }


    // RECUPERER UN PRODUIT CLIQUÉ
    function getArticle($id) {
        $articles = getArticles();
        foreach($articles as $article) {
            if ($id == $article['id']) {
                return $article;
            }
        }
    }


    // AFFICHER UN PRODUIT (PAGE PRODUCT.PHP)
    function showArticle($article) {
        echo "<p>" . $article['name'] . "</p>";
        echo "<p>" . $article['price'] . "€</p>";
        echo "<p>" . $article['desc'] . "</p>";
        echo "<form action='add-to-cart.php' method='post'>" 
             . "<input type='hidden' name='id' value='" . $article['id'] . "' />"
             . "<input type='submit' value='Ajouter au panier'></form>";
    }


    // AJOUTER DANS LE PANIER
    function addToCart($article) {
        $isArticleAlreadyAdded = false;
        for($i = 0; $i < count($_SESSION['cart']) ; $i++) {
            if ($_SESSION['cart'][$i]['id'] == $article['id']) {
                echo "<h4 style='color : red'>L'article est déjà présent dans le panier</h4>";
                $isArticleAlreadyAdded = true;
            }   
        }
        if (!$isArticleAlreadyAdded) {
            $article['quantity'] = 1;
            array_push($_SESSION['cart'], $article);
        }
    }

    // AFFICHER LE PANIER
    function displayCart() {
        foreach($_SESSION["cart"] as $article) {
            echo "<p>" . $article["name"] . "</p>";
            echo "<p>" . $article["price"] . "€</p>";
            echo "<p>quantité : " . $article["quantity"] . "</p>";
        }
    }


    // SUPPRIMER UN PRODUIT 
    function deleteArticle($article) {
        if (isset($_GET["remove"]) && is_numeric($_GET["remove"]) && isset($_SESSION["cart"]) && isset($_SESSION["cart"][$_GET["remove"]])) {
            // Remove the product from the shopping cart
            unset($_SESSION["cart"][$_GET["remove"]]);
        }
    }

?>
