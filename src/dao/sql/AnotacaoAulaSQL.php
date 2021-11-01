<?php

namespace Src\dao\sql;


class AnotacaoAulaSQL 
{
    public static function inserirAnotacaoAula()
    {
        $sql = "INSERT INTO tb_anotacao_aula
                            (
                              anotacoes_aula,
                              id_agendamento
                            )
                    VALUES (?, ?)";
        
        return $sql;        
    }
    
    public static function alterarAnotacaoAula()
    {
        $sql = "UPDATE tb_anotacao_aula SET anotacoes_aula = ? WHERE id_anotacao_aula = ?";
        
        return $sql;        
    }
    
    public static function buscarTodasAnotacoesDasAulasPorIdDoContrato()
    {
        $sql = "SELECT
                    anotacao.id_anotacao_aula,
                    anotacao.anotacoes_aula,
                    anotacao.id_agendamento
                FROM tb_anotacao_aula anotacao
                    INNER JOIN tb_agendamento agend
                        ON agend.id_agendamento = anotacao.id_agendamento
                WHERE agend.id_contrato_curso = ?";
        
        return $sql;        
    }
    

}
