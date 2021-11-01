<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\LoginSQL;

class LoginDao
{

    private PDO $conn;
    
    public function __construct()
    {
        $this->conn = Conexao::obterConexao();
    }

    public function validarLogin($login) 
    {
        try {
            
            $stmt = $this->conn->prepare(LoginSQL::validarLogin());
            $stmt->bindValue(1, $login);
            $stmt->bindValue(2, ATIVO);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("Erro ao executar o login do usuário"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
}
