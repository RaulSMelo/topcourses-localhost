<?php


namespace Src\models;

use Src\input\Input;
use Src\traits\UtilCTRL;

class DarBaixaEmParcelaModel 
{
    
    private $idDarBaixaParcela;
    private $qtdeParcela;
    private $dataVencimentoParcela;
    private $numeroParcela;
    private $valorParcela;
    private $valorParcelaPago;
    private $valorParcelaVindoDB;
    private $tipoContrato;
    private $situacaoPagamento;
    private $tipoPagamento;
    private $dataRegistroPagamento;
    private $idContratoRevTrad;
    private $idContratoCurso;
    private $idInteressado;
    private $obsPagamento;
    
    public function __construct() 
    {
        $this->getDarBaixaEmParcelaModel();
    }

    
    
    public function getIdDarBaixaParcela() 
    {
        return $this->idDarBaixaParcela;
    }

    public function getQtdeParcela() 
    {
        return $this->qtdeParcela;
    }

    public function getDataVencimentoParcela() 
    {
        return $this->dataVencimentoParcela;
    }
    
    public function getNumeroParcela() 
    {
        return $this->numeroParcela;
    }

        
    public function getValorParcela() 
    {
        return $this->valorParcela;
    }

    
    public function getValorParcelaPago() 
    {
        return $this->valorParcelaPago;
    }
    
    public function getValorParcelaVindoDB() 
    {
        return $this->valorParcelaVindoDB;
    }

    
    public function getTipoContrato() 
    {
        return $this->tipoContrato;
    }

    public function getSituacaoPagamento() 
    {
        return $this->situacaoPagamento;
    }

    public function getTipoPagamento() 
    {
        return $this->tipoPagamento;
    }

    public function getDataRegistroPagamento() 
    {
        return $this->dataRegistroPagamento;
    }

    public function getIdContratoRevTrad() 
    {
        return $this->idContratoRevTrad;
    }

    public function getIdContratoCurso() 
    {
        return $this->idContratoCurso;
    }

    public function getIdInteressado() 
    {
        return $this->idInteressado;
    }
    
    public function getObsPagamento()
    {
        return $this->obsPagamento;
    }

    
    public function setIdDarBaixaParcela($idDarBaixaParcela): void 
    {
        $this->idDarBaixaParcela = $idDarBaixaParcela;
    }

    public function setQtdeParcela($qtdeParcela): void 
    {
        $this->qtdeParcela = $qtdeParcela;
    }

    public function setDataVencimentoParcela($dataVencimentoParcela): void 
    {
        $this->dataVencimentoParcela = $dataVencimentoParcela;
    }
    
    public function setNumeroParcela($numeroParcela)
    {
        $this->numeroParcela = $numeroParcela;
    }

        
    public function setValorParcela($valorParcela): void 
    {
        $this->valorParcela = $valorParcela;
    }

    
    public function setValorParcelaPago($valorParcelaPago): void 
    {
        $this->valorParcelaPago = $valorParcelaPago;
    }
    
    public function setValorParcelaVindoDB($valorParcelaVindoDB): void 
    {
        $this->valorParcelaVindoDB = $valorParcelaVindoDB;
    }

    
    public function setTipoContrato($tipoContrato): void 
    {
        $this->tipoContrato = $tipoContrato;
    }

    public function setSituacaoPagamento($situacaoPagamento): void 
    {
        $this->situacaoPagamento = $situacaoPagamento;
    }

    public function setTipoPagamento($tipoPagamento): void 
    {
        $this->tipoPagamento = $tipoPagamento;
    }

    public function setDataRegistroPagamento($dataRegistroPagamento): void 
    {
        $this->dataRegistroPagamento = $dataRegistroPagamento;
    }

    public function setIdContratoRevTrad($idContratoRevTrad): void 
    {
        $this->idContratoRevTrad = $idContratoRevTrad;
    }

    public function setIdContratoCurso($idContratoCurso): void 
    {
        $this->idContratoCurso = $idContratoCurso;
    }

    public function setIdInteressado($idInteressado): void 
    {
        $this->idInteressado = $idInteressado;
    }
    
    public function setObsPagamento($obsPagamento): void 
    {
        $this->obsPagamento = $obsPagamento;
    }

    
    private function getDarBaixaEmParcelaModel() 
    {
        $obj = $this->getInput();
        
        $this->setIdDarBaixaParcela($obj->idDarBaixaParcela);
        $this->setQtdeParcela($obj->qtdeParcelas);
        $this->setDataVencimentoParcela($obj->diaVencimentoParcela);
        $this->setNumeroParcela($obj->numeroParcela);
        $this->setValorParcela(UtilCTRL::formatoDecimalDB(trim($obj->valorParcela)));
        $this->setValorParcelaPago(trim($obj->valorParcelaPago) != "" ? UtilCTRL::formatoDecimalDB(trim($obj->valorParcelaPago)) : "");
        $this->setValorParcelaVindoDB(trim($obj->valorParcelaVindoDB) != "" ? UtilCTRL::formatoDecimalDB(trim($obj->valorParcelaVindoDB)) : "");
        $this->setTipoContrato($obj->tipoContrato);
        $this->setSituacaoPagamento($obj->situacaoPagamento);
        $this->setTipoPagamento($obj->tipoPagamento);
        $this->setDataRegistroPagamento($obj->dataRegistroPagamento);
        $this->setIdContratoRevTrad(((int)$obj->tipoContrato == CONTRATO_REVISAO || (int)$obj->tipoContrato == CONTRATO_TRADUCAO) && trim($obj->idContrato) != "" ? trim($obj->idContrato) : null);
        $this->setIdContratoCurso(((int)$obj->tipoContrato != CONTRATO_REVISAO && (int)$obj->tipoContrato != CONTRATO_TRADUCAO) && trim($obj->idContrato) != "" ? trim($obj->idContrato) : null);
        $this->setIdInteressado($obj->idInteressado);
        $this->setObsPagamento(trim($obj->obsPagamento));
        
        
        return $this;
    }

    private function getInput() 
    {
        return(object)[
            
            "idDarBaixaParcela"     => Input::post("id-dar-baixa-parcela", FILTER_SANITIZE_NUMBER_INT),
            "qtdeParcelas"          => Input::post("qtde-parcelas", FILTER_SANITIZE_NUMBER_INT),
            "diaVencimentoParcela"  => Input::post("dia-vencimento-parcela"),
            "numeroParcela"         => Input::post("numero-parcela"),
            "valorParcela"          => Input::post("valor-parcela"),
            "valorParcelaPago"      => Input::post("valor-parcela"),
            "valorParcelaVindoDB"   => Input::post("valor-parcela-vindo-do-DB"),
            "tipoContrato"          => Input::post("id-tipo-contrato") ?? null,
            "situacaoPagamento"     => Input::post("situacao-pagamento") ?? EM_ABERTO,
            "tipoPagamento"         => Input::post("tipo-pagamento") ?? null,
            "dataRegistroPagamento" => null, 
            "idContrato"            => Input::post("id-contrato"),
            "idInteressado"         => Input::post("id-interessado", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "obsPagamento"          => Input::post("observacao-pagamento") ?? null
        ];
        
    } 
    
    
}
