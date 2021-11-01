<?php

namespace Src\dao\sql;


class HoraAulaSQL 
{
    public static function inserirHoraAula() 
    {
        $sql = "INSERT INTO tb_hora_aula 
                                        (id_idioma,
                                         valor_hora_aula,
                                         id_user_logado,
                                         data_registro)
                                    VALUES (?, ?, ?, ?)";
        
        return $sql;
    }
    
    public static function alterarHoraAula() 
    {
        $sql = "UPDATE tb_hora_aula
                        SET
                            id_idioma       = ?,
                            valor_hora_aula = ?
                    WHERE   id_hora_aula    = ?";
        
        return $sql;
    }
    
    public static function excluirHoraAula()
    {
        $sql = "DELETE FROM tb_hora_aula WHERE id_hora_aula = ?";
        
        return $sql;
    }

    public static function buscarTodasHorasAulas() 
    {
        $sql = "SELECT
                      tb_ha.id_hora_aula,
                      tb_ha.valor_hora_aula,
                      tb_ha.id_idioma,
                      cad_bas.nome_cadastro
                FROM  tb_hora_aula tb_ha
                    INNER JOIN tb_cadastro_basico cad_bas
                        ON cad_bas.id_cadastro_basico = tb_ha.id_idioma";
        
        return $sql;
    }
    
    public static function buscarValorHoraAulaPorIdIdioma()
    {
        $sql = "SELECT valor_hora_aula FROM tb_hora_aula WHERE id_idioma = ?";
        
        return $sql;
    }
           
}
