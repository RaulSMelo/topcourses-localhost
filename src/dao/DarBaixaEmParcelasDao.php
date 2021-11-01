<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\traits\UtilCTRL;
use Src\dao\sql\DarBaixaEmParcelasSQL;
use Src\models\DarBaixaEmParcelaModel;

class DarBaixaEmParcelasDao 
{
   private PDO $conn;
   
   public function __construct() 
   {
       $this->conn = Conexao::obterConexao();
   }
   
   public function filtrarTbDarBaixaEmParcelas(array $filtros)
   {
       try {
           
            $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::filtrarTbDarBaixaParcelas($filtros));
            $i = 1;
            $stmt->bindValue($i++, $filtros["data-inicio"]);
            $stmt->bindValue($i++, $filtros["data-final"]);

            if(!empty($filtros["nome"]) && !empty($filtros["sobrenome"])){

                $stmt->bindValue($i++, "%" . $filtros["nome"] . "%");
                $stmt->bindValue($i++, "%" . $filtros["sobrenome"] . "%");
                
            }else if(!empty($filtros["nome"])){

                $stmt->bindValue($i++, "%" . $filtros["nome"] . "%");
            }

            if(!empty($filtros["situacao_pag"])){

                $stmt->bindValue($i++, $filtros["situacao_pag"]);
            }

            $stmt->execute();

            return $stmt->fetchAll();
           
       } catch (\PDOException $e) {
           
           (new Log("ERRO ao obter os dados da tabela tb_dar_baixa_parcelas"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);
            
            exit;
       }
       
       
   }

   public function registrarBaixaParcelaComValorPagoIgual(DarBaixaEmParcelaModel $darBaixaParcela) 
   {
        try {
           
            $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::registrarBaixaParcelaValorPagoIgual());
            $stmt->bindValue(1, PAGO);
            $stmt->bindValue(2, $darBaixaParcela->getTipoPagamento());
            $stmt->bindValue(3, UtilCTRL::dataAtual());
            $stmt->bindValue(4, $darBaixaParcela->getValorParcelaPago());
            $stmt->bindValue(5, $darBaixaParcela->getObsPagamento());
            $stmt->bindValue(6, $darBaixaParcela->getIdDarBaixaParcela());
            
            $stmt->execute();
           
            return 1;
           
        } catch (\PDOException $e) {

            (new Log("ERRO ao registrar o pagamento - valor pago é igual valor da parcela"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);
            
            exit;
        }
       
   }
   
   public function registrarBaixaParcelaPagoComValorMenor(DarBaixaEmParcelaModel $darBaixaParcela , $novoValorParcela, $is_ultima_parcela, $ultimaDataVencimento) 
   {
        $this->conn->beginTransaction();
       
        $idContrato = "";
            
        if($darBaixaParcela->getTipoContrato() == CONTRATO_REVISAO || $darBaixaParcela->getTipoContrato() == CONTRATO_TRADUCAO){

            $idContrato = $darBaixaParcela->getIdContratoRevTrad();

        }else{

            $idContrato = $darBaixaParcela->getIdContratoCurso();
        }
        
        if(!$is_ultima_parcela){
            
            for($i = $darBaixaParcela->getNumeroParcela(); $i <= $darBaixaParcela->getQtdeParcela(); $i++){
                    
                try {
                    
                    $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::registrarBaixaParcelaValorPagoMaiorOuMenor($darBaixaParcela->getTipoContrato()));

                    if($i == $darBaixaParcela->getNumeroParcela()){

                        $stmt->bindValue(1,  PAGO);
                        $stmt->bindValue(2,  $darBaixaParcela->getTipoPagamento());
                        $stmt->bindValue(3,  UtilCTRL::dataAtual());
                        $stmt->bindValue(4,  $darBaixaParcela->getValorParcelaVindoDB());
                        $stmt->bindValue(5,  $darBaixaParcela->getValorParcelaPago());
                        $stmt->bindValue(6,  $darBaixaParcela->getObsPagamento());
                        $stmt->bindValue(7,  $darBaixaParcela->getIdInteressado());
                        $stmt->bindValue(8,  $darBaixaParcela->getNumeroParcela());
                        $stmt->bindValue(9,  $idContrato);

                    }else{

                        $stmt->bindValue(1,  EM_ABERTO);
                        $stmt->bindValue(2,  null);
                        $stmt->bindValue(3,  null);
                        $stmt->bindValue(4,  $novoValorParcela);
                        $stmt->bindValue(5,  null);
                        $stmt->bindValue(6,  null);
                        $stmt->bindValue(7,  $darBaixaParcela->getIdInteressado());
                        $stmt->bindValue(8,  $i);
                        $stmt->bindValue(9,  $idContrato);
                    }
                
                    $stmt->execute();
                    
                } catch (\PDOException $e) {
                    
                    $this->conn->rollBack();
                    
                    (new Log("ERRO ao registrar o pagamento - valor pago (maior ou menor)"))->enviarLogDeErro($e);
            
                    header("LOCATION " . PAGINA_DE_ERRO);
                    
                    exit;
                }
            }
            
        }else if($is_ultima_parcela){
            
            try {
            
                $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::registrarBaixaParcelaValorPagoMaiorOuMenor($darBaixaParcela->getTipoContrato()));

                $stmt->bindValue(1,  PAGO);
                $stmt->bindValue(2,  $darBaixaParcela->getTipoPagamento());
                $stmt->bindValue(3,  UtilCTRL::dataAtual());
                $stmt->bindValue(4,  $darBaixaParcela->getValorParcelaVindoDB());
                $stmt->bindValue(5,  $darBaixaParcela->getValorParcelaPago());
                $stmt->bindValue(6,  $darBaixaParcela->getObsPagamento());
                $stmt->bindValue(7,  $darBaixaParcela->getIdInteressado());
                $stmt->bindValue(8,  $darBaixaParcela->getNumeroParcela());
                $stmt->bindValue(9,  $idContrato);

                $stmt->execute();

                $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::inserirTbDarbaixaParcelas());

                $stmt->bindValue(1, (int)$darBaixaParcela->getQtdeParcela() +1);
                $stmt->bindValue(2, (int)$darBaixaParcela->getNumeroParcela() +1);
                $stmt->bindValue(3,  UtilCTRL::somarMesesData($ultimaDataVencimento, 1));
                $stmt->bindValue(4,  $novoValorParcela);
                $stmt->bindValue(5,  $darBaixaParcela->getTipoContrato());
                $stmt->bindValue(6,  EM_ABERTO);
                $stmt->bindValue(7,  null);
                $stmt->bindValue(8,  null);
                $stmt->bindValue(9,  $darBaixaParcela->getIdContratoRevTrad());
                $stmt->bindValue(10, $darBaixaParcela->getIdContratoCurso());
                $stmt->bindValue(11, $darBaixaParcela->getIdInteressado());
                
                $stmt->execute();
                
            }catch (\PDOException $e) {
                
                $this->conn->rollBack();
                
                (new Log("ERRO ao registrar o pagamento - valor pago menor (ultima parcela)"))->enviarLogDeErro($e);
            
                header("LOCATION " . PAGINA_DE_ERRO);

                exit;
            }
        }
        
        $this->conn->commit();
        
        return 1;
       
   }
   
   public function registrarBaixaParcelaPagoComValorMaior(DarBaixaEmParcelaModel $darBaixaParcela, $qtdePago, $diff) 
   {    
        
        $this->conn->beginTransaction();
        
        $idContrato = "";

        if($darBaixaParcela->getTipoContrato() == CONTRATO_REVISAO || $darBaixaParcela->getTipoContrato() == CONTRATO_TRADUCAO){

            $idContrato = $darBaixaParcela->getIdContratoRevTrad();
            
        }else{

            $idContrato = $darBaixaParcela->getIdContratoCurso();
        }
        
        if($diff == 0){
            
            for($i = $darBaixaParcela->getNumeroParcela(); $i < ((int)$darBaixaParcela->getNumeroParcela() + (int)$qtdePago); $i++){
                
                try {
                    
                    $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::registrarBaixaParcelaValorPagoMaiorOuMenor($darBaixaParcela->getTipoContrato()));

                    $stmt->bindValue(1, PAGO);
                    $stmt->bindValue(2, $darBaixaParcela->getTipoPagamento());
                    $stmt->bindValue(3, UtilCTRL::dataAtual());
                    $stmt->bindValue(4, $darBaixaParcela->getValorParcelaVindoDB());
                    $stmt->bindValue(5, $darBaixaParcela->getValorParcelaPago());
                    $stmt->bindValue(6, $darBaixaParcela->getObsPagamento());
                    $stmt->bindValue(7, $darBaixaParcela->getIdInteressado());
                    $stmt->bindValue(8, $i);
                    $stmt->bindValue(9, $idContrato);

                    $stmt->execute();
                    
                } catch (\PDOException $e) {
                    
                    $this->conn->rollBack();
                    
                    (new Log("ERRO ao registrar o pagamento - valor pago maior"))->enviarLogDeErro($e);
            
                    header("LOCATION " . PAGINA_DE_ERRO);

                    exit;
                }
            }
            
        }else{
                        
            for($i = (int)$darBaixaParcela->getNumeroParcela(); $i <= ((int)$darBaixaParcela->getNumeroParcela() + (int)$qtdePago); $i++){
                
                if((int)$i == ((int)$darBaixaParcela->getNumeroParcela() + (int)$qtdePago)){

                    $dadosParcelasEmAberto = $this->buscarParcelasEmAberto($darBaixaParcela);

                    $darBaixaParcela->setQtdeParcela($dadosParcelasEmAberto["ultima_parcela"]);

                    $ultimaDataVencimento = $dadosParcelasEmAberto["ultima_data_vencimento"];

                    $valorTotalParcelasEmAberto = (float)$dadosParcelasEmAberto["soma_total_parcelas"];

                    $valorPago = (float)$diff;

                    $qtdeParcelasRestante = (int)$dadosParcelasEmAberto["qtde_parcelas"];

                    $novoValorParcela = (float)UtilCTRL::formatoDecimalDB(number_format((float)($valorTotalParcelasEmAberto - $valorPago) / $qtdeParcelasRestante, 2, ",", "."));

                    for($j = $i; $j <= (int)$darBaixaParcela->getQtdeParcela(); $j++){
                        
                        try {
                            
                            $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::registrarBaixaParcelaValorPagoMaiorOuMenor($darBaixaParcela->getTipoContrato()));

                            $stmt->bindValue(1, EM_ABERTO);
                            $stmt->bindValue(2, null);
                            $stmt->bindValue(3, null);
                            $stmt->bindValue(4, $novoValorParcela);
                            $stmt->bindValue(5, null);
                            $stmt->bindValue(6, null);
                            $stmt->bindValue(7, $darBaixaParcela->getIdInteressado());
                            $stmt->bindValue(8, $j);
                            $stmt->bindValue(9, $idContrato);
                            
                            $stmt->execute();
                            
                        } catch (\PDOException $e) {
                            
                            $this->conn->rollBack();
                            
                            (new Log("ERRO ao registrar o pagamento - valor pago (maior ou menor)"))->enviarLogDeErro($e);
            
                            header("LOCATION " . PAGINA_DE_ERRO);

                            exit;
                            
                        }   
                    }
                    
                }else{
                    
                    try {
                        
                        $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::registrarBaixaParcelaValorPagoMaiorOuMenor($darBaixaParcela->getTipoContrato()));

                        $stmt->bindValue(1, PAGO);
                        $stmt->bindValue(2, $darBaixaParcela->getTipoPagamento());
                        $stmt->bindValue(3, UtilCTRL::dataAtual());
                        $stmt->bindValue(4, $darBaixaParcela->getValorParcelaVindoDB());
                        $stmt->bindValue(5, $darBaixaParcela->getValorParcelaPago());
                        $stmt->bindValue(6, $darBaixaParcela->getObsPagamento());
                        $stmt->bindValue(7, $darBaixaParcela->getIdInteressado());
                        $stmt->bindValue(8, $i);
                        $stmt->bindValue(9, $idContrato);
                        
                        $stmt->execute();
                        
                    } catch (\PDOException $e) {
                        
                        $this->conn->rollBack();
                        
                        (new Log("ERRO ao registrar o pagamento - valor pago (maior ou menor)"))->enviarLogDeErro($e);
            
                        header("LOCATION " . PAGINA_DE_ERRO);

                        exit;

                    }
                }
            }
        }
        
        $this->conn->commit();

        return 1;
   }
   
   
   
   public function buscarParcelasEmAberto(DarBaixaEmParcelaModel $darBaixaParcela) 
   {    
        $id_tipo_contrato = "";
        
        if($darBaixaParcela->getTipoContrato() == CONTRATO_REVISAO || $darBaixaParcela->getTipoContrato() == CONTRATO_TRADUCAO){
            
            $id_tipo_contrato = $darBaixaParcela->getIdContratoRevTrad();
            
        }else{
            
            $id_tipo_contrato = $darBaixaParcela->getIdContratoCurso();
        }
        
        try {
            
            $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::buscarParcelasEmAberto($darBaixaParcela->getTipoContrato()));
            $i = 1;
            $stmt->bindValue($i++, $darBaixaParcela->getIdInteressado());
            $stmt->bindValue($i++, $id_tipo_contrato);
            $stmt->bindValue($i++, $darBaixaParcela->getIdInteressado());
            $stmt->bindValue($i++, $id_tipo_contrato);
            $stmt->bindValue($i++, $darBaixaParcela->getIdInteressado());
            $stmt->bindValue($i++, $id_tipo_contrato);
            $stmt->bindValue($i++, $darBaixaParcela->getIdInteressado());
            $stmt->bindValue($i++, $id_tipo_contrato);
            $stmt->bindValue($i++, $darBaixaParcela->getIdInteressado());
            $stmt->bindValue($i++, $id_tipo_contrato);
            $stmt->bindValue($i++, $darBaixaParcela->getIdInteressado());
            $stmt->bindValue($i++, $id_tipo_contrato);

            $stmt->execute();

            return $stmt->fetch();
            
        } catch (Exception $e) {
            
            (new Log("ERRO ao buscar as parcelas em aberto"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);

            exit;
        }
        
   }
   
   public function atualizarSituacaoPagamentoPelaDataAtual() 
   {
        try {
            
            $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::atualizarSituacaoPagamentoPelaDataAtual());
            $stmt->bindValue(1, ATRASADO);
            $stmt->bindValue(2, UtilCTRL::dataAtual());
            $stmt->bindValue(3, EM_ABERTO);

            $stmt->execute();
            
            return 1;

        } catch (\PDOException $e) {

            (new Log("ERRO ao atualizar a situação das parcelas em atraso"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);

            exit;
        }
    }

}
