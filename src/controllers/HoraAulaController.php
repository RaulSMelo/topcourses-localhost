<?php


namespace Src\controllers;

use Src\models\HoraAulaModel;
use Src\dao\HoraAulaDao;
use Src\validate\ValidarCampos;

class HoraAulaController 
{
    private HoraAulaModel $horaAula;
    private HoraAulaDao   $dao;
    
    public function __construct() 
    {
        $this->dao      = new HoraAulaDao();
        $this->horaAula = new HoraAulaModel();
    }
    
    public function inserirHoraAula() 
    {
        
        $resultado = ValidarCampos::validarCamposHoraAula($this->horaAula, false);
        
        if(is_bool($resultado)){
            
            return $this->dao->inserirHoraAula($this->horaAula);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function alterarHoraAula() 
    {
        
        $resultado = ValidarCampos::validarCamposHoraAula($this->horaAula);
        
        if(is_bool($resultado)){
            
            return $this->dao->alterarHoraAula($this->horaAula);
            
        }else if (is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function excluirHoraAula(int $id) 
    {
        return $this->dao->excluirHoraAula($id);
    }
    
    public function buscarTodasHorasAulas() 
    {
        return $this->dao->buscarTodasHorasAulas();
    }
    
    public function buscarValorHoraAulaPorIdIdioma(int $id) 
    {
        return $this->dao->buscarValorHoraAulaPorIdIdioma($id);
    }

}
