<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\ConsultarHistoricoContratoSQL;

class ConsultarHistoricoContratoDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function consultarHistoricoContrato(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(ConsultarHistoricoContratoSQL::consultarHistoricoContrato());
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $id);

            $stmt->execute();
        
            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados do histórico de contratos"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

}
