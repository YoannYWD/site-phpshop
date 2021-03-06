<?php

/* 
INDEX 

- CREATION D'UN TABLEAU REGROUPANT LES PRODUITS
- AFFICHAGE DE L'ENSEMBLE DES PRODUITS
- AFFICHER UN PRODUIT DANS LA PAGE PRODUCT.PHP
- AFFICHAGE BOUTON "CONTINUER MES ACHATS" PAGE PRODUCT.PHP
- RECUPERER UN PRODUIT CLIQUÉ POUR AJOUT AU PANIER
- AJOUTER LE PRODUIT DANS LE PANIER
- AFFICHER LE PANIER
- SUPPRIMER UN PRODUIT 
- AFFICHAGE BOUTON SUPPRIMER TOUS LES PRODUITS
- SUPPRIMER TOUS LES PRODUITS
- AFFICHER LE PRIX TOTAL DU PANIER
- FONCTIONS AFFICHAGE QUANTITE TOTALE
- MODIFIER LA QUANTITE
- AFFICHAGE PHRASE RETOUR PAGE ARTICLES
- AFFICHAGE BOUTON CONTINUER MES ACHATS
- AFFICHAGE BOUTON VALIDATION DE PANIER
- AFFICHAGE TITRE CEUX QUI ONT ACHETE ONT AUSSI ACHETE
- AFFICHAGE CEUX QUI ONT ACHETE ONT AUSSI ACHETE
- AFFICHER LE RECAP TOTAL DU PANIER PAGE VALIDATION
- AFFICHER LE PANIER DANS LA PAGE SHOPPING-CART.PHP
- PRIX AVEC FRAIS DE PORT
- AFFICHAGE MODAL
- BOUTON PASSER A LA LIVRAISON
- PRIX AVEC FRAIS DE LIVRAISON
- BOUTON RETOUR PAGE ACCUEIL

**************************************************************/


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
            "name" => "Ruche Dadant 10 cadres bois",
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
                    <div class=\"col-12 col-sm-6 col-lg-4 text-center mb-3\">
                        <div class=\"card\">
                            <img src=\"" . $article['img'] . "\" class=\"card-img-top\" alt=\"image produit\">
                            <div class=\"card-body\">
                                <h5 class=\"card-title\">" . $article['name'] . "</h5>
                                <p class=\"card-text\"><span>" . $article['specPrice'] . "</span>" . " " . $priceFormat . "€</p>
                                <form action=\"product.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id\" value=\"" . $article['id'] . "\" />
                                    <input type=\"submit\" value=\"En détails\" class=\"buttonLarge\"/>
                                </form>
                                <form action=\"add-to-cart.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"name\" value=\"" . $article['name'] . "\" />
                                    <input type=\"hidden\" name=\"price\" value=\"" . $article['price'] . "\" />
                                    <input type=\"hidden\" name=\"id\" value=\"" . $article['id'] . "\" />
                                    <input type=\"submit\" value=\"Ajouter au panier\" class=\"buttonLargeImpact\"/>
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
        echo "
               <div class=\"card mb-3 text-center\">
                <img src=\"" . $article['img'] . "\" class=\"card-img-top mx-auto\" alt=\"image produit\" style=\"max-width: 540px;\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">" . $article['name'] . "</h5>
                    <p class=\"card-text\">" . $article['desc'] . "</p>
                    <p class=\"card-text\"><small class=\"text-muted\"><span>" . $article['specPrice'] . "</span>" . " " . $priceFormat . "€</small></p>
                    <form action=\"add-to-cart.php\" method=\"post\"> 
                       <input type=\"hidden\" name=\"id\" value=\"" . $article['id'] . "\" />
                       <input type=\"submit\" value=\"Ajouter au panier\" class=\"buttonLargeImpact\"/>
                    </form>
                </div>
              </div>
            ";
    }


    // AFFICHAGE BOUTON "CONTINUER MES ACHATS" PAGE PRODUCT.PHP
    function backToMainPage() {
        echo "  
                <tr>
                    <td>
                        <form action=\"index.php\" method=\"post\">
                            <input type=\"submit\" value=\"Continuer mes achats\" class=\"buttonLarge\"/>
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
                                        <input type=\"submit\" value=\"Modifier\" class=\"button\"/>
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
                                        <button type=\"submit\"><i class=\"fas fa-trash-alt\" class=\"btn\"></i></button>
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

    // AFFICHAGE BOUTON SUPPRIMER TOUS LES PRODUITS PAGE VALIDATION
    function deleteAllBtnSc() {
        if(count($_SESSION["cart"]) > 0) {
            echo "
                    <div class=\"row\">
                        <div class=\"col-12 text-center\">
                            <form action=\"add-to-cart.php\" method=\"post\">
                                <input type=\"hidden\" name=\"deleteAllArticles\"/>
                                <a href=\"/phpshop/add-to-cart\"><button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></a>
                            </form>
                        </div>
                    </div>

                    ";           
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
                                <a href=\"/phpshop/add-to-cart\"><button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></a>
                            </form>
                        </div>
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
                    <div class=\"card mb-3 p-2 summaryCard\">
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
                    <div class=\"card mb-3 p-2 summaryCard\">
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


    // AFFICHAGE BOUTON CONTINUER MES ACHATS
    function continueShopping() {
        if(count($_SESSION["cart"]) > 0) {
            echo "
                    <div class=\"row\">
                        <div class=\"col-12 text-center\">
                            <form action=\"index.php\" method=\"post\">
                                <input type=\"submit\" value=\"Continuer mes achats\" class=\"buttonLarge\"/>
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
                                <input type=\"submit\" value=\"Valider ma commande\" class=\"buttonLargeImpact\"/>
                            </form>
                        </div>
                    </div>
                 ";   
        }
    }


    // AFFICHAGE TITRE CEUX QUI ONT ACHETE ONT AUSSI ACHETE
    function showMoreArticlesTitle() {        
        if(count($_SESSION["cart"]) > 0) {
            echo "
                    <div class=\"row\">
                        <div class=\"col-12 text-center\">
                            <h1>Les clients qui ont acheté ceci ont également acheté</h1>
                        </div>
                    </div>               
                 ";
        }       
    }

    // AFFICHAGE CEUX QUI ONT ACHETE ONT AUSSI ACHETE
    function showMoreArticles() {
        $articles = getArticles();
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++){
                foreach($articles as $article) {
                    if ($_SESSION["cart"][$i]["id"] !== $article["id"] && !in_array($article["id"], $_SESSION["cart"][$i])) {
                        $priceFormat = number_format($article["price"], 2, ",", " ");
                        echo " 
                                <div class=\"col-12 col-sm-6 col-lg-4 text-center mb-5\">
                                    <div class=\"card\">
                                        <img src=\"" . $article["img"] . "\" class=\"card-img-top\" alt=\"image produit\">
                                        <div class=\"card-body\">
                                            <h5 class=\"card-title\">" . $article["name"] . "</h5>
                                            <p class=\"card-text\"><span>" . $article["specPrice"] . "</span>" . " " . $priceFormat . "€</p>
                                            <form action=\"product.php\" method=\"post\">
                                                <input type=\"hidden\" name=\"id\" value=\"" . $article["id"] . "\" />
                                                <input type=\"submit\" value=\"En détails\" class=\"buttonLarge\"/>
                                            </form>
                                            <form action=\"add-to-cart.php\" method=\"post\">
                                                <input type=\"hidden\" name=\"name\" value=\"" . $article["name"] . "\" />
                                                <input type=\"hidden\" name=\"price\" value=\"" . $article["price"] . "\" />
                                                <input type=\"hidden\" name=\"id\" value=\"" . $article["id"] . "\" />
                                                <input type=\"submit\" value=\"Ajouter au panier\" class=\"buttonLargeImpact\"/>
                                            </form>
                                        </div>
                                    </div>
                                </div>                  
                            ";     
                    } 
                }
            }
            
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
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p>Articles : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
                                <p class=\"text-end\">$totalQuantity</p>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p>TTC : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
                                <p class=\"text-end\"> " . $formatTotal . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p class=\"text-muted tvaDetails\">TVA 20% : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatTva . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p class=\"text-muted tvaDetails\">Soit HT : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatHt . "€</p>
                            </div>
                        </div>
    
                        ";
            } else {
                echo "
                        <h5 class=\"text-center mt-2 mb-3\">Récapitulatif</h5>
                        <div class=\"row\">
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p>Article : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
                                <p class=\"text-end\">$totalQuantity</p>
                            </div>
                        </div>
                        <div class=\"row mt-3\">
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p>TTC : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
                                <p class=\"text-end\"> " . $formatTotal . "€</p>
                            </div>
                        </div>
                        <div class=\"row\">
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p class=\"text-muted tvaDetails\">TVA 20% : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
                                <p class=\"text-muted text-end tvaDetails\"> " . $formatTva . "€</p>
                            </div>
                        </div>
                        <div class=\"row \">
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p class=\"text-muted tvaDetails\">Soit HT : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
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
                                        <input type=\"submit\" value=\"Modifier\" class=\"button\"/>
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
                        <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                            <p class=\"text-muted\">Frais de port (" . $formatShippingFees . "€/article) : </p>
                        </div>
                        <div class=\"col-5 col-sm-3\">
                            <p class=\"text-muted text-end\">" . $formatTotalShippingFees . "€</p>
                        </div>
                    </div>
                    <div class=\"row beforeTotalTTC\">
                    <h1></h1></div>
                    <div class=\"row\">
                        <div class=\"col-6 offset-sm-2 col-sm-4 offset-md-3 col-md-3\">
                            <p class=\"totalTTC\">TOTAL TTC : </p>
                        </div>
                        <div class=\"col-6 col-sm-4 col-md-3\">
                            <p class=\"text-end totalTTC\">" . $formatTotalWithShippingFees . "€</p>
                        </div>
                    </div>
                 ";
        }
    }

    // AFFICHAGE MODAL
    function displayModal($total, $totalWithShippingFees, $totalQuantity) {
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
 
                setlocale(LC_TIME, "fr_FR", "French");
                $expedition = utf8_encode(date('Y-m-d', strtotime("+2 days")));
                $delivery = date('Y-m-d', strtotime("+6 days"));
        
            }
            echo "
                    <h5 class=\"text-center mb-4 totalTTC\">Montant payé : " . $formatTotalWithShippingFees . "€</h5>
                    <p class=\"text-center \">Expédition prévue le : " . utf8_encode(strftime("%A %d %B %G", strtotime($expedition))) . "</p>
                    <p class=\"text-center mb-4\">Livraison estimée le : " . utf8_encode(strftime("%A %d %B %G", strtotime($delivery))) . "</p>
                    <h5 class=\"text-center\">Merci pour votre confiance !</h5>
                 ";
        }
    }


    // BOUTON PASSER A LA LIVRAISON
    function goToDelivery() {
        if ($_SESSION["cart"] > 0) {
            echo "
                <form action=\"delivery.php\" method=\"post\">
                    <input type=\"submit\" value=\"Choisir la livraison\" class=\"buttonLargeImpact\"/>
                </form>
                 ";
        } 
    }


    // PRIX AVEC FRAIS DE LIVRAISON
    function priceWithDelivery($total, $totalWithShippingFees, $totalQuantity, $deliveryValue) {
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
                $totalWithDelivery = $totalWithShippingFees + intval($deliveryValue);
                $formatTotalWithDelivery = number_format($totalWithDelivery, 2, ",", " ");          
            }
            echo "
                    <h5 class=\"text-center mt-2 mb-3\">Livraison</h5>
                    <div class=\"row\">
                        <div class=\"col-12\">
                            <p class=\"text-center\">Vous avez choisi la livraison " . ".</p>
                        </div>
                    </div>
                    <div class=\"row beforeTotalTTC\">
                    <h1></h1></div>
                    <div class=\"row\">
                        <div class=\"col-6 offset-sm-2 col-sm-4 offset-md-3 col-md-3\">
                            <p class=\"totalTTC\">TOTAL avec livraison : </p>
                        </div>
                        <div class=\"col-6 col-sm-4 col-md-3\">
                            <p class=\"text-end totalTTC\">" . $formatTotalWithDelivery . "€</p>
                        </div>
                    </div>
                 ";
        }
    }



    // BOUTON RETOUR PAGE ACCUEIL
    function validateShoppingCart() {
        if ($_SESSION["cart"] > 0) {
            echo "
                <form action=\"index.php\" method=\"post\">
                    <input type=\"submit\" name=\"validateAndDeleteAllArticles\" value=\"Retour à la page d'accueil\" class=\"buttonLargeImpact\"/>
                </form>
                 ";
        } 
    }


    // function delivery() {
    //     if (isset($_POST['delivery']) && ($_POST['delivery'] == $deliveryValue)) {
    //         $ending = "checked";
    //         return $ending;
    //     }
    //     else{
    //         $ending = "";
    //         return $ending;
    //     }
    // }

    // function displayDelivery($deliveryValues) {
    //     foreach($deliveryValues as $deliveryValue){
    //         echo "<label class=\"radio\" for=" . $deliveryValue . ">" . $deliveryValue . ",00€</label>
    //                 <input type=\"radio\" name=\"delivery\" value=\"" . $deliveryValue . "\" " . delivery($deliveryValue) . "/>";
    //     }
    // }

?>