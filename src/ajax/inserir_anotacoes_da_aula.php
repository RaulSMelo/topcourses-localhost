<?php

require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\input\Input;
use Src\models\AnotacaoAulaModel;
use Src\controllers\AnotacaoAulaController;
use Src\erro\Erro;

    if(Input::post("anotacao_aula") !== null && Input::post("id_agendamento", FILTER_SANITIZE_NUMBER_INT)){
        
        $anotacaoAulaCTRL = new AnotacaoAulaController();
        $anotacaoModel    = new AnotacaoAulaModel();
        
        $anotacaoModel->setIdAgendamento(Input::post("id_agendamento"));
        $anotacaoModel->setAnotacaoAula(Input::post("anotacao_aula"));
        
        if(Input::post("id_anotacao_aula", FILTER_SANITIZE_NUMBER_INT) !== null && !empty(Input::post("id_anotacao_aula"))){
            
            $anotacaoModel->setIdAnotacaoAula(Input::post("id_anotacao_aula"));

            $ret = $anotacaoAulaCTRL->alterarAnotacaoAula($anotacaoModel);
            
            if($ret == 1){
                
                echo json_encode(["ret" => $ret]);
                
            }else{
                
                echo json_encode(["ret" => $ret, "msg_error" => Erro::getErro()]);
            }
            
        }else{
            
            $ret = $anotacaoAulaCTRL->inserirAnotacaoAula($anotacaoModel);
            
            if($ret == 1){
                
                echo json_encode(["ret" => $ret]);
                
            }else{
                
                echo json_encode(["ret" => $ret, "msg_error" => Erro::getErro()]);
            }
        }
        
    }



