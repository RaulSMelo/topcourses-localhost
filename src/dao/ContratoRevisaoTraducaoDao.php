<?php

namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\traits\UtilCTRL;
use Src\dao\sql\InteressadoSQL;
use Src\dao\sql\ContratoRevTradSQL;
use Src\dao\sql\DarBaixaEmParcelasSQL;
use Src\models\ContratoRevisaoTraducaoModel;
use Src\models\DarBaixaEmParcelaModel;

class ContratoRevisaoTraducaoDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function inserirContratoRevTrad(ContratoRevisaoTraducaoModel $contratoRevTrad) 
    {
        $this->conn->beginTransaction();
        
        try {
            
            $stmt = $this->conn->prepare(InteressadoSQL::alterarSomenteCPFaluno());
            $stmt->bindValue(1, $contratoRevTrad->getCpfAluno());
            $stmt->bindValue(2, $contratoRevTrad->getIdInteressado());
            
            $stmt->execute();
            
            $contratoRevTrad->setSituacao(EM_ANDAMENTO);
            
            $stmt = $this->conn->prepare(ContratoRevTradSQL::inserirContratoRevTrad());
            $i = 1;
            $stmt->bindValue($i++, $contratoRevTrad->getIdTipoContrato());
            $stmt->bindValue($i++, $contratoRevTrad->getDataRecebimentoMaterial());
            $stmt->bindValue($i++, $contratoRevTrad->getDataPrazoEntrga());
            $stmt->bindValue($i++, $contratoRevTrad->getTotalPalavras());
            $stmt->bindValue($i++, $contratoRevTrad->getTotalHoras());
            $stmt->bindValue($i++, $contratoRevTrad->getValorTotal());
            $stmt->bindValue($i++, $contratoRevTrad->getQtdeParcelas());
            $stmt->bindValue($i++, $contratoRevTrad->getValorParcela());
            $stmt->bindValue($i++, $contratoRevTrad->getDiaVencimentoParcela());
            $stmt->bindValue($i++, $contratoRevTrad->getDescricaoServico());
            $stmt->bindValue($i++, $contratoRevTrad->getIdRevisor());
            $stmt->bindValue($i++, $contratoRevTrad->getIdTradutor());
            $stmt->bindValue($i++, $contratoRevTrad->getIdInteressado());
            $stmt->bindValue($i++, $contratoRevTrad->getIdUserLogado());
            $stmt->bindValue($i++, $contratoRevTrad->getDataRegistro());
            $stmt->bindValue($i++, $contratoRevTrad->getSituacao());
            
            $stmt->execute();
            
            $darBaixaParcela = new DarBaixaEmParcelaModel();
            
            $darBaixaParcela->setIdInteressado($contratoRevTrad->getIdInteressado());
            $darBaixaParcela->setIdContratoRevTrad($this->conn->lastInsertId());
            
            
            for($i = 0; $i < (int)$darBaixaParcela->getQtdeParcela(); $i++){
                
                $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::inserirTbDarbaixaParcelas());
                $j = 1;
                $stmt->bindValue($j++, $darBaixaParcela->getQtdeParcela());
                $stmt->bindValue($j++, $i + 1);
                
                if($i == 0){
                    
                    $stmt->bindValue($j++, $darBaixaParcela->getDataVencimentoParcela());
                    
                }else{
                    
                    $stmt->bindValue($j++, UtilCTRL::somarMesesData($contratoRevTrad->getDiaVencimentoParcela(), $i));
                }
                
                $stmt->bindValue($j++, $darBaixaParcela->getValorParcela());
                $stmt->bindValue($j++, $darBaixaParcela->getTipoContrato());
                $stmt->bindValue($j++, $darBaixaParcela->getSituacaoPagamento());
                $stmt->bindValue($j++, $darBaixaParcela->getTipoPagamento());
                $stmt->bindValue($j++, $darBaixaParcela->getDataRegistroPagamento());
                $stmt->bindValue($j++, $darBaixaParcela->getIdContratoRevTrad());
                $stmt->bindValue($j++, $darBaixaParcela->getIdContratoCurso());
                $stmt->bindValue($j++, $darBaixaParcela->getIdInteressado());

                $stmt->execute();
                
            }
            
            $this->conn->commit();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            $this->conn->rollBack();
            
            (new Log("ERRO ao inserir os dados do contrato de " . TIPOS_DE_CONTRATOS[$contratoRevTrad->getIdTipoContrato()]))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
        
    }
    
    public function alterarContratoRevTrad(ContratoRevisaoTraducaoModel $contratoRevTrad) 
    { 
        try {
            
            $stmt = $this->conn->prepare(ContratoRevTradSQL::alterarContratoRevTrad());
            $i = 1;
            $stmt->bindValue($i++, $contratoRevTrad->getSituacao());
            $stmt->bindValue($i++, $contratoRevTrad->getIdTradutor());
            $stmt->bindValue($i++, $contratoRevTrad->getIdRevisor());
            $stmt->bindValue($i++, $contratoRevTrad->getTotalPalavras());
            $stmt->bindValue($i++, $contratoRevTrad->getTotalHoras());
            $stmt->bindValue($i++, $contratoRevTrad->getDescricaoServico());
            $stmt->bindValue($i++, $contratoRevTrad->getMarcacoesGerais());
            $stmt->bindValue($i++, $contratoRevTrad->getIdContratoRevTrad());
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao alterar os dados do contrato de " . TIPOS_DE_CONTRATOS[$contratoRevTrad->getIdTipoContrato()]))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarTodosOsDadosContratoRevTradPorId(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(ContratoRevTradSQL::buscarTodosOsDadosContratoRevTradPorId());
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetch();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados do contrato de " . TIPOS_DE_CONTRATOS[$contratoRevTrad->getIdTipoContrato()]))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
}
