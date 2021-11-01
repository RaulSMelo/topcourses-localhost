<?php


namespace Src\dao\sql;


class AgendamentoSQL
{
    public static function inserirAgendamentoContratoCurso() 
    {
        $sql = "INSERT INTO tb_agendamento
                    (
                     dia_da_semana,
                     data_dia_semana,
                     hora_inicial,
                     hora_final,
                     id_contrato_curso
                    ) 
                VALUES(?, ?, ?, ?, ?)";
        
        return $sql;
    }
    
    public static function excluirAgendamentoContratoCursoSemAnotacoes() 
    {
        $sql = "DELETE FROM tb_agendamento WHERE id_contrato_curso = ? AND id_agendamento = ? ";
        
        return $sql;
    }
    
    public static function buscarAgendamentosPorIdDoContrato($pauta) 
    {
        $sql = "SELECT
                        id_agendamento,
                        dia_da_semana,
                        data_dia_semana,
                        hora_inicial,
                        hora_final,
                        LPAD(MONTH(data_dia_semana), 2, '0') mes
                    FROM tb_agendamento
                WHERE id_contrato_curso = ?";
        
        if($pauta){
            
            $sql .= " GROUP BY dia_da_semana";
        }
        
        $sql.= " ORDER BY data_dia_semana";
        
        return $sql;
    }
    
    public static function buscarDataMinSemAnotacaoPauta() 
    {
        $sql = "SELECT
                    MIN(data_dia_semana) data_min
                FROM tb_agendamento
                    WHERE id_contrato_curso = ?
                    AND id_agendamento NOT IN (SELECT agend.id_agendamento FROM tb_agendamento agend
                        INNER JOIN tb_pauta_alunos pauta
                            ON pauta.id_agendamento = agend.id_agendamento
                    WHERE agend.id_contrato_curso = ?)  
                    AND id_agendamento NOT IN (SELECT agend.id_agendamento FROM tb_agendamento agend
                        INNER JOIN tb_anotacao_aula anotacao
                            ON anotacao.id_agendamento = agend.id_agendamento
                    WHERE agend.id_contrato_curso = ?)";
        
        return $sql;
        
    }
    
    public static function buscarQtdeDatasComAnotacoes() 
    {
        $sql = "SELECT COUNT(data_dia_semana) data_com_anotacoes
                FROM tb_agendamento
                    WHERE id_contrato_curso = ?
                    AND id_agendamento IN (SELECT agend.id_agendamento FROM tb_agendamento agend
                        INNER JOIN tb_pauta_alunos pauta
                            ON pauta.id_agendamento = agend.id_agendamento
                    WHERE agend.id_contrato_curso = ?)  
                    OR  id_agendamento IN (SELECT agend.id_agendamento FROM tb_agendamento agend
                            INNER JOIN tb_anotacao_aula anotacao
                                ON anotacao.id_agendamento = agend.id_agendamento
                    WHERE agend.id_contrato_curso = ?)";
        
        return $sql;
        
    }
    
    public static function buscarTodosOsAgendamentosPorIDdoContrato() 
    {
        $sql = "SELECT id_agendamento FROM tb_agendamento WHERE id_contrato_curso = ?";
        
        return $sql;
    }
    
    public static function buscarTodosOsIDsDaTabelaPautaAlunosQueTenhamAnotacoes() 
    {
        $sql = "SELECT id_agendamento FROM tb_pauta_alunos WHERE id_pauta_aluno IS NOT NULL";
        
        return $sql;
    }
    
    public static function buscarTodosOsIDsDaTabelaAnotacaoDaAulaQueTenhamAnotacoes() 
    {
        $sql = "SELECT id_agendamento FROM tb_anotacao_aula WHERE id_anotacao_aula IS NOT NULL";
        
        return $sql;
    }
    
    public static function excluirAgendamento() 
    {
        $sql = "DELETE FROM tb_agendamento WHERE id_agendamento = ?";
        
        return $sql;
    }
    
    public static function buscarAgendamentosComHorasAgendadas() 
    {
        $sql = "SELECT * FROM tb_agendamento 
                    WHERE id_contrato_curso = ?
                    AND hora_inicial IS NOT NULL 
                    AND hora_final   IS NOT NULL
                    AND data_dia_semana BETWEEN ? AND ?
                    GROUP BY dia_da_semana ORDER BY dia_da_semana";
        
        return $sql;
    }






//    public static function excluirAgendamentosSemAnotacoesPauta() 
//    {
//        $sql = "DELETE FROM tb_agendamento
//                    WHERE id_contrato_curso = ?
//                        AND id_agendamento NOT IN (SELECT agend.id_agendamento FROM tb_agendamento agend
//                                INNER JOIN tb_pauta_alunos pauta
//                                        ON pauta.id_agendamento = agend.id_agendamento
//                            WHERE agend.id_contrato_curso = ?)  
//                        AND id_agendamento NOT IN (SELECT agend.id_agendamento FROM tb_agendamento agend
//                            INNER JOIN tb_anotacao_aula anotacao
//                                    ON anotacao.id_agendamento = agend.id_agendamento
//                        WHERE agend.id_contrato_curso = ?)";
//        
//        return $sql;
//        
//    }
    
}
