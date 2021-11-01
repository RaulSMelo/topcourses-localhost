<?php

require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\controllers\InteressadoController;
use Src\input\Input;

if(Input::post("id_aluno_pauta") !== null){
    
    $interessadoCTRL = new InteressadoController();
    
    $id = Input::post("id_aluno_pauta");
    
    $ret = $interessadoCTRL->buscarInteressadoPorId($id);
    
    if(count($ret) > 0){
       
        echo json_encode($ret);
        exit;
        
    }else{
        
        echo json_encode(["ret" => -1]);
        exit;
    }
        
}

