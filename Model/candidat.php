<?php

class candidat
{
private int $id_candidat;
private string $nom;
private  string $prenom;
private string $email;
private string $telephone;
private string $CV;
private date $dateCandidature;


public function getIdCandidat()
{
    return $this->id_candidat;

}

public function getNom()
{
    return $this->nom;

}

public function getPrenom()
{
    return $this->prenom;


}

public function getEmail()
{
    return $this->email;

}
public function getTelephone()
{
    return $this->telephone;

}
public function getCV()
{
    return $this->CV;

}
public function getDateCandidature()
{
    return $this->dateCandidature;

}


public function setIdCandidat($id_candidat)
{
     $this->id_candidat=$id_candidat;
return $this;
}

public function setNom($nom)
{
     $this->nom=$nom;
     return $this;
}

public function setPrenom($prenom)
{
     $this->prenom=$prenom;

     return $this;
}

public function setEmail($email)
{
    $this->email=$email;
    return $this;
}
public function setTelephone($telephone)
{
     $this->telephone=$telephone;
return $this;
}


public function setCV($CV)
{
    $this->CV=$CV;

return $this;
}
public function setDateCandidature($DateCandidature)
{
    $this->dateCandidature=$DateCandidature;

return $this;
}


}

>