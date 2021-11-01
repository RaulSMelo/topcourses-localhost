<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\ConfiguracaoEmpresaSQL;
use Src\models\ConfiguracaoEmpresaModel;

class ConfiguracaoEmpresaDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function alterarDadosConfiguracaoEmpresa(ConfiguracaoEmpresaModel $configEmpresaModel) 
    {
        try {
            
            $stmt = $this->conn->prepare(ConfiguracaoEmpresaSQL::alterarDadosConfiguracaoEmpresa());
            $i = 1;
            $stmt->bindValue($i++, $configEmpresaModel->getRazaoSocial());
            $stmt->bindValue($i++, $configEmpresaModel->getCnpj());
            $stmt->bindValue($i++, $configEmpresaModel->getEmail());
            $stmt->bindValue($i++, $configEmpresaModel->getTelefone());
            $stmt->bindValue($i++, $configEmpresaModel->getCep());
            $stmt->bindValue($i++, $configEmpresaModel->getRua());
            $stmt->bindValue($i++, $configEmpresaModel->getNumero());
            $stmt->bindValue($i++, $configEmpresaModel->getComplemento());
            $stmt->bindValue($i++, $configEmpresaModel->getBairro());
            $stmt->bindValue($i++, $configEmpresaModel->getCidade());
            $stmt->bindValue($i++, $configEmpresaModel->getEstado());
            $stmt->bindValue($i++, $configEmpresaModel->getUf());
            $stmt->bindValue($i++, $configEmpresaModel->getNomeFantasia());
            $stmt->bindValue($i++, $configEmpresaModel->getIdUserLogado());
            $stmt->bindValue($i++, $configEmpresaModel->getDataRegistro());
            $stmt->bindValue($i++, ID_CONFIGURACAO_EMPRESA);
            
            $stmt->execute();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao alterar os dados de configuração da empresa"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
        
    }
    
    public function buscarTodosDadosConfiguracaoEmpresa() 
    {
        try {
            
            $stmt = $this->conn->prepare(ConfiguracaoEmpresaSQL::buscarTodosDadosConfiguracaoEmpresa());
            
            $stmt->execute();

            return $stmt->fetch();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados de configuração da empresa"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
}
