<?php
include 'db_connexion.php';

try {
    // Obtenir l'ID du joueur depuis l'URL
    $joueur_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Préparer et exécuter la requête pour récupérer l'image
    $sql = $conn->prepare('SELECT tete, image_type FROM joueur WHERE id = ?');
    $sql->execute([$joueur_id]);

    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $tete_blob = $row['tete'];
        $image_type = $row['image_type'];

        // Envoyer les en-têtes HTTP appropriés pour l'image
        header("Content-Type: " . $image_type);
        echo $tete_blob;
    } else {
        echo "Aucune image trouvée pour ce joueur.";
    }
} catch (PDOException $e) {
    echo "Erreur dans la requête SQL: " . $e->getMessage();
}

// Fermer la connexion
$conn = null;
