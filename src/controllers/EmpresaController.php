<?php


namespace Src\controllers;

use Src\dao\EmpresaDao;
use Src\models\EmpresaModel;
use Src\validate\ValidarCampos;

class EmpresaController 
{
    private EmpresaDao $dao;
    private EmpresaModel $empresa;
    
    public function __construct() 
    {
        $this->dao = new EmpresaDao();
        $this->empresa = new EmpresaModel();
    }
    
    public function inserirEmpresa() 
    {
        $resultadoValidarEmpresa = ValidarCampos::validarCamposEmpresa($this->empresa, false);
        
        if(is_bool($resultadoValidarEmpresa)){
           
            return $this->dao->inserirEmpresa($this->empresa);
            
        }else if(is_numeric($resultadoValidarEmpresa)){
            
            return $resultadoValidarEmpresa;
        }
    }
    
    public function alterarEmpresa() 
    {
        $resultadoValidarEmpresa = ValidarCampos::validarCamposEmpresa($this->empresa);
        
        if(is_bool($resultadoValidarEmpresa)){
            
            return $this->dao->alterarEmpresa($this->empresa);
            
        }else if(is_numeric($resultadoValidarEmpresa)){
            
            return $resultadoValidarEmpresa;
            
        }
        
    }
    
    public function excluirEmpresa(int $id) 
    {
        return $this->dao->excluirEmpresa($id);
    }
    
    public function buscarEmpresaPorRazaoScialOuPorNomeFantasia(string $nome) 
    {
        return $this->dao->buscarEmpresaPorRazaoSocialOuPorNomeFantasia($nome);
    }
    
    public function buscarEmpresaPorId(int $id) 
    {
        return $this->dao->buscarEmpresasPorId($id);
    }
    
    public function buscarTodasEmpresasParaPreencherCombo() 
    {
        return $this->dao->buscarTodasEmpresasParaPreencherCombo();
    }
}
