<?php


namespace Src\controllers;

use Src\validate\ValidarCampos;
use Src\dao\RelatorioContratoDao;

class RelatorioContratoController 
{
    public function buscarRelatoriosContratos($filtros, $group_by = true) 
    {
        $dao = new RelatorioContratoDao();
        
        $dataInicio   = $filtros["data-inicio"];
        $dataFinal    = $filtros["data-final"];
        $nome         = $filtros["nome"];
        $sobrenome    = $filtros["sobrenome"];
        $tipoContrato = $filtros["tipo-contrato"];
        $situacao     = $filtros["situacao"];
        
        $resultado = ValidarCampos::validarCamposRelatoriosContratos($dataInicio, $dataFinal);
        
        if(is_bool($resultado)){
            
            return $dao->buscarRelatoriosContratos($dataInicio, $dataFinal, $nome, $sobrenome, $tipoContrato, $situacao, $group_by);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
    
    public function somaDosValoresDosContratos($filtros) 
    {
        $dao = new RelatorioContratoDao();
        
        $dataInicio   = $filtros["data-inicio"];
        $dataFinal    = $filtros["data-final"];
        $nome         = $filtros["nome"];
        $sobrenome    = $filtros["sobrenome"];
        $tipoContrato = $filtros["tipo-contrato"];
        $situacao     = $filtros["situacao"];
        
        $resultado = ValidarCampos::validarCamposRelatoriosContratos($dataInicio, $dataFinal);
        
        if(is_bool($resultado)){
            
            return $dao->somaDosValoresDosContratos($dataInicio, $dataFinal, $nome, $sobrenome, $tipoContrato, $situacao);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
        }
    }
}
