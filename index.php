<?php
    //On démarre une nouvelle session
    session_start();

    //Si la session n'existe pas, on crée une nouvelle carte
    if (empty($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    array_push($_SESSION['cart']);

    // //Afficher le panier
    // echo "<pre>";
    // print_r($_SESSION['cart']);
    // echo "</pre>";
?>


<?php
require './components/header.php';
?>



<?php
require './components/footer.php';
?>