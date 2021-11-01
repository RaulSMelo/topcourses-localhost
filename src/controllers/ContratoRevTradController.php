<?php



namespace Src\controllers;

use Src\dao\ContratoRevisaoTraducaoDao;
use Src\models\ContratoRevisaoTraducaoModel;
use Src\validate\ValidarCampos;

class ContratoRevTradController 
{
    private ContratoRevisaoTraducaoDao $dao;
    private ContratoRevisaoTraducaoModel $contratoRevTradModel;
    
    public function __construct() 
    {
        $this->dao = new ContratoRevisaoTraducaoDao();
        $this->contratoRevTradModel = new ContratoRevisaoTraducaoModel();
    }
    
    public function inserirContratoRevisaoTraducao() 
    {
        $resultado = ValidarCampos::validarCamposContratoRevTrad($this->contratoRevTradModel, false);
        
        if(is_bool($resultado)){
            
            return $this->dao->inserirContratoRevTrad($this->contratoRevTradModel);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
        
    }
    
    public function alterarContratoRevTrad() 
    {
        $resultado = ValidarCampos::validarCamposContratoRevTrad($this->contratoRevTradModel);
        
        if(is_bool($resultado)){
            
            return $this->dao->alterarContratoRevTrad($this->contratoRevTradModel);
            
        }else if (is_numeric($resultado)){
            
            return $resultado;
            
        }
    }
    
    public function buscarTodosOsDadosContratoRevTradPorId(int $id) 
    {
        return $this->dao->buscarTodosOsDadosContratoRevTradPorId($id);
    }

    
}
