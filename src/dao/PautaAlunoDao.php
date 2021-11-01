<?php

namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\PautaAlunoSQL;
use Src\models\PautaAlunoModel;

class PautaAlunoDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function inserirAnotacaoProfessor(PautaAlunoModel $pautaModel) 
    {
        try {
            
            $stmt = $this->conn->prepare(PautaAlunoSQL::inserirAnotacoesProfessor());
            $i = 1;
            $stmt->bindValue($i++, $pautaModel->getIdAlununo());
            $stmt->bindValue($i++, $pautaModel->getIdContratoCurso());
            $stmt->bindValue($i++, $pautaModel->getAnotacaoProfessor());
            $stmt->bindValue($i++, $pautaModel->getIdAgendamento());
            
            $stmt->execute();
            
            return $this->conn->lastInsertId();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao inserir a anotação do professor"))->enviarLogDeErro($e);
            
            return -1;
        }
    }
    
    public function alterarAnotacaoProfessor(PautaAlunoModel $pautaModel) 
    {
        try {
            
            $stmt = $this->conn->prepare(PautaAlunoSQL::alterarAnotacoesProfessor());
            $i = 1;
            $stmt->bindValue($i++, $pautaModel->getIdAlununo());
            $stmt->bindValue($i++, $pautaModel->getIdContratoCurso());
            $stmt->bindValue($i++, $pautaModel->getAnotacaoProfessor());
            $stmt->bindValue($i++, $pautaModel->getIdAgendamento());
            $stmt->bindValue($i++, $pautaModel->getIdPautaAluno());
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao alterar a anotação do professor"))->enviarLogDeErro($e);
            
            return -1;
        }
    }
    
    public function buscarAnotacaoProfessorPorId(int $id) 
    {
        try {
           
            $stmt = $this->conn->prepare(PautaAlunoSQL::buscarAnotacoesProfessorPorId());
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar a anotação do professor pelo id"))->enviarLogDeErro($e);
            
            return -1;
        }
    }
}
