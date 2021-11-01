<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\erro\Erro;
use Src\dao\Conexao;
use Src\dao\sql\EmpresaSQL;
use Src\dao\sql\EnderecoSQL;
use Src\models\EmpresaModel;

class EmpresaDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function inserirEmpresa(EmpresaModel $empresa) 
    {
        
        $this->conn->beginTransaction();
        
        try {
            
            $stmt = $this->conn->prepare(EmpresaSQL::inserirEmpresa());
            $i = 1;
            $stmt->bindValue($i++, $empresa->getRazaoSocial());
            $stmt->bindValue($i++, $empresa->getCnpj());
            $stmt->bindValue($i++, $empresa->getEmail());
            $stmt->bindValue($i++, $empresa->getTelefone());
            $stmt->bindValue($i++, $empresa->getTelefoneOpcional());
            $stmt->bindValue($i++, $empresa->getNomeFantasia());
            $stmt->bindValue($i++, $empresa->getIdUserLogado());
            $stmt->bindValue($i++, $empresa->getDataRegistro());
            
            $stmt->execute();
            
            $empresa->getEndereco()->setIdColaborador(null);
            $empresa->getEndereco()->setIdEmpresa($this->conn->lastInsertId());
            $empresa->getEndereco()->setIdInteressado(null);
            
            $stmt = $this->conn->prepare(EnderecoSQL::inserirEndereco());
            $i = 1;
            $stmt->bindValue($i++, $empresa->getEndereco()->getCep());
            $stmt->bindValue($i++, $empresa->getEndereco()->getRua());
            $stmt->bindValue($i++, $empresa->getEndereco()->getNumero());
            $stmt->bindValue($i++, $empresa->getEndereco()->getComplemento());
            $stmt->bindValue($i++, $empresa->getEndereco()->getBairro());
            $stmt->bindValue($i++, $empresa->getEndereco()->getCidade());
            $stmt->bindValue($i++, $empresa->getEndereco()->getUf());
            $stmt->bindValue($i++, $empresa->getEndereco()->getIdColaborador());
            $stmt->bindValue($i++, $empresa->getEndereco()->getIdEmpresa());
            $stmt->bindValue($i++, $empresa->getEndereco()->getIdInteressado());
            $stmt->bindValue($i++, $empresa->getIdUserLogado());
            $stmt->bindValue($i++, $empresa->getDataRegistro());
            
            $stmt->execute();
            
            $this->conn->commit();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            $this->conn->rollBack();
            
            (new Log("ERRO ao inserir os dados da empresa"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);
            
            exit;
        }
        
    }
    
    public function alterarEmpresa(EmpresaModel $empresa) 
    {
        $this->conn->beginTransaction();
        
        try {
            
            $stmt = $this->conn->prepare(EmpresaSQL::alterarEmpresa());
            $i = 1;
            $stmt->bindValue($i++, $empresa->getRazaoSocial());
            $stmt->bindValue($i++, $empresa->getCnpj());
            $stmt->bindValue($i++, $empresa->getEmail());
            $stmt->bindValue($i++, $empresa->getTelefone());
            $stmt->bindValue($i++, $empresa->getTelefoneOpcional());
            $stmt->bindValue($i++, $empresa->getNomeFantasia());
            $stmt->bindValue($i++, $empresa->getIdEmpresa());
            
            $stmt->execute();
            
            $stmt = $this->conn->prepare(EnderecoSQL::alterarEndereco());
            $i = 1;
            $stmt->bindValue($i++, $empresa->getEndereco()->getCep());
            $stmt->bindValue($i++, $empresa->getEndereco()->getRua());
            $stmt->bindValue($i++, $empresa->getEndereco()->getNumero());
            $stmt->bindValue($i++, $empresa->getEndereco()->getComplemento());
            $stmt->bindValue($i++, $empresa->getEndereco()->getBairro());
            $stmt->bindValue($i++, $empresa->getEndereco()->getCidade());
            $stmt->bindValue($i++, $empresa->getEndereco()->getUf());
            $stmt->bindValue($i++, $empresa->getEndereco()->getIdEndereco());
            
            $stmt->execute();
            
            $this->conn->commit();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            $this->conn->rollBack();
            
            (new Log("ERRO ao alterar os dados da empresa"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function excluirEmpresa(int $id) 
    {
        $this->conn->beginTransaction();
        
        try {
            
            $stmt = $this->conn->prepare(EmpresaSQL::retornaSeEmpresaPossuiVinculoComContratoCurso());
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            if($stmt->fetch()["qtde_id_empresa_nos_contrato_curso"] > 0){
                
                Erro::setErro(" A empresa possui vínculo com contrato, por isso não é possível realizar a exclusão");
                
                return -1;
            }
            
            $stmt = $this->conn->prepare(EnderecoSQL::excluirEndereco(EMPRESA));
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            $stmt = $this->conn->prepare(EmpresaSQL::excluirEmpresa());
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            $this->conn->commit();
            
            return 1;
            
        } catch (\PDOException $e) {
            
            $this->conn->rollBack();
            
            (new Log("ERRO ao excluir os dados da empresa"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarEmpresaPorRazaoSocialOuPorNomeFantasia(string $nome) 
    {
        try {
            
            $stmt = $this->conn->prepare(EmpresaSQL::buscarEmpresaPorRazaoSocialOuNomeFantasia());
            $stmt->bindValue(1, "%{$nome}%");
            $stmt->bindValue(2, "%{$nome}%");

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados da empresa, por razão social ou pelo nome fantasia"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);
            
            exit;
        }
        
    }
    
    public function buscarEmpresasPorId(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(EmpresaSQL::buscarEmpresaPorId());
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetch();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados da empresa, pelo ID"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);
            
            exit;
        }
        
    }
    
    public function buscarTodasEmpresasParaPreencherCombo()
    {
        try {
            
            $stmt = $this->conn->prepare(EmpresaSQL::buscarTodasEmpresasParaPreencherCombo());
        
            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados da empresa, pelo ID"))->enviarLogDeErro($e);
            
            header("LOCATION " . PAGINA_DE_ERRO);
            
            exit;
        }
        
    }
    
}
