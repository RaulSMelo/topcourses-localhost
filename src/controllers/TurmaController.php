<?php

namespace Src\controllers;

use Src\dao\TurmaDao;
use Src\models\TurmaModel;
use Src\validate\ValidarCampos;

class TurmaController
{

    private TurmaModel $turma;
    private TurmaDao $dao;

    public function __construct()
    {
        $this->turma = new TurmaModel();
        $this->dao   = new TurmaDao();
    }

    public function inserirTurma()
    {
        $resultado = ValidarCampos::validarCamposTurma($this->turma, false);

        if (is_bool($resultado)) {

            return $this->dao->inserirTurma($this->turma);
            
        } else if (is_numeric($resultado)) {

            return $resultado;
        }
    }
    
    public function alterarTurma() 
    {
        $resultado = ValidarCampos::validarCamposTurma($this->turma);
        
        if(is_bool($resultado)){
           
            return $this->dao->alterarTurma($this->turma);
            
        }else if(is_numeric($resultado)){
            
            return $resultado;
            
        }
        
    }
    
    public function excluirTurma(int $id) 
    {
       return $this->dao->excluirTurma($id);
    }

    public function buscarTodasTurmas()
    {
        return $this->dao->buscarTodasTurmas();
    }
}
