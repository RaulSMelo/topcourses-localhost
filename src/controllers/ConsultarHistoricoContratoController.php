<?php

namespace Src\controllers;

use Src\dao\ConsultarHistoricoContratoDao;

class ConsultarHistoricoContratoController
{
    private ConsultarHistoricoContratoDao $dao;
    
    public function __construct() 
    {
        $this->dao = new ConsultarHistoricoContratoDao();
    }
    
    public function consultarHistoricoContrato(int $id) 
    {
        return $this->dao->consultarHistoricoContrato($id);
    }

}
