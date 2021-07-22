<?php

    // CREATION D'UN TABLEAU REGROUPANT LES PRODUITS
    function getArticles() {
        $article1 = [
            "id" => 1,
            "img" => "./assets/images/leve-cadre.jpg",
            "name" => "Lève-cadres longueur 250 mm",
            "price" => 9,
            "totalPrice" => 9, 
            "desc" => "Lève-cadres ergonomique, robuste et astucieux ! "
        ];
        $article2 = [
            "id" => 2,
            "img" => "./assets/images/ruche.jpg",
            "name" => "Ruche Dadant 10 cadres mi-bois avec plateau milieu aéré, sans cadres",
            "price" => 64.90,
            "totalPrice" => 64.90,
            "desc" => "Cette ruche Dadant 10 cadres est équipée d'un corps et d'un plateau milieu aéré. Elle est vendue sans cadres."
        ];
        $article3 = [
            "id" => 3,
            "img" => "./assets/images/cadre.png",
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
            echo "
                <div class=\"col-12 col-lg-4 text-center\">
                    <div class=\"card\">
                        <img src=\"" . $article['img'] . "\" class=\"card-img-top\" alt=\"image produit\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">" . $article['name'] . "</h5>
                            <p class=\"card-text\">" . $article['price'] . "€</p>
                            <form action=\"add-to-cart.php\" method=\"post\">
                                <input type=\"hidden\" name=\"name\" value=\"" . $article['name'] . "\" />
                                <input type=\"hidden\" name=\"price\" value=\"" . $article['price'] . "\" />
                                <input type=\"hidden\" name=\"id\" value=\"" . $article['id'] . "\" />
                                <input type=\"submit\" value=\"Ajouter au panier\"/>
                            </form>
                            <form action=\"product.php\" method=\"post\">
                                <input type=\"hidden\" name=\"id\" value=\"" . $article['id'] . "\" />
                                <input type=\"submit\" value=\"Voir le produit\"/>
                            </form>
                        </div>
                    </div>
                </div>
            
                 ";
        }
    }




    // AFFICHER UN PRODUIT DANS LA PAGE PRODUCT.PHP
    function showArticle($article) {
        echo "<div class=\"card mb-3\">
                <img src=\"" . $article['img'] . "\" class=\"card-img-top\" alt=\"image produit\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">" . $article['name'] . "</h5>
                    <p class=\"card-text\">" . $article['desc'] . "</p>
                    <p class=\"card-text\"><small class=\"text-muted\">" . $article['price'] . "</small></p>
                </div>
             </div>
             <form action='add-to-cart.php' method='post'> 
                <input type='hidden' name='id' value='" . $article['id'] . "' />
                <input type='submit' value='Ajouter au panier'/>
              </form>";
    }


    // AFFICHAGE BOUTON "RETOUR" PAGE PRODUCT.PHP
    function backToMainPage() {
        echo "  
                <tr>
                    <td>
                        <form action=\"index.php\" method=\"post\">
                            <input type=\"submit\" value=\"retour\"/>
                        </form>
                    </td>
                </tr>
             ";   
    }



    // RECUPERER UN PRODUIT CLIQUÉ POUR AJOUT AU PANIER
    function getArticle($id) {
        $articles = getArticles();
        foreach($articles as $article) {
            if ($id == $article['id']) {
                return $article;
            }
        }
    }


    // AJOUTER LE PRODUIT DANS LE PANIER
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
                                    quantité : <input type=\"number\" name=\"changeQuantity\" min=\"1\" max=\"10\" value=\"" . $article["quantity"] . "\">
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
    function totalPrice($total, $totalQuantity) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $total += $_SESSION["cart"][$i]["totalPrice"];
                $totalQuantity += intval($_SESSION["cart"][$i]["quantity"]);                
            }
            echo "La quantité totale d'article est de " . $totalQuantity . ".";
            echo "Total du panier : " . $total . "€.";
        }
    }


    // MODIFIER LA QUANTITE
    function changeQuantity($quantity, $articleid) {
        for($i = 0; $i < count($_SESSION["cart"]); $i++) {
            if ($_SESSION["cart"][$i]["quantity"] !== $quantity && $_SESSION["cart"][$i]["id"] == $articleid) {
                $_SESSION["cart"][$i]["totalPrice"] = $_SESSION["cart"][$i]["price"] * $quantity;
                $_SESSION["cart"][$i]["quantity"] = $quantity;
                echo "<p>La quantité a été modifiée.</p>";

            } 
        }
    }


    // AFFICHAGE BOUTON VOIR LES ARTICLES
    function backToArticles() {
        if(count($_SESSION["cart"]) < 1) {
            echo "  
                    <tr>
                        <td>
                            <form action=\"index.php\" method=\"post\">
                                <input type=\"submit\" value=\"Voir les articles\"/>
                            </form>
                        </td>
                    </tr>
                 ";   
        }

    }


    // AFFICHAGE BOUTON VALIDATION DE PANIER
    function validateAddToCart() {
        if(count($_SESSION["cart"]) > 0) {
            echo "  
                    <tr>
                        <td>
                            <form action=\"index.php\" method=\"post\">
                                <input type=\"submit\" value=\"Continuer mes achats\"/>
                            </form>
                        </td>
                        <td>
                            <form action=\"shopping-cart.php\" method=\"post\">
                                <input type=\"submit\" value=\"Valider la commande\"/>
                            </form>
                        </td>
                    </tr>
                 ";   
        }

    }


    // AFFICHER LE PANIER DANS LA PAGE SHOPPING-CART.PHP
    function displayFinalCart() {
        if(count($_SESSION["cart"]) > 0) {
            foreach($_SESSION["cart"] as $article) {
                echo "
                        <tr>
                            <td>" . $article["id"] . "</td>
                            <td>" . $article["name"] . "</td>
                            <td>" . $article["price"] . "€
                                <form action=\"shopping-cart.php\" method=\"post\"> 
                                    <input type=\"hidden\" name=\"itemPrice\" value=\"" . $article["price"] . "\">
                                </form>
                            </td>
                            <td>
                                <form action=\"shopping-cart.php\" method=\"post\"> 
                                    quantité : <input type=\"number\" name=\"changeQuantity\" min=\"1\" max=\"10\" value=\"" . $article["quantity"] . "\">
                                    <input type=\"hidden\" name=\"changeQuantityId\" min=\"1\" max=\"10\" value=\"" . $article["id"] . "\">
                                    <input type=\"submit\" value=\"Modifier la quantité\"/>
                                </form>
                            </td>
                            <td>" . $article["totalPrice"]. "€
                                <form action=\"shopping-cart.php\" method=\"post\"> 
                                    <input type=\"hidden\" name=\"itotalPrice\" value=\"" . $article["totalPrice"] . "\">
                                </form>
                            </td>
                            <td>
                                <form action=\"shopping-cart.php\" method=\"post\">
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


    // PRIX AVEC FRAIS DE PORT
    function priceWithShippingFees($total, $totalWithShippingFees, $totalQuantity) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $shippingFees = 1;
                $total += $_SESSION["cart"][$i]["totalPrice"];
                $totalQuantity += intval($_SESSION["cart"][$i]["quantity"]);
                $totalWithShippingFees = $total + ($totalQuantity * $shippingFees);               
            }
            echo "Total du panier avec frais de port (1€ par article) : " . $totalWithShippingFees . "€.";
        }
    }


    // BOUTON VALIDER LA COMMANDE
    function validateShoppingCart() {
        $_SESSION["cart"] = [];
        echo "
            <form action=\"index.php\" method=\"post\">
                <input type=\"submit\" value=\"Valider ma commande\"/>
            </form>
            "; 
    }


?>
