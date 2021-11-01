<?php


namespace Src\controllers;

use Src\dao\ValidarEmailDao;

class ValidarEmailController 
{
    private ValidarEmailDao $dao;
    private $email_e_valido;
    
    public function __construct(string $email, string $tabela, int $id) 
    {
        $this->dao = new ValidarEmailDao();
        $this->email_e_valido = $this->validarEmail($email, $tabela, $id);
        
    }
    
    private function validarEmail(string $email, string $tabela, int $id) 
    {
        return $this->dao->validarEmail($email, $tabela, $id);
        
    }
    
    public function getEmail_e_valido() 
    {
        return $this->email_e_valido;
    }


}
