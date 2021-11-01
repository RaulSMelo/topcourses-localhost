<?php

namespace Src\dao\sql;

class PessoaSQL
{
    public static function inserirPessoa()
    {
        $sql = "INSERT INTO tb_pessoas 
                            (nome, 
                             sobrenome, 
                             email, 
                             telefone, 
                             cpf,
                             data_registro) 
                VALUES (?, ?, ?, ?, ?, ?)";

        return $sql;
    }

    public static function alterarPessoa()
    {
        $sql = "UPDATE tb_pessoas 
                    SET 
                        nome          = ?, 
                        sobrenome     = ?,
                        email         = ?,
                        telefone      = ?, 
                        cpf           = ? 
                WHERE id_pessoa       = ?";

        return $sql;
    }

    public static function excluirPessoa()
    {
        $sql = "DELETE FROM tb_pessoas WHERE id_pessoa = ?";

        return $sql;
    }
}