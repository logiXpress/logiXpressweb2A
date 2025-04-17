<?php

class Vehicule {
    private $id_vehicule;
    private $immatriculation;
    private $type;
    private $autonomie;
    private $statut;

    public function __construct($immatriculation, $type, $autonomie, $statut) {
        $this->immatriculation = $immatriculation;
        $this->type = $type;
        $this->autonomie = $autonomie;
        $this->statut = $statut;
    }

    public function getImmatriculation() { return $this->immatriculation; }
    public function getType() { return $this->type; }
    public function getAutonomie() { return $this->autonomie; }
    public function getStatut() { return $this->statut; }
}
?>
