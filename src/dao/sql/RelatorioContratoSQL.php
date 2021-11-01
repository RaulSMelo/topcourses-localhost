<?php


namespace Src\dao\sql;


class RelatorioContratoSQL 
{
    public static function buscarRelatoriosContratos($nome, $sobrenome, $tipoContrato, $situacao, $group_by) 
    {
        $sql = "SELECT	
                    contcurso.id_contrato_curso as id_contrato,
                    pes.nome as nome,
                    pes.sobrenome,
                    contcurso.data_inicio_contrato as data_inicio,
                    contcurso.data_termino_contrato as data_final,
                    contcurso.id_tipo_contrato as tipo_contrato,
                    contcurso.situacao,   
                    contcurso.valor_total   
                FROM tb_contrato_curso contcurso
                    INNER JOIN tb_interessados_e_tb_contrato_curso inter_e_contcurso
                            ON inter_e_contcurso.id_contrato_curso = contcurso.id_contrato_curso
                    INNER JOIN tb_interessados inter
                            ON inter.id_interessado = inter_e_contcurso.id_interessado
                    INNER JOIN tb_pessoas pes
                            ON pes.id_pessoa = inter.id_interessado
                WHERE contcurso.data_inicio_contrato  BETWEEN ? AND ?";
        
        if(!empty(trim($nome)) && !empty(trim($sobrenome))){
           
           $sql.= " AND (pes.nome LIKE ? OR pes.sobrenome LIKE ?)"; 
           
        }else if(!empty(trim($nome))){
           
           $sql.= " AND pes.nome LIKE ?";  
        }
        
        if(!empty($tipoContrato)){
           
           $sql.= " AND contcurso.id_tipo_contrato = ?"; 
        }
        
        if(!empty($situacao)){
           
           $sql.= " AND contcurso.situacao = ?"; 
        }
        
        if($group_by){
            
            $sql.= " GROUP BY contcurso.id_contrato_curso";
        }
                
        $sql .= " UNION ALL

                SELECT	
                    contrevtrad.id_contrato_rev_trad as id_contrato,
                    pes.nome as nome,
                    pes.sobrenome,
                    contrevtrad.data_recebimento_material as data_inicio,
                    contrevtrad.data_prazo_entrega as data_final,
                    contrevtrad.id_tipo_contrato as tipo_contrato,
                    contrevtrad.situacao,    
                    contrevtrad.valor_total    
                    FROM tb_contrato_rev_trad contrevtrad
                INNER JOIN tb_interessados inter
                        ON inter.id_interessado = contrevtrad.id_interessado
                INNER JOIN tb_pessoas pes
                        ON pes.id_pessoa = inter.id_interessado
                WHERE contrevtrad.data_recebimento_material  
                BETWEEN ? AND ?"; 
        
        
        if(!empty(trim($nome)) && !empty(trim($sobrenome))){
           
           $sql.= " AND (pes.nome LIKE ? OR pes.sobrenome LIKE ?)"; 
           
        }else if(!empty(trim($nome))){
           
           $sql.= " AND pes.nome LIKE ?"; 
        }
        
        if(!empty($tipoContrato)){
           
           $sql.= " AND contrevtrad.id_tipo_contrato = ?"; 
        }
        
        if(!empty($situacao)){
           
           $sql.= " AND contrevtrad.situacao = ?"; 
        }
        
        if($group_by){
            
            $sql.= " GROUP BY contrevtrad.id_contrato_rev_trad";
        }
        
        return $sql;
    }
    
    public static function somaDosValoresDosContratos($tipoContrato, $situacao) 
    {
        $sql = "SELECT SUM(soma.CC + soma.CRT) AS Soma_Total FROM 
                    (SELECT curso.id_contrato_curso,
                            SUM(curso.valor_total) AS CC, 
                            0 AS CRT FROM tb_contrato_curso AS curso 
                    WHERE curso.data_inicio_contrato  BETWEEN ? AND ?
                    AND curso.id_contrato_curso IN (SELECT icc.id_contrato_curso FROM tb_interessados_e_tb_contrato_curso icc
                                                        INNER JOIN tb_interessados inter
                                                                ON inter.id_interessado = icc.id_interessado
                                                        INNER JOIN tb_pessoas pes
                                                                ON pes.id_pessoa = inter.id_interessado
                                                        WHERE (pes.nome LIKE ? AND pes.sobrenome LIKE ?)";
                                                        
                                                        if(!empty($tipoContrato)){
                                                           
                                                            $sql.= " AND curso.id_tipo_contrato = ?";
                                                        }
                                                        
                                                        if(!empty($situacao)){
                                                           
                                                            $sql.= " AND curso.situacao = ?";
                                                        } 
                                                        
        $sql .= " ) GROUP BY curso.id_contrato_curso

                UNION ALL 

                SELECT  crt.id_contrato_rev_trad,
                        0 AS CC, 
                        SUM(crt.valor_total) FROM tb_contrato_rev_trad AS crt 
                    WHERE crt.data_recebimento_material BETWEEN ? AND ?
                    AND crt.id_interessado IN (SELECT inter.id_interessado FROM tb_interessados inter
                                                    INNER JOIN tb_pessoas pes
                                                        ON pes.id_pessoa = inter.id_interessado
                                                WHERE (pes.nome LIKE ? AND pes.sobrenome LIKE ?)";
        
                                                if(!empty($tipoContrato)){
                                                           
                                                    $sql.= " AND crt.id_tipo_contrato = ?";
                                                }

                                                if(!empty($situacao)){

                                                    $sql.= " AND crt.situacao = ?";
                                                }
                                    
	$sql.= ") GROUP BY crt.id_contrato_rev_trad) soma";
        
        
        return $sql;
    }
}
