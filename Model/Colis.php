<?php
class Colis {
    private $id_colis;
    private $nom_destinataire;
    private $phone1;
    private $phone2;
    private $designation;
    private $nombre_pieces;
    private $poids_kg;
    private $type_colis;
    private $commentaires;

    public function __construct($nom_destinataire, $phone1, $phone2 = null, $designation = null, $nombre_pieces = 1, $poids_kg = 1.00, $type_colis = 'Standard', $commentaires = null) {
        $this->nom_destinataire = $nom_destinataire;
        $this->phone1 = $phone1;
        $this->phone2 = $phone2;
        $this->designation = $designation;
        $this->nombre_pieces = $nombre_pieces;
        $this->poids_kg = $poids_kg;
        $this->type_colis = $type_colis;
        $this->commentaires = $commentaires;
    }

    // Getters
    public function getId() { return $this->id_colis; }
    public function getNomDestinataire() { return $this->nom_destinataire; }
    public function getPhone1() { return $this->phone1; }
    public function getPhone2() { return $this->phone2; }
    public function getDesignation() { return $this->designation; }
    public function getNombrePieces() { return $this->nombre_pieces; }
    public function getPoidsKg() { return $this->poids_kg; }
    public function getTypeColis() { return $this->type_colis; }
    public function getCommentaires() { return $this->commentaires; }

    // Setters
    public function setNomDestinataire($nom_destinataire) { $this->nom_destinataire = $nom_destinataire; }
    public function setPhone1($phone1) { $this->phone1 = $phone1; }
    public function setPhone2($phone2) { $this->phone2 = $phone2; }
    public function setDesignation($designation) { $this->designation = $designation; }
    public function setNombrePieces($nombre_pieces) { $this->nombre_pieces = $nombre_pieces; }
    public function setPoidsKg($poids_kg) { $this->poids_kg = $poids_kg; }
    public function setTypeColis($type_colis) { $this->type_colis = $type_colis; }
    public function setCommentaires($commentaires) { $this->commentaires = $commentaires; }
}
?>
