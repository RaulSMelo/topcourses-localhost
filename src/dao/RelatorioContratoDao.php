<?php

namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\RelatorioContratoSQL;;


class RelatorioContratoDao 
{   
    private PDO $conn;
    
    public function __construct() 
    {
        $this->conn = Conexao::obterConexao(); 
    }
    
    public function buscarRelatoriosContratos($dataInicio, $dataFinal, $nome, $sobrenome, $tipoContrato, $situacao, $group_by) 
    {
        try {
            
            $stmt = $this->conn->prepare(RelatorioContratoSQL::buscarRelatoriosContratos($nome, $sobrenome, $tipoContrato, $situacao, $group_by));
            $i = 1;
            $stmt->bindValue($i++, $dataInicio);
            $stmt->bindValue($i++, $dataFinal);

            if(!empty(trim($nome)) && !empty(trim($sobrenome))){

                $stmt->bindValue($i++, "%{$nome}%");
                $stmt->bindValue($i++, "%{$sobrenome}%");
                
            }else if(!empty(trim($nome))){

                $stmt->bindValue($i++, "%{$nome}%");
            }

            if(!empty($tipoContrato)){

                $stmt->bindValue($i++, $tipoContrato);
            }

            if(!empty($situacao)){

                $stmt->bindValue($i++, $situacao);
            }

            $stmt->bindValue($i++, $dataInicio);
            $stmt->bindValue($i++, $dataFinal);

            if(!empty(trim($nome)) && !empty(trim($sobrenome))){

                $stmt->bindValue($i++, "%{$nome}%");
                $stmt->bindValue($i++, "%{$sobrenome}%");
                
            }else if(!empty(trim($nome))){

                $stmt->bindValue($i++, "%{$nome}%");
            }

            if(!empty($tipoContrato)){

                $stmt->bindValue($i++, $tipoContrato);
            }

            if(!empty($situacao)){

                $stmt->bindValue($i++, $situacao);
            }

            $stmt->execute();

            return $stmt->fetchAll();
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar os dados do relatório de contratos"))->enviarLogDeErro($e);

            header("LOCATION: " . PAGINA_DE_ERRO);

            exit;
        }
    }
    
    public function somaDosValoresDosContratos($dataInicio, $dataFinal, $nome, $sobrenome, $tipoContrato, $situacao) 
    {
        try {
            
            $stmt = $this->conn->prepare(RelatorioContratoSQL::somaDosValoresDosContratos($tipoContrato, $situacao));
            $i = 1;
            $stmt->bindValue($i++, $dataInicio);
            $stmt->bindValue($i++, $dataFinal);
            $stmt->bindValue($i++, "%{$nome}%");
            $stmt->bindValue($i++, "%{$sobrenome}%");


            if(!empty($tipoContrato)){

                $stmt->bindValue($i++, $tipoContrato);
            }

            if(!empty($situacao)){

                $stmt->bindValue($i++, $situacao);
            }

            $stmt->bindValue($i++, $dataInicio);
            $stmt->bindValue($i++, $dataFinal);
            $stmt->bindValue($i++, "%{$nome}%");
            $stmt->bindValue($i++, "%{$sobrenome}%");

            if(!empty($tipoContrato)){

                $stmt->bindValue($i++, $tipoContrato);
            }

            if(!empty($situacao)){

                $stmt->bindValue($i++, $situacao);
            }

            $stmt->execute();

            return $stmt->fetch()["Soma_Total"];
            
        } catch (\PDOException $e) {

            (new Log("ERRO ao buscar a soma dos valores dos contratos"))->enviarLogDeErro($e);

            header("LOCATION: " . PAGINA_DE_ERRO);

            exit;
        }
    }
}
