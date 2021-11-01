<?php

namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\erro\Erro;
use Src\dao\Conexao;
use Src\dao\sql\PessoaSQL;
use Src\dao\sql\EnderecoSQL;
use Src\dao\sql\InteressadoSQL;
use Src\models\InteressadoModel;

class InteressadoDao
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::obterConexao();
    }

    public function inserirInteressado(InteressadoModel $interessado)
    { 

        $this->conn->beginTransaction();

        try {

            $stmt = $this->conn->prepare(PessoaSQL::inserirPessoa());
            $i = 1;
            $stmt->bindValue($i++, $interessado->getNome());
            $stmt->bindValue($i++, $interessado->getSobrenome());
            $stmt->bindValue($i++, $interessado->getEmail());
            $stmt->bindValue($i++, $interessado->getTelefone());
            $stmt->bindValue($i++, $interessado->getCpf());
            $stmt->bindValue($i++, $interessado->getDataRegistro());

            $stmt->execute();
            
            $lastId = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare(InteressadoSQL::inserirInteressado());
            $i = 1;
            $stmt->bindValue($i++, $lastId);
            $stmt->bindValue($i++, $interessado->getIdCurso());
            $stmt->bindValue($i++, $interessado->getIdRevisao());
            $stmt->bindValue($i++, $interessado->getIdTraducao());
            $stmt->bindValue($i++, $interessado->getDataNascimento());
            $stmt->bindValue($i++, $interessado->getProfissao());
            $stmt->bindValue($i++, $interessado->getIdIdioma());
            $stmt->bindValue($i++, $interessado->getIdMidia());
            $stmt->bindValue($i++, $interessado->getIdColaborador());
            $stmt->bindValue($i++, $interessado->getIdTipoContato());
            $stmt->bindValue($i++, $interessado->getDataAgendamento());
            $stmt->bindValue($i++, $interessado->getTesteNivelamento());
            $stmt->bindValue($i++, $interessado->getIdResultado());
            $stmt->bindValue($i++, $interessado->getInformacoesAdicionais());
            $stmt->bindValue($i++, $interessado->getIdUserLogado());

            $stmt->execute();
            
            
            $resultadoCadastroEndereco = EnderecoDao::inserirOUalterarEndereco(INTERESSADO, $lastId);

            if (!$resultadoCadastroEndereco) {

                $this->conn->rollBack();

                return $resultadoCadastroEndereco;
            }
            

            $this->conn->commit();

            return 1;
            
        } catch (\PDOException $e) {

            $this->conn->rollBack();

            (new Log("ERRO ao inserir os dados do interessado"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    
    public function alterarInteressado(InteressadoModel $interessado)
    {

        $this->conn->beginTransaction();

        try {
            
            $id = $interessado->getIdInteressado();

            $stmt = $this->conn->prepare(PessoaSQL::alterarPessoa());
            $i = 1;
            $stmt->bindValue($i++, $interessado->getNome());
            $stmt->bindValue($i++, $interessado->getSobrenome());
            $stmt->bindValue($i++, $interessado->getEmail());
            $stmt->bindValue($i++, $interessado->getTelefone());
            $stmt->bindValue($i++, $interessado->getCpf());
            $stmt->bindValue($i++, $id);

            $stmt->execute();
            

            $stmt = $this->conn->prepare(InteressadoSQL::alterarInteressado());
            $i = 1;
            $stmt->bindValue($i++, $interessado->getIdCurso());
            $stmt->bindValue($i++, $interessado->getIdRevisao());
            $stmt->bindValue($i++, $interessado->getIdTraducao());
            $stmt->bindValue($i++, $interessado->getDataNascimento());
            $stmt->bindValue($i++, $interessado->getProfissao());
            $stmt->bindValue($i++, $interessado->getIdIdioma());
            $stmt->bindValue($i++, $interessado->getIdMidia());
            $stmt->bindValue($i++, $interessado->getIdColaborador());
            $stmt->bindValue($i++, $interessado->getIdTipoContato());
            $stmt->bindValue($i++, $interessado->getDataAgendamento());
            $stmt->bindValue($i++, $interessado->getTesteNivelamento());
            $stmt->bindValue($i++, $interessado->getIdResultado());
            $stmt->bindValue($i++, $interessado->getInformacoesAdicionais());
            $stmt->bindValue($i++, $id);

            
            $stmt->execute();
            
            $resultadoCadastroEndereco = EnderecoDao::inserirOUalterarEndereco(INTERESSADO, $id);
            
            if (!$resultadoCadastroEndereco) {

                $this->conn->rollBack();
                
                return $resultadoCadastroEndereco;
            }

            $this->conn->commit();

            return 1;
            
        } catch (\PDOException $e) {

            $this->conn->rollBack();

            (new Log("ERRO ao alterar os dados do interessado"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    
    public function excluirInteressado($id) 
    {
        $this->conn->beginTransaction();
        
        try {
            
            $stmt = $this->conn->prepare(InteressadoSQL::retornaQtdeDeInteressadosEnvolvidosComContratos());
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            if(is_numeric($stmt->fetch()["qtde_interessados_nos_contratos"])){
                
                Erro::setErro("O interessado possui vínculo com contrato, por isso não é possível realizar a exclusão");
                
                return -1;
            }
            
            $stmt = $this->conn->prepare(EnderecoSQL::excluirEndereco(INTERESSADO));
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            
            $stmt = $this->conn->prepare(InteressadoSQL::excluirInteressado());
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            
            $stmt = $this->conn->prepare(PessoaSQL::excluirPessoa());
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            $this->conn->commit();
            
            return 1;
            
        } catch (\PDOException $e) {

            $this->conn->rollBack();

            (new Log("ERRO ao excluir os dados do interessado"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    
    public function filtarBuscarInteressados($data_inicio, $data_final, $nome, $sobrenome, $id_curso, $id_traducao, $id_revisao) 
    {
        try {
      
            $stmt = $this->conn->prepare(InteressadoSQL::filtrarConsultaInteressados($nome, $sobrenome, $id_curso, $id_traducao, $id_revisao));
            $i = 1;
            $stmt->bindValue($i++, $data_inicio);
            $stmt->bindValue($i++, $data_final);

            if(!empty($nome) && !empty($sobrenome)){

                $stmt->bindValue($i++, "%{$nome}%");
                $stmt->bindValue($i++, "%{$sobrenome}%");

            }else if(!empty($nome)){

                $stmt->bindValue($i++, "%{$nome}%");
            }

            if(!empty($id_curso)){

                $stmt->bindValue($i++, $id_curso);
            }

            if(!empty($id_traducao)){

                $stmt->bindValue($i++, $id_traducao);
            }

            if(!empty($id_revisao)){

                $stmt->bindValue($i++, $id_revisao);
            }

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar os dados dos interessados"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }     
    }
    
    public function buscarInteressadoPorId(int $id)
    {
        try {
            
            $stmt = $this->conn->prepare(InteressadoSQL::buscarInteressadoPorID());
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetch();
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar os dados do interessado pelo id"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function filtrarInteressadosPorNomeEsituacaoContrato($nome, $sobrenome, $situacao, $pauta) 
    {
        try {
            
            $stmt = $this->conn->prepare(InteressadoSQL::filtrarInteressadosPorNomeEsituacaoDoContrato($nome, $sobrenome, $situacao, $pauta));
            $i = 1;
            if(!empty($nome) && !empty($sobrenome)){
                
                $stmt->bindValue($i++, "%{$nome}%");
                $stmt->bindValue($i++, "%{$sobrenome}%");
                
            }else if(!empty($nome)){
                
                $stmt->bindValue($i++, "%{$nome}%");
            }
            

            if($situacao != ""){

                $stmt->bindValue($i++, $situacao);
                $stmt->bindValue($i++, $situacao);
            }

            $stmt->execute();
        
            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar os dados dos interessados pelo nome e situação do contrato"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarInteressadoPorNome($nome, $sobrenome) 
    {
        try {
            
            $stmt = $this->conn->prepare(InteressadoSQL::buscarInteressadoPorNome()); 
            $stmt->bindValue(1, "%{$nome}%");
            $stmt->bindValue(2, "%{$sobrenome}%");

            $stmt->execute();
            
            return $stmt->fetchAll(); 
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar os dados dos interessados pelo nome"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscaDataDaAulaAgendadaPorIdInteressado($id) 
    {
        try {
            
            $stmt = $this->conn->prepare(InteressadoSQL::buscaDataDaAulaAgendadaPorIdInteressado());
            $stmt->bindValue(1, $id);
            
            $stmt->execute();
            
            return $stmt->fetch();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar a data da aula agendada pelo id do interessados"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
        
    }
    
}
