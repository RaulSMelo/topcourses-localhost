<?php

require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\erro\Erro;
use Src\traits\UtilCTRL;

    if(filter_input(INPUT_POST, "data_nascimento") != null){
        
        
        $ret = UtilCTRL::validarDataNascimento(filter_input(INPUT_POST, "data_nascimento"));
        
        if(is_numeric($ret)){
           
            echo json_encode(["erro" => Erro::getErro(), "idAlerta" => "data-nascimento-alert"]);
            
        }else{
            
            echo json_encode(["ret" => $ret, "idAlerta" => "data-nascimento-alert"]);
        }
        
    }else if (filter_input(INPUT_POST, "data_agendamento") != null){
        
        $ret = UtilCTRL::validarDataInformadaEmaiorQueDataAtual("Data de agendamento", filter_input(INPUT_POST, "data_agendamento"));
        
        if(is_numeric($ret)){
            
            echo json_encode(["erro" => Erro::getErro(), "idAlerta" => "data-agendamento-alert"]);
            
        }else{
            
            echo json_encode(["ret" => $ret, "idAlerta" => "data-agendamento-alert"]);
        }
        
    
    }else if (filter_input(INPUT_POST, "data_inicio") != null && filter_input(INPUT_POST, "data_final") != null){
        
        $dataInicio = filter_input(INPUT_POST, "data_inicio");
        $dataFinal  = filter_input(INPUT_POST, "data_final");
        
        $ret       = UtilCTRL::validarDataInicioEdataFinal("Data início", "data final", $dataInicio, $dataFinal);
        
        $qtdeMeses = UtilCTRL::retornaQtdeDeMesesDeUmPeriodo($dataInicio, $dataFinal);
        
        if(is_numeric($ret) && $ret == -1){
            
            echo json_encode(["erro" => Erro::getErro(), "idAlerta" => "datainicio-e-datafinal-alert"]);
            
        }else{
            
            echo json_encode(["ret" => $ret, "idAlerta" => "datainicio-e-datafinal-alert",  "qtdeMeses" => $qtdeMeses]);
        }
        
    }else if(filter_input(INPUT_POST, "data_recebimento_material") != null && filter_input(INPUT_POST, "data_prazo_entrega") != null){
      
        
        $dataRecebimento  = filter_input(INPUT_POST, "data_recebimento_material");
        $dataPrazoEntrega = filter_input(INPUT_POST, "data_prazo_entrega");
        
        $ret = UtilCTRL::validarDataInicioEdataFinal("Data de Recebimento do material", "data do prazo de entrega", $dataRecebimento, $dataPrazoEntrega);
        
        if(is_numeric($ret)){
            
            echo json_encode(["erro" => Erro::getErro(), "idAlerta" => "msg-alerta-dataRecebimento-e-dataPrazoEntrega"]);
            
        }else{
            
            echo json_encode(["ret" => $ret, "idAlerta" => "msg-alerta-dataRecebimento-e-dataPrazoEntrega"]);
            
        }
        
    }
//    else if(filter_input(INPUT_POST, "dia_vencimento_parcela") != null){   
//        
//        $diaVencimentoParcela = filter_input(INPUT_POST, "dia_vencimento_parcela");
//        
//        $ret = UtilCTRL::validarDataInformadaEmaiorQueDataAtual("Dia de vencimento das parcelas", $diaVencimentoParcela);
//        
//        if(is_numeric($ret)){
//            
//            echo json_encode(["erro" => Erro::getErro(), "idAlerta" => "msg-alerta-dia-vencimento-parcelas"]);
//            
//        }else{
//            
//            echo json_encode(["ret" => $ret, "idAlerta" => "msg-alerta-dia-vencimento-parcelas"]);
//        }
//        
//    }

