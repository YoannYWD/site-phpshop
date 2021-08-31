<?php 

function getConnection() {
    $dsn = "mysql:host=localhost;dbname=boutique_en_ligne";
    $username = "root";
    $password = "";
    $options = [];
    try { // fonction d'exception
        $connection = new PDO($dsn, $username, $password, $options); // connection en instance de PDO
        //print "<p class=\"mb-0\" style=\"color: #000000; font-style: italic;\">Connexion réussie 😎</p>";
    } catch(PDOException $e) { //fonction qui permet d'afficher le message d'erreur si try ne fonctionne pas
        print "error : " . $e->getMessage();
        die();
    }
    return $connection;
}

/* 
INDEX 

- AFFICHAGE DE L'ENSEMBLE DES PRODUITS
- AFFICHER UN PRODUIT DANS LA PAGE PRODUCT.PHP
- AFFICHAGE BOUTON "CONTINUER MES ACHATS" PAGE PRODUCT.PHP
- RECUPERER UN PRODUIT CLIQUÉ POUR AJOUT AU PANIER
- AJOUTER LE PRODUIT DANS LE PANIER
- AFFICHER LE PANIER
- SUPPRIMER UN PRODUIT 
- AFFICHAGE BOUTON SUPPRIMER TOUS LES PRODUITS PAGE VALIDATION
- AFFICHAGE BOUTON SUPPRIMER TOUS LES PRODUITS
- SUPPRIMER TOUS LES PRODUITS
- AFFICHER LE PRIX TOTAL DU PANIER
- FONCTIONS AFFICHAGE QUANTITE TOTALE
- MODIFIER LA QUANTITE
- AFFICHAGE PHRASE RETOUR PAGE ARTICLES
- AFFICHAGE BOUTON CONTINUER MES ACHATS
- AFFICHAGE BOUTON VALIDATION DE PANIER
- AFFICHER LE RECAP TOTAL DU PANIER PAGE VALIDATION
- AFFICHER LE PANIER DANS LA PAGE SHOPPING-CART.PHP
- PRIX AVEC FRAIS DE PORT
- BOUTON PASSER A LA LIVRAISON
- PRIX AVEC FRAIS DE LIVRAISON
- AFFICHAGE MODAL
- ENREGISTREMENT COMMANDE
- VERIFICATION PASSWORD SECURISE
- ENREGISTRER NOUVEL UTILISATEUR
- ENREGISTRER ADRESSE UTILISATEUR
- LOG IN
- AFFICHER LES INFORMATIONS DE L'UTILISATEUR PAGE PROFIL
- AFFICHER BOUTONS PAGE PROFIL
- CHAMPS DE MODIFICATION DU PROFIL UTILISATEUR
- SAUVEGARDE MODIFICATION PROFIL UTILISATEUR
- AFFICHER ADRESSE
- SAUVEGARDER CHANGEMENT ADRESSE
- MODIFICATION ADRESSE
- TOUTES LES COMMANDES
- DETAIL D'UNE COMMANDE
- RECUPERER ANCIEN MOT DE PASSE
- MISE A JOUR MOT DE PASSE
- RECUPERER LES GAMMES DE PRODUIT
- AFFICHER PRODUITS PAR GAMME

**************************************************************/

$totalPrice = 0;
$total=0;
$totalquantite=0;
$formatTotalWithDelivery = 0;
$totalWithDelivery = 0;


    // AFFICHAGE DE L'ENSEMBLE DES PRODUITS
    function showArticles() {
        $connection = getConnection();
        $sql = "SELECT * FROM articles;";
        $statement = $connection->prepare($sql); // statement en instance de connexion = récupère toutes ses fonctionnalités
        $statement->execute();
        $articles = $statement->fetchAll(PDO::FETCH_ASSOC); // méthode fetchAll pour renvoyer les données sous format objet
        foreach($articles as $article) {
            $priceFormat = number_format($article["prix"], 2, ",", " ");
            echo "
                    <div class=\"col-12 col-sm-6 col-lg-4 text-center mb-3\">
                        <div class=\"card\">
                            <img src=\"" . $article["image"] . "\" class=\"card-img-top\" alt=\"image produit\">
                            <div class=\"card-body\">
                                <h5 class=\"card-title\">" . $article["nom"] . "</h5>
                                <p class=\"card-text\">" . " " . $priceFormat . "€</p>
                                <p class=\"card-text text-muted\">En stock : " . " " . $article["stock"] . "</p>
                                <form action=\"product.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id\" value=\"" . $article["id"] . "\" />
                                    <input type=\"submit\" value=\"En détails\" class=\"buttonLarge\"/>
                                </form>
                                <form action=\"add-to-cart.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"name\" value=\"" . $article["nom"] . "\" />
                                    <input type=\"hidden\" name=\"price\" value=\"" . $article["prix"] . "\" />
                                    <input type=\"hidden\" name=\"id\" value=\"" . $article["id"] . "\" />
                                    <input type=\"submit\" value=\"Ajouter au panier\" class=\"buttonLargeImpact\"/>
                                </form>
                            </div>
                        </div>
                    </div>        
                 ";
        }
    }


    // AFFICHER UN PRODUIT DANS LA PAGE PRODUCT.PHP
    function showArticle($id) {
        $connection = getConnection();
        $sql = "SELECT * FROM articles WHERE id = " . $id . ";";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $article = $statement->fetchAll(PDO::FETCH_ASSOC);
        $priceFormat = number_format($article[0]["prix"], 2, ",", " ");
        echo "
               <div class=\"card mb-3 text-center\">
                <img src=\"" . $article[0]["image"] . "\" class=\"card-img-top mx-auto\" alt=\"image produit\" style=\"max-width: 540px;\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">" . $article[0]["nom"] . "</h5>
                    <p class=\"card-text\">" . $article[0]["description"] . "</p>
                    <p class=\"card-text\"><cite>" . $article[0]["description_detaillee"] . "</cite></p>
                    <p class=\"card-text\"><small class=\"text-muted\">" . $priceFormat . "€</small></p>
                    <form action=\"add-to-cart.php\" method=\"post\"> 
                       <input type=\"hidden\" name=\"id\" value=\"" . $article[0]["id"] . "\" />
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
        $connection = getConnection();
        $sql = "SELECT * FROM articles;";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($articles as $article) {
            if ($id == $article["id"]) {
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
            $article["quantite"] = 1;
            array_push($_SESSION["cart"], $article);
        }
    }


    // AFFICHER LE PANIER
    $totalPrice = 0;
    function displayCart($totalPrice) {
        if(count($_SESSION["cart"]) > 0) {
            foreach($_SESSION["cart"] as $article) {
                $priceFormat = number_format($article["prix"], 2, ",", " ");
                $totalPrice = $article["prix"] * $article["quantite"];
                $totalPriceFormat = number_format($totalPrice, 2, ",", " ");
                $stock = $article["stock"] - $article["quantite"];
                if ($stock >= 0) {
                    echo "
                        <div class=\"card mb-3\">
                            <div class=\"row g-0\">
                                <div class=\"col-md-2 align-self-center\">
                                    <img src=\"" . $article["image"] . "\" class=\"img-fluid rounded-start\" alt=\"impage produit\">
                                </div>
                                <div class=\"col-md-3 align-self-center text-center\">
                                    <div class=\"card-body\">
                                        <h5 class=\"card-title\">" . $article["nom"] . "</h5>
                                    </div>
                                </div>
                                <div class=\"col-md-2 align-self-center text-center\">
                                    <div class=\"card-body\">
                                        <p class=\"card-text\">" . $priceFormat . "€<span>/unité</span></p>
                                        <form action=\"add-to-cart.php\" method=\"post\"> 
                                            <input type=\"hidden\" name=\"itemPrice\" value=\"" . $article["prix"] . "\">
                                        </form>
                                    </div>
                                </div>
                                <div class=\"col-md-2 align-self-center text-center\">
                                    <div class=\"card-body\">
                                        <form action=\"add-to-cart.php\" method=\"post\"> 
                                            <input type=\"number\" name=\"changequantite\" min=\"1\" max=\"" . $article["stock"] . "\" size=\"5\" value=\"" . $article["quantite"] . "\">
                                            <input type=\"hidden\" name=\"changequantiteId\" min=\"1\" max=\"10\" value=\"" . $article["id"] . "\">
                                            <input type=\"submit\" value=\"Modifier\" class=\"button\"/>
                                        </form>
                                        <p>$stock produits restant.</p>
                                    </div>
                                </div>
                                <div class=\"col-md-2 align-self-center text-center\">
                                    <div class=\"card-body\">
                                    <p class=\"card-text\">" . $totalPriceFormat . "€</p>
                                        <form action=\"add-to-cart.php\" method=\"post\"> 
                                            <input type=\"hidden\" name=\"itotalPrice\" value=\"\">
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
                } else {
                    echo "
                    <div class=\"card mb-3\">
                        <div class=\"row g-0\">
                            <div class=\"col-md-2 align-self-center\">
                                <img src=\"" . $article["image"] . "\" class=\"img-fluid rounded-start\" alt=\"impage produit\">
                            </div>
                            <div class=\"col-md-3 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">" . $article["nom"] . "</h5>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <p class=\"card-text\">" . $priceFormat . "€<span>/unité</span></p>
                                    <form action=\"add-to-cart.php\" method=\"post\"> 
                                        <input type=\"hidden\" name=\"itemPrice\" value=\"" . $article["prix"] . "\">
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <form action=\"add-to-cart.php\" method=\"post\"> 
                                        <input type=\"number\" name=\"changequantite\" min=\"1\" max=\"10\" size=\"5\" value=\"" . $article["quantite"] . "\">
                                        <input type=\"hidden\" name=\"changequantiteId\" min=\"1\" max=\"10\" value=\"" . $article["id"] . "\">
                                        <input type=\"submit\" value=\"Modifier\" class=\"button\"/>
                                    </form>
                                    <p>Stock insuffisant</p>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                <p class=\"card-text\">" . $totalPriceFormat . "€</p>
                                    <form action=\"add-to-cart.php\" method=\"post\"> 
                                        <input type=\"hidden\" name=\"itotalPrice\" value=\"\">
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

    function totalPrice($total, $totalquantite) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $total += $_SESSION["cart"][$i]["prix"] * $_SESSION["cart"][$i]["quantite"];
                $totalquantite += intval($_SESSION["cart"][$i]["quantite"]);
                $formatTotal = number_format($total, 2, ",", " ");
                $tva = ($total / 120) * 20;
                $formatTva = number_format($tva, 2, ",", " ");   
                $ht = ($total - $tva);
                $formatHt = number_format($ht, 2, ",", " ");           
            }
            if ($totalquantite > 1) {
                echo " 
                    <div class=\"card mb-3 p-2 summaryCard\">
                        <h5 class=\"text-center mt-2 mb-3\">Récapitulatif</h5>
                        <div class=\"row\">
                            <div class=\"col-6\">
                                <p>Articles : " . " " . "</p>
                            </div>
                            <div class=\"col-6\">
                                <p class=\"text-end\">$totalquantite</p>
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
                                <p class=\"text-end\">$totalquantite</p>
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
    function totalquantite($totalquantite) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $totalquantite += intval($_SESSION["cart"][$i]["quantite"]);                
            }
            echo $totalquantite;
        }
    }



    // MODIFIER LA QUANTITE
    function changequantite($quantite, $articleid) {
        for($i = 0; $i < count($_SESSION["cart"]); $i++) {
            if ($_SESSION["cart"][$i]["quantite"] !== $quantite && $_SESSION["cart"][$i]["id"] == $articleid) {
                $_SESSION["cart"][$i]["totalPrice"] = $_SESSION["cart"][$i]["prix"] * $quantite;
                $_SESSION["cart"][$i]["quantite"] = $quantite;
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


    // AFFICHER LE RECAP TOTAL DU PANIER PAGE VALIDATION
    function finalTotalPrice($total, $totalquantite) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $total += $_SESSION["cart"][$i]["prix"] * $_SESSION["cart"][$i]["quantite"];
                $totalquantite += intval($_SESSION["cart"][$i]["quantite"]);
                $formatTotal = number_format($total, 2, ",", " ");
                $tva = ($total / 120) * 20;
                $formatTva = number_format($tva, 2, ",", " ");   
                $ht = ($total - $tva);
                $formatHt = number_format($ht, 2, ",", " ");           
            }
            if ($totalquantite > 1) {
                echo " 
                        <h5 class=\"text-center mt-2 mb-3\">Récapitulatif</h5>
                        <div class=\"row\">
                            <div class=\"offset-1 col-5 offset-sm-3 col-sm-3\">
                                <p>Articles : " . " " . "</p>
                            </div>
                            <div class=\"col-5 col-sm-3\">
                                <p class=\"text-end\">$totalquantite</p>
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
                                <p class=\"text-end\">$totalquantite</p>
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
                $priceFormat = number_format($article["prix"], 2, ",", " ");
                $totalPrice = $article["prix"] * $article["quantite"];
                $totalPriceFormat = number_format($totalPrice, 2, ",", " ");
                    echo "
                    <div class=\"card mb-3\">
                        <div class=\"row g-0\">
                            <div class=\"col-md-2 align-self-center\">
                                <img src=\"" . $article["image"] . "\" class=\"img-fluid rounded-start\" alt=\"impage produit\">
                            </div>
                            <div class=\"col-md-3 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">" . $article["nom"] . "</h5>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <p class=\"card-text\">" . $priceFormat . "€<span>/unité</span></p>
                                    <form action=\"add-to-cart.php\" method=\"post\"> 
                                        <input type=\"hidden\" name=\"itemPrice\" value=\"" . $article["prix"] . "\">
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <form action=\"shopping-cart.php\" method=\"post\"> 
                                        <input type=\"number\" name=\"changequantite\" min=\"1\" max=\"10\" size=\"5\" value=\"" . $article["quantite"] . "\">
                                        <input type=\"hidden\" name=\"changequantiteId\" min=\"1\" max=\"10\" value=\"" . $article["id"] . "\">
                                        <input type=\"submit\" value=\"Modifier\" class=\"button\"/>
                                    </form>
                                </div>
                            </div>
                            <div class=\"col-md-2 align-self-center text-center\">
                                <div class=\"card-body\">
                                    <p class=\"card-text\">" . $totalPriceFormat . "€</p>
                                    <form action=\"shopping-cart.php\" method=\"post\"> 
                                        <input type=\"hidden\" name=\"itotalPrice\" value=\"" . $totalPriceFormat . "\">
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
    function priceWithShippingFees($total, $totalWithShippingFees, $totalquantite) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $shippingFees = 0.9;
                $total += $_SESSION["cart"][$i]["prix"] * $_SESSION["cart"][$i]["quantite"];
                $totalquantite += intval($_SESSION["cart"][$i]["quantite"]);
                $totalShippingFees = $totalquantite * $shippingFees;
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
    function priceWithDelivery($total, $totalWithShippingFees, $totalquantite, $deliveryValue) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $shippingFees = 0.9;
                $total += $_SESSION["cart"][$i]["prix"] * $_SESSION["cart"][$i]["quantite"];
                $totalquantite += intval($_SESSION["cart"][$i]["quantite"]);
                $totalShippingFees = $totalquantite * $shippingFees;
                $totalWithShippingFees = $total + $totalShippingFees;     
                $formatShippingFees = number_format($shippingFees, 2, ",", " "); 
                $formatTotalShippingFees = number_format($totalShippingFees, 2, ",", " ");
                $formatTotalWithShippingFees = number_format($totalWithShippingFees, 2, ",", " ");
                $formatDeliveryValue = number_format($deliveryValue, 2, ",", " ");
                $totalWithDelivery = $totalWithShippingFees + intval($deliveryValue);
                $formatTotalWithDelivery = number_format($totalWithDelivery, 2, ",", " ");          
            }
            echo "
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
                        <div class=\"row\">
                            <div class=\"col-6 offset-sm-2 col-sm-4 offset-md-3 col-md-3\">
                                <p>Livraison : " . $formatDeliveryValue . "€</p>
                            </div>
                    </div>
                ";
        }
    }

    

    // AFFICHAGE MODAL
    function displayModal($total, $totalWithShippingFees, $totalquantite, $deliveryValue, $formatTotalWithDelivery, $totalWithDelivery) {
        if(count($_SESSION["cart"]) > 0) {
            for($i = 0; $i < count($_SESSION["cart"]); $i++) {
                $shippingFees = 0.9;
                $total += $_SESSION["cart"][$i]["prix"] * $_SESSION["cart"][$i]["quantite"];
                $totalquantite += intval($_SESSION["cart"][$i]["quantite"]);
                $totalShippingFees = $totalquantite * $shippingFees;
                $totalWithShippingFees = $total + $totalShippingFees;     
                $formatShippingFees = number_format($shippingFees, 2, ",", " "); 
                $formatTotalShippingFees = number_format($totalShippingFees, 2, ",", " ");
                $formatDeliveryValue = number_format($deliveryValue, 2, ",", " ");
                global $totalWithDelivery;
                $totalWithDelivery = $totalWithShippingFees + intval($deliveryValue);
                $formatTotalWithShippingFees = number_format($totalWithShippingFees, 2, ",", " ");
                global $formatTotalWithDelivery;
                $formatTotalWithDelivery = number_format($totalWithDelivery, 2, ",", " ");   
                setlocale(LC_TIME, "fr_FR", "French");
                $expedition = utf8_encode(date('Y-m-d', strtotime("+2 days")));
                $delivery = date('Y-m-d', strtotime("+6 days"));
        
            }
            echo "
                    <h5 class=\"text-center mb-4 totalTTC\">Montant payé : " . $formatTotalWithDelivery  . "€</h5>
                    <p class=\"text-center \">Expédition prévue le : " . utf8_encode(strftime("%A %d %B %G", strtotime($expedition))) . "</p>
                    <p class=\"text-center mb-4\">Livraison estimée le : " . utf8_encode(strftime("%A %d %B %G", strtotime($delivery))) . "</p>
                    <h5 class=\"text-center\">Merci pour votre confiance !</h5>
                 ";
            
        }
        $_SESSION["cart"]["prixTotal"] = $totalWithDelivery;
    }


    // ENREGISTREMENT COMMANDE
    function saveOrder() {
        $connection = getConnection();
        if(count($_SESSION["cart"]) > 0)  {
            $prix = $_SESSION["cart"]["prixTotal"];
            $rand = rand(0, 9999999);
            $numero = str_pad($rand, 7, '0', STR_PAD_LEFT);
            $sql = "INSERT INTO commandes (id_client, numero, date_commande, prix) VALUES (:id_client, :numero, :date_commande, :prix)";
            $statement = $connection->prepare($sql);
            $statement->execute([
                "id_client" => $_SESSION["idd"],
                "numero" => $numero,
                "date_commande" => date("d/m/Y h:i"),
                "prix" => $prix
            ]);
            
            $id = $connection->lastInsertId();
            
            $statement = $connection->prepare("INSERT INTO commande_articles (id_article, id_commande, quantite) VALUES (?, ?, ?)");
            foreach ($_SESSION["cart"] as $article) {
                $statement->execute(array(
                    $article["id"], $id, $article["quantite"]
                ));

                $stock = $article["stock"] - $article["quantite"];
                $sql2 = "UPDATE articles SET articles.stock = :stock WHERE articles.id = :articleId";
                $statement2 = $connection->prepare($sql2);
                $statement2->execute([
                    "stock" => $stock,
                    "articleId" => $article["id"]
                ]);
            }       
        }  
    }


    // VERIFICATION PASSWORD SECURISE
    //Must be a minimum of 8 characters
    //Must be a maximum of 15 characters
    //Must contain at least 1 letter
    //Must contain at least 1 number
    //Must contain a special character
    function verifPassword($mot_de_passe){
        $passwordOk = false;
        $regex = "^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@$!%*?/&])(?=\S+$).{8,15}$^";
        if (preg_match($regex, $mot_de_passe)) {
            $passwordOk = true;
        }
        return $passwordOk;
    }


    //ENREGISTRER NOUVEL UTILISATEUR
    function saveNewUser() {
        $connection = getConnection(); 
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        if (verifPassword($_POST['mot_de_passe'])) {
            $mot_de_passe = password_hash(strip_tags($_POST["mot_de_passe"]), PASSWORD_DEFAULT);  
            $sql = "INSERT INTO clients (nom, prenom, email, mot_de_passe) VALUES (?,?,?,?);";
            $statement = $connection->prepare($sql);
            $result = $statement->execute([$nom, $prenom, $email, $mot_de_passe]);
            if($result) {
                echo "<div class=\"col-12 text-center\">
                        <p>Utilisateur enregistré.</p>
                      </div>";
            } else {
                echo "<div class=\"col-12 text-center\">
                        <p>Une erreur s'est produite.</p>
                      </div>"; 
            }
        } else {
            echo "<div class=\"col-12 text-center\">
                    <p>Le mot de passe ne correspond pas aux critères de sécurité.</p>
                  </div>";
        }
        $_SESSION["nom"] = $nom;
        $_SESSION["prenom"] = $prenom;
        $_SESSION["email"] = $email;
        $_SESSION["idd"] = $connection->lastInsertId();

    }


    //ENREGISTRER ADRESSE UTILISATEUR
    function saveUserAdress() {
        $connection = getConnection();
        $adresse = $_POST["adresse"];
        $code_postal = $_POST["code_postal"];
        $ville = $_POST["ville"];
        $nom = $_SESSION["nom"];
        $prenom = $_SESSION["prenom"];
        $id = $_SESSION["idd"];
        $sql = "INSERT INTO adresses (id_client, adresse, code_postal, ville) VALUES (?,?,?,?);";
        $statement = $connection->prepare($sql);
        $result = $statement->execute([$id, $adresse, $code_postal, $ville]);
        if($result) {
            echo "<div class=\"col-12 text-center\">
                    <p>Adresse enregistrée.</p>
                    <form action=\"index.php\" method=\"post\">
                        <input type=\"submit\" value=\"Aller à la page d'accueil\" class=\"buttonLarge\"/>
                    </form>
                  </div>";
        } else {
            echo "<div class=\"col-12 text-center\">
                    <p>Une erreur s'est produite.</p>
                  </div>"; 
        }
    }


    // LOG IN 
    function logIn() {
        $connection = getConnection();
        $email = $_POST["email"];
        $sql = "SELECT * FROM clients WHERE email = ?";
        $statement = $connection->prepare($sql);
        $statement->execute([$email]);
        $client = $statement->fetchAll(PDO::FETCH_ASSOC);
        $passwordOk = password_verify($_POST["mot_de_passe"], $client[0]["mot_de_passe"]);
        if($passwordOk) {
            $_SESSION["nom"] = $client[0]["nom"];
            $_SESSION["prenom"] = $client[0]["prenom"];
            $_SESSION["email"] = $client[0]["email"];
            $_SESSION["idd"] = $client[0]["id"];
            echo "<div class=\"col-12 text-center\">
                    <p>Connexion réussie ! Bienvenue " . $client[0]["prenom"] . " " . $client[0]["nom"] . ".</p>
                    <form action=\"index.php\" method=\"post\">
                        <input type=\"submit\" value=\"Aller à la page d'accueil\" class=\"buttonLarge\"/>
                    </form>
                  </div>";
        } else {
            echo "<div class=\"col-12 text-center\">
                    <p>Mot de passe incorrect.</p>
                  </div>";
        }
    }


    //AFFICHER LES INFORMATIONS DE L'UTILISATEUR PAGE PROFIL
    function displayUserInformations() {
        $connection = getConnection();
        $nom = $_SESSION["nom"];
        $prenom = $_SESSION["prenom"];
        $id = $_SESSION["idd"];
        $sql = "SELECT c.nom, c.prenom, c.email, a.adresse, a.code_postal, a.ville FROM clients AS c
                INNER JOIN adresses AS a
                ON c.id = a.id_client
                WHERE c.id = '$id';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-12 text-center mt-5 mb-5\"><p class=\"text-decoration-underline\">Mon nom :</p>
                        <p>" . $clientConnecte[0]["nom"] . "</p>
                        <br>
                        <p class=\"text-decoration-underline\">Mon prénom :</p>
                        <p>" . $clientConnecte[0]["prenom"] . "</p>
                        <br>
                        <p class=\"text-decoration-underline\">Mon adresse mail :</p>
                        <p>" . $clientConnecte[0]["email"] . "</p>
                        <br>
                        <p class=\"text-decoration-underline\">Mon adresse :</p>
                        <p>" . $clientConnecte[0]["adresse"] . "</p>
                        <p>" . $clientConnecte[0]["code_postal"] . " " . $clientConnecte[0]["ville"] . "</p>
                        <br>
                    </div>
                </div>
            </div>";
    }


    //AFFICHER BOUTONS PAGE PROFIL
    function displayProfileBtns() {
        echo "<div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-4 text-center mb-5\">
                        <form action=\"profile-adress.php\">
                            <input type=\"submit\" name=\"orders\" value=\"Modifier mes informations personnelles\" class=\"buttonLargeImpact\"/>
                        </form>
                    </div>
                    <div class=\"col-4 text-center mb-5\">
                        <form action=\"profile-password.php\" method=\"post\">
                            <input type=\"submit\" name=\"orders\" value=\"Modifier mon mot de passe\" class=\"buttonLargeImpact\"/>
                        </form>
                    </div>
                    <div class=\"col-4 text-center mb-5\">
                        <form action=\"orders.php\" method=\"post\">
                            <input type=\"submit\" name=\"orders\" value=\"Voir mes commandes\" class=\"buttonLargeImpact\"/>
                        </form>
                    </div>
                </div>
            </div>
        ";
    }


    //CHAMPS DE MODIFICATION DU PROFIL UTILISATEUR
    function userModifProfile() {
        $connection = getConnection();
        $nom = $_SESSION["nom"];
        $prenom = $_SESSION["prenom"];
        $id = $_SESSION["idd"];
        $sql = "SELECT c.nom, c.prenom, c.email, a.adresse, a.code_postal, a.ville FROM clients AS c
                INNER JOIN adresses AS a
                ON c.id = a.id_client
                WHERE c.id = '$id';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "        <form action=\"profile.php\" method=\"post\">
        <p class=\"text-decoration-underline\">Modifier mon nom :</p>
            <input class=\"form-control\" type=\"text\" name=\"nom\" value=\"" . $clientConnecte[0]["nom"] . "\">
        <br>
        <p class=\"text-decoration-underline\">Modifier mon prénom :</p>
            <input class=\"form-control\" type=\"text\" name=\"prenom\" value=\"" . $clientConnecte[0]["prenom"] . "\">
        <br>
        <p class=\"text-decoration-underline\">Modifier mon adresse mail :</p>
            <input class=\"form-control\" type=\"email\" name=\"email\" value=\"" . $clientConnecte[0]["email"] . "\">
        <br>
        <p class=\"text-decoration-underline\">Modifier mon adresse :</p>
            <input class=\"form-control\" type=\"text\" name=\"adresse\" placeholder=\"Rue, boulevard, impasse...\" value=\"" . $clientConnecte[0]["adresse"] . "\">
            <input class=\"form-control\" type=\"text\" name=\"code_postal\" placeholder=\"Code postal\" value=\"" . $clientConnecte[0]["code_postal"] . "\">
            <input class=\"form-control\" type=\"text\" name=\"ville\" placeholder=\"Ville\" value=\"" . $clientConnecte[0]["ville"] . "\">
        <input type=\"submit\" value=\"Valider mes modifications\" name=\"mod_user\" class=\"buttonLarge\"/>
        </form>";
    }
    

    //SAUVEGARDE MODIFICATION PROFIL UTILISATEUR
    function saveUserModifProfile() {
        $connection = getConnection();
        $id = $_SESSION["idd"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $adresse = $_POST["adresse"];
        $code_postal = $_POST["code_postal"];
        $ville = $_POST["ville"];
        $sql = "UPDATE clients INNER JOIN adresses 
                SET clients.nom = '$nom', 
                    clients.prenom = '$prenom', 
                    clients.email = '$email', 
                    adresses.adresse = '$adresse',
                    adresses.code_postal = '$code_postal',
                    adresses.ville = '$ville'
                WHERE adresses.id_client = '$id' AND clients.id = '$id'; ";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<p class=\"text-center\">Les modifications ont été prises en compte.</p>";
    }


    //AFFICHER ADRESSE
    function displayAdress() {
        $connection = getConnection();
        $nom = $_SESSION["nom"];
        $prenom = $_SESSION["prenom"];
        $id = $_SESSION["idd"];
        $sql = "SELECT c.nom, c.prenom, c.email, a.adresse, a.code_postal, a.ville FROM clients AS c
                INNER JOIN adresses AS a
                ON c.id = a.id_client
                WHERE c.id = '$id';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "
            <p>" . $clientConnecte[0]["adresse"] . "</p>
            <p>" . $clientConnecte[0]["code_postal"] . " " . $clientConnecte[0]["ville"] . "</p>";
    }


    //SAUVEGARDER CHANGEMENT ADRESSE
    function saveAdress() {
        $connection = getConnection();
        $id = $_SESSION["idd"];
        $adresse = $_POST["adresse"];
        $code_postal = $_POST["code_postal"];
        $ville = $_POST["ville"];
        $sql = "UPDATE clients INNER JOIN adresses 
                SET adresses.adresse = '$adresse',
                    adresses.code_postal = '$code_postal',
                    adresses.ville = '$ville'
                WHERE adresses.id_client = '$id';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<p class=\"text-center\">Les modifications ont été prises en compte :</p>";
    }


    //MODIFICATION ADRESSE
    function modAdress() {
        $connection = getConnection();
        $nom = $_SESSION["nom"];
        $prenom = $_SESSION["prenom"];
        $id = $_SESSION["idd"];
        $sql = "SELECT c.nom, c.prenom, c.email, a.adresse, a.code_postal, a.ville FROM clients AS c
                INNER JOIN adresses AS a
                ON c.id = a.id_client
                WHERE c.id = '$id';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $clientConnecte = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<form action=\"delivery.php\" method=\"post\">
        <h5 class=\"text-center mt-2 mb-3\">Modifier mon adresse</h5>
                <input class=\"form-control\" type=\"text\" name=\"adresse\" placeholder=\"Rue, boulevard, impasse...\" value=\"" . $clientConnecte[0]["adresse"] . "\">
                <input class=\"form-control\" type=\"text\" name=\"code_postal\" placeholder=\"Code postal\" value=\"" . $clientConnecte[0]["code_postal"] . "\">
                <input class=\"form-control\" type=\"text\" name=\"ville\" placeholder=\"Ville\" value=\"" . $clientConnecte[0]["ville"] . "\">
                <input type=\"submit\" value=\"Valider mes modifications\" name=\"mod_user\" class=\"buttonLarge\"/>
                </form>";
    }


    // TOUTES LES COMMANDES
    function allOrders() {
        $connection = getConnection();
        $id_client = $_SESSION["idd"];
        $sql = "SELECT c.numero, c.date_commande, c.prix FROM commandes AS c WHERE c.id_client = '$id_client';";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    // DETAIL D'UNE COMMANDE
    function detailOrder() {
        $connection = getConnection();
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
                <h2 class=\"mt-3\">". number_format($details[0]["prix_total"], 2, ",", " ") . "€</h2>
                <h5>Passée le ". $details[0]["date_commande"] . "</h5>
            </div>
            ";
    }



    // RECUPERER ANCIEN MOT DE PASSE
    function getPassword() {       
        $connection = getConnection();
        $sql = "SELECT mot_de_passe FROM clients WHERE id = ?";
        $statement = $connection->prepare($sql);
        $statement->execute([$_SESSION["idd"]]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    // MISE A JOUR MOT DE PASSE
    function updatePassword() {
        $oldPassword = getPassword();
        $oldPassword = $oldPassword["mot_de_passe"];
        $passwordOk = password_verify(strip_tags($_POST["oldPassword"]), $oldPassword);
        if ($passwordOk) {
            $id = $_SESSION["idd"];
            $newPassword = $_POST["newPassword"];
            $connection = getConnection();
            $sql = "UPDATE clients SET mot_de_passe = :mot_de_passe WHERE id = :id";
            $statement = $connection->prepare($sql);
            $statement->execute(array(
                "mot_de_passe" => password_hash($newPassword, PASSWORD_DEFAULT),
                "id" => $id
            ));
            echo "<p class=\"text-center\">Votre mot de passe a été modifié.</p>";
        } else {
            echo "<p class=\"text-center\">L'ancien mot de passe est incorrect.</p>";
        };         
    }


    // RECUPERER LES GAMMES DE PRODUIT
    function ranges($id_gamme) {
        $connection = getConnection();
        $sql = "SELECT * FROM articles WHERE id_gamme = :id_gamme";
        $statement = $connection->prepare($sql);
        $statement->execute(array(
            "id_gamme" => $id_gamme
        ));
        $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $articles;
    }

    // AFFICHER PRODUITS PAR GAMME
    function showRanges() {
        $connection = getConnection();
        $sql = "SELECT * FROM gammes";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $gammes = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($gammes as $gamme) {
            echo "<div class=\"container mt-5 mb-5\">
                    <div class=\"row\">
                        <h4 class=\"text-center\">" . $gamme['nom'] . "</h4>
                 ";
                  $rangedArticles = ranges(intval($gamme["id"]));
            foreach ($rangedArticles as $rangedArticle) {
                echo "
                    <div class=\"col-3 text-center mt-3 mb-3\">
                        <div class=\"card\">
                            <img src=\"" . $rangedArticle["image"] . "\" class=\"card-img-top\" width=\"200px\" alt=\"image produit\">
                            <div class=\"card-body\">
                                <h5 class=\"card-title\">" . $rangedArticle["nom"] . "</h5>
                                <p class=\"card-text\">" . " " . $rangedArticle["prix"] . "€</p>
                                <p class=\"card-text text-muted\">En stock : " . " " . $rangedArticle["stock"] . "</p>
                                <form action=\"product.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"id\" value=\"" . $rangedArticle["id"] . "\" />
                                    <input type=\"submit\" value=\"En détails\" class=\"buttonLarge\"/>
                                </form>
                                <form action=\"add-to-cart.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"name\" value=\"" . $rangedArticle["nom"] . "\" />
                                    <input type=\"hidden\" name=\"price\" value=\"" . $rangedArticle["prix"] . "\" />
                                    <input type=\"hidden\" name=\"id\" value=\"" . $rangedArticle["id"] . "\" />
                                    <input type=\"submit\" value=\"Ajouter au panier\" class=\"buttonLargeImpact\"/>
                                </form>
                            </div>
                        </div>
                    </div>  
                    ";
            }
            echo " 
                    </div>
                  </div>
                ";
        }
    }
?>