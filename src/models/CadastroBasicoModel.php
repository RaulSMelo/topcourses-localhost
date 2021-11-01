<?php


namespace Src\models;

use Src\input\Input;
use Src\traits\UtilCTRL;

class CadastroBasicoModel 
{
    private $idCadastroBasico;
    private $idCadastroBasicoAlterar;
    private $tipoCadastro;
    private $nomeCadastro;
    private $idUserLogado;
    private $dataRegistro;
    
    public function __construct(int $tipoCadastro) 
    {
        $this->getCadastroBasicoModel($tipoCadastro);
    }
    
    
    
    public function getIdCadastroBasico() 
    {
        return $this->idCadastroBasico;
    }
    
    public function getIdCadastroBasicoAlterar() 
    {
        return $this->idCadastroBasicoAlterar;
    }

    public function setIdCadastroBasicoAlterar($idCadastroBasicoAlterar): void 
    {
        $this->idCadastroBasicoAlterar = $idCadastroBasicoAlterar;
    }

    
    public function getTipoCadastro() 
    {
        return $this->tipoCadastro;
    }

    public function getNomeCadastro() 
    {
        return $this->nomeCadastro;
    }

    public function getIdUserLogado() 
    {
        return $this->idUserLogado;
    }

    public function getDataRegistro() 
    {
        return $this->dataRegistro;
    }

    public function setIdCadastroBasico($idCadastroBasico): void 
    {
        $this->idCadastroBasico = $idCadastroBasico;
    }

    public function setTipoCadastro($tipoCadastro): void 
    {
        $this->tipoCadastro = $tipoCadastro;
    }

    public function setNomeCadastro($nomeCadastro): void 
    {
        $this->nomeCadastro = $nomeCadastro;
    }

    public function setIdUserLogado($idUserLogado): void 
    {
        $this->idUserLogado = $idUserLogado;
    }

    public function setDataRegistro($dataRegistro): void 
    {
        $this->dataRegistro = $dataRegistro;
    }

    
    private function getCadastroBasicoModel($tipoCadastro) 
    {
        $obj = $this->getInputCadastroBasico();
        
        $this->setIdCadastroBasico($obj->idCadastroBasico);
        $this->setIdCadastroBasicoAlterar($obj->idAlterar);
        $this->setTipoCadastro($tipoCadastro);
        $this->setDataRegistro($obj->dataRegistro);
        $this->setNomeCadastro(trim($obj->nomeCadastro));
        $this->setIdUserLogado($obj->idUserLogado);
        
        return $this;
        
    }
    
        
    private function getInputCadastroBasico()
    {

        return (object) [
            
            "idAlterar"        => Input::post("id-cadastro-basico-alterar", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "idCadastroBasico" => Input::post("id-cadastro-basico", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "dataRegistro"     => UtilCTRL::dataAtual() ?? null,
            "nomeCadastro"     => trim(Input::post("nome-cadastro") ?? null),
            "idUserLogado"     => UtilCTRL::idUserLogado()
            
        ];
    }
    
}
