<?php

require_once 'user-pdo.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login     = $_POST['login'] ?? '';
    $password  = $_POST['password'] ?? '';
    $email     = $_POST['email'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $lastname  = $_POST['lastname'] ?? '';

    if ($login && $password && $email && $firstname && $lastname) {
        $user = new Userpdo();
        $user->register($login, $password, $email, $firstname, $lastname);
        $message = "Inscription réussie.";
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
    <title>Inscription</title>
</head>

<body>
    <div class="container">
        <h1>Inscription</h1>

        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Login :</label><br>
            <input type="text" name="login" required><br><br>

            <label>Mot de passe :</label><br>
            <input type="password" name="password" required><br><br>

            <label>Email :</label><br>
            <input type="email" name="email" required><br><br>

            <label>Prénom :</label><br>
            <input type="text" name="firstname" required><br><br>

            <label>Nom :</label><br>
            <input type="text" name="lastname" required><br><br>

            <button type="submit">S'inscrire</button>
        </form>

        <p><a href="login.php">Déjà inscrit ? Se connecter</a></p>
    </div>
</body>

</html>