<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\InteressadoController;
use Src\controllers\ConsultarHistoricoContratoController;
use Src\input\Input;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

    if(Input::get("cod", FILTER_SANITIZE_NUMBER_INT) !== null){
        
        $interessadoCTRL = new InteressadoController();
        $consultarHistoricoContratoCTRL = new ConsultarHistoricoContratoController();
        
        $idAluno = Input::get("cod");
        
        $interessado = $interessadoCTRL->buscarInteressadoPorId($idAluno);
        
        $dados_contrato = $consultarHistoricoContratoCTRL->consultarHistoricoContrato($idAluno);
        
        
    }


?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Consultar histórico de contratos</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Consultar histórico do cliente: <?= $interessado["nome"] ?? "" ?> <?= $interessado["sobrenome"] ?? "" ?></h2>
                    <h5><em>Aqui você consulta todos os contratos realizados do aluno selecionando</em></h5>
                </div>
                <div class="card-body card-body-form">

                    <div class="row">

                        <div class="col-12">
                            
                            <?php if(isset($dados_contrato) && count($dados_contrato) > 0): ?>

                                <div class="table-responsive">

                                    <table class="table table-striped table-dark mt-4 ">
                                        <thead>
                                            <tr>
                                                <th class="line-nowrap">Data Inicial</th>
                                                <th class="line-nowrap">Data final</th>
                                                <th class="line-nowrap">Tipo de contrato</th>
                                                <th class="line-nowrap">Situação</th>
                                                <th class="line-nowrap">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            
                                                for($i = 0; $i < count($dados_contrato); $i++): 

                                                    $contratoRevTrad = (
                                                            $dados_contrato[$i]["tipo_contrato"] == CONTRATO_REVISAO ||
                                                            $dados_contrato[$i]["tipo_contrato"] == CONTRATO_TRADUCAO
                                                        );

                                                ?>
                                                    <tr>

                                                        <td class="line-nowrap"><?= ($dados_contrato[$i]["data_inicio"] != "") ? UtilCTRL::dataFormatoBR($dados_contrato[$i]["data_inicio"]) : "" ?></td>
                                                        <td class="line-nowrap"><?= ($dados_contrato[$i]["data_final"]  != "") ? UtilCTRL::dataFormatoBR($dados_contrato[$i]["data_final"])  : "" ?></td>
                                                        <td class="line-nowrap"><?= TIPOS_DE_CONTRATOS[$dados_contrato[$i]["tipo_contrato"]] ?></td>
                                                        <td class="line-nowrap"><?= SITUACAO_CONTRATO[$dados_contrato[$i]["situacao"]] ?></td>
                                                        <td class="line-nowrap">
                                                            <a href="<?= ($contratoRevTrad) ? "alterar_contrato_rev_trad.php?id={$dados_contrato[$i]["id_contrato"]}" : "alterar_contrato_cursos.php?id-aluno={$idAluno}&id-contrato={$dados_contrato[$i]["id_contrato"]}&tipo-contrato={$dados_contrato[$i]["tipo_contrato"]}" ?>" class="btn btn-warning btn-sm">
                                                                <i class="fas fa-pencil-alt"></i>
                                                                Alterar
                                                            </a>

                                                            <?php if(!$contratoRevTrad): ?>
                                                                <a href="../pautas/pauta_aluno.php?id-contrato=<?= "{$dados_contrato[$i]["id_contrato"]}&tipo-contrato={$dados_contrato[$i]["tipo_contrato"]}" ?>" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-clipboard-list"></i>
                                                                    Acessar pauta
                                                                </a>
                                                            
                                                                <a href="<?= UtilCTRL::gerarCaminhoParaPDF($dados_contrato[$i]["tipo_contrato"]) . $dados_contrato[$i]["id_contrato"] ?>" target="_blank" class="btn btn-danger btn-sm">
                                                                    <i class="far fa-file-pdf mr-md-1"></i>
                                                                    PDF
                                                                </a>
                                                                
                                                            <?php endif ?>
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


