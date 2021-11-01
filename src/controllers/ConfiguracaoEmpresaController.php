<?php


namespace Src\controllers;

use Src\dao\ConfiguracaoEmpresaDao;
use Src\models\ConfiguracaoEmpresaModel;
use Src\validate\ValidarCampos;

class ConfiguracaoEmpresaController 
{
    private ConfiguracaoEmpresaDao $dao;
    
    public function __construct() 
    {
        $this->dao = new ConfiguracaoEmpresaDao();
    }
    
    public function alterarDadosConfiguracaoEmpresa() 
    {
        $configEmpresaModel = new ConfiguracaoEmpresaModel();
        
        $resultado = ValidarCampos::validarCamposConfiguracaoEmpresa($configEmpresaModel);
        
        if(is_bool($resultado)){
            
            return $this->dao->alterarDadosConfiguracaoEmpresa($configEmpresaModel);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function buscarTodosDadosConfiguracaoEmpresa() 
    {
        return $this->dao->buscarTodosDadosConfiguracaoEmpresa();
    }
}
