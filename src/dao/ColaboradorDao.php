<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\EnderecoDao;
use Src\dao\sql\PessoaSQL;
use Src\dao\sql\ColaboradorSQL;
use Src\models\ColaboradorModel;

class ColaboradorDao
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::obterConexao();
    }

    public function inserirColaborador(ColaboradorModel $colaborador)
    {

        $this->conn->beginTransaction();

        try {

            $stmt = $this->conn->prepare(PessoaSQL::inserirPessoa());
            $i = 1;
            $stmt->bindValue($i++, $colaborador->getNome());
            $stmt->bindValue($i++, $colaborador->getSobrenome());
            $stmt->bindValue($i++, $colaborador->getEmail());
            $stmt->bindValue($i++, $colaborador->getTelefone());
            $stmt->bindValue($i++, $colaborador->getCpf());
            $stmt->bindValue($i++, $colaborador->getDataRegistro());

            $stmt->execute();

            $lastId = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare(ColaboradorSQL::inserirColaborador());
            $i = 1;
            $stmt->bindValue($i++, $lastId);
            $stmt->bindValue($i++, $colaborador->getTipoAcesso());
            $stmt->bindValue($i++, $colaborador->getTelefoneOpcional());
            $stmt->bindValue($i++, $colaborador->getLogin());
            $stmt->bindValue($i++, $colaborador->getSenha());
            $stmt->bindValue($i++, $colaborador->getIdUserLogado());
            $stmt->bindValue($i++, $colaborador->getSituacao());

            $stmt->execute();

            for ($i = 0; $i < count($colaborador->getTipoColaborador()); $i++) {

                $stmt = $this->conn->prepare(ColaboradorSQL::inserir_TipoColaborador_e_colaborador());
                $stmt->bindValue(1, $lastId);
                $stmt->bindValue(2, $colaborador->getTipoColaborador()[$i]);
                
                $stmt->execute();
            }

            $resultadoCadastroEndereco = EnderecoDao::inserirOUalterarEndereco(COLABORADOR, $lastId, false);

            if (!$resultadoCadastroEndereco) {

                $this->conn->rollBack();

                return $resultadoCadastroEndereco;
            }


            $this->conn->commit();

            return 1;
            
        } catch (\PDOException $e) {

            $this->conn->rollBack();

            (new Log("Não foi possível inserir os dados do colaborador"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public function alterarColaborador(ColaboradorModel $colaborador)
    {
        $this->conn->beginTransaction();

        try {

            $id = $colaborador->getIdColaborador();

            $stmt = $this->conn->prepare(PessoaSQL::alterarPessoa());
            $i = 1;
            $stmt->bindValue($i++, $colaborador->getNome());
            $stmt->bindValue($i++, $colaborador->getSobrenome());
            $stmt->bindValue($i++, $colaborador->getEmail());
            $stmt->bindValue($i++, $colaborador->getTelefone());
            $stmt->bindValue($i++, $colaborador->getCpf());
            $stmt->bindValue($i++, $id);

            $stmt->execute();

            $stmt = $this->conn->prepare(ColaboradorSQL::alterarColaborador());
            $stmt->bindValue(1, $colaborador->getTipoAcesso());
            $stmt->bindValue(2, $colaborador->getTelefoneOpcional());
            $stmt->bindValue(3, ATIVO);
            $stmt->bindValue(4, $id);

            $stmt->execute();

            $stmt = $this->conn->prepare(ColaboradorSQL::excluir_tipoColaborador_e_Colaborador());
            $stmt->bindValue(1, $id);
            $stmt->execute();

            for ($i = 0; $i < count($colaborador->getTipoColaborador()); $i++) {

                $stmt = $this->conn->prepare(ColaboradorSQL::inserir_TipoColaborador_e_colaborador());
                $stmt->bindValue(1, $id);
                $stmt->bindValue(2, $colaborador->getTipoColaborador()[$i]);
                $stmt->execute();
            }
            
            $resultadoCadastroEndereco = EnderecoDao::inserirOUalterarEndereco(COLABORADOR, $id);
            
            if (!$resultadoCadastroEndereco) {

                $this->conn->rollBack();

                return $resultadoCadastroEndereco;
            }

            $this->conn->commit();

            return 1;
            
        } catch (\PDOException $e) {

            $this->conn->rollBack();
            
            (new Log("Não foi possível alterar os dados do colaborador"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function excluirColaboradores(int $id) 
    { 
        try {
            
            $stmt = $this->conn->prepare(ColaboradorSQL::excluirColaborador());
            $stmt->bindValue(1, INATIVO);
            $stmt->bindValue(2, $id);
            
            $stmt->execute();
            
            return 1;
           
        } catch (\PDOException $e) {
            
            (new Log("Não foi possível excluir os dados do colaborador"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
        
        
    }

    public function buscarTiposDeColaboradores()
    {
        try {
            
            $stmt = $this->conn->prepare(ColaboradorSQL::buscarTiposDeColaboradores());
            
            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("Não foi possível buscar os tipos de colaboradores"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public function buscarColaboradorPorTipo(int $tipoColaborador)
    {
        try {
            
            $stmt = $this->conn->prepare(ColaboradorSQL::buscarColaboradorPorTipo());
            $stmt->bindValue(1, ATIVO);
            $stmt->bindValue(2, $tipoColaborador);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("Não foi possível buscar os dados dos colaboradores pelo tipo"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public function buscarColaboradorPorId($id)
    {
        try {
            
            $stmt = $this->conn->prepare(ColaboradorSQL::buscarColaboradorPorId());
            $stmt->bindValue(1, ATIVO);
            $stmt->bindValue(2, $id);

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            
            (new Log("Não foi possível buscar os dados dos colaboradores pelo ID"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }


    public function buscarColaboradorPorNome($nome, $sobrenome, bool $group_by = false)
    {
        try {
            
            $stmt = $this->conn->prepare(ColaboradorSQL::buscarColaboradorPorNome($nome, $sobrenome, $group_by));
            $i = 1;
            $stmt->bindValue($i++, ATIVO);
            
            if(!empty($nome) && !empty($sobrenome)){
                
                $stmt->bindValue($i++, "%{$nome}%");
                $stmt->bindValue($i++, "%{$sobrenome}%");
                
            }else if(!empty ($nome)){
                
                $stmt->bindValue($i++, "%{$nome}%");
            }

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("Não foi possível buscar os dados dos colaboradores pelo nome"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public function buscarIdTipoColaboradores($id)
    {
        try {
            
            $stmt = $this->conn->prepare(ColaboradorSQL::buscaridItiposColaboradores());
            $stmt->bindValue(1, ATIVO);
            $stmt->bindValue(2, $id);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("Não foi possível buscar os IDs dos tipos de colaboradores"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public function buscarNomeTipoColaboradorPorId(int $id)
    {
        try {
            
            $stmt = $this->conn->prepare(ColaboradorSQL::buscarNomeTipoColaboradorPorId());
            $stmt->bindValue(1, ATIVO);
            $stmt->bindValue(2, $id);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("Não foi possível buscar os nomes dos tipos de colaboradores"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
}
