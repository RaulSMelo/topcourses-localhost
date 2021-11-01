<?php

namespace Src\dao\sql;

class EnderecoSQL
{
    public static function inserirEndereco()
    {
        

        $sql = "INSERT INTO tb_enderecos
                    (cep, 
                     rua, 
                     numero, 
                     complemento, 
                     bairro,
                     cidade, 
                     uf,
                     id_colaborador,
                     id_empresa,
                     id_interessado,
                     id_user_logado,
                     data_registro)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        return $sql;
        
    }

    public static function alterarEndereco()
    {
        $sql = "UPDATE tb_enderecos
                    SET 
                        cep            = ?, 
                        rua            = ?, 
                        numero         = ?, 
                        complemento    = ?, 
                        bairro         = ?,
                        cidade         = ?, 
                        uf             = ?
                    WHERE id_endereco  = ?";

        return $sql;
    }

    public static function excluirEndereco(int $tipoEndereco)
    {
        if ($tipoEndereco == INTERESSADO) {
            return "DELETE FROM tb_enderecos WHERE id_interessado = ?";
        } else if ($tipoEndereco == EMPRESA) {
            return "DELETE FROM tb_enderecos WHERE id_empresa = ?";
        } else if ($tipoEndereco == COLABORADOR) {
            return "DELETE FROM tb_enderecos WHERE id_colaborador = ?";
        }
    }
    
    public static function verificarSeExisteEnderecoCadastrado(int $tipoEndereco)
    {
         if ($tipoEndereco == INTERESSADO) {
            return "SELECT id_endereco FROM tb_enderecos WHERE id_interessado = ?";
        } else if ($tipoEndereco == EMPRESA) {
            return "SELECT id_endereco FROM tb_enderecos WHERE id_empresa = ?";
        } else if ($tipoEndereco == COLABORADOR) {
            return "SELECT id_endereco FROM tb_enderecos WHERE id_colaborador = ?";
        }
    }

}
