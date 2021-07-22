<?php

    // CREATION D'UN TABLEAU REGROUPANT LES PRODUITS
    function getArticles() {
        $article1 = [
            "id" => 1,
            "name" => "Lève-cadres Hole longueur 250 mm",
            "price" => 9,
            "totalPrice" => 9, 
            "desc" => "Lève-cadres ergonomique, robuste et astucieux ! "
        ];
        $article2 = [
            "id" => 2,
            "name" => "Ruche Dadant 10 cadres mi-bois avec plateau milieu aéré, sans cadres",
            "price" => 64.90,
            "totalPrice" => 64.90,
            "desc" => "Cette ruche Dadant 10 cadres est équipée d'un corps et d'un plateau milieu aéré. Elle est vendue sans cadres."
        ];
        $article3 = [
            "id" => 3,
            "name" => "Cadre filé pour ruche Dadant",
            "price" => 1.80,
            "totalPrice" => 1.80,
            "desc" => "Cadres de ruche Dadant filés. Ces cadres ont une hauteur de 23 cm et une tête de cadres de 47 cm."
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
                 . "<input type='submit' value='Ajouter au panier'/></form>";
            echo "<form action='product.php' method='post'>"
                 . "<input type='hidden' name='id' value='" . $article['id'] . "' />"
                 . "<input type='submit' value='Voir le produit'/></form>";
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
        echo "<p>" . $article["name"] . "</p>";
        echo "<p>" . $article["price"] . "€</p>";
        echo "<p>" . $article["desc"] . "</p>";
        echo "<form action='add-to-cart.php' method='post'>" 
             . "<input type='hidden' name='id' value='" . $article['id'] . "' />"
             . "<input type='submit' value='Ajouter au panier'/></form>";
    }


    // AJOUTER DANS LE PANIER
    function addToCart($article) {
        $isArticleAlreadyAdded = false;
        for($i = 0; $i < count($_SESSION["cart"]) ; $i++) {
            if ($_SESSION["cart"][$i]["id"] == $article["id"]) {
                echo "<h4 style=\"color : red\">L'article est déjà présent dans le panier</h4>";
                $isArticleAlreadyAdded = true;
            }   
        }
        if (!$isArticleAlreadyAdded) {
            $article["quantity"] = 1;
            array_push($_SESSION["cart"], $article);
        }
    }

    // AFFICHER LE PANIER
    function displayCart() {
        if(count($_SESSION["cart"]) > 0) {
            foreach($_SESSION["cart"] as $article) {
                $totalQuantity = $article["totalPrice"] / $article["price"];
                echo "
                        <tr>
                            <td>" . $article["id"] . "</td>
                            <td>" . $article["name"] . "</td>
                            <td>" . $article["price"] . "€
                                <form action=\"add-to-cart.php\" method=\"post\"> 
                                    <input type=\"hidden\" name=\"itemPrice\" value=\"" . $article["price"] . "\">
                                </form>
                            </td>
                            <td>
                                <form action=\"add-to-cart.php\" method=\"post\"> 
                                    quantité : " . $totalQuantity . "<input type=\"number\" name=\"changeQuantity\" min=\"1\" max=\"10\" value=\"" . $article["quantity"] . "\">
                                    <input type=\"hidden\" name=\"changeQuantityId\" min=\"1\" max=\"10\" value=\"" . $article["id"] . "\">
                                    <input type=\"submit\" value=\"Modifier la quantité\"/>
                                </form>
                            </td>
                            <td>" . $article["totalPrice"]. "€
                                <form action=\"add-to-cart.php\" method=\"post\"> 
                                    <input type=\"hidden\" name=\"itotalPrice\" value=\"" . $article["totalPrice"] . "\">
                                </form>
                            </td>
                            <td>
                                <form action=\"add-to-cart.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"deleteArticle\" value=\"" . $article["id"] . "\"/>
                                    <input type=\"submit\" value=\"Supprimer\"/>
                                </form>
                            </td>                            
                        </tr>
                    ";
            }
        } else {
            echo "<p>Votre panier est vide</p>";
        }
    }


    // SUPPRIMER UN PRODUIT 
    function deleteArticle($articleid) {
        for($i = 0; $i < count($_SESSION["cart"]); $i++) {
            if ($_SESSION["cart"][$i]["id"] == $articleid) {
                array_splice($_SESSION["cart"], $i, 1);
                echo "<p>L'article a été supprimé</p>";
            }   
        }
    }

    
    // AFFICHAGE BOUTON SUPPRIMER TOUS LES PRODUITS
    function deleteAllBtn() {
        if(count($_SESSION["cart"]) > 0) {
            echo "
                    <td>
                        <form action=\"add-to-cart.php\" method=\"post\">
                        <input type=\"hidden\" name=\"deleteAllArticles\"/>
                        <input type=\"submit\" value=\"Supprimer le panier\"/>
                        </form>
                    </td>
                 ";           
        }
    }


    // SUPPRIMER TOUS LES PRODUITS
    function deleteAllArticles() {
        $_SESSION["cart"] = []; 
    }
    

    // AFFICHER LE PRIX TOTAL DU PANIER
    function totalPrice($total) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $total += $_SESSION["cart"][$i]["totalPrice"];               
            }
            echo "Total du panier : " . $total . "€";
        }
    }


    // MODIFIER LA QUANTITE
    function changeQuantity($quantity, $articleid) {
        for($i = 0; $i < count($_SESSION["cart"]); $i++) {
            if ($_SESSION["cart"][$i]["quantity"] !== $quantity && $_SESSION["cart"][$i]["id"] == $articleid) {
                $_SESSION["cart"][$i]["totalPrice"] = $_SESSION["cart"][$i]["price"] * $quantity;
                echo "<p>La quantité a été modifiée.</p>";

            } 
        }
    }


?>
