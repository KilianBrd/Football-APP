<?php
include 'db_connexion.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football | Ajouter une appréciation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav>
        <div class="logo">
            <img src="assets/Logo64x64.png" alt="logo" />
            <h1>Joueur de foot</h1>
        </div>
        <ul>
            <li>
                <a href="../football player/index.php">Accueil</a>
            </li>
            <li>
                <a href="../football player/all-players.php">Tous les joueurs</a>
            </li>
            <li>
                <a href="../football player/add-player.php">Ajouter un joueur</a>
            </li>
            <li>
                <a href="#">Ajouter une appréciation/note</a>
            </li>
        </ul>
        <div class="hamburger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </nav>
    <div class="menubar">
        <ul>
            <li>
                <a href="../football player/index.php">Accueil</a>
            </li>
            <li>
                <a href="../football player/all-players.php">Tous les joueurs</a>
            </li>
            <li>
                <a href="../football player/add-player.php">Ajouter un joueur</a>
            </li>
            <li>
                <a href="#">Ajouter appréciation/note</a>
            </li>
        </ul>
        <script src="script.js"></script>
    </div>
    <?php
    // Récupérer l'ID du joueur depuis l'URL
    $player_id = $_GET['player_id'];

    // Requête SQL pour récupérer les informations du joueur
    $req = 'SELECT * FROM joueur WHERE id = :player_id';
    $sql = $conn->prepare($req);
    $sql->bindParam(':player_id', $player_id, PDO::PARAM_INT); // Liaison correcte de l'ID
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        // Parcourir les résultats et afficher les informations du joueur
        foreach ($result as $row) {
    ?>
            <div class="container">
                <div class="card-solo">
                    <div class="card-top">
                        <?php
                        // Vérification de l'existence de l'image du profil (tete)
                        if (!empty($row["tete"])) {
                            echo "<img class='profil-solo' src='" . htmlspecialchars($row['tete']) . "' width='50', heigth='50'>";
                        } else {
                            echo "<img class='profil-solo' src='assets/default.jpg' width='100'>"; // Image par défaut si aucune image n'est disponible
                        }
                        ?>
                    </div>
                    <div class="card-infos">
                        <div class="nom-prenom">
                            <h2><?php
                                echo htmlspecialchars($row['nom']); ?></h2>
                            <h2><?php
                                echo htmlspecialchars($row['prenom']) ?></h2>
                        </div>
                        <h3 class="age"><?php echo htmlspecialchars($row['age']) . ' ans' ?></h3>
                        <p class="appreciation">
                            <?php
                            if (isset($row['appreciation']) && !is_null($row['appreciation'])) {
                                echo htmlspecialchars($row['appreciation']);
                            } ?>
                        </p>
                        <p class="nation-club">
                            <?php
                            echo 'Nationalité : ' . htmlspecialchars($row['nation']) . '<p class="nation-club"> Club : ' . htmlspecialchars($row['club']) . '</p>'; ?>
                        </p>
                        <p class="poste">
                            <?php
                            echo 'Poste : ' . htmlspecialchars($row['poste'])
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <form method="post" class="add-appreciation-form">
                <select name="rating" id="rating">
                    <?php for ($i = 0; $i <= 5; $i++) { ?>
                        <option value="<?php echo $i; ?>"> <?php echo $i; ?></option>
                    <?php
                    } ?>
                </select>
                <button type="submit">Ajouter une note</button>
            </form>
    <?php
        }
        if (isset($_POST['rating']) && !empty($_POST['rating'])) {
            $sql = 'INSERT INTO notes(joueur_id, note) VALUES (:player_id, :note)';
            $req = $conn->prepare($sql);
            $req->bindParam(':player_id', $player_id, PDO::PARAM_INT);
            $req->bindParam(':note', $_POST['rating']);
            $req->execute();
            header('Location: all-players.php?message=rating-success');
        }
    } else {
        echo "<p>Joueur non trouvé</p>";
    }

    // Fermer la connexion
    $conn = null;
    ?>
</body>

</html>