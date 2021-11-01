<?php

namespace Src\controllers;

use Src\models\CadastroBasicoModel;
use Src\dao\CadastroBasicoDao;
use Src\traits\UtilCTRL;
use Src\input\Input;
use Src\validate\ValidarCampos;
use Src\erro\Erro;

class CadastroBasicoController
{

    private CadastroBasicoDao $dao;

    public function __construct()
    {
        $this->dao = new CadastroBasicoDao();
    }

    public function inserirCadastroBasico(int $tipoCadastro)
    {       
        $cadBasicoModel = new CadastroBasicoModel($tipoCadastro);
        
        if(ValidarCampos::validarCamposCadastroBasico($cadBasicoModel, false))
        {
            return $this->dao->inserirCadastroBasico($cadBasicoModel);
            
        }else if (is_numeric(ValidarCampos::validarCamposCadastroBasico($cadBasicoModel, false))){
            
            return ValidarCampos::validarCamposCadastroBasico($cadBasicoModel, false);
        }
        
    }

    public function alterarCadastroBasico(int $tipoCadastro)
    {

        $cadBasicoModel = new CadastroBasicoModel($tipoCadastro);
        
        if(ValidarCampos::validarCamposCadastroBasico($cadBasicoModel)){
            
            return $this->dao->alterarCadastroBasico($cadBasicoModel);
            
        }else if (is_numeric(ValidarCampos::validarCamposCadastroBasico($cadBasicoModel, false))){
            
            return ValidarCampos::validarCamposCadastroBasico($cadBasicoModel);
        }

    }
    
    
    public function excluirCadastroBasico()
    {
        if (Input::post("id-cadastro-basico-excluir", FILTER_SANITIZE_NUMBER_INT) !== null) {

            $id = Input::post("id-cadastro-basico-excluir", FILTER_SANITIZE_NUMBER_INT);
            
            return $this->dao->excluirCadastroBasico($id);
            
        } else {
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id para realizar a exclusão");
            
            return -1;
        }
    }

    public function buscarTodosCadastrosBasicos(int $tipoCadastro)
    {
        return $this->dao->buscarTodosCadastrosBasicos($tipoCadastro);
    }

    public function buscarUmCadastroBasico(int $id)
    {
        return $this->dao->buscarUmCadastroBasico($id);
    }

    
}
