<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\CadastroBasicoSQL;
use Src\models\CadastroBasicoModel;

class CadastroBasicoDao
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::obterConexao();
    }

    public function inserirCadastroBasico(CadastroBasicoModel $cadBasico)
    {

        try {
            
            $stmt = $this->conn->prepare(CadastroBasicoSQL::inserirCadastroBasico());
            $i = 1;
            $stmt->bindValue($i++, $cadBasico->getTipoCadastro());
            $stmt->bindValue($i++, $cadBasico->getDataRegistro());
            $stmt->bindValue($i++, $cadBasico->getNomeCadastro());
            $stmt->bindValue($i++, $cadBasico->getIdUserLogado());
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao inserir o nome do tipo de cadastro " . NOME_TIPO_CADASTRO_BASICO[$cadBasico->getTipoCadastro()]))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public function alterarCadastroBasico(CadastroBasicoModel $cadBasicoModel)
    {
        try {
        
            $stmt = $this->conn->prepare(CadastroBasicoSQL::alterarCadastroBasico());
            $stmt->bindValue(1, $cadBasicoModel->getNomeCadastro()) .
            $stmt->bindValue(2, $cadBasicoModel->getIdCadastroBasicoAlterar());
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao alterar o nome do tipo de cadastro " . NOME_TIPO_CADASTRO_BASICO[$cadBasico->getTipoCadastro()]))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function excluirCadastroBasico(int $id)
    {
        try {
            
            $stmt = $this->conn->prepare(CadastroBasicoSQL::excluirCadastroBasico());

            $stmt->bindValue(1, $id);

            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao excluir o nome do tipo de cadastro " . NOME_TIPO_CADASTRO_BASICO[$cadBasico->getTipoCadastro()]))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public function buscarTodosCadastrosBasicos(int $tipoCadastro)
    {
        try {
            
            $stmt = $this->conn->prepare(CadastroBasicoSQL::buscarCadastroBasico());
            $stmt->bindValue(1, $tipoCadastro);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados do tipo de cadastro básico " . NOME_TIPO_CADASTRO_BASICO[$tipoCadastro]))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public function buscarUmCadastroBasico(int $id)
    {
        try {
            
            $stmt = $this->conn->prepare(CadastroBasicoSQL::buscarCadastroBasicoPorId());
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetch();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar o cadastro básico "))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

}
