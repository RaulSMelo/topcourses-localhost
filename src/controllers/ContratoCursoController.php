<?php



namespace Src\controllers;

use Src\models\ContratoCursoModel;
use Src\dao\ContratoCursoDao;
use Src\validate\ValidarCampos;
use Src\controllers\AgendamentoController;
use Src\traits\UtilCTRL;

class ContratoCursoController 
{
    private ContratoCursoDao   $dao;
    private ContratoCursoModel $contratoCursoModel;
    
    public function __construct($model = true) 
    {
        $this->dao = new ContratoCursoDao();
        
        if($model){
            
            $this->contratoCursoModel = new ContratoCursoModel();
            
        }
    }
    
    public function inserirContratoCurso()
    {   
        
        $resultado = ValidarCampos::validarCamposContratoCurso($this->contratoCursoModel, false);
        
        if(is_bool($resultado)){
            
            return $this->dao->inserirContratoCurso($this->contratoCursoModel);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function alterarContratoCurso()
    {
        
        $resultado = ValidarCampos::validarCamposContratoCurso($this->contratoCursoModel);
        
        if(is_bool($resultado)){
            
            $agendamentoCTRL = new AgendamentoController();
            
            $id = $this->contratoCursoModel->getIdContratoCurso();
            
            $dataMinDisponivelSemAnotacao = $agendamentoCTRL->buscarDataMinSemAnotacaoPauta($id);
            
            return $this->dao->alterarContratoCurso($this->contratoCursoModel, $dataMinDisponivelSemAnotacao);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function buscarTodosOsDadosDoContratoCursoPorID(int $id, int $tipoContrato) 
    {
        $tipoContratoPF = (
            $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PF_GRUPO_MENSAL ||
            $tipoContrato == PF_INDIVIDUAL_ACIMA_DE_20_HORAS ||
            $tipoContrato == PF_INDIVIDUAL_MENSAL ||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS
        );
        
        $tipoContratoPJ = (
            $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PJ_GRUPO_MENSAL ||
            $tipoContrato == PJ_INDIVIDUAL_ACIMA_DE_20_HORAS ||
            $tipoContrato == PJ_INDIVIDUAL_MENSAL ||
            $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS
        );
        
        if($tipoContratoPF){
            
            return $this->dao->buscarTodosOsDados_ContratoPF_PorID($id);
            
        }else if($tipoContratoPJ){
            
            return $this->dao->buscarTodosOsDados_ContratoPJ_PorID($id);
        } 
    }

}
