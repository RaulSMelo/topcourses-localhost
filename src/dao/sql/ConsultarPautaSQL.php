<?php


namespace Src\dao\sql;

class ConsultarPautaSQL 
{
    public static function buscarPautas($situacao) 
    {
        $sql = "SELECT 
                    inter.id_interessado,
                    pes.nome,
                    pes.sobrenome,
                    curso.id_contrato_curso,
                    curso.data_inicio_contrato,
                    curso.data_termino_contrato,
                    curso.id_tipo_contrato,
                    curso.situacao
                FROM tb_interessados inter
                    INNER JOIN tb_pessoas pes
                            ON pes.id_pessoa = inter.id_interessado
                    INNER JOIN tb_interessados_e_tb_contrato_curso ic
                            ON ic.id_interessado = inter.id_interessado
                    INNER JOIN tb_contrato_curso curso
                            ON curso.id_contrato_curso = ic.id_contrato_curso
                WHERE pes.nome LIKE ? AND pes.sobrenome LIKE ?";
        
        if($situacao != ""){
            
            $sql.= " AND curso.situacao = ?";
        }
        
        $sql.= " ORDER BY pes.nome";
        
        return $sql;
    }
}
