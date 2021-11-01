<?php

require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\input\Input;
use Src\controllers\InteressadoController;

    if(Input::post("nome_interessado") !== null){
        
        if(Input::post("nome_interessado") !== ""){
            
            $interessadoCTRL = new InteressadoController();

            $nome = Input::post("nome_interessado");

            $ret = $interessadoCTRL->buscarInteressadoPorNome($nome);

            if(count($ret) > 0){

                echo json_encode($ret);
                
            }else{
                
                echo json_encode(0);
            }
        }
    }

