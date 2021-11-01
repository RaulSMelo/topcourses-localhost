<?php

namespace Src\models;

use Src\models\PessoaModel;
use Src\input\Input;
use Src\traits\UtilCTRL;

class InteressadoModel extends PessoaModel
{
    private  $idInteressado;
    private  $idCurso;
    private  $idRevisao;
    private  $idTraducao;
    private  $idIdioma;
    private  $idMidia;
    private  $idTipoContato;
    private  $idColaborador;
    private  $dataNascimento;
    private  $profissao;
    private  $dataAgendamento;
    private  $testeNivelamento;
    private  $idResultado;
    private  $informacoesAdicionais;
    private  $idUserLogado;

    public function __construct() {
        
        $this->getInteressadoModel();
    }


    public function getIdInteressado() 
    {
        return $this->idInteressado;
    }

    public function getIdCurso() 
    {
        return $this->idCurso;
    }

    public function getIdRevisao() 
    {
        return $this->idRevisao;
    }

    public function getIdTraducao() 
    {
        return $this->idTraducao;
    }

    public function getDataNascimento() 
    {
        return $this->dataNascimento;
    }

    public function getProfissao() 
    {
        return $this->profissao;
    }

    public function getIdIdioma() 
    {
        return $this->idIdioma;
    }

    public function getIdMidia() 
    {
        return $this->idMidia;
    }

    public function getIdColaborador() 
    {
        return $this->idColaborador;
    }

    public function getIdTipoContato() 
    {
        return $this->idTipoContato;
    }

    public function getDataAgendamento() 
    {
        return $this->dataAgendamento;
    }

    public function getTesteNivelamento() 
    {
        return $this->testeNivelamento;
    }

    public function getIdResultado() 
    {
        return $this->idResultado;
    }

    public function getInformacoesAdicionais() 
    {
        return $this->informacoesAdicionais;
    }

    public function getIdUserLogado() 
    {
        return $this->idUserLogado;
    }

    public function setIdInteressado($idInteressado): void 
    {
        $this->idInteressado = $idInteressado;
    }

    public function setIdCurso($idCurso): void 
    {
        $this->idCurso = $idCurso;
    }

    public function setIdRevisao($idRevisao): void 
    {
        $this->idRevisao = $idRevisao;
    }

    public function setIdTraducao($idTraducao): void 
    {
        $this->idTraducao = $idTraducao;
    }

    public function setDataNascimento($dataNascimento): void 
    {
        $this->dataNascimento = $dataNascimento;
    }

    public function setProfissao($profissao): void 
    {
        $this->profissao = $profissao;
    }

    public function setIdIdioma($idIdioma): void 
    {
        $this->idIdioma = $idIdioma;
    }

    public function setIdMidia($idMidia): void 
    {
        $this->idMidia = $idMidia;
    }

    public function setIdColaborador($idColaborador): void 
    {
        $this->idColaborador = $idColaborador;
    }

    public function setIdTipoContato($idTipoContato): void 
    {
        $this->idTipoContato = $idTipoContato;
    }

    public function setDataAgendamento($dataAgendamento): void 
    {
        $this->dataAgendamento = $dataAgendamento;
    }

    public function setTesteNivelamento($testeNivelamento): void 
    {
        $this->testeNivelamento = $testeNivelamento;
    }

    public function setIdResultado($idResultado): void 
    {
        $this->idResultado = $idResultado;
    }

    public function setInformacoesAdicionais($informacoesAdicionais): void 
    {
        $this->informacoesAdicionais = $informacoesAdicionais;
    }

    public function setIdUserLogado($idUserLogado): void 
    {
        $this->idUserLogado = $idUserLogado;
    }
    
    private function getInteressadoModel()
    {
        
        $obj = $this->getInputInteressado();
            
        $this->setIdInteressado($obj->idInteressado);
        $this->setNome(trim($obj->nome));
        $this->setSobrenome(trim($obj->sobrenome));
        $this->setIdCurso($obj->idCurso != "" ? $obj->idCurso : null);
        $this->setIdRevisao($obj->idRevisao != "" ? $obj->idRevisao : null);
        $this->setIdTraducao($obj->idTraducao != "" ? $obj->idTraducao : null);
        $this->setIdIdioma($obj->idIdioma);
        $this->setTelefone(trim($obj->ddd) . UtilCTRL::retiraMascara(trim($obj->telefone)));
        $this->setEmail(trim($obj->email));
        $this->setIdMidia($obj->idMidia);
        $this->setIdTipoContato($obj->idTipoContato);
        $this->setIdColaborador($obj->idAtendente);
        $this->setCpf(UtilCTRL::retiraMascara(trim($obj->cpf)));
        $this->setDataNascimento(trim($obj->dataNascimento) != "" ? trim($obj->dataNascimento) : null);
        $this->setProfissao(trim($obj->profissao));
        $this->setDataAgendamento(trim($obj->dataAgendamento) != "" ? trim($obj->dataAgendamento) : null);
        $this->setTesteNivelamento($obj->testeNivelamento);
        $this->setIdResultado($obj->idResultado != "" ? $obj->idResultado : null);
        $this->setInformacoesAdicionais(trim($obj->informacoesAdicionais));
        $this->setIdUserLogado($obj->idUserLogado);
        $this->setDataRegistro(trim($obj->dataRegistro));

        return $this;

    }

    private function getInputInteressado()
    {

        return (object)[

            "idInteressado"         => Input::post("id-interessado", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "dataRegistro"          => UtilCTRL::dataAtual() ?? null,
            "nome"                  => Input::post("nome") ?? null,
            "sobrenome"             => Input::post("sobrenome") ?? null,
            "idCurso"               => Input::post("curso", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "idRevisao"             => Input::post("revisao", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "idTraducao"            => Input::post("traducao", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "idIdioma"              => Input::post("idioma", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "ddd"                   => Input::post("ddd") ?? null,
            "telefone"              => Input::post("telefone") ?? null,
            "email"                 => Input::post("email", FILTER_VALIDATE_EMAIL) ?? null,
            "idMidia"               => Input::post("midia", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "idTipoContato"         => Input::post("tipo-contato", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "idAtendente"           => Input::post("atendente", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "cpf"                   => Input::post("cpf") ?? null,
            "dataNascimento"        => Input::post("data-nascimento") ?? null,
            "profissao"             => Input::post("profissao") ?? null,
            "dataAgendamento"       => Input::post("data-agendamento") ?? null,
            "testeNivelamento"      => Input::post("simulado-enviado", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "idResultado"           => Input::post("resultado", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "informacoesAdicionais" => Input::post("informacoes-adicionais") ?? null,
            "idUserLogado"          => UtilCTRL::idUserLogado()
        ];
    }

}
