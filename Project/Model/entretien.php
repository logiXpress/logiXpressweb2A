<?php

class Entretien {
    private $id_entretien;
    private $id_candidat;
    private $date_entretien;
    private $Status;
    private $lien_entretien;
    private $evaluation;

    public function __construct($id_candidat, $date_entretien, $Status, $lien_entretien = null, $evaluation = null) {
        $this->id_candidat = $id_candidat;
        $this->date_entretien = $date_Entretien;
        $this->Status = $Status;
        $this->lien_entretien = $lien_entretien;
        $this->evaluation = $evaluation;
    }

    // Getters
    public function getIdEntretien() { return $this->id_entretien; }
    public function getIdCandidat() { return $this->id_candidat; }
    public function getDateEntretien() { return $this->date_entretien; }
    public function getStatus() { return $this->Status; }
    public function getLienEntretien() { return $this->lien_entretien; }
    public function getEvaluation() { return $this->evaluation; }

    // Setters
    public function setIdCandidat($id_candidat) { $this->id_candidat = $id_candidat; }
    public function setDateEntretien($date_entretien) { $this->date_entretien = $date_entretien; }
    public function setStatus($Status) { $this->Status = $Status; }
    public function setLienEntretien($lien_entretien) { $this->lien_entretien = $lien_entretien; }
    public function setEvaluation($evaluation) { $this->evaluation = $evaluation; }
}
?>
