<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'db_connexion.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football | Ajouter un joueur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="add-player.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="logo">
            <img src="assets/Logo64x64.png" alt="logo" />
            <h1>Joueur de foot</h1>
        </div>
        <ul>
            <li><a href="../football player/index.php">Accueil</a></li>
            <li><a href="../football player/all-players.php">Tous les joueurs</a></li>
            <li><a href="../football player/add-player.php">Ajouter un joueur</a></li>
            <li><a href="../football player/affiche-clubs.php">Tous les clubs</a></li>
        </ul>
    </nav>

    <main class="form-container">
        <h2>Ajouter un joueur</h2>
        <form action="" method="post" enctype="multipart/form-data" id="playerForm">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="age">Âge</label>
                <input type="number" name="age" id="age" class="form-control" min="0" required>
            </div>
            <div class="form-group">
                <label for="nation">Nationalité</label>
                <input list="nations" name="nation" id="nation" class="form-control" required>
                <datalist id="nations">
                    <?php
                    $sql = $conn->prepare('SELECT PAYSNAME FROM pays ORDER BY PAYSNAME ASC');
                    $sql->execute();
                    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        echo '<option value="' . htmlspecialchars($row['PAYSNAME']) . '">';
                    }
                    ?>
                </datalist>
            </div>
            <div class="form-group">
                <label for="club">Club</label>
                <input type="text" name="club" id="club" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="poste">Poste</label>
                <input type="text" name="poste" id="poste" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tete">Photo</label>
                <input type="file" name="tete" id="tete" class="form-control-file" accept="image/*">
            </div>
            <button type="submit" class="btn">Envoyer</button>
        </form>
    </main>

    <script src="script.js"></script>
</body>

</html>