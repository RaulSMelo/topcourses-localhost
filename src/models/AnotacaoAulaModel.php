<?php


namespace Src\models;

use Src\input\Input;

class AnotacaoAulaModel 
{
    private $idAnotacaoAula;
    private $anotacaoAula;
    private $idAgendamento;
    
    public function getIdAnotacaoAula() 
    {
        return $this->idAnotacaoAula;
    }

    public function getAnotacaoAula() 
    {
        return $this->anotacaoAula;
    }

    public function getIdAgendamento() 
    {
        return $this->idAgendamento;
    }

    public function setIdAnotacaoAula($idAnotacaoAula)
    {
        $this->idAnotacaoAula = $idAnotacaoAula;
    }

    public function setAnotacaoAula($anotacaoAula)
    {
        $this->anotacaoAula = $anotacaoAula;
    }

    public function setIdAgendamento($idAgendamento)
    {
        $this->idAgendamento = $idAgendamento;
    }

}
