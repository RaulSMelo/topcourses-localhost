<?php


namespace Src\dao\sql;

class PautaAlunoSQL 
{
    public static function inserirAnotacoesProfessor() 
    {
        $sql =  "INSERT INTO tb_pauta_alunos
                            (
                                id_aluno,
                                id_contrato_curso,
                                anotacoes_professor,
                                id_agendamento
                            )
                    VALUES (?, ?, ?, ?)";
        
        return $sql;
    }
    
    public static function alterarAnotacoesProfessor() 
    {
        $sql =  "UPDATE tb_pauta_alunos
                        SET        
                            id_aluno            = ?,
                            id_contrato_curso   = ?,
                            anotacoes_professor = ?,
                            id_agendamento      = ?       
                    WHERE id_pauta_aluno        = ?";
        
        return $sql;
    }
    
    public static function buscarAnotacoesProfessorPorId() 
    {
        $sql =  "SELECT  
                        id_pauta_aluno,
                        id_aluno,
                        id_contrato_curso,
                        anotacoes_professor,
                        id_agendamento
                    FROM tb_pauta_alunos
                WHERE id_contrato_curso = ?";
        
        return $sql;
    }
}
