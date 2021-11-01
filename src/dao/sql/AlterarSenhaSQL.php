<?php


namespace Src\dao\sql;


class AlterarSenhaSQL 
{
    public static function buscarSenhaAtual() 
    {
        $sql = "SELECT senha FROM tb_colaboradores WHERE id_colaborador = ?";
        
        return $sql;
    }
    
    public static function alterarSenha() 
    {
        $sql = "UPDATE tb_colaboradores SET senha = ? WHERE id_colaborador = ?";
        
        return $sql;
    }
    
    
}
