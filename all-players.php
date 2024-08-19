<?php
include 'db_connexion.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football | Tous les joueurs</title>
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
                <a href="../football player/affiche-clubs.php">Tous les clubs</a>
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

    <div class="recherche">
        <form method="get">
            <select name="agemin" id="agemin" class="agemin">
                <option value="" selected="selected">Choisir age min.</option>
                <?php
                for ($i = 15; $i < 45; $i++) { ?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php
                }
                ?>
            </select>
            <p> - </p>
            <select name="agemax" id="agemax" class="agemax">
                <option value="" selected="selected">Choisir age max.</option>
                <?php
                for ($i = 15; $i < 45; $i++) { ?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php
                }
                ?>
            </select>
            <input list="nations" name="nation" id="nation" placeholder="Nationnalité" class="searchPlayer">
            <datalist id="nations">
                <?php
                $req = $conn->prepare('SELECT PAYSNAME FROM pays');
                $req->execute();
                $paysname = $req->fetchAll(PDO::FETCH_ASSOC);
                foreach ($paysname as $pays) {
                    echo '<option value="' . htmlspecialchars($pays['PAYSNAME']) . '">';
                }
                ?>
            </datalist>
            <input list="clubs" name="club" id="club" placeholder="Club" class="searchPlayer">
            <datalist id="clubs">
                <?php
                $req = $conn->prepare('SELECT nom FROM club');
                $req->execute();
                $clubname = $req->fetchAll(PDO::FETCH_ASSOC);
                foreach ($clubname as $club) {
                    echo '<option value="' . htmlspecialchars($club['nom']) . '">';
                }
                ?>
            </datalist>
            <input type="text" name="playerSearch" id="playerSearch" placeholder="Rechercher un joueur" class="searchPlayer">
            <button type="submit" class="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <div class="initial">
        <a href="../football player/refresh.php">Réinitialiser la recherche</a>
    </div>
    <?php
    // Base SQL query
    $base_sql = 'SELECT
    j.id AS id,
    j.prenom,
    j.nom,
    j.poste,
    j.dateOfBirth,
    j.nation,
    j.appreciation as appreciation,
    c.id AS club_id,
    c.nom AS club,
    c.emblem AS club_emblem,
    c.stade AS club_stade,
    c.fondation AS club_fondation,
    YEAR(CURDATE()) - YEAR(j.dateOfBirth) AS age
FROM
    joueur j
INNER JOIN
    joueur_club jc ON j.id = jc.joueur_id
INNER JOIN
    club c ON jc.club_id = c.id
WHERE 1=1
';

    // Check if a search term is provided
    if (isset($_GET['playerSearch']) && !empty($_GET['playerSearch'])) {
        $joueur = $_GET['playerSearch'];
        // Add search condition to the base SQL
        $base_sql .= " AND (j.nom LIKE :joueur OR prenom LIKE :joueur)";
    }

    if (isset($_GET['agemin']) && !empty($_GET['agemin'])) {
        $age_min = $_GET['agemin'];
        $base_sql .= ' AND age >= :agemin';
    }

    if (isset($_GET['agemax']) && !empty($_GET['agemax'])) {
        $age_max = $_GET['agemax'];
        $base_sql .= ' AND age <= :agemax';
    }

    if (isset($_GET['nation']) && !empty($_GET['nation'])) {
        $nation = $_GET['nation'];
        $base_sql .= ' AND nation = :nation';
    }

    if (isset($_GET['club']) && !empty($_GET['club'])) {
        $clubsearch = $_GET['club'];
        $base_sql .= ' AND c.nom = :club';
    }

    $base_sql .= ' ORDER BY j.nom ASC LIMIT 50';

    try {
        // Prepare and execute the SQL query
        $sql = $conn->prepare($base_sql);

        if (isset($joueur)) {
            // Bind the search parameter
            $sql->bindValue(':joueur', "%$joueur%");
        }

        if (isset($age_min)) {
            $sql->bindParam(':agemin', $age_min, PDO::PARAM_INT);
        }

        if (isset($age_max)) {
            $sql->bindParam(':agemax', $age_max, PDO::PARAM_INT);
        }

        if (isset($nation)) {
            $sql->bindParam(':nation', $nation);
        }

        if (isset($clubsearch)) {
            $sql->bindParam(':club', $clubsearch);
        }


        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
        //message succès

        if (isset($_GET['messsage']) && !empty($_GET['message'])) {
            if ($_GET['message'] == 'rating-success') {
                echo 'La note a bien été ajoutée';
            }
        }

        // Check if there are players to display
        if (count($result) > 0) {
            // Display each player with their image
    ?>
            <div class="all-cards">
                <?php
                foreach ($result as $row) {
                    //Chercher le code pour afficher le drapeau
                    $requetedrap = 'SELECT PAYSCODE FROM pays WHERE PAYSNAME = :nation';
                    $reqnew = $conn->prepare($requetedrap);
                    $reqnew->bindParam(':nation', $row['nation']);
                    $reqnew->execute();
                    $countryCode = $reqnew->fetchColumn();

                    $img_path = '../football player/assets/pays/' . strtolower($countryCode) . '.svg';
                ?>

                    <div class="container">
                        <div class="card-solo">
                            <div class="card-top">
                                <?php
                                // Vérification de l'existence de l'image du profil (tete)
                                if (!empty($row["tete"])) {
                                    echo "<img class='profil-solo' src='" . htmlspecialchars($row['tete']) . "' width='50', heigth='50'>";
                                } else {
                                    echo "<img class='profil-solo' src='assets/default.jpg'>"; // Image par défaut si aucune image n'est disponible
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
                                        echo '<a href="../football player/add-appreciation.php?player_id=' . $row['id'] . '"><br>Modifier</a>';
                                    } else {
                                        //Ajouter une appréciation grace à add-appréciation.php
                                        echo '<a href="../football player/add-appreciation.php?player_id=' . $row['id'] . '">Ajouter une appréciation</a>';
                                    } ?>
                                </p>
                                <p class="nation-club">
                                    <?php
                                    echo 'Nationalité : ' . htmlspecialchars($row['nation']) . '<img src="' . $img_path . '" class="paysdrapeau">'; ?>
                                </p>
                                <p class="club">
                                <div class="club-petit-container">
                                    <p class="nation-club"> Club : <?= htmlspecialchars($row['club']) ?></p>
                                    <img class="logo-club" src="<?= htmlspecialchars($row['club_emblem']) ?>" alt="Emblème du Club">
                                </div>
                                </p>
                                <p class="poste">
                                    <?php
                                    echo 'Poste : ' . htmlspecialchars($row['poste'])
                                    ?>
                                </p>
                                <p class="moyenne">
                                    <?php
                                    $moy_sql = 'SELECT AVG(note) as moyenne FROM notes WHERE joueur_id = :player_id';
                                    $requ = $conn->prepare($moy_sql);
                                    $requ->bindParam(':player_id', $row['id'], PDO::PARAM_INT);
                                    $requ->execute();
                                    $resultavg = $requ->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    Note moyenne : <br>
                                    <?php
                                    if ($resultavg && $resultavg['moyenne'] !== null) {
                                        $moyenne = $resultavg['moyenne'];

                                        //On arrondit
                                        $rounded_moyenne = round($moyenne * 2) / 2;

                                        $image = '../football player/assets/rating/star-' . $rounded_moyenne . '.PNG';

                                        echo '<img src="' . $image . '">';
                                    } else {
                                        echo "Non noté";
                                    }
                                    ?>
                                </p>
                                <a href="../football player/add-rating.php?player_id=<?php echo $row['id'] ?>" class="add-rating-link">Ajouter une note</a>

                                <a href="../football player/remove-player.php?id=<?php echo $row['id'] ?>" class="delete-link">
                                    <button class="noselect delete"><span class="text">Supprimer</span><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path>
                                            </svg></span></button>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
    <?php
        } else {
            echo "<p>Aucun joueur trouvé.</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur dans la requête SQL: " . $e->getMessage();
    }

    // Close the connection
    $conn = null;
    ?>
</body>

</html>