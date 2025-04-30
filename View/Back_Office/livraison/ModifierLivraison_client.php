<?php
require_once '../../../config/config.php';
require_once '../../../Model/Livraison.php';
require_once '../../../Controller/LivraisonC.php';

if (!isset($_GET['id_livraison'])) {
    die("ID de livraison non fourni.");
}

$id = $_GET['id_livraison'];
$livraisonC = new LivraisonC();
$livraisonData = $livraisonC->getLivraison($id);

if (!$livraisonData) {
    die("Livraison introuvable.");
}
?>

<form method="POST" action="UpdateLivraison_client.php">
    <input type="hidden" name="id_livraison" value="<?= htmlspecialchars($id) ?>">

    <label for="adresse_livraison">Adresse Livraison:</label>
    <textarea id="adresse_livraison" name="adresse_livraison" required><?= htmlspecialchars($livraisonData['Adresse_livraison']) ?></textarea><br><br>

    <label for="etat">État:</label>
    <input type="text" id="etat" value="<?= htmlspecialchars($livraisonData['Etat']) ?>" disabled><br><br>

    <label for="montant">Montant:</label>
    <input type="text" id="montant" value="<?= htmlspecialchars($livraisonData['Montant']) ?>" disabled><br><br>

    <label for="statut_paiement">Statut Paiement:</label>
    <input type="text" id="statut_paiement" value="<?= htmlspecialchars($livraisonData['Statut_paiement']) ?>" disabled><br><br>

    <label for="mode_paiement">Mode Paiement:</label>
    <select name="mode_paiement" id="mode_paiement" required>
        <?php
        $modes = ["Cash", "Credit Card", "Debit Card", "Bank Transfer", "Apple Pay", "Google Pay", "PayPal", "Skrill", "Cash on Delivery", "Bitcoin", "Ethereum", "Cheque"];
        foreach ($modes as $mode) {
            $selected = ($livraisonData['Mode_paiement'] === $mode) ? 'selected' : '';
            echo "<option value=\"$mode\" $selected>$mode</option>";
        }
        ?>
    </select><br><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?= htmlspecialchars($livraisonData['Description']) ?></textarea><br><br>

    <button type="submit">Modifier</button>
</form>
