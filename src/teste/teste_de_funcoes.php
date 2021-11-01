<?php

require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

$senhaHash = password_hash("123456", PASSWORD_DEFAULT);

echo $senhaHash;

//$dataInicio = "2021-09-01";
//$dataFinal = "2021-10-31";
//
//echo UtilCTRL::diffEntreDataInicioEDataFinal($dataInicio, $dataFinal);

//$data = "2021-10-07";
//
//echo UtilCTRL::retornaDataPorExtenso($data);