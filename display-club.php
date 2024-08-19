<link rel="stylesheet" href="display-club.css">

<?php
include 'navabar.php';
include 'db_connexion.php';

// Valider que `club_id` est un entier
$club_id = isset($_GET['club_id']) ? (int)$_GET['club_id'] : 0;

if ($club_id > 0) {  // Vérifier que l'ID est positif et valide
    $sql = 'SELECT * FROM club WHERE id = :id';
    $req = $conn->prepare($sql);
    $req->bindParam(':id', $club_id, PDO::PARAM_INT);  // Utilisation de la bonne variable et spécification du type
    $req->execute();
    $club = $req->fetch(PDO::FETCH_ASSOC);  // Récupère une seule ligne

    if ($club) {  // Vérification si le club existe
?>
        <div class="container-club-solo">
            <div class="club-card card-solo-club">
                <div class="club-logo">
                    <?php
                    $emblem = !empty($club['emblem']) ? htmlspecialchars($club['emblem']) : 'assets/default.jpg';
                    $clubName = !empty($club['nom']) ? htmlspecialchars($club['nom']) : 'Nom du club inconnu';
                    echo "<img class='club-img' src='" . $emblem . "' alt='Emblème de " . $clubName . "'>";
                    ?>
                </div>
                <div class="club-details">
                    <h2 class="club-name"><?= $clubName; ?></h2>
                    <h3 class="club-foundation">Créé en <?= !empty($club['fondation']) ? htmlspecialchars($club['fondation']) : 'Date inconnue'; ?></h3>
                    <p class="club-stadium">Stade : <?= !empty($club['stade']) ? htmlspecialchars($club['stade']) : 'Stade inconnu'; ?></p>
                </div>
            </div>
        </div>
<?php
        // Appel API pour obtenir les matchs
        $url = 'https://api.football-data.org/v4/teams/' . $club_id . '/matches/';
        $apiKey = "61699dfffd574937b59a393d04847b66";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Auth-Token: $apiKey"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        // Vérifie s'il y a une erreur de cURL
        if ($response === false) {
            echo "<p class='error-message'>Erreur de récupération des données.</p>";
        } else {
            $parse = json_decode($response, true); // 'true' pour obtenir un tableau associatif

            echo "<div class='matches-section'>";
            echo "<div class='match-section'>";
            echo "<h4 class='section-title'>Matchs en cours</h4>";
            if (isset($parse['matches']) && is_array($parse['matches'])) {
                foreach ($parse['matches'] as $match) {
                    if ($match['status'] === 'IN_PLAY') {
                        $homeTeam = !empty($match['homeTeam']['name']) ? htmlspecialchars($match['homeTeam']['name']) : 'Équipe domicile inconnue';
                        $awayTeam = !empty($match['awayTeam']['name']) ? htmlspecialchars($match['awayTeam']['name']) : 'Équipe visiteuse inconnue';
                        $homeScore = isset($match['score']['fullTime']['home']) ? htmlspecialchars($match['score']['fullTime']['home']) : 'N/A';
                        $awayScore = isset($match['score']['fullTime']['away']) ? htmlspecialchars($match['score']['fullTime']['away']) : 'N/A';
                        $dateutc = $match['utcDate'];
                        $dateutc2 = $match['lastUpdated'];
                        $date1 = new DateTime($dateutc, new DateTimeZone('UTC'));
                        $date2 = new DateTime($dateutc2, new DateTimeZone('UTC'));
                        $date1->setTimezone(new DateTimeZone('Europe/Paris'));
                        $date2->setTimezone(new DateTimeZone('Europe/Paris'));
                        $interval = $date1->diff($date2);

                        echo '<p>En cours : ' . $interval->format("%y années, %m mois, %d jours, %h heures, %i minutes, %s secondes") . '</p>';

                        echo "<div class='match-card finished'>";
                        echo "<div class='match-info'>";
                        echo "<span class='team-name'><img class='logo-club' src='" . $match['homeTeam']['crest'] . "'>$homeTeam</span>";
                        echo "<div class='score-circle'>$homeScore</div>";
                        echo "<span class='team-name'><img class='logo-club' src='" . $match['awayTeam']['crest'] . "'>$awayTeam</span>";
                        echo "<div class='score-circle'>$awayScore</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            }
            echo "<h4 class='section-title'>Matchs récents</h4>";
            echo "<div class='match-results'>";
            if (isset($parse['matches']) && is_array($parse['matches'])) {
                foreach ($parse['matches'] as $match) {
                    if ($match['status'] === 'FINISHED') {
                        $homeTeam = !empty($match['homeTeam']['name']) ? htmlspecialchars($match['homeTeam']['name']) : 'Équipe domicile inconnue';
                        $awayTeam = !empty($match['awayTeam']['name']) ? htmlspecialchars($match['awayTeam']['name']) : 'Équipe visiteuse inconnue';
                        $homeScore = isset($match['score']['fullTime']['home']) ? htmlspecialchars($match['score']['fullTime']['home']) : 'N/A';
                        $awayScore = isset($match['score']['fullTime']['away']) ? htmlspecialchars($match['score']['fullTime']['away']) : 'N/A';
                        $dateutc = $match['utcDate'];
                        $date = new DateTime($dateutc, new DateTimeZone('UTC'));
                        $date->setTimezone(new DateTimeZone('Europe/Paris'));
                        $formateddate = $date->format('d m Y \a\t H:i');

                        echo "<div class='match-card finished'>";
                        echo "<div class='match-info'>";
                        echo "<span class='team-name'><img class='logo-club' src='" . $match['homeTeam']['crest'] . "'>$homeTeam</span>";
                        echo "<div class='score-circle'>$homeScore</div>";
                        echo "<span class='team-name'><img class='logo-club' src='" . $match['awayTeam']['crest'] . "'>$awayTeam</span>";
                        echo "<div class='score-circle'>$awayScore</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            }
            echo "</div>";
            echo "</div>";

            echo "<div class='match-section'>";
            echo "<h4 class='section-title'>Prochains matchs</h4>";
            echo "<div class='match-schedule'>";
            if (isset($parse['matches']) && is_array($parse['matches'])) {
                foreach ($parse['matches'] as $match) {
                    if ($match['status'] === 'TIMED') {
                        $homeTeam = !empty($match['homeTeam']['name']) ? htmlspecialchars($match['homeTeam']['name']) : 'Équipe domicile inconnue';
                        $awayTeam = !empty($match['awayTeam']['name']) ? htmlspecialchars($match['awayTeam']['name']) : 'Équipe visiteuse inconnue';
                        $homeScore = isset($match['score']['fullTime']['home']) ? htmlspecialchars($match['score']['fullTime']['home']) : 'N/A';
                        $awayScore = isset($match['score']['fullTime']['away']) ? htmlspecialchars($match['score']['fullTime']['away']) : 'N/A';
                        $dateutc = $match['utcDate'];
                        $date = new DateTime($dateutc, new DateTimeZone('UTC'));
                        $date->setTimezone(new DateTimeZone('Europe/Paris'));
                        $formateddate = $date->format('d/m/Y \à H:i');

                        echo $formateddate;

                        echo "<div class='match-card scheduled'>";
                        echo "<div class='match-info'>";
                        echo "<span class='team-name'><img class='logo-club' src='" . $match['homeTeam']['crest'] . "'>$homeTeam</span> ";
                        echo "<div class='score-circle'>$homeScore</div>";
                        echo "<span class='team-name'><img class='logo-club' src='" . $match['awayTeam']['crest'] . "'>$awayTeam</span>";
                        echo "<div class='score-circle'>$awayScore</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                if (isset($parse['matches']) && is_array($parse['matches'])) {
                    foreach ($parse['matches'] as $match) {
                        if ($match['status'] === 'SCHEDULED') {
                            $homeTeam = !empty($match['homeTeam']['name']) ? htmlspecialchars($match['homeTeam']['name']) : 'Équipe domicile inconnue';
                            $awayTeam = !empty($match['awayTeam']['name']) ? htmlspecialchars($match['awayTeam']['name']) : 'Équipe visiteuse inconnue';
                            $homeScore = isset($match['score']['fullTime']['home']) ? htmlspecialchars($match['score']['fullTime']['home']) : 'N/A';
                            $awayScore = isset($match['score']['fullTime']['away']) ? htmlspecialchars($match['score']['fullTime']['away']) : 'N/A';
                            $dateutc = $match['utcDate'];
                            $date = new DateTime($dateutc, new DateTimeZone('UTC'));
                            $date->setTimezone(new DateTimeZone('Europe/Paris'));
                            $formateddate = $date->format('d/m/Y');

                            echo '<p>Le : ' . $formateddate . ' (pas encore programmé)</p>';
                            echo "<div class='match-card scheduled'>";
                            echo "<div class='match-info'>";
                            echo "<span class='team-name'><img class='logo-club' src='" . $match['homeTeam']['crest'] . "'>$homeTeam</span>";
                            echo "<div class='score-circle'>$homeScore</div>";
                            echo "<span class='team-name'><img class='logo-club' src='" . $match['awayTeam']['crest'] . "'>$awayTeam</span>";
                            echo "<div class='score-circle'>$awayScore</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                }
            }
            echo "</div>";
            echo "</div>";

            echo "</div>";
        }
    } else {
        echo "<p class='error-message'>Le club demandé n'existe pas.</p>";
    }
} else {
    echo "<p class='error-message'>Identifiant de club invalide.</p>";
}

$sql = 'SELECT * FROM joueur INNER JOIN joueur_club ON joueur.id = joueur_club.joueur_id 
        WHERE club_id = :club_id';
$req = $conn->prepare($sql);
$req->bindParam(':club_id', $club_id, PDO::PARAM_INT);
$req->execute();
$results = $req->fetchAll(PDO::FETCH_ASSOC); ?>

<div class="container">
    <div class="gardiens section-spacing">
        <p class="section-title">Les gardiens</p>
        <ul class="joueur-list">
            <?php foreach ($results as $joueur) {
                if ($joueur['poste'] === 'G') {
                    echo '<li><strong>' . htmlspecialchars($joueur['nom']) . '</strong> ' . htmlspecialchars($joueur['prenom']) . '</li>';
                }
            } ?>
        </ul>
    </div>

    <div class="defenseurs section-spacing">
        <p class="section-title">Les défenseurs</p>
        <ul class="joueur-list">
            <?php
            $defenseurs = ['Défenseur', 'Défenseur Central', 'Défenseur Droit', 'Défenseur Gauche'];
            foreach ($results as $joueur) {
                if (in_array($joueur['poste'], $defenseurs)) {
                    echo '<li><strong>' . htmlspecialchars($joueur['nom']) . '</strong> ' . htmlspecialchars($joueur['prenom']) . '</li>';
                }
            }
            ?>
        </ul>
    </div>

    <div class="milieux section-spacing">
        <p class="section-title">Les milieux</p>
        <ul class="joueur-list">
            <?php
            $milieux = ['Central Midfield', 'Milieu Défensif', 'Midfield', 'Milieu Offensif', 'Milieu', 'Milieu Central'];
            foreach ($results as $joueur) {
                if (in_array($joueur['poste'], $milieux)) {
                    echo '<li><strong>' . htmlspecialchars($joueur['nom']) . '</strong> ' . htmlspecialchars($joueur['prenom']) . '</li>';
                }
            }
            ?>
        </ul>
    </div>

    <div class="attaquants section-spacing">
        <p class="section-title">Les attaquants</p>
        <ul class="joueur-list">
            <?php
            $attaquants = ['Attaquant', 'Attaquant Droit', 'Buteur', 'Attaquant Gauche'];
            foreach ($results as $joueur) {
                if (in_array($joueur['poste'], $attaquants)) {
                    echo '<li><strong>' . htmlspecialchars($joueur['nom']) . '</strong> ' . htmlspecialchars($joueur['prenom']) . '</li>';
                }
            }
            ?>
        </ul>
    </div>
</div>