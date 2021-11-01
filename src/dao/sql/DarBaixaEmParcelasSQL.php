<?php


namespace Src\dao\sql;


class DarBaixaEmParcelasSQL 
{
    public static function inserirTbDarbaixaParcelas() 
    {
        $sql = "INSERT INTO tb_dar_baixa_parcelas
                            (
                              qtde_parcelas,
                              numero_da_parcela,
                              data_vencimento_parcela,
                              valor_parcela,
                              tipo_contrato,
                              situacao_pagamento,
                              tipo_pagamento,
                              data_registro_pagamento,
                              id_contrato_rev_trad,
                              id_contrato_curso,
                              id_interessado   
                            )
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
   
        return $sql;
    }
    
    public static function filtrarTbDarBaixaParcelas(array $filtros) 
    {
        $sql = "SELECT
                        pes.nome,
                        pes.sobrenome,
                        dbp.id_dar_baixa_parcelas,
                        dbp.numero_da_parcela,
                        dbp.qtde_parcelas,
                        dbp.data_vencimento_parcela,
                        dbp.valor_parcela,
                        dbp.valor_pago,
                        dbp.tipo_contrato,
                        dbp.situacao_pagamento,
                        dbp.tipo_pagamento,
                        dbp.data_registro_pagamento,
                        dbp.id_contrato_rev_trad,
                        dbp.id_contrato_curso,
                        dbp.id_interessado,
                        dbp.observacao_pagamento
                    FROM tb_dar_baixa_parcelas dbp
                        INNER JOIN tb_pessoas pes
                            ON pes.id_pessoa = dbp.id_interessado
                WHERE dbp.data_vencimento_parcela BETWEEN ? AND ?";
        
        if(!empty($filtros["nome"]) && !empty($filtros["sobrenome"])){
           
            $sql .= " AND (pes.nome LIKE ? OR pes.sobrenome LIKE ?)";
            
        }else if(!empty($filtros["nome"])){
           
            $sql .= " AND pes.nome LIKE ?";
        }
        
        if(!empty($filtros["situacao_pag"])){
            
            $sql .= " AND dbp.situacao_pagamento = ?";
        }
        
        $sql .= " ORDER BY dbp.numero_da_parcela";
        
        return $sql;
    }
    
    public static function registrarBaixaParcelaValorPagoIgual() 
    {
        $sql = "UPDATE tb_dar_baixa_parcelas
                       SET
                          situacao_pagamento      = ?,
                          tipo_pagamento          = ?,
                          data_registro_pagamento = ?,
                          valor_pago              = ?,
                          observacao_pagamento    = ?
                    WHERE id_dar_baixa_parcelas   = ?";
        
        return $sql;
    }
    
    public static function registrarBaixaParcelaValorPagoMaiorOuMenor($tipo_contrato) 
    {
        $sql = "UPDATE tb_dar_baixa_parcelas
                        SET
                            situacao_pagamento      = ?,
                            tipo_pagamento          = ?,
                            data_registro_pagamento = ?,
                            valor_parcela           = ?,
                            valor_pago              = ?,
                            observacao_pagamento    = ?
                        WHERE id_interessado        = ?
                        AND   numero_da_parcela     = ?";
        
        if($tipo_contrato == CONTRATO_REVISAO || $tipo_contrato == CONTRATO_TRADUCAO){
            
            $sql .= " AND id_contrato_rev_trad = ?";
            
        }else{
            
            $sql .= " AND id_contrato_curso = ?";
        }
        
        return $sql;
    }
    
    public static function atualizarSituacaoPagamentoPelaDataAtual() 
    {
        $sql = "UPDATE tb_dar_baixa_parcelas
                        SET
                          situacao_pagamento      = ?
                    WHERE data_vencimento_parcela < ? 
                        AND situacao_pagamento    = ?";
        
        return $sql;
    }
    
    public static function buscarParcelasEmAberto($tipo_contrato)
    {   
        
        $and_tipo_contrato_igual = "";
        
        if($tipo_contrato == CONTRATO_REVISAO || $tipo_contrato == CONTRATO_TRADUCAO){
            
            $and_tipo_contrato_igual = " AND id_contrato_rev_trad = ?";
       
        }else{
            
            $and_tipo_contrato_igual = " AND id_contrato_curso = ?";
        }
        
        $sql = "SELECT  
                        (SELECT 
				SUM(dbp.valor_parcela) 
                        FROM tb_dar_baixa_parcelas dbp 
                        WHERE dbp.valor_pago IS NULL 
                        AND   dbp.id_interessado = ?". 
                        $and_tipo_contrato_igual .") as soma_total_parcelas,
                        (SELECT 
                               COUNT(dbp.numero_da_parcela) 
                         FROM tb_dar_baixa_parcelas dbp 
                        WHERE dbp.valor_pago IS NULL 
                        AND   dbp.id_interessado   = ?" . 
                        $and_tipo_contrato_igual .") as qtde_parcelas,
                        (SELECT 
                               MIN(dbp.numero_da_parcela) 
                        FROM tb_dar_baixa_parcelas dbp 
                        WHERE dbp.valor_pago IS NULL 
                        AND   dbp.id_interessado = ?". 
                        $and_tipo_contrato_igual .") as primeira_parcela_em_aberto,
                        (SELECT 
                               MAX(dbp.numero_da_parcela) 
                        FROM tb_dar_baixa_parcelas dbp 
                        WHERE dbp.valor_pago IS NULL 
                        AND   dbp.id_interessado = ?". 
                        $and_tipo_contrato_igual .") as ultima_parcela,
                        (SELECT 
                               MAX(dbp.data_vencimento_parcela) 
                        FROM tb_dar_baixa_parcelas dbp 
                        WHERE dbp.valor_pago IS NULL 
                        AND   dbp.id_interessado = ?". 
                        $and_tipo_contrato_igual .") as ultima_data_vencimento,
                        tipo_contrato
                FROM tb_dar_baixa_parcelas
                WHERE id_interessado   = ?". 
                $and_tipo_contrato_igual .
                " GROUP BY tipo_contrato";
        
        return $sql;
    }
}
