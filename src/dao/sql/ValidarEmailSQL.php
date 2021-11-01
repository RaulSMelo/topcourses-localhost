<?php


namespace Src\dao\sql;

class ValidarEmailSQL 
{
        
    public static function validarEmail(string $tabela , int $id)
    {
        $sql = "SELECT COUNT(*) cont_email FROM {$tabela} WHERE email = ?";
        
        if($id != 0){
            
            if($tabela == "tb_pessoas"){
                
                $sql .= " AND id_pessoa != ?";
                
            }else if($tabela == "tb_empresas"){
                
                 $sql .= " AND id_empresa != ?";
            }
        }

        return $sql;
    }
}
