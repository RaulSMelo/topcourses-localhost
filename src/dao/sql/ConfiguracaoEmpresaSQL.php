<?php


namespace Src\dao\sql;


class ConfiguracaoEmpresaSQL 
{
    
    public static function alterarDadosConfiguracaoEmpresa() 
    {
        $sql = "UPDATE tb_configuracao_empresa
                    SET 
                        razao_social      = ?,
                        cnpj              = ?,
                        email             = ?,
                        telefone          = ?,
                        cep               = ?,
                        rua               = ?,
                        numero            = ?,
                        complemento       = ?,
                        bairro            = ?,
                        cidade            = ?,
                        estado            = ?,
                        uf                = ?,
                        nome_fantasia     = ?,
                        id_usuario_logado = ?,
                        data_registro     = ?
                WHERE   id_empresa        = ?";
        
        return $sql;
    }
    
    public static function buscarTodosDadosConfiguracaoEmpresa() 
    {
        $sql = "SELECT
                    id_empresa,
                    razao_social,
                    cnpj,
                    email,
                    telefone,
                    cep,
                    rua,
                    numero,
                    complemento,
                    bairro,
                    cidade,
                    estado,
                    uf,
                    nome_fantasia
                FROM tb_configuracao_empresa";
        
        return $sql;
    }
}
