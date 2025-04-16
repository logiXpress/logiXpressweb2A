<?php
class Livraison {
    private $id_livraison;
    private $id_client;
    private $id_livreur;
    private $id_colis;
    private $adresse_livraison;
    private $etat;
    private $date_creation;
    private $montant;
    private $statut_paiement;
    private $mode_paiement;
    private $description;
    private $gouvernement;
    private $delegation;
    private $local;

    public function __construct($adresse_livraison, $etat, $montant, $statut_paiement, $mode_paiement, $description, $gouvernement, $delegation, $local,$id_colis) {
    
        $this->adresse_livraison = $adresse_livraison;
        $this->etat = $etat;
        $this->montant = $montant;
        $this->statut_paiement = $statut_paiement;
        $this->mode_paiement = $mode_paiement;
        $this->description = $description;
        $this->gouvernement = $gouvernement;
        $this->delegation = $delegation;
        $this->local = $local;
        $this->id_colis = $id_colis;

    }

    // Getters
    public function getIdClient() { return $this->id_client; }
    public function getIdLivreur() { return $this->id_livreur; }
    public function getIdColis() { return $this->id_colis; }
    public function getAdresseLivraison() { return $this->adresse_livraison; }
    public function getEtat() { return $this->etat; }
    public function getMontant() { return $this->montant; }
    public function getStatutPaiement() { return $this->statut_paiement; }
    public function getModePaiement() { return $this->mode_paiement; }
    public function getDescription() { return $this->description; }
    public function getGouvernement() { return $this->gouvernement; }
    public function getDelegation() { return $this->delegation; }
    public function getLocal() { return $this->local; }
}
?>
