<?php
class Livraison {
    private $id_livraison;
    private $id_client;
    private $id_livreur;
    private $adresse_livraison;
    private $etat;
    private $date_creation;
    private $montant;
    private $statut_paiement;
    private $mode_paiement;
    private $description;

    public function __construct($id_client, $id_livreur, $adresse_livraison, $etat, $montant, $statut_paiement, $mode_paiement,$description) {
        $this->id_client = $id_client;
        $this->id_livreur = $id_livreur;
        $this->adresse_livraison = $adresse_livraison;
        $this->etat = $etat;
        $this->montant = $montant;
        $this->statut_paiement = $statut_paiement;
        $this->mode_paiement = $mode_paiement;
        $this->description= $description;
    }

    // Getters
    public function getIdClient() { return $this->id_client; }
    public function getIdLivreur() { return $this->id_livreur; }
    public function getAdresseLivraison() { return $this->adresse_livraison; }
    public function getEtat() { return $this->etat; }
    public function getMontant() { return $this->montant; }
    public function getStatutPaiement() { return $this->statut_paiement; }
    public function getModePaiement() { return $this->mode_paiement; }
    public function getdescription() { return $this->description; }

}
?>
