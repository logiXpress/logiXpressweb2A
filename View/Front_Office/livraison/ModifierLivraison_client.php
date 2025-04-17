<?php

require_once '../../../config/config.php';
require_once '../../../Model/Livraison.php';
require_once '../../../Controller/LivraisonC.php';
$pdo = config::getConnexion();

// Vérifier si l'ID de la livraison est fourni
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

<!-- Formulaire de modification (seuls certains champs sont modifiables) -->
<form method="POST" action="UpdateLivraison_client.php">
    <input type="hidden" name="id_livraison" value="<?= $id ?>">

    <label for="adresse_livraison">Adresse Livraison:</label>
    <textarea id="adresse_livraison" name="adresse_livraison" required><?= $livraisonData['Adresse_livraison'] ?></textarea><br><br>

    <label for="etat">État:</label>
    <input type="text" id="etat" name="etat" value="<?= $livraisonData['Etat'] ?>" disabled><br><br>

    <label for="montant">Montant:</label>
    <input type="text" id="montant" name="montant" value="<?= $livraisonData['Montant'] ?>" disabled><br><br>

    <label for="statut_paiement">Statut Paiement:</label>
    <input type="text" id="statut_paiement" name="statut_paiement" value="<?= $livraisonData['Statut_paiement'] ?>" disabled><br><br>

    <label for="mode_paiement">Mode Paiement:</label>
    <select name="mode_paiement" id="mode_paiement" required>
        <option value="Cash" <?= ($livraisonData['Mode_paiement'] == 'Cash') ? 'selected' : '' ?>>Cash</option>
        <option value="Credit Card" <?= ($livraisonData['Mode_paiement'] == 'Credit Card') ? 'selected' : '' ?>>Credit Card</option>
        <option value="Debit Card" <?= ($livraisonData['Mode_paiement'] == 'Debit Card') ? 'selected' : '' ?>>Debit Card</option>
        <option value="Bank Transfer" <?= ($livraisonData['Mode_paiement'] == 'Bank Transfer') ? 'selected' : '' ?>>Bank Transfer</option>
        <option value="Apple Pay" <?= ($livraisonData['Mode_paiement'] == 'Apple Pay') ? 'selected' : '' ?>>Apple Pay</option>
        <option value="Google Pay" <?= ($livraisonData['Mode_paiement'] == 'Google Pay') ? 'selected' : '' ?>>Google Pay</option>
        <option value="PayPal" <?= ($livraisonData['Mode_paiement'] == 'PayPal') ? 'selected' : '' ?>>PayPal</option>
        <option value="Skrill" <?= ($livraisonData['Mode_paiement'] == 'Skrill') ? 'selected' : '' ?>>Skrill</option>
        <option value="Cash on Delivery" <?= ($livraisonData['Mode_paiement'] == 'Cash on Delivery') ? 'selected' : '' ?>>Cash on Delivery</option>
        <option value="Bitcoin" <?= ($livraisonData['Mode_paiement'] == 'Bitcoin') ? 'selected' : '' ?>>Bitcoin</option>
        <option value="Ethereum" <?= ($livraisonData['Mode_paiement'] == 'Ethereum') ? 'selected' : '' ?>>Ethereum</option>
        <option value="Cheque" <?= ($livraisonData['Mode_paiement'] == 'Cheque') ? 'selected' : '' ?>>Cheque</option>
    </select><br><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?= $livraisonData['Description'] ?></textarea><br><br>

    <button type="submit">Modifier</button>
</form>
