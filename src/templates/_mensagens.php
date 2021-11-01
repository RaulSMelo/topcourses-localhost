<?php

use Src\erro\Erro;

if (filter_input(INPUT_GET, "ret") !== null) {

    $ret = filter_input(INPUT_GET, "ret");
}

if (isset($ret)) {


    $mensagem = Erro::getErro()[0] ?? "";

    switch ($ret) {
        case -1:
            echo "<div class='alert alert-danger border border-danger font-weight-bold mt-md-3 mb-md-4'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    {$mensagem}
                  </div>";
            break;
        case "0":
            echo "<div class='alert alert-warning border border-warning font-weight-bold mt-md-3 mb-md-4'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    {$mensagem}
                  </div>";
            break;
        case 1:
            echo "<div class='alert alert-success border border-success closed font-weight-bold mt-md-3 mb-md-4'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    Operação realizada com sucesso
                  </div>";
            break;
        case 2:
            echo "<div class='alert alert-info border border-info closed font-weight-bold mt-md-3 mb-md-4'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    Não existe nenhum registro com base nesse filtro
                  </div>";
            break;
        case 3:
            echo "<div class='alert alert-info border border-info closed font-weight-bold mt-md-3 mb-md-4'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    {$mensagem}
                  </div>";
            break;
    }
}
