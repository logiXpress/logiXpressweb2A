<?php

class Entretien {
    private $id_vehicule;
    private $date;
    private $type_intervention;
    private $statut; // Nouvel attribut

    public function __construct($id_vehicule, $date, $type_intervention, $statut = 'non soumis') {
        $this->id_vehicule = $id_vehicule;
        $this->date = $date;
        $this->type_intervention = $type_intervention;
        $this->statut = $statut; // Initialisation de l'attribut statut
    }

    public function getIdVehicule() {
        return $this->id_vehicule;
    }

    public function getDate() {
        return $this->date;
    }

    public function getTypeIntervention() {
        return $this->type_intervention;
    }

    public function getStatut() {
        return $this->statut; // Méthode pour accéder à l'attribut statut
    }

    public function setStatut($statut) {
        $this->statut = $statut; // Méthode pour modifier l'attribut statut
    }
}

?>