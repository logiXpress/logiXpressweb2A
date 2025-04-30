<?php


class Entretien {
    private $id_vehicule;
    private $date;
    private $type_intervention;

    public function __construct($id_vehicule, $date, $type_intervention) {
        $this->id_vehicule = $id_vehicule;
        $this->date = $date;
        $this->type_intervention = $type_intervention;
    }

    public function getIdVehicule() { return $this->id_vehicule; }
    public function getDate() { return $this->date; }
    public function getTypeIntervention() { return $this->type_intervention; }
}

?>
