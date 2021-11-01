<?php

namespace Src\dao\sql;

class CadastroBasicoSQL {
    
    public static function inserirCadastroBasico ()
    {
        $sql = "INSERT INTO tb_cadastro_basico 
                    (tipo_cadastro, data_registro, nome_cadastro, id_user_logado)
                    VALUES (?, ?, ?, ?)";
        
        return $sql;
    }
    
    public static function alterarCadastroBasico() 
    {
        $sql = "UPDATE tb_cadastro_basico SET nome_cadastro = ? WHERE id_cadastro_basico = ?";
        
        return $sql;
    }
    
    public static function buscarCadastroBasico()
    {
        $sql = "SELECT id_cadastro_basico, nome_cadastro 
                    FROM tb_cadastro_basico 
                WHERE tipo_cadastro = ? ORDER BY nome_cadastro";
     
        return $sql;
    }
    
    public static function buscarCadastroBasicoPorId()
    {
        $sql = "SELECT id_cadastro_basico, nome_cadastro 
                    FROM tb_cadastro_basico 
                WHERE id_cadastro_basico = ?";
     
        return $sql;
    }
    
    public static function excluirCadastroBasico()
    {
        $sql = "DELETE FROM tb_cadastro_basico WHERE id_cadastro_basico = ?";
        
        return $sql;
    }
    
}
