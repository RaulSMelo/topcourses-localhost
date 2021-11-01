<?php

namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\traits\UtilCTRL;
use Src\dao\sql\AgendamentoSQL;
use Src\dao\sql\InteressadoSQL;
use Src\dao\sql\ContratoCursoSQL;
use Src\models\ContratoCursoModel;
use Src\dao\sql\DarBaixaEmParcelasSQL;
use Src\models\DarBaixaEmParcelaModel;

class ContratoCursoDao 
{
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao();
    }
    
    public function inserirContratoCurso(ContratoCursoModel $contratoCurso)
    {
        
        $this->conn->beginTransaction();
        
        try {
            
            for($i = 0; $i < count($contratoCurso->getIdAluno()); $i++){
                
                $stmt = $this->conn->prepare(InteressadoSQL::alterarSomenteCPFaluno());
                $stmt->bindValue(1, UtilCTRL::retiraMascara($contratoCurso->getCpf()[$i]));
                $stmt->bindValue(2, $contratoCurso->getIdAluno()[$i]);
                $stmt->execute();
            }
            
            
            $contratoCurso->setSituacao(EM_ANDAMENTO);
            
            $stmt = $this->conn->prepare(ContratoCursoSQL::inserirContratoCurso());
            $i = 1;
            $stmt->bindValue($i++, $contratoCurso->getIdTipoContrato());
            $stmt->bindValue($i++, $contratoCurso->getIdCurso());
            $stmt->bindValue($i++, $contratoCurso->getIdIdioma());
            $stmt->bindValue($i++, $contratoCurso->getValorHoraAula());
            $stmt->bindValue($i++, $contratoCurso->getTotalHoras());
            $stmt->bindValue($i++, $contratoCurso->getValorEntrada());
            $stmt->bindValue($i++, $contratoCurso->getQtdeParcelas());
            $stmt->bindValue($i++, $contratoCurso->getValorParcela());
            $stmt->bindValue($i++, $contratoCurso->getDesconto());
            $stmt->bindValue($i++, $contratoCurso->getValorTotal());
            $stmt->bindValue($i++, $contratoCurso->getDiaVencimentoParcela());
            $stmt->bindValue($i++, $contratoCurso->getDataInicioContrato());
            $stmt->bindValue($i++, $contratoCurso->getDataTerminoContrato());
            $stmt->bindValue($i++, $contratoCurso->getNumeroMesesPorAno());
            $stmt->bindValue($i++, $contratoCurso->getLocalDasAulas());
            $stmt->bindValue($i++, $contratoCurso->getCargaHorariaSemanal());
            $stmt->bindValue($i++, $contratoCurso->getIdProfessor());
            $stmt->bindValue($i++, $contratoCurso->getIdNivel());
            $stmt->bindValue($i++, $contratoCurso->getIdTurma());
            $stmt->bindValue($i++, $contratoCurso->getMaterial());
            $stmt->bindValue($i++, $contratoCurso->getPrograma());
            $stmt->bindValue($i++, $contratoCurso->getMarcacaoGeral());
            $stmt->bindValue($i++, $contratoCurso->getIdEmpresa());
            $stmt->bindValue($i++, $contratoCurso->getIdUserLogado());
            $stmt->bindValue($i++, $contratoCurso->getDataRegistro());
            $stmt->bindValue($i++, $contratoCurso->getSituacao());
            
            $stmt->execute();
            
            $idContratoCurso = $this->conn->lastInsertId();
            $idsAlunos       = $contratoCurso->getIdAluno();
            
            for($i = 0; $i < count($idsAlunos); $i++){
                
                $stmt =  $this->conn->prepare(ContratoCursoSQL::inserirTbInteressadoEtbcontratoCurso());
                $stmt->bindValue(1, $idsAlunos[$i]);
                $stmt->bindValue(2, $idContratoCurso);
                $stmt->execute();
            }
            
            $darBaixaParcela = new DarBaixaEmParcelaModel();
            
            $darBaixaParcela->setIdContratoCurso($idContratoCurso);
            
            
            for($i = 0; $i < count($idsAlunos); $i++){
                
                $darBaixaParcela->setIdInteressado($idsAlunos[$i]);
                
                for($k = 0; $k < (int)$darBaixaParcela->getQtdeParcela(); $k++){

                    $stmt = $this->conn->prepare(DarBaixaEmParcelasSQL::inserirTbDarbaixaParcelas());
                    $j = 1;
                    $stmt->bindValue($j++, $darBaixaParcela->getQtdeParcela());
                    $stmt->bindValue($j++, $k + 1);

                    if($k == 0){

                        $stmt->bindValue($j++, $darBaixaParcela->getDataVencimentoParcela());

                    }else{

                        $stmt->bindValue($j++, UtilCTRL::somarMesesData($contratoCurso->getDiaVencimentoParcela(), $k));
                    }

                    $stmt->bindValue($j++, $darBaixaParcela->getValorParcelaPago());
                    $stmt->bindValue($j++, $darBaixaParcela->getTipoContrato());
                    $stmt->bindValue($j++, $darBaixaParcela->getSituacaoPagamento());
                    $stmt->bindValue($j++, $darBaixaParcela->getTipoPagamento());
                    $stmt->bindValue($j++, $darBaixaParcela->getDataRegistroPagamento());
                    $stmt->bindValue($j++, $darBaixaParcela->getIdContratoRevTrad());
                    $stmt->bindValue($j++, $darBaixaParcela->getIdContratoCurso());
                    $stmt->bindValue($j++, $darBaixaParcela->getIdInteressado());

                    $stmt->execute();

                }
            }
            
            $diasSemana = $contratoCurso->getAgendamento()->getDiaDaSemana();
            $dataInicio = $contratoCurso->getDataInicioContrato();
            $dataFinal  = $contratoCurso->getDataTerminoContrato();
            $arrDtIni   = $contratoCurso->getAgendamento()->getHoraInicial();
            $arrDtFim   = $contratoCurso->getAgendamento()->getHoraFinal();
            
            $datasAgendadas = UtilCTRL::PegarDataDosDiasDaSemanaAgendamento($diasSemana, $dataInicio, $dataFinal);
            
            
            
            if(!in_array("a-combinar", $diasSemana)){
                
                foreach ($datasAgendadas as $key => $value){

                   
                    for($i = 0; $i < count($diasSemana); $i++){
                    
                        if($key == $diasSemana[$i]){
                            
                            for($j = 0; $j < count($value); $j++){
                                
                                $stmt = $this->conn->prepare(AgendamentoSQL::inserirAgendamentoContratoCurso());
                                $stmt->bindValue(1, $diasSemana[$i]);
                                $stmt->bindValue(2, $value[$j]);
                                $stmt->bindValue(3, $arrDtIni[$i]);
                                $stmt->bindValue(4, $arrDtFim[$i]);
                                $stmt->bindValue(5, $idContratoCurso);

                                $stmt->execute();
                                
                            }
                        }
                    }   
                } 
                
            }else{
                
                foreach ($datasAgendadas as $data){
                        
                    $stmt = $this->conn->prepare(AgendamentoSQL::inserirAgendamentoContratoCurso());
                    $stmt->bindValue(1, date('w', strtotime($data)));
                    $stmt->bindValue(2, $data);
                    $stmt->bindValue(3, null);
                    $stmt->bindValue(4, null);
                    $stmt->bindValue(5, $idContratoCurso);

                    $stmt->execute();
                }
            }
            
            $this->conn->commit();
            
            return ["ret" => 1, "id-contrato" => $idContratoCurso, "tipo-contrato" => $contratoCurso->getIdTipoContrato()];
            
        } catch (\PDOException $e) {
            
            $this->conn->rollBack();
            
            (new Log("ERRO ao inserir os dados do contrato " . TIPOS_DE_CONTRATOS[$contratoCurso->getIdTipoContrato()] ))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;           
        }
    }
    
    public function alterarContratoCurso(ContratoCursoModel $contratoCurso, $dataInicio) 
    {   
        
        $this->conn->beginTransaction();
        
        try {
            
            $stmt = $this->conn->prepare(ContratoCursoSQL::alterarContratoCurso()); 
            $i = 1;
            $stmt->bindValue($i++, $contratoCurso->getIdProfessor());
            $stmt->bindValue($i++, $contratoCurso->getIdNivel());
            $stmt->bindValue($i++, $contratoCurso->getIdTurma());
            $stmt->bindValue($i++, $contratoCurso->getMaterial());
            $stmt->bindValue($i++, $contratoCurso->getPrograma());
            $stmt->bindValue($i++, $contratoCurso->getMarcacaoGeral());
            $stmt->bindValue($i++, $contratoCurso->getSituacao());
            $stmt->bindValue($i++, $contratoCurso->getIdContratoCurso());
            
            $stmt->execute();
            
            $this->percorrerEexcluirOsAgendamentosSemAnotacoes($contratoCurso->getIdContratoCurso());
            
            $diasSemana = $contratoCurso->getAgendamento()->getDiaDaSemana();
            $dataFinal  = $contratoCurso->getDataTerminoContrato();
            $arrHrIni   = $contratoCurso->getAgendamento()->getHoraInicial();
            $arrHrFim   = $contratoCurso->getAgendamento()->getHoraFinal();
            $idContrato = $contratoCurso->getIdContratoCurso();
            
            $datasAgendadas = UtilCTRL::PegarDataDosDiasDaSemanaAgendamento($diasSemana, $dataInicio, $dataFinal);
            
            
            
            if(!in_array("a-combinar", $diasSemana)){
                
                foreach ($datasAgendadas as $key => $value){

                   
                    for($i = 0; $i < count($diasSemana); $i++){
                    
                        if($key == $diasSemana[$i]){
                            
                            for($j = 0; $j < count($value); $j++){
                                
                                $stmt = $this->conn->prepare(AgendamentoSQL::inserirAgendamentoContratoCurso());
                                $stmt->bindValue(1, $diasSemana[$i]);
                                $stmt->bindValue(2, $value[$j]);
                                $stmt->bindValue(3, $arrHrIni[$i]);
                                $stmt->bindValue(4, $arrHrFim[$i]);
                                $stmt->bindValue(5, $idContrato);

                                $stmt->execute();
                                
                            }
                        }
                    }   
                } 
                
            }else{
                
                foreach ($datasAgendadas as $data){
                        
                    $stmt = $this->conn->prepare(AgendamentoSQL::inserirAgendamentoContratoCurso());
                    $stmt->bindValue(1, date('w', strtotime($data)));
                    $stmt->bindValue(2, $data);
                    $stmt->bindValue(3, null);
                    $stmt->bindValue(4, null);
                    $stmt->bindValue(5, $idContrato);

                    $stmt->execute();
                }
            }
            
            
            $this->conn->commit();
            
            return 1;
            
        } catch (\PDOException $e) {
           
            $this->conn->rollBack();
            
            (new Log("ERRO ao alterar os dados do contrato " . TIPOS_DE_CONTRATOS[$contratoCurso->getIdTipoContrato()] ))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
            
        }
        
    }


    public function buscarTodosOsDados_ContratoPF_PorID(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(ContratoCursoSQL::buscarTodosOsDados_ContratoPF_PorID());
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $id);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados do contrato curso PF pelo ID"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarTodosOsDados_ContratoPJ_PorID(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(ContratoCursoSQL::buscarTodosOsDados_ContratoPJ_PorID());
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $id);
            $stmt->bindValue(3, $id);

            $stmt->execute();
        
            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados do contrato curso PJ pelo ID"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    
    public function buscarTodosOsAgendamentosPeloID(int $id) 
    {
        try {
            
            $stmt = $this->conn->prepare(AgendamentoSQL::buscarTodosOsAgendamentosPorIDdoContrato());
            $stmt->bindValue(1, $id);

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os dados dos agendamentos pelo ID do contrato"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarTodosOsIDsDaTabelaPautaAlunosQueTenhamAnotacoes() 
    {
        try {
           
            $stmt = $this->conn->prepare(AgendamentoSQL::buscarTodosOsIDsDaTabelaPautaAlunosQueTenhamAnotacoes());
            
            $stmt->execute();
            
            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os IDs da tabela tb_pauta_alunos"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function buscarTodosOsIDsDaTabelaAnotacaoDaAulaQueTenhamAnotacoes() 
    {
        try {
           
            $stmt = $this->conn->prepare(AgendamentoSQL::buscarTodosOsIDsDaTabelaAnotacaoDaAulaQueTenhamAnotacoes());
            
            $stmt->execute();
            
            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {
            
            (new Log("ERRO ao buscar os IDs da tabela tb_anotacao_aula"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }
    
    public function excluirAgendamento($id) 
    {
        try {
           
            $stmt = $this->conn->prepare(AgendamentoSQL::excluirAgendamento());
            $stmt->bindValue(1, $id);
            
            $stmt->execute();
                    
                    
        } catch (\PDOException $e) {

            (new Log("ERRO ao excluir o agendamento - ID: " . $id))->enviarLogDeErro($e);

            header("LOCATION: " . PAGINA_DE_ERRO);

            exit;
        }
    }
    
    public function retornarSomenteIdsTabelaAgendamento($idContrato)
    {
        $ids = [];
        
        $agendamentos = $this->buscarTodosOsAgendamentosPeloID($idContrato);
        
        for($i = 0; $i < count($agendamentos); $i++){
            
            $ids[] = $agendamentos[$i]["id_agendamento"];
        }
        
        return $ids;
    }
    
    public function retornarSomenteIdsTabelaPautaEAnotacaoAula()
    {
        $ids = [];
        
        $pauta_alunos   = $this->buscarTodosOsIDsDaTabelaPautaAlunosQueTenhamAnotacoes();
        $anotacoes_aula = $this->buscarTodosOsIDsDaTabelaAnotacaoDaAulaQueTenhamAnotacoes();
        
        $ids_tabela_pauta_e_anotacao = array_merge($pauta_alunos, $anotacoes_aula);
        
        for($i = 0; $i < count($ids_tabela_pauta_e_anotacao); $i++){
            
            $ids[] = $ids_tabela_pauta_e_anotacao[$i]["id_agendamento"];
        }
        
        return array_unique($ids);
    }
    
    public function percorrerEexcluirOsAgendamentosSemAnotacoes($idContrato) 
    {
        $ids_agendamentos = $this->retornarSomenteIdsTabelaAgendamento($idContrato);
        $ids_tabela_pauta_e_anotacao = $this->retornarSomenteIdsTabelaPautaEAnotacaoAula();
        
        foreach ($ids_agendamentos as $key => $id){
            
            if(!in_array($id, $ids_tabela_pauta_e_anotacao)){
                
                $this->excluirAgendamento($id);
            }
        }
        
    }

}
