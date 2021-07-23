<?php

    // CREATION D'UN TABLEAU REGROUPANT LES PRODUITS
    function getArticles() {
        $article1 = [
            "id" => 1,
            "img" => "./assets/images/leve-cadre.jpg",
            "name" => "Lève-cadres longueur 250 mm",
            "price" => 9,
            "specPrice" => "",
            "totalPrice" => 9, 
            "desc" => "Lève-cadres ergonomique, robuste et astucieux ! "
        ];
        $article2 = [
            "id" => 2,
            "img" => "./assets/images/ruche.jpg",
            "name" => "Ruche Dadant 10 cadres mi-bois",
            "price" => 64.90,
            "specPrice" => "",
            "totalPrice" => 64.90,
            "desc" => "Cette ruche Dadant 10 cadres est équipée d'un corps et d'un plateau milieu aéré. Elle est vendue sans cadres."
        ];
        $article3 = [
            "id" => 3,
            "img" => "./assets/images/cadre.png",
            "name" => "Cadre filé pour ruche Dadant",
            "price" => 1.80,
            "specPrice" => "à partir de",
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
            $priceFormat = number_format($article['price'], 2, ",", " ");
            echo "
                <div class=\"col-12 col-lg-4 text-center\">
                    <div class=\"card\">
                        <img src=\"" . $article['img'] . "\" class=\"card-img-top\" alt=\"image produit\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">" . $article['name'] . "</h5>
                            <p class=\"card-text\"><span>" . $article['specPrice'] . "</span>" . " " . $priceFormat . "€</p>
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
        $priceFormat = number_format($article['price'], 2, ",", " ");
        echo "<div class=\"card mb-3 text-center\">
                <img src=\"" . $article['img'] . "\" class=\"card-img-top mx-auto\" alt=\"image produit\" style=\"max-width: 540px;\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">" . $article['name'] . "</h5>
                    <p class=\"card-text\">" . $article['desc'] . "</p>
                    <p class=\"card-text\"><small class=\"text-muted\"><span>" . $article['specPrice'] . "</span>" . " " . $priceFormat . "€</small></p>
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
                echo "<div class=\"col-12 text-center\">
                        <p style=\"color : red\">Cet article est déjà présent dans votre panier !</p>
                      </div>";
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
                $priceFormat = number_format($article['price'], 2, ",", " ");
                $totalPriceFormat = number_format($article['totalPrice'], 2, ",", " ");
                echo "
                    <div class=\"card mb-3\">
                        <div class=\"row g-0\">
                            <div class=\"col-md-2 align-self-center\">
                                <img src=\"" . $article["img"] . "\" class=\"img-fluid rounded-start\" alt=\"impage produit\">
                            </div>
                            <div class=\"col-md-3 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">" . $article["name"] . "</h5>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <p class=\"card-text\">" . $priceFormat . "€<span>/unité</span></p>
                                    <form action=\"add-to-cart.php\" method=\"post\"> 
                                        <input type=\"hidden\" name=\"itemPrice\" value=\"" . $article["price"] . "\">
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <form action=\"add-to-cart.php\" method=\"post\"> 
                                        <input type=\"number\" name=\"changeQuantity\" min=\"1\" max=\"10\" size=\"5\" value=\"" . $article["quantity"] . "\">
                                        <input type=\"hidden\" name=\"changeQuantityId\" min=\"1\" max=\"10\" value=\"" . $article["id"] . "\">
                                        <input type=\"submit\" value=\"Modifier\"/>
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <p class=\"card-text\">" . $totalPriceFormat . "€</p>
                                    <form action=\"add-to-cart.php\" method=\"post\"> 
                                        <input type=\"hidden\" name=\"itotalPrice\" value=\"" . $article["totalPrice"] . "\">
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-1 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <form action=\"add-to-cart.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"deleteArticle\" value=\"" . $article["id"] . "\"/>
                                        <button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
            }
        } else {
            echo "<div class=\"col-12 text-center\">
                    <p>Votre panier est vide.</p>
                  </div>";
        }
    }






    // SUPPRIMER UN PRODUIT 
    function deleteArticle($articleid) {
        for($i = 0; $i < count($_SESSION["cart"]); $i++) {
            if ($_SESSION["cart"][$i]["id"] == $articleid) {
                array_splice($_SESSION["cart"], $i, 1);
                echo "<div class=\"col-12 text-center\">
                        <p>L'article a été supprimé du panier.</p>
                      </div>";
            }   
        }
    }

    
    // AFFICHAGE BOUTON SUPPRIMER TOUS LES PRODUITS
    function deleteAllBtn() {
        if(count($_SESSION["cart"]) > 0) {
            echo "
                    <div class=\"row\">
                        <div class=\"col-12 text-center\">
                            <form action=\"add-to-cart.php\" method=\"post\">
                                <input type=\"hidden\" name=\"deleteAllArticles\"/>
                                <button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button>
                            </form>
                        </div>
                </div>
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
                $formatTotal = number_format($total, 2, ",", " ");
                $tva = ($total / 120) * 20;
                $formatTva = number_format($tva, 2, ",", " ");   
                $ht = ($total - $tva);
                $formatHt = number_format($ht, 2, ",", " ");           
            }
            if ($totalQuantity > 1) {
                echo " 
                        <h5 class=\"text-center mt-2 mb-3\">Récapitulatif</h5>
                        <div class=\"row\">
                            <div class=\"col-6\">
                                <p>Articles : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-end\">$totalQuantity</p>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"col-6\">
                                <p>TTC : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-end\"> " . $formatTotal . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-6\">
                                <p class=\"text-muted tvaDetails\">TVA 20% : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatTva . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-6\">
                                <p class=\"text-muted tvaDetails\">Soit HT : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatHt . "€</p>
                            </div>
                        </div>
    
                     ";
            } else {
                echo "
                        <h5 class=\"text-center mt-2 mb-3\">Récapitulatif</h5>
                        <div class=\"row\">
                            <div class=\"col-6\">
                                <p>Article : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-end\">$totalQuantity</p>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"col-6\">
                                <p>TTC : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-end\"> " . $formatTotal . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-6\">
                                <p class=\"text-muted tvaDetails\">TVA 20% : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatTva . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-6\">
                                <p class=\"text-muted tvaDetails\">Soit HT : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatHt . "€</p>
                            </div>
                        </div>

                     ";
            }

        }
    }


    // FONCTIONS AFFICHAGE QUANTITE TOTALE
    function totalQuantity($totalQuantity) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $totalQuantity += intval($_SESSION["cart"][$i]["quantity"]);                
            }
            echo $totalQuantity;
        }
    }



    // MODIFIER LA QUANTITE
    function changeQuantity($quantity, $articleid) {
        for($i = 0; $i < count($_SESSION["cart"]); $i++) {
            if ($_SESSION["cart"][$i]["quantity"] !== $quantity && $_SESSION["cart"][$i]["id"] == $articleid) {
                $_SESSION["cart"][$i]["totalPrice"] = $_SESSION["cart"][$i]["price"] * $quantity;
                $_SESSION["cart"][$i]["quantity"] = $quantity;
                echo "<div class=\"col-12 text-center\">
                        <p>La quantité a été modifiée.</p>
                      </div>";

            } 
        }
    }


    // AFFICHAGE PHRASE RETOUR PAGE ARTICLES
    function backToArticles() {
        if(count($_SESSION["cart"]) < 1) {

            echo "<div class=\"col-12 text-center\">
                    <p class=\"backToArticles\">Cliquez <a href=\"index.php\">ici</a> pour continuer vos achats.</p>
                  </div>";
        }
    }


    // AFFICHAGE BOUTON VALIDATION DE PANIER
    function continueShopping() {
        if(count($_SESSION["cart"]) > 0) {
            echo "
                    <div class=\"row\">
                        <div class=\"col-12 text-center\">
                            <form action=\"index.php\" method=\"post\">
                                <input type=\"submit\" value=\"Continuer mes achats\"/>
                            </form>
                        </div>
                    </div>
                ";   
        }
    }


    // AFFICHAGE BOUTON VALIDATION DE PANIER
    function validateAddToCart() {
        if(count($_SESSION["cart"]) > 0) {
            echo "  
                    <div class=\"row\">
                        <div class=\"col-12 text-center\">
                            <form action=\"shopping-cart.php\" method=\"post\">
                                <input type=\"submit\" value=\"Valider la commande\"/>
                            </form>
                        </div>
                    </div>
                 ";   
        }

    }


    // AFFICHER LE RECAP TOTAL DU PANIER PAGE VALIDATION
    function finalTotalPrice($total, $totalQuantity) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $total += $_SESSION["cart"][$i]["totalPrice"];
                $totalQuantity += intval($_SESSION["cart"][$i]["quantity"]);
                $formatTotal = number_format($total, 2, ",", " ");
                $tva = ($total / 120) * 20;
                $formatTva = number_format($tva, 2, ",", " ");   
                $ht = ($total - $tva);
                $formatHt = number_format($ht, 2, ",", " ");           
            }
            if ($totalQuantity > 1) {
                echo " 
                        <h5 class=\"text-center mt-2 mb-3\">Récapitulatif</h5>
                        <div class=\"row\">
                            <div class=\"col-3 offset-3\">
                                <p>Articles : " . " " . "</p>
                            </div>
                            <div class=\"col-3\">
                                <p class=\"text-end\">$totalQuantity</p>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"col-3 offset-3\">
                                <p>TTC : " . " " . "</p>
                            </div>
                            <div class=\"col-3\">
                                <p class=\"text-end\"> " . $formatTotal . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-3 offset-3\">
                                <p class=\"text-muted tvaDetails\">TVA 20% : " . " " . "</p>
                            </div>
                            <div class=\"col-3\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatTva . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-3 offset-3\">
                                <p class=\"text-muted tvaDetails\">Soit HT : " . " " . "</p>
                            </div>
                            <div class=\"col-3\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatHt . "€</p>
                            </div>
                        </div>
    
                        ";
            } else {
                echo "
                        <h5 class=\"text-center mt-2 mb-3\">Récapitulatif</h5>
                        <div class=\"row\">
                            <div class=\"col-3 offset-3\">
                                <p>Article : " . " " . "</p>
                            </div>
                            <div class=\"col-3\">
                                <p class=\"text-end\">$totalQuantity</p>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"col-3 offset-3\">
                                <p>TTC : " . " " . "</p>
                            </div>
                            <div class=\"col-3\">
                                <p class=\"text-end\"> " . $formatTotal . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-3 offset-3\">
                                <p class=\"text-muted tvaDetails\">TVA 20% : " . " " . "</p>
                            </div>
                            <div class=\"col-3\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatTva . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"col-3 offset-3\">
                                <p class=\"text-muted tvaDetails\">Soit HT : " . " " . "</p>
                            </div>
                            <div class=\"col-3\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatHt . "€</p>
                            </div>
                        </div>

                        ";
            }

        }
    }


    // AFFICHER LE PANIER DANS LA PAGE SHOPPING-CART.PHP
    function displayFinalCart() {
        if(count($_SESSION["cart"]) > 0) {
            foreach($_SESSION["cart"] as $article) {
                $priceFormat = number_format($article['price'], 2, ",", " ");
                $totalPriceFormat = number_format($article['totalPrice'], 2, ",", " ");
                    echo "
                    <div class=\"card mb-3\">
                        <div class=\"row g-0\">
                            <div class=\"col-md-2 align-self-center\">
                                <img src=\"" . $article["img"] . "\" class=\"img-fluid rounded-start\" alt=\"impage produit\">
                            </div>
                            <div class=\"col-md-3 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">" . $article["name"] . "</h5>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <p class=\"card-text\">" . $priceFormat . "€<span>/unité</span></p>
                                    <form action=\"add-to-cart.php\" method=\"post\"> 
                                        <input type=\"hidden\" name=\"itemPrice\" value=\"" . $article["price"] . "\">
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <form action=\"shopping-cart.php\" method=\"post\"> 
                                        <input type=\"number\" name=\"changeQuantity\" min=\"1\" max=\"10\" size=\"5\" value=\"" . $article["quantity"] . "\">
                                        <input type=\"hidden\" name=\"changeQuantityId\" min=\"1\" max=\"10\" value=\"" . $article["id"] . "\">
                                        <input type=\"submit\" value=\"Modifier\"/>
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <p class=\"card-text\">" . $totalPriceFormat . "€</p>
                                    <form action=\"shopping-cart.php\" method=\"post\"> 
                                        <input type=\"hidden\" name=\"itotalPrice\" value=\"" . $article["totalPrice"] . "\">
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-1 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <form action=\"shopping-cart.php\" method=\"post\">
                                        <input type=\"hidden\" name=\"deleteArticle\" value=\"" . $article["id"] . "\"/>
                                        <button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
            }
        } else {
            echo "<div class=\"col-12 text-center\">
                    <p>Votre panier est vide.</p>
                  </div>";
        }
    }


    // PRIX AVEC FRAIS DE PORT
    function priceWithShippingFees($total, $totalWithShippingFees, $totalQuantity) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $shippingFees = 0.9;
                $total += $_SESSION["cart"][$i]["totalPrice"];
                $totalQuantity += intval($_SESSION["cart"][$i]["quantity"]);
                $totalShippingFees = $totalQuantity * $shippingFees;
                $totalWithShippingFees = $total + $totalShippingFees;     
                $formatShippingFees = number_format($shippingFees, 2, ",", " "); 
                $formatTotalShippingFees = number_format($totalShippingFees, 2, ",", " ");
                $formatTotalWithShippingFees = number_format($totalWithShippingFees, 2, ",", " ");          
            }
            echo "
                    <div class=\"row\">
                        <div class=\"col-3 offset-3\">
                            <p class=\"text-muted\">Frais de port (" . $formatShippingFees . "€/article) : </p>
                        </div>
                        <div class=\"col-3\">
                            <p class=\"text-muted text-end\">" . $formatTotalShippingFees . "€</p>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-3 offset-3\">
                            <p class=\"totalTTC\">TOTAL TTC : </p>
                        </div>
                        <div class=\"col-3\">
                            <p class=\"text-end totalTTC\">" . $formatTotalWithShippingFees . "€</p>
                        </div>
                    </div>
                 ";
        }
    }


    // BOUTON VALIDER LA COMMANDE
    function validateShoppingCart() {
        if ($_SESSION["cart"] > 0) {
            echo "
                <form action=\"index.php\" method=\"post\">
                    <input type=\"submit\" name=\"validateAndDeleteAllArticles\" value=\"Valider ma commande\"/>
                </form>
                 ";
        } 
    }


?>