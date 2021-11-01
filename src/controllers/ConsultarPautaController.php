<?php

namespace Src\controllers;

use Src\input\Input;
use Src\dao\ConsultarPautaDao;

class ConsultarPautaController 
{
    public function buscarPautas($nome, $sobrenome, $situacao) {
        
        $dao = new ConsultarPautaDao();
        
        return $dao->buscarPautas($nome, $sobrenome, $situacao);
    }
}
