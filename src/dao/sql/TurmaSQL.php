<?php

namespace Src\dao\sql;

class TurmaSQL
{
    public static function inserirTurma()
    {
        $sql = "INSERT INTO tb_turmas 
                                    (nome_turma,
                                    id_colaborador,
                                    id_user_logado,
                                    data_registro) 
                            VALUES (?, ?, ?, ?)";

        return $sql;
    }
    
    public static function alterarTurma() 
    {
        $sql = "UPDATE tb_turmas
                    SET
                        nome_turma     = ?,
                        id_colaborador = ?
                WHERE   id_turma       = ?";
        
        return $sql;
        
    }
    
    public static function excluirTurma() 
    {
        $sql = "DELETE FROM tb_turmas turma 
                    WHERE turma.id_turma = ? 
                    AND turma.id_turma NOT IN (SELECT id_turma FROM tb_contrato_curso cc WHERE cc.id_turma = turma.id_turma);";
        
        return $sql;
        
    }

    public static function buscarTodasTurmas()
    {
        $sql = "SELECT 
                        tur.id_turma,
                        tur.nome_turma,
                        col.id_colaborador,
                        pes.nome,
                        pes.sobrenome
                FROM tb_turmas tur
                    INNER JOIN tb_colaboradores col
                        ON col.id_colaborador = tur.id_colaborador
                    INNER JOIN tb_pessoas pes
                        ON pes.id_pessoa = col.id_colaborador
                ORDER BY tur.nome_turma";

        return $sql;
    }
}
