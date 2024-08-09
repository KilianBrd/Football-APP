<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'db_connexion.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football | Ajouter un joueur </title>
    <!--link Font -->
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

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
    $sql = $conn->prepare('SELECT PAYSNAME FROM pays ORDER BY PAYSNAME ASC');
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h1>Ajouter un joueur</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="nom" id="nom" placeholder="Nom"><br>
        <input type="text" name="prenom" id="prenom" placeholder="Prénom"><br>
        <input type="text" name="age" id="age" placeholder="Âge"><br>

        <!-- Utilisation correcte de la datalist -->
        <input list="nations" name="nation" id="nation" placeholder="Nation">
        <datalist id="nations">
            <?php
            foreach ($result as $row) {
                echo '<option value="' . htmlspecialchars($row['PAYSNAME']) . '">';
            }
            ?>
        </datalist>
        <br>

        <input type="text" name="club" id="club" placeholder="Club"><br>
        <input type="text" name="poste" id="poste" placeholder="Poste"><br>
        <input type="file" name="tete" id="tete"><br>
        <input type="submit" value="Envoyer">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer les champs texte
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $age = $_POST['age'];
        $nation = $_POST['nation'];
        $club = $_POST['club'];
        $poste = $_POST['poste'];

        // Gérer le fichier uploadé
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["tete"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier si le fichier est bien une image
        $check = getimagesize($_FILES["tete"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // Vérifier si le fichier existe déjà
        if (file_exists($target_file)) {
            echo "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifier la taille du fichier (ici limité à 500KB)
        if ($_FILES["tete"]["size"] > 5000000) {
            echo "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Autoriser certains formats de fichier
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Vérifier si $uploadOk est à 0 en cas d'erreur
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été uploadé.";
            // Si tout est ok, essayer d'uploader le fichier
        } else {
            if (move_uploaded_file($_FILES["tete"]["tmp_name"], $target_file)) {
                echo "Le fichier " . basename($_FILES["tete"]["name"]) . " a été uploadé.";

                // Insertion dans la base de données
                $req = $conn->prepare('INSERT INTO joueur (nom, prenom, age, nation, club, poste, tete) VALUES (:nom, :prenom, :age, :nation, :club, :poste, :tete)');
                $req->bindParam(':prenom', $prenom);
                $req->bindParam(':nom', $nom);
                $req->bindParam(':age', $age);
                $req->bindParam(':nation', $nation);
                $req->bindParam(':club', $club);
                $req->bindParam(':poste', $poste);
                $req->bindParam(':tete', $target_file);
                $req->execute();
            } else {
                echo "Désolé, une erreur s'est produite lors de l'upload de votre fichier.";
            }
        }
    }
    ?>
    </form>
</body>

</html>