<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\RelatorioContratoController;

UtilCTRL::validarTipoDeAcessoADM();

    if(Input::post("btn-buscar") !== null){
        
        $relatorioContratoCTRL = new RelatorioContratoController();
        
        $nome      = "";
        $sobrenome = "";
        
        if(!empty(trim(Input::post("nome")))){
            
            $nome_sobrenome = UtilCTRL::retornaNomeEsobrenome(Input::post("nome"));
            
            $nome      = trim($nome_sobrenome["nome"]);
            $sobrenome = trim($nome_sobrenome["sobrenome"] ?? "");
        }
        
        $filtros = [
            "data-inicio"   => Input::post("data-inicio"),
            "data-final"    => Input::post("data-final"),
            "nome"          => $nome,
            "sobrenome"     => $sobrenome,
            "tipo-contrato" => Input::post("id-tipo-contrato"),
            "situacao"      => Input::post("situacao")
        ];

        
        $dadosRelatorio      = $relatorioContratoCTRL->buscarRelatoriosContratos($filtros);
        $somaTotalDosValores = $relatorioContratoCTRL->somaDosValoresDosContratos($filtros);
        $nomes_dos_contratos = $relatorioContratoCTRL->buscarRelatoriosContratos($filtros, false);
        
    }


?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Relatório de contratos</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Relatório de contratos </h2>
                    <h5><em>Aqui você pode ver e baixar o PDF dos relatórios por período e por situação do contrato</em></h5>
                </div>

                <div class="card-body card-body-form">

                    <div class="row mb-3">

                        <div class="col-12">

                            <form action="relatorio_contratos.php" method="POST">

                                <div class="form-row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-title" for="data-inicio">Data início</label>
                                            <input value="<?= $filtros["data-inicio"] ?? "" ?>" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="obr form-control form-control-sm <?= (isset($filtros["data-inicio"]) && !empty($filtros["data-inicio"])) ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="data-inicio" name="data-inicio" placeholder="Data início">
                                            <small id="msg-erro-data-inicio-relatorio" class="text-danger invisible" >Por favor, informe o campo data início</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="input-title" for="data-final-relatorio">Data final</label>
                                            <input value="<?= $filtros["data-final"] ?? "" ?>" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="obr form-control form-control-sm <?= (isset($filtros["data-final"]) && !empty($filtros["data-final"])) ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="data-final" name="data-final" placeholder="Data final">
                                            <small id="msg-erro-data-final-relatorio" class="text-danger invisible" >Por favor, informe o campo data final</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div id="datainicio-e-datafinal-alert" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="input-title" for="nome">Nome</label>
                                            <input value="<?= (isset($filtros["nome"]) && isset($filtros["sobrenome"]) && !empty($filtros["nome"])) ? $filtros["nome"] . " " . $filtros["sobrenome"] : "" ?>" class="nao-obr form-control form-control-sm <?= (isset($filtros["nome"]) && !empty($filtros["nome"])) ? "is-valid" : "bg-components-form" ?>" name="nome" id="nome" autocomplete="off">
                                        </div>
                                    </div>   
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-title" for="id-tipo-contrato">Tipos de contrato</label>
                                            <select class="nao-obr custom-select custom-select-sm <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"])) ? "is-valid" : "bg-components-form" ?>" name="id-tipo-contrato" id="id-tipo-contrato">
                                                <option value="">Todos</option>
                                                <optgroup label="Pessoa física">
                                                    <option value="<?= PF_GRUPO_ACIMA_DE_20_HORAS ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PF_GRUPO_ACIMA_DE_20_HORAS) ? "selected" : ""  ?>>PF grupo acima de 20 horas</option>
                                                    <option value="<?= PF_GRUPO_MENSAL ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PF_GRUPO_MENSAL) ? "selected" : "" ?>>PF grupo mensal</option>
                                                    <option value="<?= PF_INDIVIDUAL_ACIMA_DE_20_HORAS ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PF_INDIVIDUAL_ACIMA_DE_20_HORAS) ? "selected" : ""  ?>>PF individual acima de 20 horas</option>
                                                    <option value="<?= PF_INDIVIDUAL_MENSAL ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PF_INDIVIDUAL_MENSAL) ? "selected" : ""  ?>>PF individual mensal</option>
                                                    <option value="<?= PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS) ? "selected" : ""  ?>>Pessoa física individual termo de compromisso até 20 horas</option>
                                                    <option value="<?= PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS) ? "selected" : ""  ?>>Pessoa física grupo termo de compromisso até 20 horas</option>
                                                <optgroup label="Pessoa jurídica">
                                                    <option value="<?= PJ_GRUPO_ACIMA_DE_20_HORAS ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PJ_GRUPO_ACIMA_DE_20_HORAS) ? "selected" : "" ?>>PJ grupo acima de 20 horas</option>
                                                    <option value="<?= PJ_GRUPO_MENSAL ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PJ_GRUPO_MENSAL) ? "selected" : ""  ?>>PJ grupo mensal</option>
                                                    <option value="<?= PJ_INDIVIDUAL_ACIMA_DE_20_HORAS ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PJ_INDIVIDUAL_ACIMA_DE_20_HORAS) ? "selected" : ""  ?>>PJ individual acima de 20 horas</option>
                                                    <option value="<?= PJ_INDIVIDUAL_MENSAL ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PJ_INDIVIDUAL_MENSAL) ? "selected" : ""  ?>>PJ individual mensal</option>
                                                    <option value="<?= PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS) ? "selected" : ""  ?>>PJ termo de compromisso até 20 horas</option>
                                                <optgroup label="Revisão e tradução">
                                                    <option value="<?= CONTRATO_REVISAO ?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == CONTRATO_REVISAO)  ? "selected" : ""  ?>>Revisão</option>
                                                    <option value="<?= CONTRATO_TRADUCAO?>" <?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"]) && $filtros["tipo-contrato"] == CONTRATO_TRADUCAO) ? "selected" : ""  ?>>Tradução</option>
                                            </select>
                                        </div>
                                    </div>                               
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-title" for="situacao">Situação</label>
                                            <select class="nao-obr custom-select custom-select-sm <?= (isset($filtros["situacao"]) && !empty($filtros["situacao"])) ? "is-valid" : "bg-components-form" ?>" name="situacao" id="situacao">
                                                <option value="">Todos</option>
                                                <option value="<?= CANCELADO ?>" <?= (isset($filtros["situacao"]) && !empty($filtros["situacao"]) && $filtros["situacao"] == CANCELADO) ? "selected" : "" ?>>Cancelado</option>
                                                <option value="<?= CONCLUIDO ?>" <?= (isset($filtros["situacao"]) && !empty($filtros["situacao"]) && $filtros["situacao"] == CONCLUIDO) ? "selected" : "" ?>>Concluído</option>
                                                <option value="<?= EM_ANDAMENTO ?>" <?= (isset($filtros["situacao"]) && !empty($filtros["situacao"]) && $filtros["situacao"] == EM_ANDAMENTO) ? "selected" : "" ?>>Em andamento</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <button onclick="return validarFormulario()" name="btn-buscar" class="btn btn-info btn-pattern">Pesquisar</button>
                                    </div>
                                </div>

                            </form>

                            <hr>

                        </div><!-- col-12 -->

                    </div> <!-- row -->

                    <?php if(isset($dadosRelatorio) && count($dadosRelatorio) > 0): ?>
                    
                        <div class="row">    

                            <div class="col-12">

                                <div class="card border-dark">
                                    
                                    <div class="card-header text-left mt-0 header bg-dark">
                                        <h4><em class="text-warning">Resultados da pesquisa</em></h4>
                                    </div>

                                    <div class="card-body main-body">

                                        <div class="row">

                                            <div class="col-12">

                                                <div class="form-row d-md-flex d-sm-block align-items-center">
                                                    <label class="lead mr-md-3 col-md-3 text-white">Período: </label>
                                                    <label class="lead col text-white" id="label-periodo"><?= (isset($filtros["data-inicio"]) && !empty($filtros["data-inicio"]) && isset($filtros["data-final"]) && !empty($filtros["data-final"]) ) ? UtilCTRL::dataFormatoBR($filtros["data-inicio"]) . "  à  " . UtilCTRL::dataFormatoBR($filtros["data-final"]) : "" ?></label>
                                                </div>

                                                <div class="form-row d-md-flex d-sm-table align-items-center">
                                                    <label class="lead mr-md-3 col-md-3 text-white">Tipo do contrato: </label>
                                                    <label class="lead col text-white" id="label-area-interesse"><?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"])) ? TIPOS_DE_CONTRATOS[$filtros["tipo-contrato"]] : "Todos" ?></label>
                                                </div>

                                                <div class="form-row d-md-flex d-sm-block align-items-center">
                                                    <label class="lead mr-md-3 col-md-3 text-white">Situação: </label>
                                                    <label class="lead col text-white" id="label-situacao"><?= (isset($filtros["situacao"]) && !empty($filtros["situacao"])) ? SITUACAO_CONTRATO[$filtros["situacao"]] : "Todos" ?></label>
                                                </div>
                                                
                                                <hr class="bg-light">
                                                
                                                <div class="form-row d-md-flex d-sm-block align-items-center">
                                                    <label class="lead mr-md-3 col-md-3 text-white"><em><b>Total de Contratos: </b></em></label>
                                                    <label class="lead col text-white font-weight-bold" id="label-total-contratos"><?= isset($dadosRelatorio) ? count($dadosRelatorio) : "" ?></label>
                                                </div>

                                                <div class="form-row d-md-flex d-sm-block align-items-center">
                                                    <label class="lead mr-md-3 col-md-3 text-white"><em><b>Valor total dos contratos: </b></em></label>
                                                    <label class="lead col text-white font-weight-bold" id="label-valor-total"><?= (isset($somaTotalDosValores) && !empty($somaTotalDosValores)) ? UtilCTRL::formatoMoedaBRComSifrao($somaTotalDosValores) : "" ?></label>
                                                </div>
                                                
                                                <hr class="bg-light">

                                            </div>
                                            
                                            <form action="relatorio_contratos_pdf.php" target="_blank" method="POST">
                                                
                                                <input value="<?= $filtros["data-inicio"] ?? "" ?>" type="hidden" name="data-inicio">
                                                
                                                <input value="<?= $filtros["data-final"] ?? "" ?>" type="hidden" name="data-final">
                                                
                                                <input value="<?= $filtros["nome"] ?? "" ?>" type="hidden" name="nome">
                                                
                                                <input value="<?= $filtros["sobrenome"] ?? ""?>" type="hidden" name="sobrenome">
                                                
                                                <input value="<?= $filtros["tipo-contrato"] ?? ""?>" type="hidden" name="tipo-contrato">
                                                
                                                <input value="<?= $filtros["situacao"] ?? ""?>" type="hidden" name="situacao">
                                                
                                                <div class="col-md-12 px-md-2 mx-md-1 mt-md-2">
                                                    <button class="btn btn-danger" name="btn-imprimir-relatorio-contratos" id="btn-baixar-pdf">
                                                        <i class="fas fa-print"></i>
                                                        Imprimir
                                                    </button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-12">

                                <div class="table-responsive">
                                    
                                    <table class="table table-striped table-dark mt-4 table-modal ">
                                        <thead>
                                            <tr>
                                                <th class="line-nowrap">Nomes</th>
                                                <th class="line-nowrap">Tipos de contrato</th>
                                                <th class="line-nowrap">Período</th>
                                                <th class="line-nowrap">Situação</th>
                                                <th class="line-nowrap">Valores</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php for($i = 0; $i < count($dadosRelatorio); $i++): ?>  
                                                   
                                                <tr>
                                                    <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top">
                                                        <em>
                                                            <?php for($j = 0; $j < count($nomes_dos_contratos); $j++): ?>

                                                                <?php if($dadosRelatorio[$i]["id_contrato"] == $nomes_dos_contratos[$j]["id_contrato"] && $dadosRelatorio[$i]["tipo_contrato"] == $nomes_dos_contratos[$j]["tipo_contrato"]): ?>

                                                                    <?= $nomes_dos_contratos[$j]["nome"] . " " . $nomes_dos_contratos[$j]["sobrenome"] . "<br>" ?>

                                                                <?php endif ?>

                                                            <?php endfor ?>
                                                        </em>
                                                    </td>
                                                    <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top"><?= TIPOS_DE_CONTRATOS[$dadosRelatorio[$i]["tipo_contrato"]] ?></td>
                                                    <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top"><?= UtilCTRL::dataFormatoBR($dadosRelatorio[$i]["data_inicio"]) . " à " . UtilCTRL::dataFormatoBR($dadosRelatorio[$i]["data_final"]) ?></td>
                                                    <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top"><?= SITUACAO_CONTRATO[$dadosRelatorio[$i]["situacao"]] ?></td>
                                                    <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top"><?= UtilCTRL::formatoMoedaBRComSifrao($dadosRelatorio[$i]["valor_total"]) ?></td>
                                                </tr>
                                                    
                                            <?php endfor ?>
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div> <!-- col-md-12 -->

                        </div> <!-- row -->
                    
                    <?php endif ?>

                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- container -->

        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>
        <script src="../../assets/my-functions-js/ajax.js"></script>

    </body>
</html>

