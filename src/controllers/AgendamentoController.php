<?php



namespace Src\controllers;

use Src\models\AgendamentoModel;
use Src\dao\AgendamentoDao;

class AgendamentoController 
{
    private AgendamentoDao   $dao;
    private AgendamentoModel $agendamentoModel;
    
    public function __construct($model = true) 
    {
        $this->dao = new AgendamentoDao();
        
        if($model){
            
            $this->agendamentoModel = new AgendamentoModel();
            
        }
    }
    
    public function buscarAgendamentosPorIdDoContrato(int $id, $pauta = false) 
    {
        return $this->dao->buscarAgendamentosPorIdDoContrato($id, $pauta);
    }
    
    public function buscarDataMinSemAnotacaoPauta(int $id) 
    {
        return $this->dao->buscarDataMinSemAnotacaoPauta($id);
    }
    
    
    public function buscarQtdeDatasComAnotacoes(int $id) 
    {
        return $this->dao->buscarQtdeDatasComAnotacoes($id);
    }
    
    public function buscarAgendamentosComHorasAgendadas($idContrato, $dataInicio, $dataFinal) 
    {
        return $this->dao->buscarAgendamentosComHorasAgendadas($idContrato, $dataInicio, $dataFinal);
    }
    
    
}
