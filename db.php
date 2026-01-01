<?php
/*
| CONNEXION À LA BASE DE DONNÉES
| Ce fichier est inclus partout
| Il crée la variable $pdo
*/

$host = "localhost";
$dbname = "listetaches";
$user = "root";
$pass = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    // Affiche les erreurs SQL (important pour apprendre)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
    }
?>