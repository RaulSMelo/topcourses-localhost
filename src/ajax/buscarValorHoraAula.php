<?php

require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\input\Input;
use Src\controllers\HoraAulaController;
use Src\traits\UtilCTRL;

    if(Input::post("id_idioma", FILTER_SANITIZE_NUMBER_INT) != null){
        
        $horaAulaCTRL = new HoraAulaController();
        
        $id = Input::post("id_idioma");
        
        $ret = $horaAulaCTRL->buscarValorHoraAulaPorIdIdioma($id);

        if(!empty($ret)){
            echo UtilCTRL::formatoMoedaBRSemSifrao($ret["valor_hora_aula"]);
        }else{
            echo "Valor Da hora/aula não cadastrado";
        }

    }

