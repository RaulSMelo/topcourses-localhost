<?php

namespace Src\controllers;

use Src\dao\PautaAlunoDao;
use Src\models\PautaAlunoModel;
use Src\validate\ValidarCampos;

class PautaAlunoController 
{
   
    private PautaAlunoDao $dao;
    
    public function __construct() 
    {
        $this->dao = new PautaAlunoDao();
    }
    
    public function inserirAnotacaoProfessor(PautaAlunoModel $pautaModel) 
    {
        $resultado = ValidarCampos::validarCamposPautaAluno($pautaModel, false);
        
        if(is_bool($resultado)){
            
            return $this->dao->inserirAnotacaoProfessor($pautaModel);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
        
    }
    
    public function alterarAnotacaoProfessor(PautaAlunoModel $pautaModel) 
    {
        $resultado = ValidarCampos::validarCamposPautaAluno($pautaModel);
        
        if(is_bool($resultado)){
            
            return $this->dao->alterarAnotacaoProfessor($pautaModel);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
        
    }
    
    public function buscarAnotacaoProfessorPorId(int $id) 
    {
        return $this->dao->buscarAnotacaoProfessorPorId($id);
    }
    
}
