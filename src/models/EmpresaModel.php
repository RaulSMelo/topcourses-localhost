<?php


namespace Src\models;

use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\models\EnderecoModel;

class EmpresaModel 
{
    private $idEmpresa;
    private $razaoSocial;
    private $cnpj;
    private $email;
    private $telefone;
    private $telefoneOpcional;
    private $nomeFantasia;
    private $idUserLogado;
    private $dataRegistro;
    private $situacao;
    private EnderecoModel $endereco;
    
    
    public function __construct() 
    {
        $this->getEmpresaModel();
        $this->endereco = new EnderecoModel();
    }

    public function getEndereco(): EnderecoModel 
    {
        return $this->endereco;
    }
            
    
    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function getRazaoSocial() 
    {
        return $this->razaoSocial;
    }

    public function getCnpj() 
    {
        return $this->cnpj;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function getTelefone() 
    {
        return $this->telefone;
    }

    public function getTelefoneOpcional() 
    {
        return $this->telefoneOpcional;
    }

    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    public function getIdUserLogado() 
    {
        return $this->idUserLogado;
    }
    
    public function getDataRegistro() 
    {
        return $this->dataRegistro;
    }
    
    public function getSituacao() 
    {
        return $this->situacao;
    }

    public function setIdEmpresa($idEmpresa) 
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function setRazaoSocial($razaoSocial) 
    {
        $this->razaoSocial = $razaoSocial;
    }

    public function setCnpj($cnpj) 
    {
        $this->cnpj = $cnpj;
    }

    public function setEmail($email) 
    {
        $this->email = $email;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setTelefoneOpcional($telefoneOpcional) 
    {
        $this->telefoneOpcional = $telefoneOpcional;
    }

    public function setNomeFantasia($nomeFantasia) 
    {
        $this->nomeFantasia = $nomeFantasia;
    }

    public function setIdUserLogado($idUserLogado)
    {
        $this->idUserLogado = $idUserLogado;
    }
    
    public function setDataRegistro($dataRegistro) 
    {
        $this->dataRegistro = $dataRegistro;
    }
    
    public function setSituacao($situacao): void 
    {
        $this->situacao = $situacao;
    }

    private function getEmpresaModel() 
    {
        $obj = $this->getInput();
        
        $this->setIdEmpresa($obj->idEmpresa);
        $this->setRazaoSocial(trim($obj->razaoSocial));
        $this->setCnpj(UtilCTRL::retiraMascara(trim($obj->cnpj)));
        $this->setEmail(trim($obj->emailEmpresa));
        $this->setTelefone(trim($obj->ddd) . UtilCTRL::retiraMascara(trim($obj->telefone)));
        $this->setTelefoneOpcional(trim($obj->dddOpcional) . UtilCTRL::retiraMascara(trim($obj->telefoneOpcional)));
        $this->setNomeFantasia(trim($obj->nomeFantasia));
        $this->setIdUserLogado($obj->idUserLogado);
        $this->setDataRegistro(trim($obj->dataRegistro));
        
        return $this;
        
    }


    private function getInput() 
    {
       return(object)[
           
           "idEmpresa"        => Input::post("id-empresa", FILTER_SANITIZE_NUMBER_INT),
           "razaoSocial"      => Input::post("razao-social"),
           "cnpj"             => Input::post("cnpj"),
           "emailEmpresa"     => Input::post("email-empresa", FILTER_VALIDATE_EMAIL),
           "ddd"              => Input::post("ddd"),
           "telefone"         => Input::post("telefone"),
           "dddOpcional"      => Input::post("ddd-telefone-opcional-empresa"),
           "telefoneOpcional" => Input::post("telefone-opcional-empresa"),
           "nomeFantasia"     => Input::post("nome-fantasia"),
           "idUserLogado"     => UtilCTRL::idUserLogado(),
           "dataRegistro"     => UtilCTRL::dataAtual()
           
       ];
    }

    
}
