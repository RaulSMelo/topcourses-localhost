<?php

namespace Src\dao\sql;

class InteressadoSQL {

    public static function inserirInteressado() {
        $sql = "INSERT INTO tb_interessados 
                    (id_interessado,
                     id_curso,
                     id_revisao,
                     id_traducao,
                     data_nascimento,
                     profissao,
                     id_idioma,
                     id_midia,
                     id_colaborador,
                     id_tipo_contato,
                     data_agendamento,
                     teste_nivelamento,
                     id_resultado,
                     informacoes_adicionais,
                     id_user_logado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        return $sql;
    }

    public static function alterarInteressado() {
        $sql = "UPDATE tb_interessados 
                    SET 
                        id_curso               = ?,
                        id_revisao             = ?,
                        id_traducao            = ?,
                        data_nascimento        = ?,
                        profissao              = ?,
                        id_idioma              = ?,
                        id_midia               = ?,
                        id_colaborador         = ?,
                        id_tipo_contato        = ?,
                        data_agendamento       = ?,
                        teste_nivelamento      = ?,
                        id_resultado           = ?,
                        informacoes_adicionais = ?
                WHERE id_interessado           = ?";

        return $sql;
    }

    public static function excluirInteressado() {
        $sql = "DELETE FROM tb_interessados WHERE id_interessado = ?";

        return $sql;
    }

    public static function buscarInteressadoPorID() {
        $sql = "SELECT  interessado.id_interessado,
                        pessoa.nome, 
                        pessoa.sobrenome,
                        pessoa.email, 
                        pessoa.telefone, 
                        pessoa.cpf,
                        interessado.id_curso,
                        interessado.id_revisao,
                        interessado.id_traducao,
                        interessado.data_nascimento,
                        interessado.profissao,
                        interessado.id_idioma,
                        interessado.id_midia,
                        interessado.id_colaborador,
                        interessado.id_tipo_contato,
                        interessado.data_agendamento,
                        interessado.teste_nivelamento,
                        interessado.id_resultado,
                        interessado.informacoes_adicionais,
                        interessado.id_user_logado,
                        id_endereco,
                        endereco.cep,
                        endereco.rua,
                        endereco.numero,
                        endereco.complemento,
                        endereco.bairro,
                        endereco.cidade,
                        endereco.uf
            FROM tb_interessados AS interessado
                INNER JOIN tb_pessoas AS pessoa
                    ON pessoa.id_pessoa = interessado.id_interessado
                LEFT JOIN tb_enderecos AS endereco
                    ON endereco.id_interessado = interessado.id_interessado
            WHERE interessado.id_interessado = ?";

        return $sql;
    }

    public static function filtrarConsultaInteressados($nome, $sobrenome, $id_curso, $id_traducao, $id_revisao) {

        $sql = "SELECT interessado.id_interessado,
                       pessoa.nome,
                       pessoa.sobrenome,
                       pessoa.email,
                       pessoa.telefone,
                       interessado.id_curso,
                       interessado.id_traducao,
                       interessado.id_revisao
                FROM tb_interessados interessado
                    INNER JOIN tb_pessoas pessoa
                        ON pessoa.id_pessoa = interessado.id_interessado
                WHERE pessoa.data_registro BETWEEN ? AND ?";
        
                
        if(!empty($nome) && !empty($sobrenome)){

            $sql .= " AND (pessoa.nome LIKE ? OR pessoa.sobrenome LIKE ?)";

        }else if(!empty($nome)){

            $sql .= " AND pessoa.nome LIKE ?";
        }

        if(!empty($id_curso)){

            $sql .= " AND interessado.id_curso = ?";
        }

        if(!empty($id_traducao)){

            $sql .= " AND interessado.id_traducao = ?";
        }

        if(!empty($id_revisao)){

            $sql .= " AND interessado.id_revisao = ?";
        }
        
        $sql .= " ORDER BY pessoa.nome";

        return $sql;
    }

    public static function filtrarInteressadosPorNomeEsituacaoDoContrato($nome, $sobrenome, $situacao, $pauta) 
    {
        $sql = "SELECT
                        inter.id_interessado,
                        pes.nome,
                        pes.sobrenome,
                        pes.email,
                        pes.telefone,
                        (SELECT COUNT(id_interessado) id_interessado FROM tb_interessados_e_tb_contrato_curso WHERE id_interessado = inter.id_interessado) qtde_contrato_curso,
                        (SELECT COUNT(id_interessado) id_interessado FROM tb_contrato_rev_trad WHERE id_interessado = inter.id_interessado) qtde_contrato_rev_trad,
                        tb_curso.id_contrato_curso,
                        tb_curso.data_inicio_contrato,
                        tb_curso.data_termino_contrato,
                        tb_curso.id_tipo_contrato tipo_curso,
                        tb_curso.situacao situacao_curso,
                        tb_rev_trad.id_contrato_rev_trad,
                        tb_rev_trad.data_recebimento_material,
                        tb_rev_trad.data_prazo_entrega,
                        tb_rev_trad.id_tipo_contrato tipo_rev_trad,
                        tb_rev_trad.situacao situacao_rev_trad
                FROM tb_interessados inter
                    INNER JOIN tb_pessoas pes
                        ON pes.id_pessoa = inter.id_interessado
                    LEFT JOIN tb_interessados_e_tb_contrato_curso inter_e_cc
                        ON inter_e_cc.id_interessado = inter.id_interessado
                    LEFT JOIN tb_contrato_curso tb_curso
                        ON tb_curso.id_contrato_curso = inter_e_cc.id_contrato_curso
                    LEFT JOIN tb_contrato_rev_trad tb_rev_trad
                        ON tb_rev_trad.id_interessado = inter.id_interessado
                WHERE";
        
        if(!empty($nome) && !empty($sobrenome)){

            $sql.= " (pes.nome LIKE ? OR pes.sobrenome LIKE ?)";

        }else if(!empty($nome)){

            $sql .= " pes.nome LIKE ?";
        }
        
        if(!empty($situacao)){
                
            $sql .= " AND (tb_curso.situacao = ? OR tb_rev_trad.situacao = ?)";
            
        }

        if($pauta){
                
            $sql .= " AND tb_curso.id_contrato_curso IS NOT NULL";
            
            return $sql;
            
        }
        
        $sql .= "  GROUP BY pes.nome ORDER BY pes.nome";
        
        return $sql;
    }
    
    public static function buscarInteressadoPorNome()
    {
        $sql = "SELECT 
                        inter.id_interessado,
                        pes.nome,
                        pes.sobrenome,
                        pes.cpf
                    FROM tb_interessados inter
                        INNER JOIN tb_pessoas pes
                            ON pes.id_pessoa = inter.id_interessado
                WHERE   pes.nome LIKE ? 
                    AND pes.sobrenome LIKE ? 
                    AND pes.id_pessoa = inter.id_interessado
                    ORDER BY pes.nome";
        
        return $sql;
    }
    
    public static function retornaQtdeDeInteressadosEnvolvidosComContratos()
    {
        $sql = "SELECT
                    SUM((SELECT COUNT(id_interessado) id_interessado FROM tb_interessados_e_tb_contrato_curso WHERE id_interessado = inter.id_interessado) 
                        + 
                        (SELECT COUNT(id_interessado) id_interessado FROM tb_contrato_rev_trad WHERE id_interessado = inter.id_interessado)) AS qtde_interessados_nos_contratos
                FROM tb_interessados inter WHERE inter.id_interessado = ?";
        
        return $sql;
    }

    public static function alterarSomenteCPFaluno() 
    {
        $sql = "UPDATE tb_pessoas SET cpf = ? WHERE id_pessoa = ?";
        
        return $sql;
    }
    
    public static function buscaDataDaAulaAgendadaPorIdInteressado()
    {
        $sql = "SELECT data_agendamento FROM tb_interessados WHERE id_interessado = ?";
        
        return $sql;
    }
}
