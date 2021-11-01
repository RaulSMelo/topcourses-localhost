<?php


namespace Src\models;

use Src\input\Input;
use Src\traits\UtilCTRL;

class HoraAulaModel 
{
    private $idHoraAula;
    private $idIdioma;
    private $valorHoraAula;
    private $idUserLogado;
    private $dataRegistro;
    
    public function __construct() 
    {
        $this->getHoraAulaModel(); 
    }

    
    public function getIdHoraAula() 
    {
        return $this->idHoraAula;
    }

    public function getIdIdioma() 
    {
        return $this->idIdioma;
    }

    public function getValorHoraAula() 
    {
        return $this->valorHoraAula;
    }

    public function getIdUserLogado() 
    {
        return $this->idUserLogado;
    }

    public function getDataRegistro() 
    {
        return $this->dataRegistro;
    }

    public function setIdHoraAula($idHoraAula)
    {
        $this->idHoraAula = $idHoraAula;
    }

    public function setIdIdioma($idIdioma)
    {
        $this->idIdioma = $idIdioma;
    }

    public function setValorHoraAula($valorHoraAula)
    {
        $this->valorHoraAula = $valorHoraAula;
    }

    public function setIdUserLogado($idUserLogado)
    {
        $this->idUserLogado = $idUserLogado;
    }

    public function setDataRegistro($dataRegistro)
    {
        $this->dataRegistro = $dataRegistro;
    }
    
    private function getHoraAulaModel() 
    {
        $obj = $this->getInput();
        
        $this->setIdHoraAula($obj->idHoraAula);
        $this->setIdIdioma($obj->idIdioma);
        $this->setValorHoraAula(UtilCTRL::formatoDecimalDB($obj->valorHoraAula));
        $this->setIdUserLogado($obj->idUserLogado);
        $this->setDataRegistro($obj->dataRegistro);
        
        return $this;
        
    }

    private function getInput()
    {
        return(object)[
            
            "idHoraAula"    => Input::post("id-hora-aula", FILTER_SANITIZE_NUMBER_INT),
            "idIdioma"      => Input::post("id-idioma", FILTER_SANITIZE_NUMBER_INT),
            "valorHoraAula" => Input::post("valor-hora-aula"),
            "idUserLogado"  => UtilCTRL::idUserLogado(),
            "dataRegistro"  => UtilCTRL::dataAtual()
            
        ];
    }
    
}
