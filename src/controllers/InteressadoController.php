<?php

namespace Src\controllers;

use Src\input\Input;
use Src\dao\InteressadoDao;
use Src\models\InteressadoModel;
use Src\validate\ValidarCampos;
use Src\erro\Erro;
use Src\traits\UtilCTRL;

class InteressadoController
{
    private InteressadoDao $dao;
    private InteressadoModel $interessado;

    public function __construct()
    {
        $this->dao         = new InteressadoDao();
        $this->interessado = new InteressadoModel();
    }

    
    public function inserirInteressado()
    {
        
        $camposInteressadosEvalido = ValidarCampos::validarCamposInteressados($this->interessado, false);
        
        if (!is_numeric($camposInteressadosEvalido)) {

            return $this->dao->inserirInteressado($this->interessado);
            
        } else {
            
            return $camposInteressadosEvalido;
        }
    }
    
    public function alterarInteressado()
    {
        
        $camposInteressadosEvalido = ValidarCampos::validarCamposInteressados($this->interessado);

        if (!is_numeric($camposInteressadosEvalido)) {
           
            return $this->dao->alterarInteressado($this->interessado);
            
        } else {
            
            return $camposInteressadosEvalido;
        }
    }
    
    public function excluirInteressado(int $id)
    {
        return $this->dao->excluirInteressado($id);   
    }

    public function filtrarBuscaInteressados($data_inicio, $data_final, $nome, $sobrenome, $id_curso, $id_traducao, $id_revisao)
    {
        
        $resultado = ValidarCampos::validarCamposFiltrosConsultaInteressado($data_inicio, $data_final);
        
        if(is_bool($resultado)){

            return $this->dao->filtarBuscarInteressados($data_inicio, $data_final, $nome, $sobrenome, $id_curso, $id_traducao, $id_revisao);
             
        }else {

            return $resultado;
            
        }    
    }
 
    
    public function buscarInteressadoPorId(int $id)
    {
        return $this->dao->buscarInteressadoPorId($id);
    }
    
    public function filtrarInteressadosPorNomeEsituacaoContrato($nome, $situacao, $pauta = false) 
    {
        if(!empty(trim($nome))){
            
            $nomeCompleto = UtilCTRL::retornaNomeEsobrenome($nome);
            
            $nome      = $nomeCompleto["nome"];
            $sobrenome = $nomeCompleto["sobrenome"] ?? "";
            
            return $this->dao->filtrarInteressadosPorNomeEsituacaoContrato($nome, $sobrenome, $situacao, $pauta);
            
        }else{
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO. ". Campo nome não pode ser vazio");
            
            return 0;
        }
        
    }
    
    public function buscarInteressadoPorNome($nome) 
    {
        if($nome != null && trim($nome) != ""){
            
            $nomeCompleto = UtilCTRL::retornaNomeEsobrenome($nome);
            
            $nome = $nomeCompleto["nome"];
            $sobrenome = $nomeCompleto["sobrenome"] ?? "";
            
            return $this->dao->buscarInteressadoPorNome($nome, $sobrenome);
            
        }
    }
    
    public static function buscaDataDaAulaAgendadaPorIdInteressado($id) 
    {
        return $this->dao->buscaDataDaAulaAgendadaPorIdInteressado($id);
    }
       
}

