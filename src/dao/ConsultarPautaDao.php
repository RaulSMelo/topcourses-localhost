<?php



namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\ConsultarPautaSQL;

class ConsultarPautaDao 
{
    public function buscarPautas($nome, $sobrenome, $situacao) 
    {
        try {
            
            $dao  = Conexao::obterConexao();
            $stmt = $dao->prepare(ConsultarPautaSQL::buscarPautas($situacao));
            $stmt->bindValue(1, "%$nome%");
            $stmt->bindValue(2, "%$sobrenome%");
            
            if($situacao != ""){
                
                $stmt->bindValue(3, $situacao);
            }
            
            $stmt->execute();
            
            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao consultar as pautas"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
}
