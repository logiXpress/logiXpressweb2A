<?php
class Reclamation {
    private ?int $id_reclamation;
    private int $id_client;
    private string $Categorie;
    private string $Description;
    private string $Statut;

    public function __construct(?int $id_reclamation, int $id_client, string $Categorie, string $Description) {
        $this->id_reclamation = $id_reclamation;
        $this->id_client = $id_client;
        $this->Categorie = $Categorie;
        $this->Description = $Description;
        $this->Statut ="In Progress";
    }

    // Getters
    public function getIdReclamation(): ?int { return $this->id_reclamation; }
    public function getIdClient(): int { return $this->id_client; }
    public function getCategorie(): string { return $this->Categorie; }
    public function getDescription(): string { return $this->Description; }
    public function getStatut(): string { return $this->Statut; }

    // Setters
    public function setIdReclamation(int $id_reclamation): void { $this->id_reclamation = $id_reclamation; }
    public function setIdClient(int $id_client): void { $this->id_client = $id_client; }
    public function setCategorie(string $Categorie): void { $this->Categorie = $Categorie; }
    public function setDescription(string $Description): void { $this->Description = $Description; }
    public function setStatut(string $Statut): void { $this->Statut = $Statut; }
}
?>
