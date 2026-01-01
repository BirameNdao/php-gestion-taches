<?php
// 1. DÉMARRAGE DE LA SESSION
// Obligatoire pour savoir si l'utilisateur est connecté
session_start();

// 2. SI L'UTILISATEUR N'EST PAS CONNECTÉ
// On l'envoie vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 3. REDIRECTION SELON LE RÔLE
// Si admin → page admin
// Sinon → page utilisateur
if ($_SESSION['role'] === 'admin') {
    header("Location: admin.php");
    exit;
} else {
    header("Location: user.php");
    exit;
}
?>