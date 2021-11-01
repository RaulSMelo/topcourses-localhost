<?php


namespace Src\models;

use Src\input\Input;
use Src\traits\UtilCTRL;

class ContratoRevisaoTraducaoModel 
{
    private $idContratoRevTrad;
    private $idTipoContrato;
    private $cpfAluno;
    private $dataRecebimentoMaterial;
    private $dataPrazoEntrga;
    private $totalPalavras;
    private $totalHoras;
    private $valorTotal;
    private $qtdeParcelas;
    private $valorParcela;
    private $diaVencimentoParcela;
    private $descricaoServico;
    private $idRevisor;
    private $idTradutor;
    private $idInteressado;
    private $idUserLogado;
    private $dataRegistro;
    private $situacao;
    private $marcacoesGerais;
    
    
    public function __construct() 
    {
        $this->getContratoRevTradModel();
    }

    
    
    public function getIdContratoRevTrad() 
    {
        return $this->idContratoRevTrad;
    }

    public function getIdTipoContrato() 
    {
        return $this->idTipoContrato;
    }
    
    public function getCpfAluno() 
    {
        return $this->cpfAluno;
    }

    
    public function getDataRecebimentoMaterial() 
    {
        return $this->dataRecebimentoMaterial;
    }

    public function getDataPrazoEntrga() 
    {
        return $this->dataPrazoEntrga;
    }

    public function getTotalPalavras() 
    {
        return $this->totalPalavras;
    }

    public function getTotalHoras() 
    {
        return $this->totalHoras;
    }

    public function getValorTotal() 
    {
        return $this->valorTotal;
    }

    public function getQtdeParcelas() 
    {
        return $this->qtdeParcelas;
    }

    public function getValorParcela() 
    {
        return $this->valorParcela;
    }

    public function getDiaVencimentoParcela() 
    {
        return $this->diaVencimentoParcela;
    }
    
    public function getDescricaoServico() 
    {
        return $this->descricaoServico;
    }
    
    public function getIdRevisor() 
    {
        return $this->idRevisor;
    }

    public function getIdTradutor() 
    {
        return $this->idTradutor;
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

    public function getSituacao() 
    {
        return $this->situacao;
    }
    
    public function getMarcacoesGerais() 
    {
        return $this->marcacoesGerais;
    }
    
    public function setIdContratoRevTrad($idContratoRevTrad)
    {
        $this->idContratoRevTrad = $idContratoRevTrad;
    }

    public function setIdTipoContrato($idTipoContrato)
    {
        $this->idTipoContrato = $idTipoContrato;
    }
    
    public function setCpfAluno($cpfAluno): void 
    {
        $this->cpfAluno = $cpfAluno;
    }

    
    public function setDataRecebimentoMaterial($dataRecebimentoMaterial)
    {
        $this->dataRecebimentoMaterial = $dataRecebimentoMaterial;
    }

    public function setDataPrazoEntrga($dataPrazoEntrga)
    {
        $this->dataPrazoEntrga = $dataPrazoEntrga;
    }

    public function setTotalPalavras($totalPalavras)
    {
        $this->totalPalavras = $totalPalavras;
    }

    public function setTotalHoras($totalHoras)
    {
        $this->totalHoras = $totalHoras;
    }

    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
    }

    public function setQtdeParcelas($qtdeParcelas)
    {
        $this->qtdeParcelas = $qtdeParcelas;
    }

    public function setValorParcela($valorParcela)
    {
        $this->valorParcela = $valorParcela;
    }

    public function setDiaVencimentoParcela($diaVencimentoParcela)
    {
        $this->diaVencimentoParcela = $diaVencimentoParcela;
    }
    
    
    public function setDescricaoServico($descricaoServico)
    {
        $this->descricaoServico = $descricaoServico;
    }

    public function setIdRevisor($idRevisor)
    {
        $this->idRevisor = $idRevisor;
    }

    public function setIdTradutor($idTradutor)
    {
        $this->idTradutor = $idTradutor;
    }

    public function setIdInteressado($idInteressado)
    {
        $this->idInteressado = $idInteressado;
    }

    public function setIdUserLogado($idUserLogado)
    {
        $this->idUserLogado = $idUserLogado;
    }

    public function setDataRegistro($dataRegistro) 
    {
        $this->dataRegistro = $dataRegistro;
    }

    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }
    
    public function setMarcacoesGerais($marcacoesGerais)
    {
        $this->marcacoesGerais = $marcacoesGerais;
    }

    private function getContratoRevTradModel() 
    {
        $obj = $this->getInput();
        
        $this->setIdContratoRevTrad($obj->idContratoRevTrad);
        $this->setIdTipoContrato($obj->idTipoContrato);
        $this->setCpfAluno($obj->cpf != "" ? UtilCTRL::retiraMascara(trim($obj->cpf)) : "");
        $this->setDataRecebimentoMaterial(trim($obj->dataRecebimentoMaterial));
        $this->setDataPrazoEntrga(trim($obj->prazoEntrega));
        $this->setTotalPalavras((trim($obj->totalPalavras) != "") ? $obj->totalPalavras : null );
        $this->setTotalHoras((trim($obj->totalHoras) != "") ? $obj->totalHoras : null);
        $this->setValorTotal(trim($obj->valorTotal) != "" ? UtilCTRL::formatoDecimalDB(trim($obj->valorTotal)) : "");
        $this->setQtdeParcelas(trim($obj->qtdeParcelas));
        $this->setValorParcela(trim($obj->valorParcela) != "" ? UtilCTRL::formatoDecimalDB(trim($obj->valorParcela)) : "");  
        $this->setDiaVencimentoParcela(trim($obj->diaVencimentoParcela));
        $this->setDescricaoServico(trim($obj->descricaoServico));
        $this->setIdRevisor(($obj->idRevisor != "")   ? $obj->idRevisor  : null);
        $this->setIdTradutor(($obj->idTradutor != "") ? $obj->idTradutor : null);
        $this->setIdInteressado($obj->idInteressado);
        $this->setIdUserLogado($obj->idUserLogado);
        $this->setDataRegistro(trim($obj->dataRegistro));
        $this->setSituacao($obj->situacao);
        $this->setMarcacoesGerais($obj->marcacoesGerais);
        
        return $this;
    }

    
    private function getInput() 
    {
        return(object)[
            
            "idContratoRevTrad"       => Input::post("id-contrato-rev-trad", FILTER_SANITIZE_NUMBER_INT),
            "idTipoContrato"          => Input::post("id-tipo-contrato", FILTER_SANITIZE_NUMBER_INT),
            "cpf"                     => Input::post("cpf"),
            "dataRecebimentoMaterial" => Input::post("data-recebimento-material"),
            "prazoEntrega"            => Input::post("data-prazo-entrega"),
            "totalPalavras"           => Input::post("total-palavras", FILTER_SANITIZE_NUMBER_INT),
            "totalHoras"              => Input::post("total-horas", FILTER_SANITIZE_NUMBER_INT),
            "valorTotal"              => Input::post("valor-total"),
            "qtdeParcelas"            => Input::post("qtde-parcelas", FILTER_SANITIZE_NUMBER_INT),
            "valorParcela"            => Input::post("valor-parcela"),
            "diaVencimentoParcela"    => Input::post("dia-vencimento-parcela"),
            "descricaoServico"        => Input::post("descricao-servico"),
            "idRevisor"               => Input::post("id-revisor", FILTER_SANITIZE_NUMBER_INT),
            "idTradutor"              => Input::post("id-tradutor", FILTER_SANITIZE_NUMBER_INT),
            "idInteressado"           => Input::post("id-interessado", FILTER_SANITIZE_NUMBER_INT),
            "idUserLogado"            => UtilCTRL::idUserLogado(),
            "dataRegistro"            => UtilCTRL::dataAtual(),
            "situacao"                => Input::post("situacao"),
            "marcacoesGerais"         => Input::post("marcacao-geral")
        ];
    }
   
}
