<?php

require_once 'user-pdo.php';

$message   = '';
$userInfos = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($login && $password) {
        $user = new Userpdo();
        if ($user->connect($login, $password)) {
            $userInfos = $user->getAllInfos();
            $message   = "Connexion réussie.";
        } else {
            $message = "Login ou mot de passe incorrect.";
        }
    } else {
        $message = "Merci de remplir tous les champs.";
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="assets/style.css">
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>

<body>
    <div class="container">
        <h1>Connexion</h1>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Login :</label><br>
            <input type="text" name="login" required><br><br>

            <label>Mot de passe :</label><br>
            <input type="password" name="password" required><br><br>

            <button type="submit">Se connecter</button>
        </form>

        <?php if ($userInfos): ?>
            <h2>Informations de l'utilisateur connecté</h2>
            <ul>
                <li>ID : <?= htmlspecialchars($userInfos['id']) ?></li>
                <li>Login : <?= htmlspecialchars($userInfos['login']) ?></li>
                <li>Email : <?= htmlspecialchars($userInfos['email']) ?></li>
                <li>Prénom : <?= htmlspecialchars($userInfos['firstname']) ?></li>
                <li>Nom : <?= htmlspecialchars($userInfos['lastname']) ?></li>
            </ul>
        <?php endif; ?>

        <p><a href="register.php">Créer un compte</a></p>
    </div>
</body>

</html>