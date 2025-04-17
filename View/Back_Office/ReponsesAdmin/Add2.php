<?php
include '../../../Controller/ReponsesAdminC.php';
include '../../../Model/ReponsesAdmin.php';
require_once '../Controller/ReclamationC.php';

if (isset($_POST['id_reclamation'], $_POST['id_admin'], $_POST['Reponse']) &&
    !empty($_POST['id_reclamation']) &&
    !empty($_POST['id_admin']) &&
    !empty(trim($_POST['Reponse']))
) {
    $db = config::getConnexion();

    // Vérifier si l'admin existe dans la table utilisateurs
    $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id_admin");
    $stmt->execute(['id_admin' => $_POST['id_admin']]);
    $admin = $stmt->fetch();

    if (!$admin) {
        die("<p style='color: red;'>Erreur : ID Admin invalide.</p>");
    }

    // Ajouter la réponse
    $rc = new ReponsesAdminC();
    $reponse = new ReponsesAdmin(
        null, // id_reponse auto-incrémenté
        intval($_POST['id_reclamation']),
        intval($_POST['id_admin']),
        htmlspecialchars(trim($_POST['Reponse'])),
        date('Y-m-d H:i:s') // Date actuelle
    );

    $rc->ajouterReponse($reponse);

    // 🟢 Mettre à jour le statut de la réclamation en "Résolu"
    $recC = new ReclamationC();
    $recC->changerStatut(intval($_POST['id_reclamation']), 'Résolu');

    // Redirection
    header('Location: ListeReponses.php');
    exit();
} else {
    echo "<p style='color: red;'>Erreur : Tous les champs sont requis.</p>";
}
?>