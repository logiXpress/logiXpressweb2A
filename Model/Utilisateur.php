<?php
class Utilisateur {
    private $id_utilisateur;
    private $nom;
    private $prenom;
    private $email;
    private $motDePasse;
    private $type;
    private $phone_number; // New attribute for phone number

    public function __construct($nom, $prenom, $email, $motDePasse, $type,$phone_number, $id_utilisateur = null) {
        $this->id_utilisateur = $id_utilisateur;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->type = $type;
        $this->phone_number = $phone_number;

    }

    // Getters
    public function getId() {
        return $this->id_utilisateur;
    }
    public function getNom() {
        return $this->nom;
    }
    public function getPrenom() {
        return $this->prenom;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getMotDePasse() {
        return $this->motDePasse;
    }
    public function getType() {
        return $this->type;
    }
    public function getphone() {
        return $this->phone_number;
    }
    // Setters
    public function setId($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }

    public function setType($type) {
        $this->type = $type;
    }
    public function setphone($phone_number) {
        $this->phone_number = $phone_number;
    }
}
?>
