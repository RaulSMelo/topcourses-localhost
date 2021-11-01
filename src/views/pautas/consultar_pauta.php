<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\ConsultarPautaController;

UtilCTRL::validarSessao();

    $pautaCTRL = new ConsultarPautaController();
    
    if(filter_input(INPUT_POST, "btn-buscar") !== null){
        
        $nome = "";
        $sobrenome = "";
        
        if(Input::post("nome") !== null){
            
            $nome_completo = UtilCTRL::retornaNomeEsobrenome(Input::post("nome"));
            
            $nome = trim($nome_completo["nome"]);
            $sobrenome = $nome_completo["sobrenome"] ?? "";
        }
        
        $situacao = Input::post("situacao", FILTER_SANITIZE_NUMBER_INT) ?? "";
        
        $nome = $nome_completo["nome"];
        
        $resultado = $pautaCTRL->buscarPautas($nome, $sobrenome, $situacao);
            
        if(count($resultado) > 0){

            $dadosContrato = $resultado;

        }else{

            $ret = 2;
        }
    }
    
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Consultar pauta</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Consultar pauta</h2>
                    <h5><em>Aqui você pode consultar pautas dos alunos</em></h5>
                </div>
                <div class="card-body card-body-form">

                    <div class="row">

                        <div class="col-md-12">

                            <form action="" method="POST">

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-title" for="nome">Nome</label>
                                            <input value="<?= $nome ?? "" ?> <?= $sobrenome ?? "" ?>" class="form-control form-control-sm <?= (isset($nome) && $nome != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="nome" name="nome" placeholder="Nome" autocomplete="off">
                                            <small id=msg-erro-nome class="text-danger invisible" >Por favor, informe o campo <b>nome</b></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-title" for="situacao">Situação</label>
                                            <select class="nao-obr custom-select custom-select-sm <?= (isset($situacao) && $situacao != "") ? "is-valid" : "bg-components-form" ?>" name="situacao" id="situacao">
                                                <option value="">Todos</option>
                                                <option value="<?= CANCELADO ?>" <?= isset($situacao) && $situacao == CANCELADO ? "selected" : "" ?>>Cancelado</option>
                                                <option value="<?= CONCLUIDO ?>" <?= isset($situacao) && $situacao == CONCLUIDO ? "selected" : "" ?>>Concluído</option>
                                                <option value="<?= EM_ANDAMENTO ?>" <?= isset($situacao) && $situacao == EM_ANDAMENTO ? "selected" : "" ?>>Em andamento</option>
                                            </select>
                                            <small id=msg-erro-situacao class="text-danger invisible" >Por favor, informe o campo <b>situacao</b></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <button onclick="return validarFormulario()" class="btn btn-info btn-pattern" name="btn-buscar" id="btn-buscar">Buscar</button>      
                                    </div>
                                </div>

                            </form>

                            <hr>
                            
                            <?php if(isset($dadosContrato) && count($dadosContrato) > 0): ?>

                                <div class="table-responsive">

                                    <table class="table table-striped table-dark mt-4">
                                        <thead>
                                            <tr>
                                                <th>Nomes</th>
                                                <th>Tipos de contratos</th>
                                                <th>Início e término</th>
                                                <th>Situação</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                            <?php for($i = 0; $i < count($dadosContrato); $i++):
                                                
                                                $idContrato   = $dadosContrato[$i]["id_contrato_curso"];
                                                $tipoContrato = $dadosContrato[$i]["id_tipo_contrato"];
                                                $nomeCompleto = $dadosContrato[$i]["nome"] . " " . $dadosContrato[$i]["sobrenome"];
                                                $dataInicio   = UtilCTRL::dataFormatoBR($dadosContrato[$i]["data_inicio_contrato"]);
                                                $dataFinal    = UtilCTRL::dataFormatoBR($dadosContrato[$i]["data_termino_contrato"]);
                                                $situacao     = SITUACAO_CONTRATO[$dadosContrato[$i]["situacao"]];
                                                
                                            ?>
                                            
                                                <tr>
                                                    <td class="line-nowrap"><?= $nomeCompleto ?></td>
                                                    <td class="line-nowrap"><?= TIPOS_DE_CONTRATOS[$tipoContrato] ?></td>
                                                    <td class="line-nowrap"><?= $dataInicio . " a " . $dataFinal ?></td>
                                                    <td class="line-nowrap"><?= $situacao ?></td>
                                                    <td class="line-nowrap">
                                                        <a href="pauta_aluno.php?<?= "id-contrato={$idContrato}&tipo-contrato={$tipoContrato}" ?>" class="btn btn-success btn-sm">
                                                            <i class="fas fa-search"></i>
                                                            Consultar pauta
                                                        </a>
                                                    </td>
                                                </tr>
                                            
                                            <?php endfor ?>
                                            
                                        </tbody>
                                    </table>

                                </div> <!-- table-responsive -->
                            
                            <?php endif ?>
                            
                        </div> <!-- col-12 -->
                    </div> <!-- row -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- container -->

        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>
        
    </body>
</html>


