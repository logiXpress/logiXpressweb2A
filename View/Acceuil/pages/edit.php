<?php
include '../../../Controller/ReclamationC.php';
include '../../../Model/Reclamation.php';

$pc = new ReclamationC();
$reclamation = null;

function contains_profanity($text)
{
    $api_key = "673a0cb62e1c472928f0e8e0f0a77b7a";
    $encoded_text = urlencode($text);
    $url = "https://api1.webpurify.com/services/rest/?method=webpurify.live.check&api_key=$api_key&text=$encoded_text&lang=fr&format=json";

    $response = file_get_contents($url);
    if ($response === FALSE)
        return false;
    $data = json_decode($response, true);

    return $data['rsp']['found'] != "0";
}

if (isset($_GET['id_reclamation']) && !empty($_GET['id_reclamation'])) {
    $reclamation = $pc->getReclamationById(intval($_GET['id_reclamation']));
    if (!$reclamation) {
        die("<p style='color: red;'>Erreur : Réclamation introuvable.</p>");
    }
}

if (isset($_POST['update'])) {
    if (
        isset($_POST['id_client'], $_POST['Categorie'], $_POST['Description'], $_POST['Statut']) &&
        !empty($_POST['id_client']) &&
        !empty(trim($_POST['Categorie'])) &&
        !empty(trim($_POST['Description'])) &&
        !empty(trim($_POST['Statut']))
    ) {
        $description = trim($_POST['Description']);

        if (contains_profanity($description)) {
            echo "<p style='color: red;'>Erreur : Description contient des propos inappropriés.</p>";
            exit();
        }

        $p = new Reclamation(
            intval($_POST['id_reclamation']),
            intval($_POST['id_client']),
            htmlspecialchars(trim($_POST['Categorie'])),
            htmlspecialchars($description)
        );
        $p->setStatut(htmlspecialchars(trim($_POST['Statut'])));
        $pc->updateReclamation($p, $_POST['id_reclamation']);
        header('Location: claim.php');
        exit();
    } else {
        echo "<p style='color: red;'>Erreur : Tous les champs sont requis.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Réclamation</title>
</head>

<body>
    <h1>Modifier une Réclamation</h1>

    <?php if ($reclamation): ?>
        <form action="edit.php" method="POST">
            <input type="hidden" name="id_reclamation" value="<?= htmlspecialchars($reclamation['id_reclamation']); ?>">

            <label>ID Client :</label>
            <input type="number" name="id_client" value="<?= htmlspecialchars($reclamation['id_client']); ?>" required><br>

            <label>Catégorie :</label>
            <select name="Categorie" required>
                <?php
                $categories = [
                    "Late Delivery",
                    "Missed Delivery",
                    "Wrong Address Delivery",
                    "Package Not Received",
                    "Damaged Package",
                    "Missing Items",
                    "Tampered Package",
                    "Wrong Item Delivered",
                    "Rude Delivery Staff",
                    "Lack of Communication",
                    "Unresponsive Support",
                    "Inaccurate Tracking Information",
                    "Overcharged",
                    "Unauthorized Payment",
                    "Refund Not Processed",
                    "Coupon/Discount Not Applied",
                    "Order Canceled Without Notice",
                    "Order Not Processed",
                    "Duplicate Order"
                ];
                foreach ($categories as $cat) {
                    $selected = ($reclamation['Categorie'] === $cat) ? 'selected' : '';
                    echo "<option value=\"$cat\" $selected>$cat</option>";
                }
                ?>
            </select><br>

            <label>Description :</label>
            <textarea name="Description" required><?= htmlspecialchars($reclamation['Description']); ?></textarea><br>

            <label>Statut :</label>
            <input type="text" name="Statut" value="<?= htmlspecialchars($reclamation['Statut']); ?>" required><br>

            <label>Réponse (non modifiable) :</label>
            <textarea readonly><?= htmlspecialchars($reclamation['Reponse'] ?? "Pas encore de réponse"); ?></textarea><br>

            <input type="submit" name="update" value="Mettre à jour">
        </form>
    <?php else: ?>
        <p>Erreur : Aucune réclamation trouvée.</p>
    <?php endif; ?>
    <script>
        const forbiddenWords = [
            "putain", "merde", "con", "connard", "salope", "enculé", "bordel",
            "fuck", "shit", "bitch", "asshole", "bastard", "zebi", "asba",
            "3asba", "nikomek", "tahan", "ta7an", "mnayek", "fucking",
            "fucker", "zab", "kahba", "zokomek", "tetkouhb", "tetkouhbou",
            "nyak", "puta", "pendejo", "hijo de puta", "madre",
            "culero", "pendeja", "miboun", "mbachel"
        ];

        const descInput = document.getElementById('Description');
        const errorMsg = document.getElementById('descriptionError');
        const form = descInput.closest('form');

        // Fonction pour simplifier les mots (réduit les répétitions de lettres)
        function simplify(text) {
            return text.toLowerCase().replace(/(.)\1{1,}/g, '$1'); // ex: fuuuuck => fuuck => fuck
        }

        // Fonction principale de détection + masquage
        function maskProfanity(text) {
            const lowerOriginal = text.toLowerCase();
            let result = text;

            forbiddenWords.forEach(word => {
                // Construire une expression qui tolère les lettres répétées : f+u+c+k+
                const flexiblePattern = word
                    .split('')
                    .map(letter => `${letter}+`)
                    .join('');
                const regex = new RegExp(flexiblePattern, 'gi');

                result = result.replace(regex, match => '*'.repeat(match.length));

                // En plus, chercher même dans les mots composés, en mode "simplifié"
                const simplified = simplify(lowerOriginal);
                if (simplified.includes(word)) {
                    const originalIndex = simplified.indexOf(word);
                    const before = result.substring(0, originalIndex);
                    const stars = '*'.repeat(word.length);
                    const after = result.substring(originalIndex + word.length);
                    result = before + stars + after;
                }
            });

            return result;
        }

        descInput.addEventListener('input', () => {
            const original = descInput.value;
            const masked = maskProfanity(original);
            if (original !== masked) {
                descInput.value = masked;
                errorMsg.textContent = "⚠️ Inappropriate language detected and masked.";
            } else {
                errorMsg.textContent = "";
            }
        });

        form.addEventListener('submit', function (e) {
            if (descInput.value.includes('*')) {
                e.preventDefault();
                errorMsg.textContent = "Please remove inappropriate language before submitting.";
            }
        });
    </script>




</body>

</html>