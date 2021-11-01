<?php

namespace Src\models;

use Src\input\Input;
use Src\traits\UtilCTRL;

class EnderecoModel
{
    private $idEndereco;
    private $cep;
    private $rua;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $uf;
    private $idColaborador;
    private $idEmpresa;
    private $idInteressado;
    private $idUserLogado;
    private $dataRegistro;


    public function __construct()
    {
        $this->getEnderecoModel();
    }



    public function getIdEndereco()
    {
        return $this->idEndereco;
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

    public function getUf()
    {
        return $this->uf;
    }

    public function getIdColaborador()
    {
        return $this->idColaborador;
    }

    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function getIdInteressado()
    {
        return $this->idInteressado;
    }

    public function getIdUserLogado()
    {
        return $this->idUserLogado;
    }

    public function getDataRegistro()
    {
        return $this->dataRegistro;
    }

    public function setIdEndereco($idEndereco): void
    {
        $this->idEndereco = $idEndereco;
    }

    public function setCep($cep): void
    {
        $this->cep = $cep;
    }

    public function setRua($rua): void
    {
        $this->rua = $rua;
    }

    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    public function setComplemento($complemento): void
    {
        $this->complemento = $complemento;
    }

    public function setBairro($bairro): void
    {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade): void
    {
        $this->cidade = $cidade;
    }

    public function setUf($uf): void
    {
        $this->uf = $uf;
    }

    public function setIdColaborador($idColaborador): void
    {
        $this->idColaborador = $idColaborador;
    }

    public function setIdEmpresa($idEmpresa): void
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function setIdInteressado($idInteressado): void
    {
        $this->idInteressado = $idInteressado;
    }

    public function setIdUserLogado($idUserLogado): void
    {
        $this->idUserLogado = $idUserLogado;
    }

    public function setDataRegistro($dataRegistro): void
    {
        $this->dataRegistro = $dataRegistro;
    }

    private function getEnderecoModel()
    {

        $obj = $this->getInputEndereco();

        $this->setIdEndereco($obj->idEndereco);
        $this->setCep(UtilCTRL::retiraMascara(trim($obj->cep)));
        $this->setRua(trim($obj->rua));
        $this->setNumero(trim($obj->numero));
        $this->setComplemento(trim($obj->complemento));
        $this->setBairro(trim($obj->bairro));
        $this->setCidade(trim($obj->cidade));
        $this->setUf(trim(strtoupper(trim($obj->uf))));
        $this->setIdUserLogado($obj->idUserLogado);
        $this->setDataRegistro($obj->dataRegistro);

        return $this;
    }


    private function getInputEndereco()
    {

        return (object) [

            "idEndereco"   => Input::post("id-endereco", FILTER_SANITIZE_NUMBER_INT),
            "cep"          => Input::post("cep"),
            "rua"          => Input::post("rua"),
            "numero"       => Input::post("numero"),
            "complemento"  => Input::post("complemento"),
            "bairro"       => Input::post("bairro"),
            "cidade"       => Input::post("cidade"),
            "uf"           => Input::post("uf"),
            "idUserLogado" => UtilCTRL::idUserLogado(),
            "dataRegistro" => UtilCTRL::dataAtual()
        ];
    }
}
