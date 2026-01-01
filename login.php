<?php
// --------------------------------------------------
// 1. DÉMARRAGE DE LA SESSION
// --------------------------------------------------
session_start();

// --------------------------------------------------
// 2. CONNEXION À LA BASE
// --------------------------------------------------
require 'db.php';

// --------------------------------------------------
// 3. MESSAGE D’ERREUR
// --------------------------------------------------
$error = null;

// --------------------------------------------------
// 4. TRAITEMENT DU FORMULAIRE
// --------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['login']) && !empty($_POST['mot_de_passe'])) {

        $login = $_POST['login'];
        $password = sha1($_POST['mot_de_passe']); // SHA1 demandé par le prof

        $sql = "SELECT id, nom, prenom, role
                FROM users
                WHERE login = :login
                AND mot_de_passe = :mot_de_passe";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':login' => $login,
            ':mot_de_passe' => $password
        ]);

        $user = $stmt->fetch();

        if ($user) {
            // Création de la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nom']     = $user['nom'];
            $_SESSION['prenom']  = $user['prenom'];
            $_SESSION['role']    = $user['role'];

            // Redirection selon le rôle
            if ($user['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: user.php");
            }
            exit;

        } else {
            $error = "Login ou mot de passe incorrect";
        }

    } else {
        $error = "Tous les champs sont obligatoires";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<!-- CARTE DE CONNEXION -->
<div class="card shadow p-4" style="width: 360px;">

    <h3 class="text-center mb-4">Connexion</h3>

    <!-- MESSAGE D’ERREUR -->
    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- FORMULAIRE -->
    <form method="post">

        <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" name="login" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                Se connecter
            </button>
        </div>

    </form>

</div>

</body>
</html>
