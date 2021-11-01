<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\AgendamentoSQL;

class AgendamentoDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function buscarAgendamentosPorIdDoContrato(int $id, $pauta) 
    {
        try {
            
            $stmt = $this->conn->prepare(AgendamentoSQL::buscarAgendamentosPorIdDoContrato($pauta));
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar o agendamento pelo ID"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarDataMinSemAnotacaoPauta(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(AgendamentoSQL::buscarDataMinSemAnotacaoPauta());
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $id);
            $stmt->bindValue(3, $id);

            $stmt->execute();

            return $stmt->fetch()["data_min"];
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar a data mínima sem anotação na pauta"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    
    public function buscarQtdeDatasComAnotacoes(int $id) 
    {
        try {
           
            $stmt = $this->conn->prepare(AgendamentoSQL::buscarQtdeDatasComAnotacoes());
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $id);
            $stmt->bindValue(3, $id);

            $stmt->execute();

            return (int)$stmt->fetch()["data_com_anotacoes"];
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar as datas com anotação na pauta"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    } 
    
    public function buscarAgendamentosComHorasAgendadas($idContrato, $dataInicio, $dataFinal) 
    {
        try {
            
            $stmt = $this->conn->prepare(AgendamentoSQL::buscarAgendamentosComHorasAgendadas());
            $stmt->bindValue(1, $idContrato);
            $stmt->bindValue(2, $dataInicio);
            $stmt->bindValue(3, $dataFinal);
            
            $stmt->execute();
            
            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os agendamentos com horas agendadas"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
}
