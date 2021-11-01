<?php

require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\input\Input;
use Src\models\PautaAlunoModel;
use Src\controllers\PautaAlunoController;
use Src\erro\Erro;

    if(Input::post("id_aluno", FILTER_SANITIZE_NUMBER_INT)           !== null &&
       Input::post("id_contrato", FILTER_SANITIZE_NUMBER_INT)        !== null &&
       Input::post("anotacao_professor", FILTER_SANITIZE_NUMBER_INT) !== null &&
       Input::post("id_agendamento", FILTER_SANITIZE_NUMBER_INT)     !== null)
    {
        $pautaModel = new PautaAlunoModel();
        $pautaCTRL  = new PautaAlunoController();
        
        $pautaModel->setIdAlununo(Input::post("id_aluno"));
        $pautaModel->setIdContratoCurso(Input::post("id_contrato"));
        $pautaModel->setAnotacaoProfessor(Input::post("anotacao_professor"));
        $pautaModel->setIdAgendamento(Input::post("id_agendamento"));
        
        if(Input::post("id_pauta_aluno", FILTER_SANITIZE_NUMBER_INT) !== null){
            
            $pautaModel->setIdPautaAluno(Input::post("id_pauta_aluno"));
            
            $ret = $pautaCTRL->alterarAnotacaoProfessor($pautaModel);
            
            echo $ret;exit;
            
            if($ret == 1){
               
                echo json_encode(["ret"   => $ret]);
                
                exit;
                
            }else{
                
                echo json_encode(["ret" => $ret, "msg_error" => "Houve uma falha ao tentar salvar a anotação"]);
                
                exit;
            }
            
        }else{

            $ret = $pautaCTRL->inserirAnotacaoProfessor($pautaModel);
            
            if($ret >= 1){
               
                echo json_encode(["ret" => $ret]);
                
                exit;
                
            }else{
                
                echo json_encode(["ret" => $ret, "msg_error" => "Houve uma falha ao tentar salvar a anotação"]);
                
                exit;
            }
        }    
        
    }

