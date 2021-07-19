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
    };


    // AFFICHAGE DE L'ENSEMBLE DES PRODUITS
    function showArticles() {
        $articles = getArticles();
        foreach($articles as $article) {
            echo "<p>" . $article['name'] . "</p>";
            echo "<p>" . $article['price'] . "€</p>";
            echo "<p>" . $article['desc'] . "</p>";
            echo "<a href='add-to-cart.php?id=" . $article['id'] . "'>détail du produit</a>";
        }
    }

?>

