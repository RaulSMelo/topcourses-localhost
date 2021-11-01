<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\models\HoraAulaModel;
use Src\dao\sql\HoraAulaSQL;

class HoraAulaDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function inserirHoraAula(HoraAulaModel $horaAula) 
    {
        try {
            
            $stmt = $this->conn->prepare(HoraAulaSQL::inserirHoraAula());
            $i = 1;
            $stmt->bindValue($i++, $horaAula->getIdIdioma());
            $stmt->bindValue($i++, $horaAula->getValorHoraAula());
            $stmt->bindValue($i++, $horaAula->getIdUserLogado());
            $stmt->bindValue($i++, $horaAula->getDataRegistro());
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao inserir os dados da hora/aula"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }    
    }
    
    public function alterarHoraAula(HoraAulaModel $horaAula) 
    {
        try {
            
            $stmt = $this->conn->prepare(HoraAulaSQL::alterarHoraAula());
            $i = 1;
            $stmt->bindValue($i++, $horaAula->getIdIdioma());
            $stmt->bindValue($i++, $horaAula->getValorHoraAula());
            $stmt->bindValue($i++, $horaAula->getIdHoraAula());
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao alterar os dados da hora/aula"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function excluirHoraAula(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(HoraAulaSQL::excluirHoraAula());
            $stmt->bindValue(1, $id);
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao excluir os dados da hora/aula"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarTodasHorasAulas() 
    {
        try {
           
            $stmt = $this->conn->prepare(HoraAulaSQL::buscarTodasHorasAulas());
        
            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar os dados da hora/aula"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarValorHoraAulaPorIdIdioma(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(HoraAulaSQL::buscarValorHoraAulaPorIdIdioma());
            $stmt->bindValue(1, $id);
            $stmt->execute();

            return $stmt->fetch();
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar o valor da hora/aula pelo idioma"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    
}
