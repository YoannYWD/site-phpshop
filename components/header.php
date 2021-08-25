

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Culture</title>
    <link rel="icon" type="image/png" href="./assets/images/favicon.png">

    <!-- STYLES -->
    <link rel="stylesheet" href="./assets/css/reset-eric-mayer.css">
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Otomanopee+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&display=swap" rel="stylesheet">   

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">

</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="/site-phpshop"><img src="./assets/images/bee.jpg" alt="logo" width="100px"><span>Happy Culture</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
<<<<<<< Updated upstream
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/phpshop">Accueil</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/phpshop/add-to-cart">Panier</a>
                    </li>
                </ul>
=======
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/site-phpshop">Accueil</a>
                        </li>

                        <?php
                            if (!isset($_SESSION["prenom"]) && !isset($_SESSION["nom"])){
                                echo "<li class=\"nav-item\">
                                        <a class=\"nav-link\" href=\"/site-phpshop/register.php\">Inscription</a>
                                      </li>
                                      <li class=\"nav-item\">
                                        <a class=\"nav-link\" href=\"/site-phpshop/login.php\">Se connecter</a>
                                      </li>";
                            }   

                            if (isset($_SESSION["prenom"]) && isset($_SESSION["nom"])){
                                echo "<li class=\"nav-item\">
                                        <a class=\"nav-link\" href=\"/site-phpshop/add-to-cart.php\">Panier</a>
                                      </li>
                                      <li class=\"nav-item\">
                                        <a class=\"nav-link\" href=\"/site-phpshop/ranges.php\">Nos gammes de produits</a>
                                      </li>
                                      <li class=\"nav-item\">
                                        <a class=\"nav-link\" href=\"/site-phpshop/profile.php\">Mon profil</a>
                                      </li>";
                            }
                        ?>

                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php
                            if (isset($_SESSION["prenom"]) && isset($_SESSION["nom"])){
                                echo "<li class=\"nav-item me-2\">
                                        <p class=\"connection text-center\">" . $_SESSION["prenom"] . " " . $_SESSION["nom"] . "<p>
                                        <form action=\"index.php\" method=\"post\">
                                            <input type=\"submit\" class=\"buttonLarge\" name=\"log_out\" value=\"Se déconnecter\">
                                        </form>
                                    </li>";
                            }
                        ?>
                    </ul>
>>>>>>> Stashed changes
                </div>
            </div>
        </nav>
    </header>
    
