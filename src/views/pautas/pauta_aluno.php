<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\input\Input;
use Src\controllers\ContratoCursoController;
use Src\controllers\AgendamentoController;
use Src\controllers\PautaAlunoController;
use Src\controllers\AnotacaoAulaController;
use Src\traits\UtilCTRL;

UtilCTRL::validarSessao();

    if(Input::get("id-contrato", FILTER_SANITIZE_NUMBER_INT)   !== null &&
       Input::get("tipo-contrato", FILTER_SANITIZE_NUMBER_INT) !== null)
    {
        $contratoCursoCTRL = new ContratoCursoController(false);
        $agendamentoCTRL   = new AgendamentoController(false);
        $pautaCTRL         = new PautaAlunoController();
        $anotacaoAulaCTRL  = new AnotacaoAulaController(false);
        
        $idContrato   = Input::get("id-contrato");
        $tipoContrato = Input::get("tipo-contrato");
        
        $contrato_grupo_de_alunos = (
                
                $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS ||
                $tipoContrato == PF_GRUPO_MENSAL            ||
                $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS ||
                $tipoContrato == PJ_GRUPO_MENSAL            ||
                $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS

        );

        $contrato_PF = (
                
                $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS          ||
                $tipoContrato == PF_GRUPO_MENSAL                     ||
                $tipoContrato == PF_INDIVIDUAL_ACIMA_DE_20_HORAS     ||
                $tipoContrato == PF_INDIVIDUAL_MENSAL                ||
                $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
                $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS
        );

        $contrato_PJ = (
                
                $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS          ||
                $tipoContrato == PJ_GRUPO_MENSAL                     ||
                $tipoContrato == PJ_INDIVIDUAL_ACIMA_DE_20_HORAS     ||
                $tipoContrato == PJ_INDIVIDUAL_MENSAL                ||
                $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS
        );
        
        $dadosContrato    = $contratoCursoCTRL->buscarTodosOsDadosDoContratoCursoPorID($idContrato, $tipoContrato);
        $agendamentos     = $agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato);
        $mesesAgendamento = UtilCTRL::retornaQtdeDatasAgendadasPorMes($agendamentos);
        $anotacoesPauta   = $pautaCTRL->buscarAnotacaoProfessorPorId($idContrato);
        $anotacoesAulas   = $anotacaoAulaCTRL->buscarTodasAnotacoesDasAulasPorIdDoContrato($idContrato);
        
        $datas = (count($agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato, true)) == 7) ? true : $agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato, true);
        
    }

?>

<!DOCTYPE html>
<html>
<head lang="pt-br">
    <?php include_once '../../templates/_head.php' ?>
    <title>Pauta de alunos</title>
</head>

<body class="main-body">

    <?php include_once '../../templates/_menu.php' ?>

    <div class="container padding-card-pattern">
        <div class="card my-3 main-card">
            <div class="card-header text-left mt-0 header bg-dark">
                <h2>Pauta de alunos</h2>
                <h5><em>Acompanhamento e anotações de conteúdo das aulas</em></h5>
            </div>
            <div class="card-body card-body-form">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label col-form-label-sm">Year:</label>
                            <div class="col-sm-8">
                                <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?=(isset($dadosContrato[0]["data_inicio_contrato"]) && isset($dadosContrato[0]["data_termino_contrato"])) ? UtilCTRL::retornaAnoContrato($dadosContrato[0]["data_inicio_contrato"], $dadosContrato[0]["data_termino_contrato"]) : "" ?>" name="ano" id="ano">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label col-form-label-sm">Student:</label>
                            
                            <?php if($contrato_grupo_de_alunos): ?>
                                <div class="col-md-8 d-inline">
                                    <?php for($i = 0; $i < count($dadosContrato); $i++): ?>
                                        <a href="#" onclick="buscarDadosDoAlunoPauta(event)" data-id="<?= $dadosContrato[$i]["id_interessado"] ?>" class="input-pauta-alunos text-secondary font-weight-bold text-uppercase" data-toggle="modal" data-target="#modal-dados-pauta-aluno"><?= (isset($dadosContrato[$i]["nome"]) && isset($dadosContrato[$i]["sobrenome"])) ? $dadosContrato[$i]["nome"] . " " . $dadosContrato[$i]["sobrenome"] : "" ?><?= ($i < count($dadosContrato) - 1) ? "<span class='text-dark font-weight-bold'>,</span> " : "<span class='text-dark font-weight-bold'>.</span>"  ?></a>
                                    <?php endfor ?>
                                </div>
                            <?php else: ?>
                                <div class="col-md-8">
                                    <input readonly type="text" class="form-control form-control-sm input-pauta-alunos font-weight-bold text-uppercase" value="<?= (isset($dadosContrato[0]["nome"]) && isset($dadosContrato[0]["sobrenome"])) ? $dadosContrato[0]["nome"] . " " . $dadosContrato[0]["sobrenome"] : "" ?>" name="estudante" id="estudante">
                                </div>
                            <?php endif ?>
                            
                        </div>
                    </div>

                    <?php if(!$contrato_grupo_de_alunos): ?>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label col-form-label-sm">Email:</label>
                                <div class="col-sm-8">
                                    <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?= $dadosContrato[0]["email"] ?? "" ?>" name="email" id="email">
                                </div>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label col-form-label-sm">Teacher:</label>
                            <div class="col-sm-8">
                                <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?= $dadosContrato[0]["prof_nome"] ?? "" ?> <?= $dadosContrato[0]["prof_sobrenome"] ?? ""  ?>" name="prefessor" id="professor">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label col-form-label-sm">Day/Time:</label>
                            
                                <?php if(is_bool($datas)): ?>
                                    <div class="col-md-8">
                                        <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="A combinar" name="dia-hora" id="dia-hora">
                                    </div>
                                <?php elseif(is_array($datas)): ?>

                                <div class="col-md-8">
                                    <table>
                                        <tbody>

                                            <?php for($i = 0; $i < count($datas); $i++): ?>

                                                <tr>
                                                    <td class="line-nowrap">
                                                        <span style="color: #495057"><?= DIAS_DA_SEMANA[$datas[$i]["dia_da_semana"]] ?></span>
                                                    </td>
                                                    <td class="line-nowrap">
                                                        <span style="margin: 1rem; color: #495057">das</span>
                                                    </td>
                                                    <td class="line-nowrap">
                                                        <span style="color: #495057"><?= (!empty($datas[$i]["hora_inicial"])) ? UtilCTRL::formatarHoras($datas[$i]["hora_inicial"]) : "" ?></span>
                                                    </td>
                                                    <td>
                                                        <span style="margin: 1rem; color: #495057">às</span>
                                                    </td>
                                                    <td class="line-nowrap">
                                                        <span style="color: #495057"><?= (!empty($datas[$i]["hora_final"])) ? UtilCTRL::formatarHoras($datas[$i]["hora_final"]) : "" ?></span>
                                                    </td>
                                                </tr>

                                            <?php endfor ?>

                                            </tbody>
                                        </table>
                                    </div>

                                <?php endif ?>

                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label col-form-label-sm">Course/Level:</label>
                            <div class="col-sm-8">
                                <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?= (isset($dadosContrato[0]["curso"]) && isset($dadosContrato[0]["nivel"])) ? $dadosContrato[0]["curso"] . "/" .  $dadosContrato[0]["nivel"] : "" ?>" name="curso-nivel" id="curso-nivel">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Marerial:</label>
                            <div class="col-sm-10">
                                <textarea readonly type="text" class="form-control form-control-sm input-pauta-alunos"  name="material" id="material"><?= (isset($dadosContrato[0]["material"]) && $dadosContrato[0]["material"] != "") ? $dadosContrato[0]["material"] : "" ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label col-form-label-sm">Programme:</label>
                            <div class="col-sm-10">
                                <textarea readonly type="text" class="form-control form-control-sm input-pauta-alunos"  name="programa" id="programa"><?= (isset($dadosContrato[0]["programa"]) && $dadosContrato[0]["programa"] != "") ?  $dadosContrato[0]["programa"] : "" ?></textarea>
                            </div>
                        </div>
                    </div>

                    <?php if(!$contrato_grupo_de_alunos): ?>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label col-form-label-sm">Phone:</label>
                                <div class="col-sm-8">
                                    <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?= (isset($dadosContrato[0]["telefone"]) && !empty($dadosContrato[0]["telefone"])) ? UtilCTRL::mascaraTelefone($dadosContrato[0]["telefone"]) : "" ?>" name="telefone" id="telefone">
                                </div>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if(!$contrato_grupo_de_alunos): ?>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label col-form-label-sm">Birthday:</label>
                                <div class="col-sm-8">
                                    <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?= (isset($dadosContrato[0]["data_nascimento"]) && !empty($dadosContrato[0]["data_nascimento"])) ? UtilCTRL::dataFormatoBR($dadosContrato[0]["data_nascimento"]) : "" ?>" name="aniversario" id="aniversario">
                                </div>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if(!$contrato_grupo_de_alunos): ?>

                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label col-form-label-sm">Job:</label>
                                <div class="col-sm-8">
                                    <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?= $dadosContrato[0]["profissao"] ?? "" ?>" name="profissao" id="profissao">
                                </div>
                            </div>
                        </div>

                    <?php endif ?>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label col-form-label-sm">Tipo de contrato:</label>
                            <div class="col-sm-8">
                                <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?= TIPOS_DE_CONTRATOS[$tipoContrato] ?>" name="tipo-contato" id="tipo-contato">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label col-form-label-sm">Data início e término:</label>
                            <div class="col-sm-8">
                                <input readonly type="text" class="form-control form-control-sm input-pauta-alunos" value="<?= (isset($dadosContrato[0]["data_inicio_contrato"]) && !empty($dadosContrato[0]["data_inicio_contrato"]) && isset($dadosContrato[0]["data_termino_contrato"]) && !empty($dadosContrato[0]["data_termino_contrato"])) ? UtilCTRL::dataFormatoBR($dadosContrato[0]["data_inicio_contrato"]) .  " a " .  UtilCTRL::dataFormatoBR($dadosContrato[0]["data_termino_contrato"]) : "" ?>" name="dtInicio-dtTermino" id="dtInicio-dtTermino">
                            </div>
                        </div>
                    </div>

                </div> <!-- row -->
            </div> <!-- card-body -->
        </div> <!-- card -->

        <div class="card my-3 border border-dark">

            <div class="card-header d-flex justify-content-between mt-0 header bg-dark">
                <h5 class="text-white">Anotações do professor</h5>
                <h5 class="text-white">Ano: <?= (isset($dadosContrato[0]["data_inicio_contrato"]) && isset($dadosContrato[0]["data_termino_contrato"])) ? UtilCTRL::retornaAnoContrato($dadosContrato[0]["data_inicio_contrato"], $dadosContrato[0]["data_termino_contrato"]) : "" ?></h5>
            </div>

            <div class="card-body card-body-form">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="d-md-flex">
                            <div>
                                <i class="fas fa-circle mr-1 text-danger"></i>
                                <span class="font-italic mr-3"><b>A</b>-Absent</span>
                            </div>
                            <div>
                                <i class="fas fa-circle mr-1 text-orange"></i>
                                <span class="font-italic mr-3"><b>H</b>-Holiday</span>
                            </div>
                            <div>
                                <i class="fas fa-circle mr-1 text-warning"></i>
                                <span class="font-italic mr-3"><b>R</b>-Reschedule this lesson</span>
                            </div>
                            <div>
                                <i class="fas fa-circle mr-1 text-success"></i>
                                <span class="font-italic mr-3"><b>OK</b>-Lesson taught</span>
                            </div>
                            <div>
                                <i class="fas fa-circle mr-1 text-info"></i>
                                <span class="font-italic mr-3"><b>VT</b>-Vacation Time</span>
                            </div>
                            <div>
                                <i class="fas fa-eraser mr-1 text-darkcyan"></i>
                                <span class="font-italic mr-3">Delete option</span>
                            </div>
                        </div>
                        
                        <div id="msg-alerta-pauta-aluno" class="alert alert-danger mensagem-alerta invisible mt-3" role="alert"></div>
                        
                        <?php foreach ($mesesAgendamento as $key => $value): ?>
                        
                            <div data-meses class="table-responsive-md scrollbar overflow-x">

                                <table class="table table-bordered table-dark mt-4 ">
                                    
                                    <thead>
                                        <tr>
                                            <?php
                                                
                                                $cor_titulo_tabela = "";
                                                
                                                if($key == "01" || $key == "04" || $key == "07" || $key == "10"){
                                                    
                                                    $cor_titulo_tabela = "bg-darkgreen";
                                                    
                                                }else if($key == "02" || $key == "05" || $key == "08" || $key == "11"){
                                                    
                                                    $cor_titulo_tabela = "bg-indigo";
                                                    
                                                }else if($key == "03" || $key == "06" || $key == "09" || $key == "12"){
                                                    
                                                    $cor_titulo_tabela = "bg-darkmagenta";
                                                    
                                                }
                                            ?>
                                            <th colspan="<?= (count(UtilCTRL::retornaTotalDiasAgendadosNoMes($agendamentos, $key)["mes"]) + 1) ?>" class="text-md-center text-sm-left <?= $cor_titulo_tabela ?>"><?= NOME_DOS_MESES_DO_ANO[$key] ?></th>
                                        </tr>   
                                    </thead>
                                    <tbody>
                                        
                                        <?php for($j = 0; $j < count($dadosContrato); $j++): 
                                           
                                            if($j == 0){
                                                
                                                $diasAgendadosDoMes = UtilCTRL::retornaTotalDiasAgendadosNoMes($agendamentos, $key);
                                                
                                                ksort($diasAgendadosDoMes["mes"]);
                                            }
                                            
                                        ?>
                                           
                                            <tr>
                                                <?php $i = 1 ?>
                                                
                                                <?php foreach ($diasAgendadosDoMes["mes"] as $dia => $mes): ?>
                                                    
                                                    <?php if($j == 0 && $i == 1):?>
                                                        <td class="text-center">Nome</td>
                                                        <td class="text-center"><?= $dia; $i++; ?></td>
                                                    <?php elseif($j == 0 && $i > 1): ?>
                                                        <td class="text-center"><?= $dia ?></td>
                                                    <?php endif ?>
                                                        
                                                <?php endforeach ?>   
                                            </tr>                
                                            <tr>
                                                <?php $i = 0 ?>
                                                
                                                <?php foreach ($diasAgendadosDoMes["mes"] as $dia => $mes): ?>

                                                    <?php if($i == 0): ?>

                                                        <?php if(isset($dadosContrato[$j]["nome"]) && isset($dadosContrato[$j]["sobrenome"])): ?>
                                                
                                                            <td class="line-nowrap">
                                                                <?= $dadosContrato[$j]["nome"] . " " . $dadosContrato[$j]["sobrenome"] ?>
                                                                <input value="<?= $dadosContrato[$j]["id_interessado"] ?>" type="hidden" name="id-aluno">
                                                            </td>
                                                            <td class="celula-anotacao text-center">
                                                                
                                                                <input value="<?= $diasAgendadosDoMes["id-agendamento"][$i] ?>" type="hidden" name="id-agendamento">
                                                                
                                                                <ul class="navbar-nav mr-auto">
                                                                    <li class="nav-item dropdown">

                                                                        <?php $encontrouAnotacao = false ?>
                                                                        
                                                                        <?php if(isset($anotacoesPauta) && count($anotacoesPauta) > 0): ?>

                                                                            <?php foreach ($anotacoesPauta as $anotacao):  ?>

                                                                                <?php $encontrouAnotacao = false ?>

                                                                                <?php if($dadosContrato[$j]["id_interessado"] == $anotacao["id_aluno"] && $diasAgendadosDoMes["id-agendamento"][$i] == $anotacao["id_agendamento"]): ?>

                                                                                    <input value="<?= $anotacao["id_pauta_aluno"] ?>" type="hidden" name="id-pauta-aluno">

                                                                                    <a class="nav-link link <?= ANOTACOES_DO_PROFESSOR[$anotacao["anotacoes_professor"]]["cor"] ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        <?= ANOTACOES_DO_PROFESSOR[$anotacao["anotacoes_professor"]]["letra"] ?>
                                                                                    </a>
                                                                                    
                                                                                    <?php $encontrouAnotacao = true ?>

                                                                                <?php endif ?>

                                                                                <?php if($encontrouAnotacao){ break; }?>

                                                                            <?php endforeach  ?>

                                                                        <?php endif ?>
                                                                                    
                                                                        <?php if(!$encontrouAnotacao): ?>
                                                                        
                                                                            <a class="nav-link link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="fas fa-chevron-down"></i>
                                                                            </a>
                                                                        
                                                                        <?php endif ?>
                                                                                    
                                                                        <div class="dropdown-menu opcao" aria-labelledby="navbarDropdown">
                                                                            <a data-id="0" class="dropdown-item bg-danger" href="#">A</a>
                                                                            <a data-id="1" class="dropdown-item bg-orange" href="#">H</a>
                                                                            <a data-id="2" class="dropdown-item bg-success" href="#">OK</a>
                                                                            <a data-id="3" class="dropdown-item bg-warning" href="#">R</a>
                                                                            <a data-id="4" class="dropdown-item bg-info" href="#">VT</a>
                                                                            <a data-id="5" class="dropdown-item bg-apagar-anotacao" href="#">
                                                                                <i class="fas fa-eraser"></i>
                                                                            </a>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                            
                                                        <?php endif ?>

                                                        <?php else: ?>        

                                                            <td class="celula-anotacao text-center">
                                                                
                                                                <input value="<?= $diasAgendadosDoMes["id-agendamento"][$i] ?>" type="hidden" name="id-agendamento">
                                                                
                                                                <ul class="navbar-nav mr-auto">
                                                                    <li class="nav-item dropdown">
                                                                        
                                                                        <?php $encontrouAnotacao = false ?>

                                                                            <?php if(isset($anotacoesPauta) && count($anotacoesPauta) > 0): ?>

                                                                                <?php foreach ($anotacoesPauta as $anotacao):  ?>

                                                                                    <?php $encontrouAnotacao = false ?>

                                                                                    <?php if($dadosContrato[$j]["id_interessado"] == $anotacao["id_aluno"] && $diasAgendadosDoMes["id-agendamento"][$i] == $anotacao["id_agendamento"]): ?>

                                                                                        <input value="<?= $anotacao["id_pauta_aluno"] ?>" type="hidden" name="id-pauta-aluno">

                                                                                        <a class="nav-link link <?= ANOTACOES_DO_PROFESSOR[$anotacao["anotacoes_professor"]]["cor"] ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            <?= ANOTACOES_DO_PROFESSOR[$anotacao["anotacoes_professor"]]["letra"] ?>
                                                                                        </a>

                                                                                        <?php $encontrouAnotacao = true ?>

                                                                                    <?php endif ?>

                                                                                    <?php if($encontrouAnotacao) break; ?>

                                                                                <?php endforeach  ?>

                                                                            <?php endif ?>
                                                                                    
                                                                        <?php if(!$encontrouAnotacao): ?>
                                                                        
                                                                            <a class="nav-link link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="fas fa-chevron-down"></i>
                                                                            </a>
                                                                        
                                                                        <?php endif ?>
                                                                                    
                                                                        <div class="dropdown-menu opcao" aria-labelledby="navbarDropdown">
                                                                            <a data-id="0" class="dropdown-item bg-danger" href="#">A</a>
                                                                            <a data-id="1" class="dropdown-item bg-orange" href="#">H</a>
                                                                            <a data-id="2" class="dropdown-item bg-success" href="#">OK</a>
                                                                            <a data-id="3" class="dropdown-item bg-warning" href="#">R</a>
                                                                            <a data-id="4" class="dropdown-item bg-info" href="#">VT</a>
                                                                            <a data-id="5" class="dropdown-item bg-apagar-anotacao" href="#">
                                                                                <i class="fas fa-eraser"></i>
                                                                            </a>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>

                                                        <?php endif ?>

                                                    <?php $i++; endforeach ?>

                                                </tr>
                                                    
                                            <?php endfor ?>

                                        </tbody>      
                                    </table>
                                </div>
                        
                            <?php endforeach ?>

                    </div> <!-- col-sm-12 -->
                </div> <!-- row -->
            </div> <!-- card-body -->
        </div> <!-- card -->

        <div class="card my-3 border border-dark">
            <div class="card-header text-left mt-0 header bg-dark">
                <h5 class="text-white">Informações adicionais sobre as liçoes</h5>
            </div>
            <div class="card-body card-body-form">
                <div class="row">
                    <div class="col-sm-12">
                        <form>
                            
                            <input value="<?= $idContrato ?>" type="hidden" id="id-contrato" name="id-contrato">
                            
                            <input value="<?= $tipoContrato ?>" type="hidden" name="tipo-contrato">
                            
                            <table id="tabela-lesson-given" class="table table-responsive-sm table-bordered table-dark mt-4 ">
                                <thead>
                                    <tr>
                                        <th class="text-center bg-success">Date</th>
                                        <th class="text-center bg-info">Lesson Given</th>
                                        <th class="text-center bg-indigo">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    
                                    <?php for($i = 0; $i < count($agendamentos); $i++): ?>
                                    
                                        <tr>
                                            <td class="align-middle"><?= UtilCTRL::dataFormatoBR($agendamentos[$i]["data_dia_semana"]) ?></td>
                                            <td>
                                                <input value="<?= UtilCTRL::retornaAnotacoesDaAula($anotacoesAulas, $agendamentos[$i]["id_agendamento"])["id_anotacao_aula"] ?? "" ?>" type="hidden" name="id-anotacao-aula">
                                                <input value="<?= $agendamentos[$i]["id_agendamento"] ?>" type="hidden" name="id-agendamento-anotacao-aula">
                                                <div class="area-anotacoes-aula" contenteditable="true"><?= UtilCTRL::retornaAnotacoesDaAula($anotacoesAulas, $agendamentos[$i]["id_agendamento"])["anotacoes_aula"] ?? "" ?></div>
                                                <div data-msg-alerta class="alert alert-danger mensagem-alerta invisible mt-3" role="alert"></div>
                                            </td>
                                            <td class="align-middle">
                                                <?php if(isset(UtilCTRL::retornaAnotacoesDaAula($anotacoesAulas, $agendamentos[$i]["id_agendamento"])["id_anotacao_aula"]) && !empty(UtilCTRL::retornaAnotacoesDaAula($anotacoesAulas, $agendamentos[$i]["id_agendamento"])["id_anotacao_aula"])): ?>
                                                    <button data-acao="alterar" class="btn btn-sm btn-warning ml-md-2 d-flex align-items-center" type="button" name="btn-alterar">
                                                        <i class="fas fa-pencil-alt mr-1"></i>
                                                        Alterar
                                                    </button>
                                                <?php else: ?>
                                                    <button data-acao="salvar" class="btn btn-sm btn-success ml-md-2 d-flex align-items-center" type="button" name="btn-salvar">
                                                        <i class="fas fa-save mr-1"></i>
                                                        Salvar
                                                    </button>
                                                <?php endif ?>
                                            </td>
                                            
                                        </tr>
                                    <?php endfor ?>
                                </tbody>
                            </table>
                        </form>

                    </div> <!-- col-md-12 -->
                </div> <!-- row -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- container -->
    
    <div class="modal fade" id="modal-dados-pauta-aluno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
            <div class="modal-content main-body border border-warning border-bottom">
                <div class="modal-header border-bottom border-warning bg-warning">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">Dados do aluno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="col-md-12">
                        <div id="msg-alerta-modal-dados-aluno-pauta" class="alert alert-danger mensagem-alerta invisible" role="alert"></div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-title" for="nome-completo">Student</label>
                            <input class="form-control form-control-sm bg-transparent border text-white" type="text" id="nome-modal" name="nome-completo" disabled>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-title" for="email-modal">Email</label>
                            <input class="form-control form-control-sm bg-transparent border text-white" type="text" id="email-modal" name="email-modal" disabled>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-title" for="telefone-modal">Phone</label>
                            <input class="form-control form-control-sm bg-transparent border text-white" type="text" id="telefone-modal" name="telefone-modal" disabled>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-title" for="data-nascimento-modal">Birthday</label>
                            <input class="form-control form-control-sm bg-transparent border text-white" type="date" id="data-nascimento-modal" name="data-nascimento-modal" disabled>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-title" for="profissao-modal">Job</label>
                            <input class="form-control form-control-sm bg-transparent border text-white" type="text" id="profissao-modal" name="profissao-modal" disabled>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-pattern" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- inclui os scripts globais -->
    <?php include_once "../../templates/_script.php"?>
    <script src="../../assets/vendor/linkify/linkify.min.js"></script>
    <script src="../../assets/vendor/linkify/linkify-element.min.js"></script>
    <script src="../../assets/vendor/linkify/linkify-html.min.js"></script>
    <script src="../../assets/vendor/linkify/linkify-string.min.js"></script>
    <script src="../../assets/my-functions-js/pauta_alunos.js"></script>

</body>
</html>
