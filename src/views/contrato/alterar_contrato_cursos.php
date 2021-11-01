<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\log\Log;
use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\TurmaController;
use Src\controllers\AgendamentoController;
use Src\controllers\ColaboradorController;
use Src\controllers\ContratoCursoController;
use Src\controllers\CadastroBasicoController;


UtilCTRL::validarTipoDeAcessoADM();



    $contratoCursoCTRL = new ContratoCursoController(false);
    $agendamentoCTRL   = new AgendamentoController(false);
    $cadBasicoCTRL     = new CadastroBasicoController();
    $turmaCTRL         = new TurmaController();
    $colaboradorCTRL   = new ColaboradorController();
    
    if(Input::post("btn-alterar") !== null) {
        
        $idContrato   = Input::post("id-contrato-curso", FILTER_SANITIZE_NUMBER_INT);
        $tipoContrato = Input::post("id-tipo-contrato", FILTER_SANITIZE_NUMBER_INT);
        $idAluno      = $_POST["id-aluno"];
        
        $contratoCursoCTRL              = new ContratoCursoController();
        
        $ret                            = $contratoCursoCTRL->alterarContratoCurso();
        
        $todosAgendamentos              = $agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato);
        
        $dataMinDisponivelSemAnotacao   = $agendamentoCTRL->buscarDataMinSemAnotacaoPauta($idContrato);
        
        $qtdeDatasComAnotacoes          = $agendamentoCTRL->buscarQtdeDatasComAnotacoes($idContrato);
        
        $array_dataInicio_ate_dataFinal = UtilCTRL::gerarDatasParaNovoAgendamento($dataMinDisponivelSemAnotacao, Input::post("data-final"));
        
        $a_combinar = (count($todosAgendamentos) == (count($array_dataInicio_ate_dataFinal) + $qtdeDatasComAnotacoes));
        
        if($ret == 1){
            
            header("LOCATION: alterar_contrato_cursos.php?id-aluno={$idAluno[0]}&id-contrato={$idContrato}&tipo-contrato={$tipoContrato}&ret={$ret}");
            exit;
            
        }else{
            
            $contrato_grupo_de_alunos = (
                    $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS ||
                    $tipoContrato == PF_GRUPO_MENSAL ||
                    $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS ||
                    $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS ||
                    $tipoContrato == PJ_GRUPO_MENSAL);

            $contrato_PF = (
                    $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS ||
                    $tipoContrato == PF_GRUPO_MENSAL ||
                    $tipoContrato == PF_INDIVIDUAL_ACIMA_DE_20_HORAS ||
                    $tipoContrato == PF_INDIVIDUAL_MENSAL ||
                    $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
                    $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS);

            $contrato_PJ = (
                    $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS ||
                    $tipoContrato == PJ_GRUPO_MENSAL ||
                    $tipoContrato == PJ_INDIVIDUAL_ACIMA_DE_20_HORAS ||
                    $tipoContrato == PJ_INDIVIDUAL_MENSAL ||
                    $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS);

            $contrato_com_dias_a_combinar = (
                $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS ||
                $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
                $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS
            );

            
            $dadosContrato                  = $contratoCursoCTRL->buscarTodosOsDadosDoContratoCursoPorID($idContrato, $tipoContrato);
            
            $todosAgendamentos              = $agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato);
        
            $dataMinDisponivelSemAnotacao   = $agendamentoCTRL->buscarDataMinSemAnotacaoPauta($idContrato);

            $qtdeDatasComAnotacoes          = $agendamentoCTRL->buscarQtdeDatasComAnotacoes($idContrato);
            
            $agendamentos                   = $agendamentoCTRL->buscarAgendamentosComHorasAgendadas($idContrato, $dataMinDisponivelSemAnotacao, $dadosContrato[0]["data_termino_contrato"]);

            $array_dataInicio_ate_dataFinal = UtilCTRL::gerarDatasParaNovoAgendamento($dataMinDisponivelSemAnotacao, $dadosContrato[0]["data_termino_contrato"]);

            $a_combinar = (count($todosAgendamentos) == (count($array_dataInicio_ate_dataFinal) + $qtdeDatasComAnotacoes));


            $professores = $colaboradorCTRL->buscarColaboradorPorTipo(PROFESSOR);
            $niveis      = $cadBasicoCTRL->buscarTodosCadastrosBasicos(NIVEL);
            $idiomas     = $cadBasicoCTRL->buscarTodosCadastrosBasicos(IDIOMA);
            $cursos      = $cadBasicoCTRL->buscarTodosCadastrosBasicos(CURSO);
            $turmas      = $turmaCTRL->buscarTodasTurmas();
              
        }

        
    }else if(Input::get("id-contrato", FILTER_SANITIZE_NUMBER_INT)   !== null && 
             Input::get("tipo-contrato", FILTER_SANITIZE_NUMBER_INT) !== null &&
             Input::get("id-aluno", FILTER_SANITIZE_NUMBER_INT)      !== null){
        
        $idContrato   = Input::get("id-contrato");
        $tipoContrato = Input::get("tipo-contrato");
        $idAluno      = Input::get("id-aluno");

        $contrato_grupo_de_alunos = (
            $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PF_GRUPO_MENSAL ||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS ||
            $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PJ_GRUPO_MENSAL);

        $contrato_PF = (
            $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PF_GRUPO_MENSAL ||
            $tipoContrato == PF_INDIVIDUAL_ACIMA_DE_20_HORAS ||
            $tipoContrato == PF_INDIVIDUAL_MENSAL ||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS);

        $contrato_PJ = (
            $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PJ_GRUPO_MENSAL ||
            $tipoContrato == PJ_INDIVIDUAL_ACIMA_DE_20_HORAS ||
            $tipoContrato == PJ_INDIVIDUAL_MENSAL ||
            $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS);

        $contrato_com_dias_a_combinar = (
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS      ||
            $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS
        );
        
         
        $dadosContrato                  = $contratoCursoCTRL->buscarTodosOsDadosDoContratoCursoPorID($idContrato, $tipoContrato);

        $todosAgendamentos              = $agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato);
        
        $dataMinDisponivelSemAnotacao   = $agendamentoCTRL->buscarDataMinSemAnotacaoPauta($idContrato);

        $qtdeDatasComAnotacoes          = $agendamentoCTRL->buscarQtdeDatasComAnotacoes($idContrato);
        
        $agendamentos                   = $agendamentoCTRL->buscarAgendamentosComHorasAgendadas($idContrato, $dataMinDisponivelSemAnotacao, $dadosContrato[0]["data_termino_contrato"]);
        
        $array_dataInicio_ate_dataFinal = UtilCTRL::gerarDatasParaNovoAgendamento($dataMinDisponivelSemAnotacao, $dadosContrato[0]["data_termino_contrato"]);
        
        $a_combinar = (count($todosAgendamentos) == (count($array_dataInicio_ate_dataFinal) + $qtdeDatasComAnotacoes));
        
        $professores = $colaboradorCTRL->buscarColaboradorPorTipo(PROFESSOR);
        $niveis      = $cadBasicoCTRL->buscarTodosCadastrosBasicos(NIVEL);
        $idiomas     = $cadBasicoCTRL->buscarTodosCadastrosBasicos(IDIOMA);
        $cursos      = $cadBasicoCTRL->buscarTodosCadastrosBasicos(CURSO);
        $turmas      = $turmaCTRL->buscarTodasTurmas();
        
    }else{
        
        (new Log("ERRO ao carregar os dados da página alterar contrato curso"))->enviarLogDeErro(new Exception);
        
        header("LOCATION: " . PAGINA_DE_ERRO);
        
        exit;

    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once '../../templates/_head.php' ?>
    <title>Alterar contrato de cursos</title>
</head>

<body class="main-body">

<?php include_once '../../templates/_menu.php' ?>

<div class="container padding-card-pattern">
    <div class="card my-3 main-card">
        
        <div class="card-header text-left mt-0 header bg-dark">
            <h2>Alterar contratos de cursos</h2>
            <h5><em>Aqui você pode alterar os contratos de cursos de PF e PJ  que ainda está em aberto </em></h5>
        </div>
        
        <div class="card-body card-body-form">

        <!--*** DADOS DE INTERESSADOS ***-->
        <div>

            <div class="row">

                <div class="col-12">
                    <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                </div>

            </div> <!-- row -->

        </div> <!-- FIM dados do aluno -->

            <section data-sessao-contrato-alterar  class="col-md-12 p-0" id="contrato-alterar-curso">

                <div class="row">

                    <div class="col-md-12">

                        <div class="card my-3 main-body border border-warning">
                            <div class="mb-3 border-bottom border-warning">
                                <h3 class="card-header bg-dark"><em>ALTERAR - <?= TIPOS_DE_CONTRATOS[$tipoContrato] ?></em></h3>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <?php  if($contrato_PF && $contrato_grupo_de_alunos): ?>

                                        <div class="col-md-12">

                                            <fieldset class="border-warning" form="form-novo-contrato">

                                                <div class="bg-dark rounded p-md-3">

                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <h3 class="text-light text-center"><?= ($contrato_grupo_de_alunos) ? "ALUNOS" : "ALUNO" ?></h3>
                                                            <hr class="border-light">
                                                        </div>
                                                    </div>

                                                    <?php for($i = 0; $i < count($dadosContrato); $i++): ?>

                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?= ($i == 0) ? "<label class='text-light lead text-center'>NOME</label>" : "" ?>
                                                                    <input class="form-control bg-transparent 7 border-0  text-light p-0 m-0" value="<?= $dadosContrato[$i]["nome"] . " " . $dadosContrato[$i]["sobrenome"] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?= ($i == 0) ? "<label class='text-light lead text-center'>EMAIL</label>" : "" ?>
                                                                    <input class="form-control bg-transparent border-0 text-light p-0 m-0" value="<?= $dadosContrato[$i]["email"] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?= ($i == 0) ? "<label class='text-light lead text-center'>TELEFONE</label>" : "" ?>
                                                                    <input class="form-control bg-transparent border-0 text-light p-0 m-0" value="<?= UtilCTRL::mascaraTelefone($dadosContrato[$i]["telefone"]) ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php endfor ?>

                                                </div>

                                            </fieldset>

                                        </div>

                                    <?php  endif ?>

                                    <?php  if($contrato_PF && !$contrato_grupo_de_alunos): ?>

                                        <div class="col-md-12">

                                            <fieldset class="border-warning" form="form-novo-contrato">

                                                <div class="bg-dark rounded p-md-3">

                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <h3 class="text-light text-center">ALUNO</h3>
                                                            <hr class="border-light">
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class='text-light lead text-center'>NOME</label>
                                                                <input class="form-control bg-transparent 7 border-0  text-light p-0 m-0" value="<?= $dadosContrato[0]["nome"] . " " . $dadosContrato[0]["sobrenome"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class='text-light lead text-center'>EMAIL</label>
                                                                <input class="form-control bg-transparent border-0 text-light p-0 m-0" value="<?= $dadosContrato[0]["email"] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class='text-light lead text-center'>TELEFONE</label>
                                                                <input class="form-control bg-transparent border-0 text-light p-0 m-0" value="<?= UtilCTRL::mascaraTelefone($dadosContrato[0]["telefone"]) ?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </fieldset>

                                        </div>

                                    <?php endif ?>

                                    <?php  if($contrato_PJ): ?>

                                        <div class="col-md-12">

                                            <fieldset class="border-warning" form="form-novo-contrato">

                                                <div class="bg-dark rounded p-md-3">

                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <h3 class="text-light text-center">DADOS DA EMPRESA</h3>
                                                            <hr class="border-light">
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <div class="form-group d-flex flex-column">
                                                                <label class="lead text-light" for="nome">Razão social</label>
                                                                <input value="<?= $dadosContrato[0]["razao_social"] ?>" type="text" class="lead bg-transparent border-0 text-light m-0 p-0" readonly >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group d-flex flex-column">
                                                                <label class="lead text-light" for="cpf">CNPJ</label>
                                                                <input value="<?= ($dadosContrato[0]["cnpj"] != "") ? UtilCTRL::mascaraCNPJ($dadosContrato[0]["cnpj"]) : "" ?>" type="text" class="lead bg-transparent border-0 text-light m-0 p-0" readonly >
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <div class="form-group d-flex flex-column">
                                                                <label class="lead text-light" for="telefone">Telefone</label>
                                                                <input value="<?= ($dadosContrato[0]["tel_empresa"] != "") ? UtilCTRL::mascaraTelefone($dadosContrato[0]["telefone"]) : ""?>" type="text" class="lead bg-transparent border-0 text-light m-0 p-0" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group d-flex flex-column">
                                                                <label class="lead text-light" for="email">Email</label>
                                                                <input value="<?= $dadosContrato[0]["email_empresa"] ?>" type="email" class="lead bg-transparent border-0 text-light m-0 p-0" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="bg-dark rounded p-md-3 mt-3">

                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <h3 class="text-light text-center"><?= ($contrato_grupo_de_alunos) ? "ALUNOS" : "ALUNO" ?></h3>
                                                            <hr class="border-light">
                                                        </div>
                                                    </div>

                                                    <?php for($i = 0; $i < count($dadosContrato); $i++): ?>

                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?= ($i == 0) ? "<label class='text-light lead text-center'>NOME</label>" : "" ?>
                                                                    <input class="form-control bg-transparent 7 border-0  text-light p-0 m-0" value="<?= $dadosContrato[$i]["nome"] . " " . $dadosContrato[$i]["sobrenome"] ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?= ($i == 0) ? "<label class='text-light lead text-center'>EMAIL</label>" : "" ?>
                                                                    <input class="form-control bg-transparent border-0 text-light p-0 m-0" value="<?= $dadosContrato[$i]["email"] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?= ($i == 0) ? "<label class='text-light lead text-center'>TELEFONE</label>" : "" ?>
                                                                    <input class="form-control bg-transparent border-0 text-light p-0 m-0" value="<?= UtilCTRL::mascaraTelefone($dadosContrato[$i]["telefone"]) ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php endfor ?>

                                                </div>

                                            </fieldset>

                                        </div>

                                    <?php endif ?>

                                </div>

                                <form id="form-alterar-contrato-curso" action="alterar_contrato_cursos.php" method="POST">
                                        
                                    <div class="row">
                                        
                                        <input value="<?= $idContrato ?>" type="hidden" name="id-contrato-curso">
                                        
                                        <input value="<?= $tipoContrato ?>" type="hidden" id="id-tipo-contrato" name="id-tipo-contrato">
                                        
                                        <input value="<?= $idAluno[0] ?>" type="hidden" name="id-aluno[]">
                                        
                                        <input value="<?= UtilCTRL::formatarHoras($dadosContrato[0]["total_horas"]) ?>"  type="hidden" name="total-horas">
                                        
                                        <input value="<?= $dadosContrato[0]["id_empresa"] ?? "" ?>" type="hidden" name="id-empresa">
                                        
                                        <input value="<?= $dadosContrato[0]["data_inicio_contrato"] ?>" type="hidden" id="data-inicio" name="data-inicio">
                                        
                                        <input value="<?= $dadosContrato[0]["data_termino_contrato"] ?>" type="hidden" id="data-final" name="data-final">
                                        
                                        <!--*** AGENDAMENTOS ***-->
                                        <div class="col-md-12">

                                            <fieldset class="border-warning" form="form-novo-contrato">

                                                <legend class="text-white">AGENDAMENTO DAS AULAS</legend>

                                                <div class="bg-dark rounded p-md-3 mb-5">
                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <div class="form-group d-flex flex-column">
                                                                <label class="lead text-light" for="total-horas">Total de horas:</label>
                                                                <input value="<?= ($dadosContrato[0]["total_horas"] != "") ? UtilCTRL::formatarHoras($dadosContrato[0]["total_horas"]) : "" ?>" type="text" class="lead bg-transparent text-light border-0  p-0 m-0" id="total-horas" name="total-horas" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group d-flex flex-column">
                                                                <label class="lead text-light" for="carga-horaria">Carga horária semanal:</label>
                                                                <input value="<?= (isset($dadosContrato[0]["carga_horaria_semanal"]) && !empty($dadosContrato[0]["carga_horaria_semanal"])) ? $dadosContrato[0]["carga_horaria_semanal"] : "" ?>" type="text" class="lead bg-transparent text-light border-0 m-0 p-0" id="carga-horaria" name="carga-horaria" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                    <?php for($i = 1; $i <= 7; $i++): ?>
                                                        
                                                        <?php if($i == 1):
                                                            
                                                            $segunda_feira = false;
                                                        
                                                            for($j = 0; $j < count($agendamentos); $j++){
                                                                
                                                                if($agendamentos[$j]["dia_da_semana"] == $i && 
                                                                   $agendamentos[$j]["hora_inicial"]  != "" && 
                                                                   $agendamentos[$j]["hora_final"]    != "")
                                                                {
                                                                    
                                                                    $segunda_feira = true;
                                                                }
                                                                
                                                                if($segunda_feira) break;
                                                            }
                                                        
                                                        
                                                        ?>

                                                            <!-- SEGUNDA-FEIRA -->
                                                            <div class="form-row align-items-center mb-2">

                                                                <div class="col-md-2">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="1" <?= ($segunda_feira) ? "checked" : "" ?> name="dia-semana[]" type="checkbox" class="custom-control-input" id="checkbox-segunda-feira">
                                                                        <label class="custom-control-label font-weight-bold font-italic <?= ($segunda_feira) ? "text-dark" : "text-white" ?>" id="label-seg" for="checkbox-segunda-feira">
                                                                            SEGUNDA-FEIRA
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-auto" id="das-seg" style="display: <?= ($segunda_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-seg-hi" style="display: <?= ($segunda_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-inicio-segunda">Hora do início</label>
                                                                    <input value="<?= ($segunda_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_inicial"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($segunda_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-inicio-segunda" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-inicio-segunda" class="text-danger invisible">Preencha o campo hora início</small>
                                                                </div>

                                                                <div class="col-md-auto" id="as-seg" style="display: <?= ($segunda_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-seg-ht" style="display: <?= ($segunda_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-termino-segunda">Hora do término</label>
                                                                    <input value="<?= ($segunda_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_final"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($segunda_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-termino-segunda" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-termino-segunda" class="text-danger invisible">Preencha o campo hora término</small>
                                                                </div>

                                                            </div>
                                                            <!--*** Fim opcao segunda-feira ***-->

                                                            <div class="form-row mr-md-2">
                                                                <div class="col-md-11">
                                                                    <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                                                </div>
                                                            </div>
                                                            
                                                        <?php elseif($i == 2): 
                                                           
                                                            $terca_feira = false;
                                                        
                                                            for($j = 0; $j < count($agendamentos); $j++){
                                                                
                                                                if($agendamentos[$j]["dia_da_semana"] == $i && 
                                                                   $agendamentos[$j]["hora_inicial"]  != "" && 
                                                                   $agendamentos[$j]["hora_final"]    != "")
                                                                {
                                                                    
                                                                    $terca_feira = true;
                                                                }
                                                                
                                                                if($terca_feira) break;
                                                            }
                                                        ?>
                                                            
                                                            <!-- TERÇA-FEIRA -->
                                                            <div class="form-row align-items-center mb-2">

                                                                <div class="col-md-2">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="2" <?= ($terca_feira) ? "checked" : "" ?> name="dia-semana[]" type="checkbox" class="custom-control-input" id="checkbox-terca-feira">
                                                                        <label class="custom-control-label font-weight-bold font-italic <?= ($terca_feira) ? "text-dark" : "text-white" ?>" id="label-ter" for="checkbox-terca-feira">
                                                                            TERÇA-FEIRA
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-auto" id="das-ter" style="display: <?= ($terca_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-ter-hi" style="display: <?= ($terca_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-inicio-terca">Hora do início</label>
                                                                    <input value="<?= ($terca_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_inicial"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($terca_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-inicio-terca" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-inicio-terca" class="text-danger invisible">Preencha o campo hora início</small>
                                                                </div>

                                                                <div class="col-md-auto" id="as-ter" style="display: <?= ($terca_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-ter-ht" style="display: <?= ($terca_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-termino-terca">Hora do término</label>
                                                                    <input value="<?= ($terca_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_final"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($terca_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-termino-terca" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-termino-terca" class="text-danger invisible">Preencha o campo hora término</small>
                                                                </div>

                                                            </div>
                                                            <!--*** Fim opcao terça-feira ***-->

                                                            <div class="form-row mr-md-2">
                                                                <div class="col-md-11">
                                                                    <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                                                </div>
                                                            </div>

                                                        <?php elseif($i == 3): 
                                                            
                                                            $quarta_feira = false;
                                                        
                                                            for($j = 0; $j < count($agendamentos); $j++){
                                                                
                                                                if($agendamentos[$j]["dia_da_semana"] == $i && 
                                                                   $agendamentos[$j]["hora_inicial"]  != "" && 
                                                                   $agendamentos[$j]["hora_final"]    != "")
                                                                {
                                                                    
                                                                    $quarta_feira = true;
                                                                }
                                                                
                                                                if($quarta_feira) break;
                                                            }
                                                        ?>
                                                            
                                                            <!-- QUARTA-FEIRA -->
                                                            <div class="form-row align-items-center mb-2">

                                                                <div class="col-md-2">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="3" <?= ($quarta_feira) ? "checked" : "" ?> name="dia-semana[]"  type="checkbox" class="custom-control-input" id="checkbox-quarta-feira">
                                                                        <label class="custom-control-label font-weight-bold font-italic <?= ($quarta_feira) ? "text-dark" : "text-white" ?>" id="label-qua" for="checkbox-quarta-feira">
                                                                            QUARTA-FEIRA
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-auto" id="das-qua" style="display: <?= ($quarta_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-qua-hi" style="display: <?= ($quarta_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-inicio-quarta">Hora do início</label>
                                                                    <input value="<?= ($quarta_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_inicial"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($quarta_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-inicio-quarta" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-inicio-quarta" class="text-danger invisible">Preencha o campo hora início</small>
                                                                </div>

                                                                <div class="col-md-auto" id="as-qua" style="display: <?= ($quarta_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-qua-ht" style="display: <?= ($quarta_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-termino-quarta">Hora do término</label>
                                                                    <input value="<?= ($quarta_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_final"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($quarta_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-termino-quarta" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-termino-quarta" class="text-danger invisible">Preencha o campo hora término</small>
                                                                </div>

                                                            </div>
                                                            <!--*** Fim opcao quarta-feira ***-->

                                                            <div class="form-row mr-md-2">
                                                                <div class="col-md-11">
                                                                    <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                                                </div>
                                                            </div>

                                                        <?php elseif($i == 4):
                                                            
                                                            $quinta_feira = false;
                                                        
                                                            for($j = 0; $j < count($agendamentos); $j++){
                                                                
                                                                if($agendamentos[$j]["dia_da_semana"] == $i && 
                                                                   $agendamentos[$j]["hora_inicial"]  != "" && 
                                                                   $agendamentos[$j]["hora_final"]    != "")
                                                                {
                                                                    
                                                                    $quinta_feira = true;
                                                                }
                                                                
                                                                if($quinta_feira) break;
                                                            }
                                                        
                                                        ?>
     
                                                            <!-- QUINTA-FEIRA -->
                                                            <div class="form-row align-items-center mb-2">

                                                                <div class="col-md-2">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="4" <?= ($quinta_feira) ? "checked" : "" ?> name="dia-semana[]"  type="checkbox" class="custom-control-input" id="checkbox-quinta-feira">
                                                                        <label class="custom-control-label font-weight-bold font-italic <?= ($quinta_feira) ? "text-dark" : "text-white" ?>" id="label-qui" for="checkbox-quinta-feira">
                                                                            QUINTA-FEIRA
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-auto" id="das-qui" style="display: <?= ($quinta_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-qui-hi" style="display: <?= ($quinta_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-inicio-quinta">Hora do início</label>
                                                                    <input value="<?= ($quinta_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_inicial"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($quinta_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-inicio-quinta" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-inicio-quinta" class="text-danger invisible">Preencha o campo hora início</small>
                                                                </div>

                                                                <div class="col-md-auto" id="as-qui" style="display: <?= ($quinta_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-qui-ht" style="display: <?= ($quinta_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-termino-quinta">Hora do término</label>
                                                                    <input value="<?= ($quinta_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_final"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($quinta_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-termino-quinta" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-termino-quinta" class="text-danger invisible">Preencha o campo hora término</small>
                                                                </div>

                                                            </div>
                                                            <!--*** Fim opcao quinta-feira ***-->

                                                            <div class="form-row mr-md-2">
                                                                <div class="col-md-11">
                                                                    <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                                                </div>
                                                            </div>

                                                        <?php elseif($i == 5): 
                                                            
                                                            $sexta_feira = false;
                                                        
                                                            for($j = 0; $j < count($agendamentos); $j++){
                                                                
                                                                if($agendamentos[$j]["dia_da_semana"] == $i && 
                                                                   $agendamentos[$j]["hora_inicial"]  != "" && 
                                                                   $agendamentos[$j]["hora_final"]    != "")
                                                                {
                                                                    
                                                                    $sexta_feira = true;
                                                                }
                                                                
                                                                if($sexta_feira) break;
                                                            }
                                                        
                                                        ?>
                                                            
                                                            <!-- SEXTA-FEIRA -->
                                                            <div class="form-row align-items-center mb-2">

                                                                <div class="col-md-2">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="5" <?= ($sexta_feira) ? "checked" : "" ?> name="dia-semana[]"  type="checkbox" class="custom-control-input" id="checkbox-sexta-feira">
                                                                        <label class="custom-control-label font-weight-bold font-italic <?= ($sexta_feira) ? "text-dark" : "text-white" ?>" id="label-sex" for="checkbox-sexta-feira">
                                                                            SEXTA-FEIRA
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-auto" id="das-sex" style="display: <?= ($sexta_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-sex-hi" style="display: <?= ($sexta_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-inicio-sexta">Hora do início</label>
                                                                    <input value="<?= ($sexta_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_inicial"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($sexta_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-inicio-sexta" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-inicio-sexta" class="text-danger invisible">Preencha o campo hora início</small>
                                                                </div>

                                                                <div class="col-md-auto" id="as-sex" style="display: <?= ($sexta_feira) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-sex-ht" style="display: <?= ($sexta_feira) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-termino-sexta">Hora do término</label>
                                                                    <input value="<?= ($sexta_feira) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_final"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($sexta_feira) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-termino-sexta" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-termino-sexta" class="text-danger invisible">Preencha o campo hora término</small>
                                                                </div>

                                                            </div>
                                                            <!--*** Fim opcao sexta-feira ***-->

                                                            <div class="form-row mr-md-2">
                                                                <div class="col-md-11">
                                                                    <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                                                </div>
                                                            </div>

                                                        <?php elseif($i == 6):
                                                            
                                                            $sabado = false;
                                                        
                                                            for($j = 0; $j < count($agendamentos); $j++){
                                                                
                                                                if($agendamentos[$j]["dia_da_semana"] == $i && 
                                                                   $agendamentos[$j]["hora_inicial"]  != "" && 
                                                                   $agendamentos[$j]["hora_final"]    != "")
                                                                {
                                                                    
                                                                    $sabado = true;
                                                                }
                                                                
                                                                if($sabado) break;
                                                            }
                                                        ?>
                                                            
                                                            <!-- SÁBADO -->
                                                            <div class="form-row align-items-center">

                                                                <div class="col-md-2">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="6" <?= ($sabado) ? "checked" : "" ?> name="dia-semana[]"  type="checkbox" class="custom-control-input" id="checkbox-sabado">
                                                                        <label class="custom-control-label font-weight-bold font-italic <?= ($sabado) ? "text-dark" : "text-white" ?>" id="label-sab" for="checkbox-sabado">
                                                                            SÁBADO
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-auto" id="das-sab" style="display: <?= ($sabado) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-sab-hi" style="display: <?= ($sabado) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-inicio-sabado">Hora do início</label>
                                                                    <input value="<?= ($sabado) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_inicial"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($sabado) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-inicio-sabado" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-inicio-sabado" class="text-danger invisible">Preencha o campo hora início</small>
                                                                </div>

                                                                <div class="col-md-auto" id="as-sab" style="display: <?= ($sabado) ? "block" : "none" ?>">
                                                                    <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                                                </div>

                                                                <div class="col-md-4" id="div-sab-ht" style="display: <?= ($sabado) ? "block" : "none" ?>">
                                                                    <label class="sr-only" for="hora-termino-sabado-contrato-pf-individual-mensal">Hora do término</label>
                                                                    <input value="<?= ($sabado) ? UtilCTRL::formatarHoras($agendamentos[$j]["hora_final"]) : "" ?>" maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="obr form-control form-control-sm <?= ($sabado) ? "is-valid" : "campo-obrigatorio" ?>" id="hora-termino-sabado" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                                                    <small id="msg-erro-hora-termino-sabado" class="text-danger invisible">Preencha o campo hora término</small>
                                                                </div>

                                                            </div>
                                                            <!--*** Fim opcao sábado ***-->


                                                            <div class="form-row mt-md-2 mr-md-2">
                                                                <div class="col-md-11">
                                                                    <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                                                </div>
                                                            </div>
                                                            
                                                        <?php elseif($i == 7): ?>

                                                            <?php if($contrato_com_dias_a_combinar): ?>

                                                                <div class="form-row align-items-center mt-2">
                                                                    <div class="col-md-2">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input <?= ($a_combinar) ? "checked" : "" ?> type="checkbox" class="custom-control-input" id="checkbox-a-combinar" name="dia-semana[]" value="a-combinar">
                                                                            <label class="custom-control-label font-weight-bold font-italic text-white" for="checkbox-a-combinar">
                                                                                A COMBINAR
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            <?php endif ?>
                                                            
                                                        <?php endif ?>

                                                    <?php endfor ?>
                                                        
                                            </fieldset>

                                            <div id="msg-alerta-hora-agendamento" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 

                                        </div><!-- FIM col-md-12 agendamentos -->


                                        <!-- INFORMAÇÕES ADICIONAIS -->
                                        <div class="col-md-12">

                                            <fieldset form="form-alterar-contrato-curso" class="border border-warning">

                                                <legend class="text-uppercase text-white">Informações adicionais</legend>

                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="input-title text-warning" for="id-professor">Professor</label>
                                                            <select class="custom-select custom-select-sm <?= ($dadosContrato[0]["id_professor"] != "") ? "is-valid" : "bg-components-form" ?>" id="id-professor" name="id-professor">
                                                                <option value="">Selecione...</option>
                                                                
                                                                <?php for ($i = 0; $i < count($professores); $i++) : ?>
                                                                    <option value="<?= $professores[$i]["id_colaborador"] ?>" <?= ($dadosContrato[0]["id_professor"] != "" && $dadosContrato[0]["id_professor"] == $professores[$i]["id_colaborador"]) ? "selected" : "" ?>><?= $professores[$i]["nome"] . " " . $professores[$i]["sobrenome"] ?></option>
                                                                <?php endfor ?>
                                                                    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="input-title text-warning" for="id-nivel">Nível</label>
                                                            <select class="custom-select custom-select-sm <?= ($dadosContrato[0]["id_nivel"] != "") ? "is-valid" : "bg-components-form" ?>" id="id-nivel" name="id-nivel">
                                                                <option value="">Selecione...</option>
                                                                
                                                                <?php for ($i = 0; $i < count($niveis); $i++) : ?>
                                                                    <option value="<?= $niveis[$i]["id_cadastro_basico"] ?>" <?= ($dadosContrato[0]["id_nivel"] != "" && $dadosContrato[0]["id_nivel"] == $niveis[$i]["id_cadastro_basico"]) ? "selected" : "" ?>><?= $niveis[$i]["nome_cadastro"] ?></option>
                                                                <?php endfor ?>
                                                                    
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="input-title text-warning" for="id-turma">Turma</label>
                                                            <select class="custom-select custom-select-sm <?= ($dadosContrato[0]["id_turma"] != "") ? "is-valid" : "bg-components-form" ?>" id="id-turma" name="id-turma">
                                                                <option value="">Não tem vínculo com turma</option>
                                                                
                                                                <?php for ($i = 0; $i < count($turmas); $i++) : ?>
                                                                    <option value="<?= $turmas[$i]["id_turma"] ?>" <?= ($dadosContrato[0]["id_turma"] != "" && $dadosContrato[0]["id_turma"] == $turmas[$i]["id_turma"]) ? "selected" : "" ?>><?= $turmas[$i]["nome_turma"] ?></option>
                                                                <?php endfor ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="input-title text-warning" for="material">Material</label>
                                                            <textarea class="form-control form-control-sm <?= ($dadosContrato[0]["material"] != "") ? "is-valid" : "bg-components-form"  ?>" style="resize: none" rows="5" id="material" name="material" placeholder="Anotações sobre material" autocomplete="off"><?= $dadosContrato[0]["material"] ?? "" ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="input-title text-warning" for="programa">Programa</label>
                                                            <textarea class="form-control form-control-sm <?= ($dadosContrato[0]["programa"] != "") ? "is-valid" : "bg-components-form" ?>" style="resize: none" rows="5" id="programa" name="programa" placeholder="Anotações sobre programa" autocomplete="off"><?= $dadosContrato[0]["programa"] ?? "" ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="input-title text-warning" for="situacao">Situação</label>
                                                            <select class="custom-select custom-select-sm <?= ($dadosContrato[0]["situacao"] != "") ? "is-valid" : "bg-components-form" ?>" id="situacao" name="situacao" >
                                                                <option value="">Selecione...</option>
                                                                <option value="<?= CANCELADO ?>" <?= $dadosContrato[0]["situacao"] == CANCELADO ? "selected" : "" ?>>Cancelado</option>
                                                                <option value="<?= CONCLUIDO ?>" <?= $dadosContrato[0]["situacao"] == CONCLUIDO ? "selected" : "" ?>>Concluído</option>
                                                                <option value="<?= EM_ANDAMENTO ?>" <?= $dadosContrato[0]["situacao"] == EM_ABERTO ? "selected" : "" ?>>Em andamento</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="input-title text-warning" for="marcacao-geral">Marcações gerais de alterações</label>
                                                            <textarea class="form-control form-control-sm <?= ($dadosContrato[0]["marcacao_geral"] != "") ? "is-valid" : "bg-components-form" ?>" style="resize: none" rows="5" id="marcacao-geral" name="marcacao-geral" placeholder="Marcações gerais"><?= $dadosContrato[0]["marcacao_geral"] ?? "" ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </fieldset>

                                        </div> <!-- FIM col-md-12 informações adicionais -->

                                        <div class="col-md-12">
                                            <div class="modal-footer border-0 pr-0">
                                                <a href="consultar_historico_contrato.php?cod=<?= $idAluno ?? "" ?>" class="btn btn-dark btn-pattern">
                                                    <i class="fas fa-arrow-left mr-2"></i>
                                                    Voltar
                                                </a>
                                                <button onclick="return validarFormulario(event)" class="btn btn-success btn-pattern" type="submit" name="btn-alterar" id="btn-salvar">Alterar</button>
                                            </div>
                                        </div>

                                    </div> <!-- row corpo do card  -->

                                </form> <!-- form-->

                            </div> <!-- card-body  -->

                        </div> <!-- card -->

                    </div><!-- col-md-12 -->

                </div> <!-- row -->

            </section> <!-- FIM Sessão alterar contrato -->

        </div> <!-- card-body -->
        
    </div> <!-- card -->
    
</div> <!-- container -->


<!-- inclui os scripts globais -->
<?php include_once "../../templates/_script.php"?>
<script src="../../assets/my-functions-js/agendamento.js"></script>
<script src="../../assets/my-functions-js/validacoes_campos_contratos.js"></script>
<script src="../../assets/my-functions-js/validar_formulario.js"></script>
<script src="../../assets/my-functions-js/util.js"></script>

</body>
</html>