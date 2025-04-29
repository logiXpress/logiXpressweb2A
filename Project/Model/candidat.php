<?php

class Candidat {
    private $id_candidat;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $CV;
    private $dateCandidature;

    public function __construct($nom, $prenom, $email, $telephone, $CV = null, $dateCandidature = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->CV = $CV;
        $this->dateCandidature = $dateCandidature ?: date('Y-m-d'); // Default to current date if not provided
    }

    // Getters
    public function getIdCandidat() { return $this->id_candidat; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getTelephone() { return $this->telephone; }
    public function getCV() { return $this->CV; }
    public function getDateCandidature() { return $this->dateCandidature; }

    // Setters
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setEmail($email) { $this->email = $email; }
    public function setTelephone($telephone) { $this->telephone = $telephone; }
    public function setCV($CV) { $this->CV = $CV; }
    public function setDateCandidature($dateCandidature) { $this->dateCandidature = $dateCandidature; }
}
?>