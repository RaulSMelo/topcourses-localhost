<?php

namespace Src\dao\sql;

class EmpresaSQL 
{
    
    public static function inserirEmpresa() 
    {
        $sql = "INSERT INTO tb_empresas
                                    (razao_social, 
                                     cnpj, 
                                     email, 
                                     telefone, 
                                     telefone_opcional,
                                     nome_fantasia,
                                     id_user_logado,
                                     data_registro) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
        return $sql;

    }
    
    public static function alterarEmpresa() 
    {
        $sql = "UPDATE tb_empresas
                    SET 
                        razao_social      = ?,
                        cnpj              = ?,
                        email             = ?,   
                        telefone          = ?,
                        telefone_opcional = ?,
                        nome_fantasia     = ?
                WHERE   id_empresa        = ?";
        
        return $sql;        
    }
    
    public static function excluirEmpresa() 
    {
        $sql = "DELETE FROM tb_empresas 
                       WHERE id_empresa 
                       NOT IN (SELECT id_empresa FROM tb_contrato_curso)  
                       AND id_empresa = ?";
        
        return $sql;
    }
    
    public static function retornaSeEmpresaPossuiVinculoComContratoCurso() 
    {
        $sql = "SELECT COUNT(id_empresa) AS qtde_id_empresa_nos_contrato_curso FROM tb_contrato_curso curso WHERE curso.id_empresa = ?";
        
        return $sql;
    }

    

    public static function buscarEmpresaPorRazaoSocialOuNomeFantasia() 
    {
        $sql = "SELECT 
                      id_empresa,
                      razao_social,
                      nome_fantasia,
                      email,
                      telefone
                FROM  tb_empresas
                WHERE razao_social LIKE ? OR nome_fantasia LIKE ?
                ORDER BY razao_social";
        
        return $sql;
    }
    
    public static function buscarEmpresaPorId() 
    {
        $sql = "SELECT
                      emp.id_empresa,
                      emp.razao_social,
                      emp.cnpj,
                      emp.nome_fantasia,
                      emp.email,
                      emp.telefone,
                      emp.telefone_opcional,
                      emp.nome_fantasia,
                      end.id_endereco,
                      end.cep,
                      end.rua,
                      end.numero,
                      end.complemento,
                      end.bairro,
                      end.cidade,
                      end.uf
                FROM tb_empresas emp
                    INNER JOIN tb_enderecos end
                        ON end.id_empresa = emp.id_empresa
                WHERE emp.id_empresa = ?";
        
        return $sql;
    }
    
    public static function buscarTodasEmpresasParaPreencherCombo() 
    {
        $sql = "SELECT
                      id_empresa,
                      razao_social
                FROM  tb_empresas 
                    ORDER BY razao_social";
        
        return $sql;
    }
}
