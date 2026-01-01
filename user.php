<?php
// 1. DÉMARRAGE DE LA SESSION
session_start();

// 2. SÉCURITÉ : SEUL UN USER PEUT ACCÉDER
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// 3. CONNEXION À LA BASE DE DONNÉES
require 'db.php';

// 4. RÉCUPÉRER UNIQUEMENT LES TÂCHES DU USER
$sql = "SELECT * FROM tache
        WHERE id_user = :id_user
        ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id_user' => $_SESSION['user_id']
]);

$taches = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes tâches</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- INFOS UTILISATEUR -->
    <p class="text-end">
        Connecté :
        <strong><?= $_SESSION['prenom'] ?> <?= $_SESSION['nom'] ?></strong>
        | <a href="logout.php">Déconnexion</a>
    </p>

    <h2 class="text-center mb-4">Mes tâches</h2>

    <!-- SI AUCUNE TÂCHE -->
    <?php if (empty($taches)): ?>
        <p class="text-center text-muted">Aucune tâche</p>
    <?php endif; ?>

    <!-- TABLEAU DES TÂCHES -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Statut</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($taches as $tache): ?>
            <tr>
                <td><?= htmlspecialchars($tache['titre']) ?></td>
                <td><?= htmlspecialchars($tache['description']) ?></td>
                <td>
                    <span class="badge bg-<?= $tache['statut'] === 'terminée' ? 'success' : 'warning' ?>">
                        <?= $tache['statut'] ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
