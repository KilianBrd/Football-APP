    <?php
    include 'db_connexion.php'; // Connexion à la base de données

    $url = "https://api.football-data.org/v4/competitions/PD/teams";
    $apiKey = "61699dfffd574937b59a393d04847b66";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-Auth-Token: $apiKey"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $parse = json_decode($response);

    // Tableau de traduction des nationalités
    $nationalityMap = [
        'Afghanistan' => 'Afghanistan',
        'Albania' => 'Albanie',
        'Algeria' => 'Algérie',
        'Andorra' => 'Andorre',
        'Angola' => 'Angola',
        'Antigua and Barbuda' => 'Antigua-et-Barbuda',
        'Argentina' => 'Argentine',
        'Armenia' => 'Arménie',
        'Australia' => 'Australie',
        'Austria' => 'Autriche',
        'Azerbaijan' => 'Azerbaïdjan',
        'Bahamas' => 'Bahamas',
        'Bahrain' => 'Bahreïn',
        'Bangladesh' => 'Bangladesh',
        'Barbados' => 'Barbade',
        'Belarus' => 'Biélorussie',
        'Belgium' => 'Belgique',
        'Belize' => 'Belize',
        'Benin' => 'Bénin',
        'Bhutan' => 'Bhoutan',
        'Bolivia' => 'Bolivie',
        'Bosnia and Herzegovina' => 'Bosnie-Herzégovine',
        'Botswana' => 'Botswana',
        'Brazil' => 'Brésil',
        'Brunei' => 'Brunei',
        'Bulgaria' => 'Bulgarie',
        'Burkina Faso' => 'Burkina Faso',
        'Burundi' => 'Burundi',
        'Cabo Verde' => 'Cap-Vert',
        'Cambodia' => 'Cambodge',
        'Cameroon' => 'Cameroun',
        'Canada' => 'Canada',
        'Central African Republic' => 'République Centrafricaine',
        'Chad' => 'Tchad',
        'Chile' => 'Chili',
        'China' => 'Chine',
        'Colombia' => 'Colombie',
        'Comoros' => 'Comores',
        'Congo' => 'Congo',
        'Costa Rica' => 'Costa Rica',
        'Croatia' => 'Croatie',
        'Cuba' => 'Cuba',
        'Cyprus' => 'Chypre',
        'USA' => 'Etats-Unis',
        'Czech Republic' => 'République Tchèque',
        'Denmark' => 'Danemark',
        'Djibouti' => 'Djibouti',
        'Dominica' => 'Dominique',
        'Dominican Republic' => 'République Dominicaine',
        'East Timor' => 'Timor-Oriental',
        'Ecuador' => 'Équateur',
        'Egypt' => 'Égypte',
        'El Salvador' => 'Salvador',
        'Equatorial Guinea' => 'Guinée Équatoriale',
        'Eritrea' => 'Érythrée',
        'Estonia' => 'Estonie',
        'Eswatini' => 'Eswatini',
        'Ethiopia' => 'Éthiopie',
        'England' => 'Royaume-Uni',
        'Fiji' => 'Fidji',
        'Finland' => 'Finlande',
        'France' => 'France',
        'Ivory Coast' => 'Côte d\'Ivoire',
        'Gabon' => 'Gabon',
        'Gambia' => 'Gambie',
        'Georgia' => 'Géorgie',
        'Germany' => 'Allemagne',
        'Ghana' => 'Ghana',
        'Greece' => 'Grèce',
        'Grenada' => 'Grenade',
        'Guatemala' => 'Guatemala',
        'Guinea' => 'Guinée',
        'Guinea-Bissau' => 'Guinée-Bissau',
        'Guyana' => 'Guyane',
        'Haiti' => 'Haïti',
        'Honduras' => 'Honduras',
        'Hungary' => 'Hongrie',
        'Iceland' => 'Islande',
        'India' => 'Inde',
        'Indonesia' => 'Indonésie',
        'Iran' => 'Iran',
        'Iraq' => 'Irak',
        'Ireland' => 'Irlande',
        'Israel' => 'Israël',
        'Italy' => 'Italie',
        'Jamaica' => 'Jamaïque',
        'Japan' => 'Japon',
        'Jordan' => 'Jordanie',
        'Kazakhstan' => 'Kazakhstan',
        'Kenya' => 'Kenya',
        'Kiribati' => 'Kiribati',
        'Korea' => 'Corée',
        'Kuwait' => 'Koweït',
        'Kyrgyzstan' => 'Kirghizistan',
        'Laos' => 'Laos',
        'Latvia' => 'Lettonie',
        'Lebanon' => 'Liban',
        'Lesotho' => 'Lesotho',
        'Liberia' => 'Liberia',
        'Libya' => 'Libye',
        'Liechtenstein' => 'Liechtenstein',
        'Lithuania' => 'Lituanie',
        'Luxembourg' => 'Luxembourg',
        'Madagascar' => 'Madagascar',
        'Malawi' => 'Malawi',
        'Malaysia' => 'Malaisie',
        'Maldives' => 'Maldives',
        'Mali' => 'Mali',
        'Malta' => 'Malte',
        'Marshall Islands' => 'Îles Marshall',
        'Mauritania' => 'Mauritanie',
        'Mauritius' => 'Île Maurice',
        'Mexico' => 'Mexique',
        'Micronesia' => 'Micronésie',
        'Moldova' => 'Moldova',
        'Monaco' => 'Monaco',
        'Mongolia' => 'Mongolie',
        'Montenegro' => 'Monténégro',
        'Morocco' => 'Maroc',
        'Mozambique' => 'Mozambique',
        'Myanmar' => 'Myanmar',
        'Namibia' => 'Namibie',
        'Nauru' => 'Nauru',
        'Nepal' => 'Népal',
        'Netherlands' => 'Pays-Bas',
        'New Zealand' => 'Nouvelle-Zélande',
        'Nicaragua' => 'Nicaragua',
        'Niger' => 'Niger',
        'Nigeria' => 'Nigéria',
        'North Macedonia' => 'Macédoine du Nord',
        'Norway' => 'Norvège',
        'Oman' => 'Oman',
        'Pakistan' => 'Pakistan',
        'Palau' => 'Palau',
        'Panama' => 'Panama',
        'Papua New Guinea' => 'Papouasie-Nouvelle-Guinée',
        'Paraguay' => 'Paraguay',
        'Peru' => 'Pérou',
        'Philippines' => 'Philippines',
        'Poland' => 'Pologne',
        'Portugal' => 'Portugal',
        'Qatar' => 'Qatar',
        'Romania' => 'Roumanie',
        'Russia' => 'Russie',
        'Rwanda' => 'Rwanda',
        'Saint Kitts and Nevis' => 'Saint-Kitts-et-Nevis',
        'Saint Lucia' => 'Sainte-Lucie',
        'Saint Vincent and the Grenadines' => 'Saint-Vincent-et-les-Grenadines',
        'Samoa' => 'Samoa',
        'San Marino' => 'Saint-Marin',
        'Sao Tome and Principe' => 'Sao Tomé-et-Principe',
        'Saudi Arabia' => 'Arabie Saoudite',
        'Senegal' => 'Sénégal',
        'Serbia' => 'Serbie',
        'Seychelles' => 'Seychelles',
        'Sierra Leone' => 'Sierra Leone',
        'Singapore' => 'Singapour',
        'Slovakia' => 'Slovaquie',
        'Slovenia' => 'Slovénie',
        'Solomon Islands' => 'Îles Salomon',
        'Somalia' => 'Somalie',
        'South Africa' => 'Afrique du Sud',
        'South Sudan' => 'Soudan du Sud',
        'Spain' => 'Espagne',
        'Sri Lanka' => 'Sri Lanka',
        'Sudan' => 'Soudan',
        'Suriname' => 'Suriname',
        'Sweden' => 'Suède',
        'Switzerland' => 'Suisse',
        'Syria' => 'Syrie',
        'Taiwan' => 'Taïwan',
        'Tajikistan' => 'Tadjikistan',
        'Tanzania' => 'Tanzanie',
        'Thailand' => 'Thaïlande',
        'Togo' => 'Togo',
        'Tonga' => 'Tonga',
        'Trinidad and Tobago' => 'Trinité-et-Tobago',
        'Tunisia' => 'Tunisie',
        'Turkey' => 'Turquie',
        'Turkmenistan' => 'Turkménistan',
        'Tuvalu' => 'Tuvalu',
        'Uganda' => 'Ouganda',
        'Ukraine' => 'Ukraine',
        'United Arab Emirates' => 'Émirats Arabes Unis',
        'United Kingdom' => 'Royaume-Uni',
        'United States' => 'États-Unis',
        'Uruguay' => 'Uruguay',
        'Uzbekistan' => 'Ouzbékistan',
        'Vanuatu' => 'Vanuatu',
        'Vatican City' => 'Vatican',
        'Venezuela' => 'Venezuela',
        'Vietnam' => 'Viêt Nam',
        'Yemen' => 'Yémen',
        'Zambia' => 'Zambie',
        'Zimbabwe' => 'Zimbabwe'
    ];

    // Tableau de conversion des positions
    $positionMap = [
        'Goalkeeper' => 'G',
        'Defender' => 'Défenseur',
        'Defence' => 'Défenseur',
        'Midfield' => 'Milieu',
        'Forward' => 'Attaquant',
        'Centre-Forward' => 'Buteur',
        'Attacking Midfield' => 'Milieu Offensif',
        'Right Winger' => 'Attaquant Droit',
        'Left Winger' => 'Attaquant Gauche',
        'Right-Back' => 'Défenseur Droit',
        'Left-Back' => 'Défenseur Gauche',
        'Central Defender' => 'Défenseur Central',
        'Defensive Midfield' => 'Milieu Défensif',
        'Centre-Back' => 'Défenseur Central',
        'Offence' => 'Attaquant'
    ];


    if (isset($parse->competition) && isset($parse->teams)) {
        // Insérer ou mettre à jour la compétition
        $sql = 'INSERT INTO competition (id, nom, code, type, emblem) VALUES (:id, :name, :code, :type, :emblem)
                ON DUPLICATE KEY UPDATE nom = VALUES(nom), code = VALUES(code), type = VALUES(type), emblem = VALUES(emblem)';
        $req = $conn->prepare($sql);
        $req->execute([
            ':id' => $parse->competition->id,
            ':name' => $parse->competition->name,
            ':code' => $parse->competition->code,
            ':type' => $parse->competition->type,
            ':emblem' => $parse->competition->emblem
        ]);

        // Boucle sur les équipes
        foreach ($parse->teams as $team) {
            // Insérer ou mettre à jour le club
            $sql = 'INSERT INTO club (id, nom, emblem, stade, fondation) VALUES (:id, :nom, :emblem, :stade, :fondation)
            ON DUPLICATE KEY UPDATE nom = VALUES(nom), emblem = VALUES(emblem), stade = VALUES(stade), fondation = VALUES(fondation)';
            $req = $conn->prepare($sql);
            $req->execute([
                ':id' => $team->id,
                ':nom' => $team->name,
                ':emblem' => $team->crest,
                ':stade' => $team->venue,
                ':fondation' => $team->founded
            ]);

            $club_id = $team->id;

            // Insérer ou mettre à jour l'association dans la table club_competition
            $sql = 'INSERT INTO club_competition (competitioncode, club_id) VALUES (:competitioncode, :club_id)
            ON DUPLICATE KEY UPDATE club_id = VALUES(club_id)';
            $req = $conn->prepare($sql);
            $req->execute([
                ':competitioncode' => $parse->competition->id,
                ':club_id' => $club_id
            ]);

            // Boucle sur les joueurs de chaque équipe
            foreach ($team->squad as $player) {
                $nameParts = splitName($player->name);

                // Conversion de la position
                $position = $positionMap[$player->position] ?? $player->position;

                // Traduction de la nationalité
                $nationality = $nationalityMap[$player->nationality] ?? $player->nationality;

                // Insérer ou mettre à jour le joueur
                $sql = 'INSERT INTO joueur (id, prenom, nom, poste, dateOfBirth, nation) VALUES (:id, :prenom, :nom, :poste, :dateOfBirth, :nation)
                ON DUPLICATE KEY UPDATE prenom = VALUES(prenom), nom = VALUES(nom), poste = VALUES(poste), dateOfBirth = VALUES(dateOfBirth), nation = VALUES(nation)';
                $req = $conn->prepare($sql);
                $req->execute([
                    ':id' => $player->id,
                    ':prenom' => $nameParts['firstName'],
                    ':nom' => $nameParts['lastName'],
                    ':poste' => $position,
                    ':dateOfBirth' => $player->dateOfBirth,
                    ':nation' => $nationality
                ]);

                // Associer le joueur au club
                $sql = 'INSERT INTO joueur_club (joueur_id, club_id) VALUES (:joueur_id, :club_id)';
                $req = $conn->prepare($sql);
                $req->execute([
                    ':joueur_id' => $player->id,
                    ':club_id' => $club_id
                ]);
            }
        }


        echo "Les clubs et les joueurs ont été insérés avec succès.";
    } else {
        echo "Erreur: Impossible de récupérer les données.";
    }

    // Fonction pour séparer les noms
    function splitName($fullName)
    {
        $parts = explode(' ', $fullName);
        if (count($parts) >= 3) {
            return [
                'firstName' => $parts[0],
                'lastName' => implode(' ', array_slice($parts, 1))
            ];
        } elseif (count($parts) === 2) {
            return [
                'firstName' => $parts[0],
                'lastName' => $parts[1]
            ];
        } else {
            return [
                'firstName' => '',
                'lastName' => $fullName
            ];
        }
    }
