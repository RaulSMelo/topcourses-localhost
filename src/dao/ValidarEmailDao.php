<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\ValidarEmailSQL;


class ValidarEmailDao 
{
   private PDO $conn;
   
   public function __construct() 
   {
       $this->conn = Conexao::obterConexao();       
   }
   
   public function validarEmail($email, $tabela, $id) 
   {
        try {
            
            $stmt = $this->conn->prepare(ValidarEmailSQL::validarEmail($tabela, $id));
            $stmt->bindValue(1, $email);

            if($id != 0){

                $stmt->bindValue(2, $id);
            }

            $stmt->execute();
        
            return $stmt->fetch();

        } catch (\PDOException $e) {

            (new Log("Erro ao validar o email"))->enviarLogDeErro($e);

            header("LOCATION: " . PAGINA_DE_ERRO);

            exit;
        }
   }
    
}
