<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dsn = "mysql:host=localhost;dbname=boutique_en_ligne";
$username = "Yoann";
$password = "Balmora1034!";
$options = [];
$connection = new PDO($dsn, $username, $password, $options); // connection en instance de PDO
try { // fonction d'exception
    //print "<p class=\"mb-0\" style=\"color: #000000; font-style: italic;\">Connexion réussie 😎</p>";
} catch(PDOException $e) { //fonction qui permet d'afficher le message d'erreur si try ne fonctionne pas
    print "error : " . $e->getMessage();
    die();
}
?>