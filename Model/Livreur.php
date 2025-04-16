<?php
require_once 'Utilisateur.php';

class Livreur extends Utilisateur {
    private $statut;
    private $id_vehicule;

    public function __construct($nom, $prenom, $email, $motDePasse, $statut, $id_vehicule, $id_utilisateur = null) {
        parent::__construct($nom, $prenom, $email, $motDePasse, 'Livreur', $id_utilisateur);
        $this->statut = $statut;
        $this->id_vehicule = $id_vehicule;
    }

    // Getters
    public function getStatut() {
        return $this->statut;
    }

    public function getIdVehicule() {
        return $this->id_vehicule;
    }

    // Setters
    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function setIdVehicule($id_vehicule) {
        $this->id_vehicule = $id_vehicule;
    }
}
?>
