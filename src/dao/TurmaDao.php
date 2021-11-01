<?php

namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\erro\Erro;
use Src\dao\Conexao;
use Src\dao\sql\TurmaSQL;
use Src\models\TurmaModel;

class TurmaDao
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::obterConexao();
    }


    public function inserirTurma(TurmaModel $turma)
    {
        try {
            
            $stmt = $this->conn->prepare(TurmaSQL::inserirTurma());
            $i = 1;
            $stmt->bindValue($i++, $turma->getNomeTurma());
            $stmt->bindValue($i++, $turma->getIdColaborador());
            $stmt->bindValue($i++, $turma->getIdUserLogado());
            $stmt->bindValue($i++, $turma->getDataRegistro());
            
            $stmt->execute();
 
            return 1;
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao inserir os dados da turma"))->enviarLogDeErro($e);

            header("LOCATION: " . PAGINA_DE_ERRO);

            exit;
        }
    }
    
    public function alterarTurma(TurmaModel $turma) 
    {
        try {
            
            $stmt = $this->conn->prepare(TurmaSQL::alterarTurma());
            $stmt->bindValue(1, $turma->getNomeTurma());
            $stmt->bindValue(2, $turma->getIdColaborador());
            $stmt->bindValue(3, $turma->getIdTurma());
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao alterar os dados da turma"))->enviarLogDeErro($e);

            header("LOCATION: " . PAGINA_DE_ERRO);

            exit;
        }
    }
    
    public function excluirTurma(int $id) 
    {
        try {

            $stmt = $this->conn->prepare(TurmaSQL::excluirTurma());
            $stmt->bindValue(1, $id);
            
            $stmt->execute();
            
            if($stmt->rowCount() == 0){
                
                Erro::setErro("Turma possui vínculo(s) com contrato(s), por isso não foi possível realizar a exclusão");
                
                return -1;
            }
            
            return 1;
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao excluir os dados da turma"))->enviarLogDeErro($e);

            header("LOCATION: " . PAGINA_DE_ERRO);

            exit;
        }  
    }

    public function buscarTodasTurmas()
    {
        try {
           
            $stmt = $this->conn->prepare(TurmaSQL::buscarTodasTurmas());

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar os dados da turma"))->enviarLogDeErro($e);

            header("LOCATION: " . PAGINA_DE_ERRO);

            exit;
        }
    }
}
