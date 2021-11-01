<?php


namespace Src\models;

use Src\input\Input;
use Src\traits\UtilCTRL;

class TurmaModel
{
    private $idTurma;
    private $nomeTurma;
    private $idColaborador;
    private $idUserLogado;
    private $dataRegistro;

    public function __construct()
    {
        $this->getTurmaModel();
    }


    public function getIdTurma()
    {
        return $this->idTurma;
    }

    public function getNomeTurma()
    {
        return $this->nomeTurma;
    }

    public function getIdColaborador()
    {
        return $this->idColaborador;
    }

    public function getIdUserLogado()
    {
        return $this->idUserLogado;
    }

    public function getDataRegistro()
    {
        return $this->dataRegistro;
    }

    public function setIdTurma($idTurma)
    {
        $this->idTurma = $idTurma;
    }

    public function setNomeTurma($nomeTurma)
    {
        $this->nomeTurma = $nomeTurma;
    }

    public function setIdColaborador($idColaborador)
    {
        $this->idColaborador = $idColaborador;
    }

    public function setIdUserLogado($idUserLogado)
    {
        $this->idUserLogado = $idUserLogado;
    }

    public function setDataRegistro($dataRegistro)
    {
        $this->dataRegistro = $dataRegistro;
    }

    private function getTurmaModel()
    {
        $obj = $this->getInput();

        $this->setIdTurma($obj->idTurma);
        $this->setNomeTurma($obj->nomeTurma);
        $this->setIdColaborador($obj->idColaborador);
        $this->setIdUserLogado($obj->idUserLogado);
        $this->setDataRegistro($obj->dataRegistro);

        return $this;
    }

    private function getInput()
    {
        return (object)[

            "idTurma"       => Input::post("id-turma", FILTER_SANITIZE_NUMBER_INT),
            "nomeTurma"     => Input::post("nome-turma"),
            "idColaborador" => Input::post("id-colaborador", FILTER_SANITIZE_NUMBER_INT),
            "idUserLogado"  => UtilCTRL::idUserLogado(),
            "dataRegistro"  => UtilCTRL::dataAtual()
        ];
    }
}
