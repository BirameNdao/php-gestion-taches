<?php
// 1. DÉMARRER LA SESSION
session_start();

// 2. SUPPRIMER TOUTES LES VARIABLES DE SESSION
session_unset();

// 3. DÉTRUIRE LA SESSION
session_destroy();

// 4. REDIRECTION VERS LOGIN
header("Location: login.php");
exit;
?>