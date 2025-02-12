<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire en toute sécurité
    $host = htmlspecialchars($_POST['host'] ?? 'localhost');
    $port = htmlspecialchars($_POST['port'] ?? '3306');
    $dbname = htmlspecialchars($_POST['dbname'] ?? '');
    $username = htmlspecialchars($_POST['username'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');

    // Initialise le message de statut
    $status = '';

    try {
        // Crée une nouvelle instance PDO pour la connexion à MariaDB
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active les exceptions en cas d'erreur
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Mode de récupération des données
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées
        ];

        $pdo = new PDO($dsn, $username, $password, $options);

        // Si la connexion est réussie
        $status = '<div style="color: green;">Connexion réussie à la base de données.</div>';
    } catch (PDOException $e) {
        // En cas d'échec de la connexion, capture l'exception et affiche le message d'erreur
        $status = '<div style="color: red;">Échec de la connexion : ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test de Connexion MariaDB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0 16px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin-top: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        h2 {
            text-align: center;
        }
        .status {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Tester la Connexion à MariaDB</h2>
    <form method="post" action="">
        <label for="host">Hôte :</label>
        <input type="text" id="host" name="host" placeholder="Ex. localhost" required value="<?php echo isset($host) ? htmlspecialchars($host) : 'localhost'; ?>">

        <label for="port">Port :</label>
        <input type="text" id="port" name="port" placeholder="Ex. 3306" required value="<?php echo isset($port) ? htmlspecialchars($port) : '3306'; ?>">

        <label for="dbname">Nom de la Base de Données :</label>
        <input type="text" id="dbname" name="dbname" placeholder="Ex. ma_base" required value="<?php echo isset($dbname) ? htmlspecialchars($dbname) : ''; ?>">

        <label for="username">Nom d'Utilisateur :</label>
        <input type="text" id="username" name="username" placeholder="Ex. root" required value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">

        <label for="password">Mot de Passe :</label>
        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>

        <input type="submit" value="Tester la Connexion">
    </form>

    <?php
    // Affiche le statut de la connexion après la soumission du formulaire
    if (isset($status)) {
        echo '<div class="status">' . $status . '</div>';
    }
    ?>
</div>

</body>
</html>
