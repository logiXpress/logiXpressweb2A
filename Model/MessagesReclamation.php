<?php

class MessagesReclamation
{
    private $id_message;
    private $id_reclamation;
    private $id_utilisateur;
    private $contenu;
    private $date_envoi;

    public function __construct($id_reclamation, $id_utilisateur, $contenu, $date_envoi = null, $id_message = null)
    {
        $this->id_message = $id_message;
        $this->id_reclamation = $id_reclamation;
        $this->id_utilisateur = $id_utilisateur;
        $this->contenu = $contenu;
        $this->date_envoi = $date_envoi;
    }

    // ID Message
    public function getIdMessage()
    {
        return $this->id_message;
    }

    public function setIdMessage($id_message)
    {
        $this->id_message = $id_message;
    }

    // ID Réclamation
    public function getIdReclamation()
    {
        return $this->id_reclamation;
    }

    public function setIdReclamation($id_reclamation)
    {
        $this->id_reclamation = $id_reclamation;
    }

    // ID Utilisateur
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    // Contenu
    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    // Date Envoi
    public function getDateEnvoi()
    {
        return $this->date_envoi;
    }

    public function setDateEnvoi($date_envoi)
    {
        $this->date_envoi = $date_envoi;
    }
}
