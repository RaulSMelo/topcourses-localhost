<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\AnotacaoAulaSQL;
use Src\models\AnotacaoAulaModel;


class AnotacaoAulaDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function inserirAnotacaoAula(AnotacaoAulaModel $anotacaoModel) 
    {
        try {
            
            $stmt = $this->conn->prepare(AnotacaoAulaSQL::inserirAnotacaoAula());
            $stmt->bindValue(1, $anotacaoModel->getAnotacaoAula());
            $stmt->bindValue(2, $anotacaoModel->getIdAgendamento());
            
            $stmt->execute();
            
            return $this->conn->lastInsertId();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao inserir anotação da aula"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function alterarAnotacaoAula(AnotacaoAulaModel $anotacaoModel) 
    {
        try {
            
            $stmt = $this->conn->prepare(AnotacaoAulaSQL::alterarAnotacaoAula());
            $stmt->bindValue(1, $anotacaoModel->getAnotacaoAula());
            $stmt->bindValue(2, $anotacaoModel->getIdAnotacaoAula());
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao alterar anotação da aula"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarTodasAnotacoesDasAulasPorIdDoContrato(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(AnotacaoAulaSQL::buscarTodasAnotacoesDasAulasPorIdDoContrato());
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados anotações das aulas pelo ID"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

}
