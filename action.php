<?php
// CONNEXION À LA BASE
require 'db.php';

// 1. AJOUTER UNE TÂCHE
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {

    $titre       = $_POST['titre'];
    $description = $_POST['description'];
    $statut      = $_POST['statut'];
    $id_user     = $_POST['id_user'];

    $sql = "INSERT INTO tache (titre, description, statut, id_user)
            VALUES (:titre, :description, :statut, :id_user)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':statut' => $statut,
        ':id_user' => $id_user
    ]);

    header("Location: admin.php");
    exit;
}

// 2. SUPPRIMER UNE TÂCHE
if (isset($_GET['supprimer'])) {

    $id = $_GET['supprimer'];

    $sql = "DELETE FROM tache WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: admin.php");
    exit;
}

// 3. RÉCUPÉRER UNE TÂCHE POUR MODIFICATION
$tache_a_modifier = null;

if (isset($_GET['modifier'])) {

    $id = $_GET['modifier'];

    $sql = "SELECT * FROM tache WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    $tache_a_modifier = $stmt->fetch();
}

// 4. MODIFIER UNE TÂCHE
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {

    $id          = $_POST['id'];
    $titre       = $_POST['titre'];
    $description = $_POST['description'];
    $statut      = $_POST['statut'];

    $sql = "UPDATE tache
            SET titre = :titre,
                description = :description,
                statut = :statut
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':statut' => $statut,
        ':id' => $id
    ]);

    header("Location: admin.php");
    exit;
}

// 5. LISTE DES TÂCHES
$taches = $pdo->query("SELECT * FROM tache ORDER BY id DESC")->fetchAll();
