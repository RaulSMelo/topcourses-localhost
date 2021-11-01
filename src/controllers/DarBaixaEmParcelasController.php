<?php

namespace Src\controllers;

use Src\dao\DarBaixaEmParcelasDao;
use Src\validate\ValidarCampos;
use Src\models\DarBaixaEmParcelaModel;
use Src\erro\Erro;
use Src\traits\UtilCTRL;

class DarBaixaEmParcelasController {

    private DarBaixaEmParcelasDao $dao;
    private DarBaixaEmParcelaModel $darBaixaParcela;

    public function __construct() {
        
        $this->dao             = new DarBaixaEmParcelasDao();
        $this->darBaixaParcela = new DarBaixaEmParcelaModel();
    }

    public function filtrarDarBaixaEmParcelas(array $filtros) {
        
        $resultado = ValidarCampos::validarCamposFiltroDarBaixaEmParcela($filtros["data-inicio"], $filtros["data-final"]);


        if (is_bool($resultado)) {
            
            return $this->dao->filtrarTbDarBaixaEmParcelas($filtros);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function registrarBaixaParcela()
    {

        $resultado = ValidarCampos::validarCamposRegistrarBaixaParcela($this->darBaixaParcela);
        
        if(is_bool($resultado)){
            
            $dadosParcelasEmAberto = $this->dao->buscarParcelasEmAberto($this->darBaixaParcela);
            
            if((float)$this->darBaixaParcela->getValorParcelaPago() <= (float)$dadosParcelasEmAberto["soma_total_parcelas"]){
                
                if($this->darBaixaParcela->getValorParcelaPago() == $this->darBaixaParcela->getValorParcelaVindoDB()){
                
                    return $this->dao->registrarBaixaParcelaComValorPagoIgual($this->darBaixaParcela);

                }else if($this->darBaixaParcela->getValorParcelaPago() < $this->darBaixaParcela->getValorParcelaVindoDB()){

                    if((int)$dadosParcelasEmAberto["qtde_parcelas"] > 0){

                        $this->darBaixaParcela->setNumeroParcela($dadosParcelasEmAberto["primeira_parcela_em_aberto"]);
                        $this->darBaixaParcela->setQtdeParcela($dadosParcelasEmAberto["ultima_parcela"]);

                        $is_ultima_parcela = ($dadosParcelasEmAberto["primeira_parcela_em_aberto"] == $dadosParcelasEmAberto["ultima_parcela"]);

                        $ultimaDataVencimento = $dadosParcelasEmAberto["ultima_data_vencimento"];

                        $valorTotalParcelasEmAberto = (float)$dadosParcelasEmAberto["soma_total_parcelas"];

                        $valorPago = (float)$this->darBaixaParcela->getValorParcelaPago();

                        $qtdeParcelasRestante = ($is_ultima_parcela) ? (int)$dadosParcelasEmAberto["qtde_parcelas"] : (int)$dadosParcelasEmAberto["qtde_parcelas"] -1;

                        $novoValorParcela = (float)UtilCTRL::formatoDecimalDB(number_format((float)($valorTotalParcelasEmAberto - $valorPago) / $qtdeParcelasRestante, 2, ",", "."));

                        return $this->dao->registrarBaixaParcelaPagoComValorMenor($this->darBaixaParcela, $novoValorParcela, $is_ultima_parcela, $ultimaDataVencimento);

                    }

                }else if($this->darBaixaParcela->getValorParcelaPago() > $this->darBaixaParcela->getValorParcelaVindoDB()){
                    
                    $qtdePago = 0;
                    $diff     = 0;
                    
                    if((float)$this->darBaixaParcela->getValorParcelaPago() % (float)$this->darBaixaParcela->getValorParcelaVindoDB() == 0 ){
                        
                        $qtdePago = abs((float)$this->darBaixaParcela->getValorParcelaPago() / (float)$this->darBaixaParcela->getValorParcelaVindoDB());
                        
                    }else{
                        
                        $qtdePago = (int)abs((float)$this->darBaixaParcela->getValorParcelaPago() / (float)$this->darBaixaParcela->getValorParcelaVindoDB());
                        $diff     = number_format((float)$this->darBaixaParcela->getValorParcelaPago() % (float)$this->darBaixaParcela->getValorParcelaVindoDB(), 2);
                    }
                    
                    $this->darBaixaParcela->setNumeroParcela($dadosParcelasEmAberto["primeira_parcela_em_aberto"]);
                    
                    return $this->dao->registrarBaixaParcelaPagoComValorMaior($this->darBaixaParcela, $qtdePago, $diff);

                }
            }
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function atualizarSituacaoPagamentoPelaDataAtual() 
    {
        return $this->dao->atualizarSituacaoPagamentoPelaDataAtual();
    }

}
