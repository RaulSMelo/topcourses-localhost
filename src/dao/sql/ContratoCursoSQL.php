<?php

namespace Src\dao\sql;

class ContratoCursoSQL {

    public static function inserirContratoCurso() {
        $sql = "INSERT INTO tb_contrato_curso
                            (
                             id_tipo_contrato,
                             id_curso,
                             id_idioma,
                             valor_hora_aula,
                             total_horas,
                             valor_entrada,
                             qtde_parcelas,
                             valor_parcela,
                             desconto,
                             valor_total,
                             dia_vencimento_parcela,
                             data_inicio_contrato,
                             data_termino_contrato,
                             numero_meses_por_ano,
                             local_das_aulas,
                             carga_horaria_semanal,
                             id_professor,
                             id_nivel,
                             id_turma,
                             material,
                             programa,
                             marcacao_geral,
                             id_empresa,
                             id_user_logado,
                             data_registro,
                             situacao
                            )
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        return $sql;
    }
    
    public static function alterarContratoCurso() 
    {
        $sql = "UPDATE tb_contrato_curso
                    SET
                        id_professor    = ?,
                        id_nivel        = ?,
                        id_turma        = ?,
                        material        = ?,
                        programa        = ?,
                        marcacao_geral  = ?, 
                        situacao        = ? 
                WHERE id_contrato_curso = ?";
        
        return $sql;
        
    }

    public static function inserirTbInteressadoEtbcontratoCurso() {
        $sql = "INSERT INTO tb_interessados_e_tb_contrato_curso
                        (
                           id_interessado, 
                           id_contrato_curso
                        )
                    VALUES (?, ?)";

        return $sql;
    }

    public static function buscarTodosOsDados_ContratoPF_PorID() {
        $sql = "SELECT
                        tb_inter.id_interessado,
                        tb_inter.data_nascimento,
                        tb_curso.id_contrato_curso,
                        pes.nome,
                        pes.sobrenome,
                        pes.email,
                        pes.telefone,
                        pes.cpf,
                        tb_end.cep,
                        tb_end.rua,
                        tb_end.numero,
                        tb_end.complemento,
                        tb_end.bairro,
                        tb_end.cidade,
                        tb_end.uf,
                        (SELECT nome_cadastro FROM tb_cadastro_basico WHERE id_cadastro_basico = tb_curso.id_curso) curso,
                        (SELECT nome_cadastro FROM tb_cadastro_basico WHERE id_cadastro_basico = tb_curso.id_idioma) idioma,
                        (SELECT nome_cadastro FROM tb_cadastro_basico WHERE id_cadastro_basico = tb_curso.id_nivel) nivel,
                        (SELECT nome FROM tb_pessoas WHERE id_pessoa = tb_curso.id_professor) prof_nome,
                        (SELECT sobrenome FROM tb_pessoas WHERE id_pessoa = tb_curso.id_professor) prof_sobrenome,
                        (SELECT COUNT(data_dia_semana) FROM tb_agendamento WHERE id_contrato_curso = ?) dias_agendados,
                        tb_curso.valor_hora_aula,
                        tb_curso.total_horas,
                        tb_curso.valor_entrada,
                        tb_curso.qtde_parcelas,
                        tb_curso.valor_parcela,
                        tb_curso.desconto,
                        tb_curso.valor_total,
                        tb_curso.dia_vencimento_parcela,
                        tb_curso.data_inicio_contrato,
                        tb_curso.data_termino_contrato,
                        tb_curso.numero_meses_por_ano,
                        tb_curso.local_das_aulas,
                        tb_curso.carga_horaria_semanal,
                        tb_curso.id_professor,
                        tb_curso.id_nivel,
                        tb_curso.id_turma,
                        tb_curso.material,
                        tb_curso.programa,
                        tb_curso.marcacao_geral,
                        tb_curso.data_registro,
                        tb_curso.situacao
                FROM tb_interessados tb_inter
                        INNER JOIN tb_pessoas pes
                                ON pes.id_pessoa = tb_inter.id_interessado
                        LEFT JOIN tb_enderecos tb_end
                                ON tb_end.id_interessado = tb_inter.id_interessado
                        INNER JOIN tb_interessados_e_tb_contrato_curso tb_int_e_cc
                                ON tb_inter.id_interessado = tb_int_e_cc.id_interessado
                        INNER JOIN tb_contrato_curso tb_curso
                                ON tb_int_e_cc.id_contrato_curso = tb_curso.id_contrato_curso
                WHERE tb_curso.id_contrato_curso = ? ORDER BY pes.nome";

        return $sql;
    }

    public static function buscarTodosOsDados_ContratoPJ_PorID() {
        $sql = "SELECT
                        tb_inter.id_interessado,
                        tb_inter.data_nascimento,
                        tb_curso.id_contrato_curso,
                        tb_emp.id_empresa,
                        tb_emp.razao_social,
                        tb_emp.cnpj,
                        tb_emp.email email_empresa,
                        tb_emp.telefone tel_empresa,
                        tb_emp.telefone_opcional,
                        tb_emp.nome_fantasia,
                        pes.nome,
                        pes.sobrenome,
                        pes.email,
                        pes.telefone,
                        pes.cpf,
                        end.cep,
                        end.rua,
                        end.numero,
                        end.complemento,
                        end.bairro,
                        end.cidade,
                        end.uf,
                        (SELECT nome_cadastro FROM tb_cadastro_basico WHERE id_cadastro_basico = tb_curso.id_curso) curso,
                        (SELECT nome_cadastro FROM tb_cadastro_basico WHERE id_cadastro_basico = tb_curso.id_idioma) idioma,
                        (SELECT nome_cadastro FROM tb_cadastro_basico WHERE id_cadastro_basico = tb_curso.id_nivel) nivel,
                        (SELECT nome FROM tb_pessoas WHERE id_pessoa = tb_curso.id_professor) prof_nome,
                        (SELECT sobrenome FROM tb_pessoas WHERE id_pessoa = tb_curso.id_professor) prof_sobrenome,
                        tb_curso.valor_hora_aula,
                        tb_curso.total_horas,
                        tb_curso.valor_entrada,
                        tb_curso.qtde_parcelas,
                        tb_curso.valor_parcela,
                        tb_curso.desconto,
                        tb_curso.valor_total,
                        tb_curso.dia_vencimento_parcela,
                        tb_curso.data_inicio_contrato,
                        tb_curso.data_termino_contrato,
                        tb_curso.numero_meses_por_ano,
                        tb_curso.local_das_aulas,
                        tb_curso.carga_horaria_semanal,
                        tb_curso.id_professor,
                        tb_curso.id_nivel,
                        tb_curso.id_turma,
                        tb_curso.material,
                        tb_curso.programa,
                        tb_curso.marcacao_geral,
                        tb_curso.data_registro,
                        tb_curso.situacao,
                        (SELECT COUNT(id_contrato_curso) FROM tb_interessados_e_tb_contrato_curso WHERE id_contrato_curso = ? ) total_alunos,
                        (SELECT COUNT(data_dia_semana) FROM tb_agendamento WHERE id_contrato_curso = ? ) dias_agendados
                    FROM tb_empresas tb_emp
                        LEFT JOIN tb_enderecos end
                            ON end.id_empresa = tb_emp.id_empresa
                        INNER JOIN tb_contrato_curso tb_curso
                            ON tb_curso.id_empresa = tb_emp.id_empresa
                        INNER JOIN tb_interessados_e_tb_contrato_curso tb_int_e_cc
                            ON tb_int_e_cc.id_contrato_curso = tb_curso.id_contrato_curso
                        INNER JOIN tb_interessados tb_inter
                            ON tb_inter.id_interessado = tb_int_e_cc.id_interessado
                        INNER JOIN tb_pessoas pes
                            ON pes.id_pessoa = tb_inter.id_interessado
                WHERE tb_curso.id_contrato_curso = ? ORDER BY pes.nome";

        return $sql;
    }

}
