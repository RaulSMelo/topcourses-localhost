<?php

namespace Src\controllers;

use Src\dao\AnotacaoAulaDao;
use Src\models\AnotacaoAulaModel;
use Src\validate\ValidarCampos;

class AnotacaoAulaController 
{
    private AnotacaoAulaDao $dao;
    
    public function __construct($model = true) 
    {
        $this->dao = new AnotacaoAulaDao();

    }
    
    public function inserirAnotacaoAula(AnotacaoAulaModel $anotacaoModel) 
    {
        $resultado = ValidarCampos::validarCamposAnotacaoAula($anotacaoModel, false);
        
        if(is_bool($resultado)){
            
            return $this->dao->inserirAnotacaoAula($anotacaoModel);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function alterarAnotacaoAula(AnotacaoAulaModel $anotacaoModel) 
    {
        $resultado = ValidarCampos::validarCamposAnotacaoAula($anotacaoModel);
        
        if(is_bool($resultado)){
            
            return $this->dao->alterarAnotacaoAula($anotacaoModel);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function buscarTodasAnotacoesDasAulasPorIdDoContrato(int $id) 
    {
        return $this->dao->buscarTodasAnotacoesDasAulasPorIdDoContrato($id);
    }

}
