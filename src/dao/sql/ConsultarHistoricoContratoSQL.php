<?php


namespace Src\dao\sql;


class ConsultarHistoricoContratoSQL 
{
    public static function consultarHistoricoContrato() 
    {
        $sql = "SELECT 
                    inter.id_interessado,
                    crt.id_contrato_rev_trad id_contrato,
                    crt.id_tipo_contrato tipo_contrato,
                    crt.data_recebimento_material data_inicio,
                    crt.data_prazo_entrega data_final,
                    crt.situacao	
                    FROM tb_interessados inter
                        LEFT JOIN tb_contrato_rev_trad crt
                            ON crt.id_interessado = inter.id_interessado
                WHERE inter.id_interessado = ? 
                AND crt.id_contrato_rev_trad IS NOT NULL

                UNION ALL

                SELECT 
                    inter.id_interessado,
                    cc.id_contrato_curso,
                    cc.id_tipo_contrato,
                    cc.data_inicio_contrato,
                    cc.data_termino_contrato,
                    cc.situacao
                FROM tb_interessados inter
                    LEFT JOIN tb_interessados_e_tb_contrato_curso inter_e_cc
                        ON inter_e_cc.id_interessado = inter.id_interessado
                    LEFT JOIN tb_contrato_curso cc 
                        ON cc.id_contrato_curso = inter_e_cc.id_contrato_curso
                WHERE inter.id_interessado = ? 
                AND cc.id_contrato_curso IS NOT NULL";
        
        return $sql;
        
    }
}
