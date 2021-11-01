<?php


namespace Src\models;


class PautaAlunoModel 
{
    
    private $idPautaAluno;
    private $idAlununo;
    private $idContratoCurso;
    private $anotacaoProfessor;
    private $idAgendamento;
    
    
    public function getIdPautaAluno() 
    {
        return $this->idPautaAluno;
    }
    
    public function getIdAlununo() 
    {
        return $this->idAlununo;
    }

    public function getIdContratoCurso() 
    {
        return $this->idContratoCurso;
    }


    public function getAnotacaoProfessor() 
    {
        return $this->anotacaoProfessor;
    }

    public function getAnotacoesSobreLicoes() 
    {
        return $this->anotacoesSobreLicoes;
    }

    public function getIdAgendamento() 
    {
        return $this->idAgendamento;
    }

    public function setIdPautaAluno($idPautaAluno): void 
    {
        $this->idPautaAluno = $idPautaAluno;
    }
    
    public function setIdAlununo($idAlununo): void 
    {
        $this->idAlununo = $idAlununo;
    }

    public function setIdContratoCurso($idContratoCurso): void 
    {
        $this->idContratoCurso = $idContratoCurso;
    }


    public function setAnotacaoProfessor($anotacaoProfessor): void 
    {
        $this->anotacaoProfessor = $anotacaoProfessor;
    }

    public function setAnotacoesSobreLicoes($anotacoesSobreLicoes): void 
    {
        $this->anotacoesSobreLicoes = $anotacoesSobreLicoes;
    }

    public function setIdAgendamento($idAgendamento): void 
    {
        $this->idAgendamento = $idAgendamento;
    }
    
    
}
