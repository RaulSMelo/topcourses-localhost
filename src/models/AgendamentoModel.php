<?php

namespace Src\models;

use Src\input\Input;

class AgendamentoModel 
{
   
    private       $idAgendamento;
    private array $diaDaSemana;
    private array $dataDiaSemana;
    private array $horaInicial;
    private array $horaFinal;
    private       $idContratoCurso;
    
    public function __construct() 
    {
        $this->getAgendamentoModel();
    }

    
    public function getIdAgendamento() 
    {
        return $this->idAgendamento;
    }

    public function getDiaDaSemana(): array 
    {
        return $this->diaDaSemana;
    }

    public function getDataDiaSemana(): array
    {
        return $this->dataDiaSemana;
    }

    public function getHoraInicial(): array 
    {
        return $this->horaInicial;
    }

    public function getHoraFinal(): array 
    {
        return $this->horaFinal;
    }

    public function getIdContratoCurso() 
    {
        return $this->idContratoCurso;
    }

    public function setIdAgendamento($idAgendamento)
    {
        $this->idAgendamento = $idAgendamento;
    }

    public function setDiaDaSemana(array $diaDaSemana)
    {
        $this->diaDaSemana = $diaDaSemana;
    }

    public function setDataDiaSemana($dataDiaSemana)
    {
        $this->dataDiaSemana.array_push($dataDiaSemana);
    }

    public function setHoraInicial(array $horaInicial)
    {
        $this->horaInicial = $horaInicial;
    }

    public function setHoraFinal(array $horaFinal)
    {
        $this->horaFinal = $horaFinal;
    }

    public function setIdContratoCurso($idContratoCurso)
    {
        $this->idContratoCurso = $idContratoCurso;
    }
    
    private function getAgendamentoModel() 
    {
        $obj = $this->getInput();
        
        $this->setIdAgendamento($obj->idAgendamento);
        $this->setDiaDaSemana($obj->diaSemana);
        $this->setHoraInicial(count($obj->horaInicio) > 0 ? array_values(array_filter($obj->horaInicio)) : null );
        $this->setHoraFinal(count($obj->horaFinal) > 0 ? array_values(array_filter($obj->horaFinal)) : null);
        $this->setIdContratoCurso($obj->idContratoCurso);
        
        return $this;
    }

   
    private function getInput()
    {
        return(object)[
            
            "idAgendamento"   => Input::post("id-agendamento", FILTER_SANITIZE_NUMBER_INT),
            "diaSemana"       => $_POST["dia-semana"],
            "horaInicio"      => $_POST["hora-inicio"],
            "horaFinal"       => $_POST["hora-termino"],
            "idContratoCurso" => Input::post("id-contrato-curso", FILTER_SANITIZE_NUMBER_INT)
        ];
    }


    
}
