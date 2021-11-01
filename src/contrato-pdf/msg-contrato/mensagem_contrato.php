<?php

require_once dirname(__DIR__, "3") . "/vendor/autoload.php";

use Src\input\Input;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();
    
    if(Input::get("ret", FILTER_SANITIZE_NUMBER_INT)           !== null && 
       Input::get("id-contrato", FILTER_SANITIZE_NUMBER_INT)   === null &&
       Input::get("tipo-contrato", FILTER_SANITIZE_NUMBER_INT) === null)
    {
        $ret = Input::get("ret");
        
    }else if( Input::get("id-contrato", FILTER_SANITIZE_NUMBER_INT)   !== null && 
              Input::get("ret", FILTER_SANITIZE_NUMBER_INT)           !== null &&
              Input::get("tipo-contrato", FILTER_SANITIZE_NUMBER_INT) !== null)
    {
        
        $ret = Input::get("ret");
        $idContrato = Input::get("id-contrato");
        $tipoContrato = Input::get("tipo-contrato");
        
        $caminho_pdf = UtilCTRL::gerarCaminhoParaPDF($tipoContrato);    

    }
    
?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Contrato cadastrado</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="row">

                <div class="col-12">
                    <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                </div>
                
                <?php if (isset($_GET["id-contrato"]) && isset($_GET["tipo-contrato"])): ?>
                    <div class="col-12">
                        <a href="<?= $caminho_pdf . $idContrato ?>" target="_blank" class="btn btn-dark">Visualizar | imprimir contrato</a>
                    </div>
                <?php endif ?>
                
            </div>
        </div>
        
        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>
        
    </body>

</html>


