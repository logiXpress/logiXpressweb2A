<?php

class entretien
{
private int $id_entretien;
private int $id_candidat;
private date $date_entretien;
private  string $status;
private string $lien_entretien;
private string $evaluation;


public function getIdEntretien()
{
return $this->id_entretien;
}

public function getIdCandidat()
{
    return $this->id_candidat;

}

public function getDateEntretien()
{
    return $this->date_entretien;

}

public function getStatus()
{
    return $this->status;


}

public function getLienEntretien()
{
    return $this->lien_entretien;

}
public function getEvaluation()
{
    return $this->evaluation;

}


public function setIdEntretien($id_entretien)
{
    $this->id_entretien=$id_entretien;

return $this;
}

public function setIdCandidat($id_candidat)
{
     $this->id_candidat=$id_candidat;
return $this;
}

public function setDateEntretien($date_entretien)
{
     $this->date_entretien=$date_entretien;
     return $this;
}

public function setStatus($status)
{
     $this->status=$status;

     return $this;
}

public function setLienEntretien($lien_entretien)
{
    $this->lien_entretien=$lien_entretien;
    return $this;
}
public function setEvaluation($evaluation)
{
     $this->evaluation=$evaluation;
return $this;
}



}

>