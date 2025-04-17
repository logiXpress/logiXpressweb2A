<?php
class ReponsesAdmin {
    private ?int $id_reponse; // Auto-incrémenté, peut être NULL lors de l'insertion
    private int $id_reclamation; // Clé étrangère
    private int $id_admin; // Clé étrangère
    private string $Reponse;
    private string $Date_reponse;

    public function __construct(?int $id_reponse, int $id_reclamation, int $id_admin, string $Reponse, string $Date_reponse) {
        $this->id_reponse = $id_reponse;
        $this->id_reclamation = $id_reclamation;
        $this->id_admin = $id_admin;
        $this->Reponse = $Reponse;
        $this->Date_reponse = $Date_reponse;
    }

    // Getters
    public function getIdReponse(): ?int { return $this->id_reponse; }
    public function getIdReclamation(): int { return $this->id_reclamation; }
    public function getIdAdmin(): int { return $this->id_admin; }
    public function getReponse(): string { return $this->Reponse; }
    public function getDateReponse(): string { return $this->Date_reponse; }

    // Setters
    public function setIdReponse(int $id_reponse): void { $this->id_reponse = $id_reponse; }
    public function setIdReclamation(int $id_reclamation): void { $this->id_reclamation = $id_reclamation; }
    public function setIdAdmin(int $id_admin): void { $this->id_admin = $id_admin; }
    public function setReponse(string $Reponse): void { $this->Reponse = $Reponse; }
    public function setDateReponse(string $Date_reponse): void { $this->Date_reponse = $Date_reponse; }
}
?>
