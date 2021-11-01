<?php

namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\AlterarSenhaSQL;

class AlterarSenhaDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function buscarSenhaAtual(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(AlterarSenhaSQL::buscarSenhaAtual());
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetch()["senha"];
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar a senha atual do usuário"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function alterarSenha($novaSenha, int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(AlterarSenhaSQL::alterarSenha());
            $stmt->bindValue(1, $novaSenha);
            $stmt->bindValue(2, $id);
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao alterar a senha do usuário"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
}
