<?php


namespace Src\dao\sql;


class LoginSQL 
{
    public static function validarLogin() 
    {
        $sql = "SELECT col.id_colaborador,
                       col.tipo_acesso,
                       col.login,
                       col.senha,
                       pes.nome,
                       pes.sobrenome
                    FROM tb_colaboradores col
                        INNER JOIN tb_pessoas pes
                            ON col.id_colaborador = pes.id_pessoa
                WHERE login    = ? 
                AND   situacao = ?";
        
        return $sql;
    }
}
