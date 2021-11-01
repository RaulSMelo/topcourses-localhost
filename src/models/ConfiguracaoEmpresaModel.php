<?php


namespace Src\models;

use Src\traits\UtilCTRL;
use Src\input\Input;

class ConfiguracaoEmpresaModel 
{
    private $razaoSocial;
    private $cnpj;
    private $email;
    private $telefone;
    private $cep;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $uf;
    private $nomeFantasia;
    private $idUserLogado;
    private $dataRegistro;
    
    public function __construct() 
    {
        $this->configuracaoEmpresaModel();
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

    public function getCep() 
    {
        return $this->cep;
    }

    public function getRua() 
    {
        return $this->rua;
    }

    public function getNumero() 
    {
        return $this->numero;
    }

    public function getComplemento() 
    {
        return $this->complemento;
    }

    public function getBairro() 
    {
        return $this->bairro;
    }

    public function getCidade() 
    {
        return $this->cidade;
    }

    public function getEstado() 
    {
        return $this->estado;
    }

    public function getUf() 
    {
        return $this->uf;
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

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function setRua($rua)
    {
        $this->rua = $rua;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setUf($uf)
    {
        $this->uf = $uf;
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
    
    private function configuracaoEmpresaModel() 
    {
        $obj = $this->getInput();
        
        $this->setRazaoSocial(trim($obj->razaoSocial));
        $this->setCnpj((!empty(trim($obj->cnpj))) ? UtilCTRL::retiraMascara($obj->cnpj) : "");
        $this->setEmail(trim($obj->emailEmpresa));
        $this->setTelefone((!empty(trim($obj->telefone))) ? trim($obj->ddd) . UtilCTRL::retiraMascara($obj->telefone) : "");
        $this->setCep((!empty(trim($obj->cep))) ? UtilCTRL::retiraMascara(trim($obj->cep)) : "");
        $this->setRua(trim($obj->rua));
        $this->setNumero(trim($obj->numero));
        $this->setComplemento(trim($obj->complemento));
        $this->setBairro(trim($obj->bairro));
        $this->setCidade(trim($obj->cidade));
        $this->setEstado(trim($obj->estado));
        $this->setUf(trim($obj->uf));
        $this->setNomeFantasia(trim($obj->nomeFantasia));
        $this->setIdUserLogado($obj->idUserLogado);
        $this->setDataRegistro($obj->dataRegistro);
    }

    
    private function getInput() 
    {
        return (object)[

            "razaoSocial"      => Input::post("razao-social"),
            "cnpj"             => Input::post("cnpj"),
            "emailEmpresa"     => Input::post("email-empresa", FILTER_VALIDATE_EMAIL),
            "ddd"              => Input::post("ddd"),
            "telefone"         => Input::post("telefone"),
            "cep"              => Input::post("cep"),
            "rua"              => Input::post("rua"),
            "numero"           => Input::post("numero"),
            "complemento"      => Input::post("complemento"),
            "bairro"           => Input::post("bairro"),
            "cidade"           => Input::post("cidade"),
            "estado"           => Input::post("estado"),
            "uf"               => Input::post("uf"),
            "nomeFantasia"     => Input::post("nome-fantasia"),
            "idUserLogado"     => UtilCTRL::idUserLogado(),
            "dataRegistro"     => UtilCTRL::dataAtual()
        ];
    }
        
}
