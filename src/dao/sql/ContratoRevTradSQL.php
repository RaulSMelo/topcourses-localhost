<?php


namespace Src\dao\sql;


class ContratoRevTradSQL 
{
    public static function inserirContratoRevTrad() 
    {
        $sql = "INSERT INTO tb_contrato_rev_trad
                        (
                          id_tipo_contrato,
                          data_recebimento_material,
                          data_prazo_entrega,
                          total_palavras,
                          total_horas,
                          valor_total,
                          qtde_parcelas,
                          valor_parcela,
                          dia_vencimento_parcela,
                          descricao_servico,
                          id_revisor,
                          id_tradutor,
                          id_interessado,
                          id_user_logado,
                          data_registro,
                          situacao
                        ) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        return $sql;
    }
    
    public static function alterarContratoRevTrad() 
    {
        $sql = "UPDATE tb_contrato_rev_trad
                        SET 
                            situacao          = ?,
                            id_tradutor       = ?,
                            id_revisor        = ?,
                            total_palavras    = ?,
                            total_horas       = ?,
                            descricao_servico = ?,
                            marcacoes_gerais  = ?
                WHERE id_contrato_rev_trad    = ?";
        
        return $sql;
    }
    
    public static function buscarTodosOsDadosContratoRevTradPorId() 
    {
       $sql = "SELECT
                    pes.nome,
                    pes.sobrenome,
                    pes.email,
                    pes.telefone,
                    pes.cpf,
                    crt.id_contrato_rev_trad,
                    crt.id_tipo_contrato,
                    crt.data_recebimento_material,
                    crt.data_prazo_entrega,
                    crt.total_palavras,
                    crt.total_horas,
                    crt.valor_total,
                    crt.qtde_parcelas,
                    crt.valor_parcela,
                    crt.dia_vencimento_parcela,
                    crt.descricao_servico,
                    crt.id_revisor,
                    crt.id_tradutor,
                    crt.id_interessado,
                    crt.situacao,
                    crt.marcacoes_gerais
                FROM tb_contrato_rev_trad crt
                    INNER JOIN tb_pessoas pes
                        ON pes.id_pessoa = crt.id_interessado
                WHERE id_contrato_rev_trad = ?";
       
       return $sql;
    }
}
