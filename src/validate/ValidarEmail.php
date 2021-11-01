<?php

require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\controllers\ValidarEmailController;
use Src\input\Input;

    if(Input::post("email_pessoa", FILTER_VALIDATE_EMAIL)){

        $email  = filter_input(INPUT_POST, "email_pessoa");
        $id     = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

        $resultado = new ValidarEmailController(trim($email), "tb_pessoas", $id);

        echo json_encode($resultado->getEmail_e_valido());

    }else if (Input::post("email_empresa", FILTER_VALIDATE_EMAIL)){

        $email  = filter_input(INPUT_POST, "email_empresa");
        $id     = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

        $resultado = new ValidarEmailController(trim($email), "tb_empresas", $id);

        echo json_encode($resultado->getEmail_e_valido());

    }else{

         echo json_encode(["erro" => -1]);
    }