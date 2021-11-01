<?php

namespace Src\dao\sql;


class ColaboradorSQL
{
    public static function inserirColaborador()
    {
        $sql = "INSERT INTO tb_colaboradores
                    (id_colaborador, 
                     tipo_acesso, 
                     telefone_opcional, 
                     login, 
                     senha, 
                     id_user_logado,
                     situacao) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        return $sql;
    }

    public static function inserir_TipoColaborador_e_colaborador()
    {
        $sql = "INSERT INTO tb_tipo_colaborador_e_tb_colaboradores 
                    (id_colaborador, id_tipo_colaborador) 
                VALUES (?, ?)";

        return $sql;
    }

    public static function alterarColaborador()
    {
        $sql = "UPDATE tb_colaboradores
                    SET tipo_acesso       = ?,
                        telefone_opcional = ? 
                    WHERE situacao = ? AND id_colaborador  = ?";
        return $sql;
    }

    public static function excluir_tipoColaborador_e_Colaborador()
    {
        $sql =   "DELETE FROM tb_tipo_colaborador_e_tb_colaboradores
                    WHERE id_colaborador = ?";

        return $sql;
    }



    public static function excluirColaborador()
    {
        $sql = "UPDATE tb_colaboradores SET situacao = ? WHERE id_colaborador = ?";

        return $sql;
    }



    public static function buscarTiposDeColaboradores()
    {
        $sql = "SELECT id_tipo_colaborador, nome_tipo FROM tb_tipo_colaborador ORDER BY nome_tipo";

        return $sql;
    }

    public static function buscarColaboradorPorId()
    {

        $sql = "SELECT  col.id_colaborador,
                        pes.nome,
                        pes.sobrenome,
                        pes.email,
                        pes.telefone,
                        pes.cpf,
                        col.tipo_acesso,
                        col.telefone_opcional,
                        end.id_endereco,
                        end.cep,
                        end.rua,
                        end.numero,
                        end.complemento,
                        end.bairro,
                        end.cidade,
                        end.uf
                FROM tb_colaboradores col
                    INNER JOIN tb_pessoas pes 
                        ON pes.id_pessoa = col.id_colaborador
                    LEFT JOIN tb_enderecos end
                        ON end.id_colaborador = col.id_colaborador
            WHERE col.situacao = ? AND col.id_colaborador = ?";

        return $sql;
    }

    public static function buscarColaboradorPorTipo()
    {
        $sql = "SELECT  tec.id_colaborador,
                        tec.id_tipo_colaborador,
                        pes.nome,
                        pes.sobrenome
                FROM tb_tipo_colaborador_e_tb_colaboradores tec
                    INNER JOIN tb_colaboradores col
                        ON col.id_colaborador = tec.id_colaborador
                    INNER JOIN tb_tipo_colaborador tipo
                        ON tipo.id_tipo_colaborador = tec.id_tipo_colaborador
                    INNER JOIN tb_pessoas pes
                        ON pes.id_pessoa = col.id_colaborador
                WHERE col.situacao = ? AND tipo.tipo_colaborador = ?";

        return $sql;
    }



    public static function buscarColaboradorPorNome($nome, $sobrenome, bool $group_by)
    {
        $sql = "SELECT 
                        tipo_col.id_colaborador, 
                        tipo_col.id_tipo_colaborador,
                        pes.nome,
                        pes.sobrenome,
                        pes.email,
                        pes.telefone,
                        (select tipo.nome_tipo WHERE tipo_col.id_tipo_colaborador = tipo.id_tipo_colaborador) as nome_tipo_colaborador
                FROM tb_tipo_colaborador_e_tb_colaboradores tipo_col
                        INNER JOIN tb_colaboradores col
                                ON col.id_colaborador = tipo_col.id_colaborador
                        INNER JOIN tb_pessoas pes
                                ON pes.id_pessoa = col.id_colaborador
                        INNER JOIN tb_tipo_colaborador tipo
                                ON tipo.id_tipo_colaborador = tipo_col.id_tipo_colaborador                       
                WHERE col.situacao = ? AND tipo_col.id_colaborador > 0";
        
        
        if(!empty($nome) && !empty($sobrenome)){
            
            $sql .= " AND (pes.nome LIKE ? OR pes.sobrenome LIKE ?)";
            
        }else if(!empty($nome)){
            
            $sql .= " AND pes.nome LIKE ?";
        }
        
        if ($group_by) {

            $sql .= " GROUP BY tipo_col.id_colaborador ORDER BY pes.nome";
        }

        return $sql;
    }

    public static function buscaridItiposColaboradores()
    {
        $sql = "SELECT tipo_col.id_tipo_colaborador
                    FROM tb_tipo_colaborador_e_tb_colaboradores tipo_col
                        INNER JOIN tb_colaboradores col
                            ON col.id_colaborador = tipo_col.id_colaborador
                WHERE col.situacao = ? AND tipo_col.id_colaborador = ?";

        return $sql;
    }

    public static function buscarNomeTipoColaboradorPorId()
    {
        $sql = "SELECT 
                    tipo.nome_tipo
                    FROM tb_tipo_colaborador_e_tb_colaboradores tipo_col
                        INNER JOIN tb_tipo_colaborador tipo
                            ON tipo.id_tipo_colaborador = tipo_col.id_tipo_colaborador
                        INNER JOIN tb_colaboradores col
                            ON col.id_colaborador = tipo_col.id_colaborador
                WHERE col.situacao = ? AND tipo_col.id_colaborador = ?";

        return $sql;
    }
    
    public static function buscarDadosLogin()
    {
        $sql = "SELECT login, senha, FROM tb_colaboradores WHERE login = ? AND senha = ?";

        return $sql;
    }
    
    
}
