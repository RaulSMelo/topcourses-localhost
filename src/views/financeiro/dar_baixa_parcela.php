<?php
require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\DarBaixaEmParcelasController;
use Src\traits\UtilCTRL;
use Src\input\Input;

UtilCTRL::validarTipoDeAcessoADM();

$darBaixaEmParcelasCTRL = new DarBaixaEmParcelasController();

$darBaixaEmParcelasCTRL->atualizarSituacaoPagamentoPelaDataAtual();

if (filter_input(INPUT_POST, "btn-buscar") !== null) {

    $nome = "";
    $sobrenome = "";
    
    if(Input::post("nome-aluno") !== null){
        
        $nomeCompleto =  UtilCTRL::retornaNomeEsobrenome(Input::post("nome-aluno"));
        $nome         = $nomeCompleto["nome"];
        $sobrenome    = $nomeCompleto["sobrenome"] ?? "";

    }

    $filtros = [
        "data-inicio"  => trim(Input::post("data-inicio")),
        "data-final"   => trim(Input::post("data-final")),
        "nome"         => trim($nome),
        "sobrenome"    => trim($sobrenome),
        "situacao_pag" => trim(Input::post("situacao-pagamento", FILTER_SANITIZE_NUMBER_INT))
    ];

    $parcelas = $darBaixaEmParcelasCTRL->filtrarDarBaixaEmParcelas($filtros);

    if (count($parcelas) == 0) {

        $ret = 2;
    }
    
} else if (filter_input(INPUT_POST, "btn-confirmar-baixa") !== null) {

    $ret = $darBaixaEmParcelasCTRL->registrarBaixaParcela();

    $nome = "";
    $sobrenome = "";
    
    if(Input::post("nome-aluno") !== null){
        
        $nomeCompleto = UtilCTRL::retornaNomeEsobrenome(Input::post("nome-aluno"));
        $nome         = trim($nomeCompleto["nome"]);
        $sobrenome    = trim($nomeCompleto["sobrenome"]) ?? "";
    }


    $filtros = [
        "data-inicio"  => trim(Input::post("data-inicio")),
        "data-final"   => trim(Input::post("data-final")),
        "nome"         => trim($nome),
        "sobrenome"    => trim($sobrenome),
        "situacao_pag" => trim(Input::post("situacao-pag-modal", FILTER_SANITIZE_NUMBER_INT))
    ];

    $parcelas = $darBaixaEmParcelasCTRL->filtrarDarBaixaEmParcelas($filtros);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Consultar parcelas | Dar baixa</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Consultar parcelas | Dar baixa</h2>
                    <h5><em>Aqui você pode consultar o contrato para dar baixa nas parcelas</em></h5>
                </div>
                <div class="card-body card-body-form">

                    <div class="row">

                        <div class="col-md-12">
                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                        </div>

                        <div class="col-12">

                            <form action="dar_baixa_parcela.php" method="POST">

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="input-title" for="data-inicio">Data início</label>
                                            <input value="<?= $filtros["data-inicio"] ?? "" ?>" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="obr form-control form-control-sm <?= (isset($filtros["data-inicio"]) && $filtros["data-inicio"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="data-inicio" name="data-inicio" placeholder="Data início" autocomplete="off">
                                            <small id="msg-erro-data-inicio" class="text-danger invisible">Preencha o campo data início</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="input-title" for="data-final">Data final</label>
                                            <input value="<?= $filtros["data-final"] ?? "" ?>" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="obr form-control form-control-sm <?= (isset($filtros["data-final"]) && $filtros["data-final"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="data-final" name="data-final" placeholder="Data final" autocomplete="off">
                                            <small id="msg-erro-data-final" class="text-danger invisible">Preencha o campo data final</small>
                                        </div>
                                    </div>  
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div id="datainicio-e-datafinal-alert" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-title" for="nome-aluno">Nome do aluno</label>
                                            <input value="<?= $filtros["nome"] ?? "" ?> <?= $filtros["sobrenome"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($filtros["nome"]) && $filtros["nome"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="nome-aluno" name="nome-aluno" placeholder="Nome do aluno" autocomplete="off">
                                            <small id="msg-erro-nome-aluno" class="text-danger invisible">Preencha o campo Nome do aluno ou da empresa</small>
                                        </div>
                                    </div>                           
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-title" for="situacao-pagamento">Situação do pagamento</label>
                                            <select class="nao-obr custom-select custom-select-sm <?= (isset($filtros["situacao_pag"]) && $filtros["situacao_pag"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="situacao-pagamento" name="situacao-pagamento">
                                                <option value="">Todos</option>
                                                <option value="<?= CANCELADO ?>" <?= (isset($filtros["situacao_pag"]) && $filtros["situacao_pag"] == CANCELADO) ? "selected" : "" ?>>Cancelado</option>
                                                <option value="<?= ATRASADO ?>" <?= (isset($filtros["situacao_pag"]) && $filtros["situacao_pag"] == ATRASADO) ? "selected" : "" ?>>Atrasado</option>
                                                <option value="<?= EM_ABERTO ?>" <?= (isset($filtros["situacao_pag"]) && $filtros["situacao_pag"] == EM_ABERTO) ? "selected" : "" ?>>Em aberto</option>
                                                <option value="<?= PAGO ?>" <?= (isset($filtros["situacao_pag"]) && $filtros["situacao_pag"] == PAGO) ? "selected" : "" ?>>Pago</option>
                                            </select>
                                            <small id="msg-erro-data-final" class="text-danger invisible">Preencha o campo <b>data final</b></small>
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

                            <?php if (isset($parcelas) && count($parcelas) > 0): ?>

                                <div class="table-responsive">

                                    <table class="table table-striped table-dark mt-4 ">
                                        <thead>
                                            <tr>
                                                <th class="line-nowrap">Nome</th>
                                                <th class="line-nowrap">Parcela</th>
                                                <th class="line-nowrap">Vencimento</th>
                                                <th class="line-nowrap">Valor da Parcela</th>
                                                <th class="line-nowrap">Valor pago</th>
                                                <th class="line-nowrap">Situação</th>
                                                <th class="line-nowrap">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php for ($i = 0; $i < count($parcelas); $i++): ?>

                                                <tr>
                                                    <td class="line-nowrap"><?= $parcelas[$i]["nome"] . " " . $parcelas[$i]["sobrenome"] ?></td>
                                                    <td class="line-nowrap"><?= $parcelas[$i]["numero_da_parcela"] . " de " . $parcelas[$i]["qtde_parcelas"] ?></td>
                                                    <td class="line-nowrap"><?= UtilCTRL::dataFormatoBR($parcelas[$i]["data_vencimento_parcela"]) ?></td>
                                                    <td class="line-nowrap"><?= UtilCTRL::formatoMoedaBRComSifrao($parcelas[$i]["valor_parcela"]) ?></td>
                                                    <td class="line-nowrap <?= (!empty($parcelas[$i]["valor_pago"])) ? "" : "text-center" ?>"><?= (!empty($parcelas[$i]["valor_pago"])) ? UtilCTRL::formatoMoedaBRComSifrao($parcelas[$i]["valor_pago"]) : "" ?></td>
                                                    <td class="line-nowrap"><span style="width: 4.5rem;padding: 0.3rem 0" class="<?= $parcelas[$i]["situacao_pagamento"] == EM_ABERTO ? "badge rounded-pill bg-warning text-dark" : "" ?> <?= $parcelas[$i]["situacao_pagamento"] == ATRASADO ? "badge rounded-pill bg-danger" : "" ?> <?= $parcelas[$i]["situacao_pagamento"] == PAGO ? "badge rounded-pill bg-success" : "" ?>"><?= SITUACAO_PAGAMENTO[$parcelas[$i]["situacao_pagamento"]] ?></span></td>
                                                    <td class="line-nowrap">
                                                        <a  onclick="modalDarBaixaEmParcela('<?= $parcelas[$i]["id_dar_baixa_parcelas"] ?>', '<?= $parcelas[$i]["nome"] . " " . $parcelas[$i]["sobrenome"] ?>', '<?= $parcelas[$i]["numero_da_parcela"] . " de " . $parcelas[$i]["qtde_parcelas"] ?>', '<?= UtilCTRL::formatoMoedaBRComSifrao($parcelas[$i]["valor_parcela"]) ?>', '<?= ($parcelas[$i]["valor_pago"] != "") ? UtilCTRL::formatoMoedaBRComSifrao($parcelas[$i]["valor_pago"]) : "" ?>', '<?= $parcelas[$i]["data_vencimento_parcela"] ?>', '<?= $parcelas[$i]["tipo_pagamento"] != "" ? TIPOS_DE_PAGAMENTOS[$parcelas[$i]["tipo_pagamento"]] : "" ?>', '<?= $parcelas[$i]["data_registro_pagamento"] ?>', '<?= $parcelas[$i]["tipo_pagamento"] ?>', '<?= $parcelas[$i]["observacao_pagamento"] ?>', '<?= $parcelas[$i]["id_interessado"] ?>', ' <?= $parcelas[$i]["tipo_contrato"] ?>', '<?= ((int) $parcelas[$i]["tipo_contrato"] == CONTRATO_REVISAO || (int) $parcelas[$i]["tipo_contrato"] == CONTRATO_TRADUCAO) ? $parcelas[$i]["id_contrato_rev_trad"] : $parcelas[$i]["id_contrato_curso"] ?>')" class="btn <?= $parcelas[$i]["situacao_pagamento"] == PAGO ? "btn-primary" : "btn-success" ?> btn-sm" data-toggle="modal" data-target="#modal-dar-baixa-parcela">
                                                            <?= $parcelas[$i]["situacao_pagamento"] == PAGO ? "<i class='fas fa-info-circle'></i> Detalhes" : "<i class='fas fa-hand-holding-usd'></i> Dar baixa" ?>    
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

        <form action="dar_baixa_parcela.php" method="POST">

            <div class="modal fade" id="modal-dar-baixa-parcela" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-top  rounded" role="document">
                    <div class="modal-content main-body border border-warning border-bottom">
                        <div class="modal-header border-bottom border-warning bg-dark">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Confirmar detalhes do pagamento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <input id="id-dar-baixa-parcela" name="id-dar-baixa-parcela" type="hidden">

                            <input id="id-interessado" name="id-interessado" type="hidden">

                            <input id="id-tipo-contrato" name="id-tipo-contrato" type="hidden">

                            <input id="id-contrato" name="id-contrato" type="hidden">

                            <input id="numero-parcela" name="numero-parcela" type="hidden">


                            <input value="<?= $filtros["data-inicio"] ?? "" ?>" id="dt-ini-modal" name="data-inicio" type="hidden">

                            <input value="<?= $filtros["data-final"] ?? "" ?>" id="dt-fim-modal" name="data-final" type="hidden">

                            <input value="<?= $filtros["situacao_pag"] ?? "" ?>" id="situacao-pag" name="situacao-pag-modal" type="hidden">


                            <div class="col-md-12">
                                <div class="form-row"> 
                                    <div class="col-md-3">
                                        <label class="col-form-label col-form-label-sm font-weight-bold">Nome:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control form-control-sm bg-transparent text-dark border-0 font-weight-bold w-100" id="nome" name="nome-aluno" type="text" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label class="col-form-label col-form-label-sm font-weight-bold">Parcela:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control form-control-sm bg-transparent text-dark border-0 font-weight-bold w-100" id="parcela" type="text" disabled>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label class="col-form-label col-form-label-sm font-weight-bold">Valor da parcela:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control form-control-sm bg-transparent text-dark border-0 font-weight-bold w-100" id="div-valor-parcela" type="text" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label class="col-form-label col-form-label-sm font-weight-bold">Data de Vencimento:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control form-control-sm bg-transparent text-dark border-0 font-weight-bold w-100" id="dia-vencimento" type="date" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" id="div-valor-pago">
                                <div class="form-row"> 
                                    <div class="col-md-3">
                                        <label class="col-form-label col-form-label-sm font-weight-bold">Valor pago:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control form-control-sm bg-transparent text-dark border-0 font-weight-bold w-100" id="valor-pago" type="text" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" id="div-tipo-pagamento">
                                <div class="form-row"> 
                                    <div class="col-md-3">
                                        <label class="col-form-label col-form-label-sm font-weight-bold">Tipo de pagamento:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control form-control-sm bg-transparent text-dark border-0 font-weight-bold w-100" id="input-tipo-pagamento" type="text" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" id="div-data-pagamento">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label class="col-form-label col-form-label-sm font-weight-bold">Data do pagamento:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control form-control-sm bg-transparent text-dark border-0 font-weight-bold w-100" id="input-data-pagamento" type="date" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12">

                                <input type="hidden" id="valor-parcela-vindo-do-DB" name="valor-parcela-vindo-do-DB">

                                <div class="form-row" id="form-row-valor-parcela"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark font-weight-bold" for="valor-parcela">Valor da parcela</label>
                                            <input data-moeda class="form-control form-control-sm text-darkfont-weight-bold campo-obrigatorio-modal" type="text" id="valor-parcela" name="valor-parcela" placeholder="Valor da parcela" autocomplete="off">
                                            <small id="msg-erro-valor-parcela" class="text-danger invisible">Preencha o campo valor da parcela</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row" id="form-row-tipo-pagamento"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-dark font-weight-bold" for="tipo-pagamento">Tipos de pagamentos</label>
                                            <select class="custom-select custom-select-sm campo-obrigatorio-modal" type="text" name="tipo-pagamento" id="tipo-pagamento" >
                                                <option value="">Selecione...</option>
                                                <option value="<?= BIT_COINS ?>">BIT COINS</option>
                                                <option value="<?= BOLETO_BANCARIO ?>">BOLETO BANCÁRIO</option>
                                                <option value="<?= CARTAO_DE_CREDITO ?>">CARTÃO DE CRÉDITO</option>
                                                <option value="<?= CARTAO_DE_DEBITO ?>">CARTÃO DE DÉBITO</option>
                                                <option value="<?= CHEQUE ?>">CHEQUE</option>
                                                <option value="<?= DINHEIRO ?>">DINHEIRO</option>
                                                <option value="<?= DEPOSITO ?>">DEPÓSITO</option>
                                                <option value="<?= PIX ?>">PIX</option>
                                                <option value="<?= TRANFERENCIA ?>">TRANSFERÊNCIA</option>
                                            </select>
                                            <small id="msg-erro-tipo-pagamento" class="text-danger invisible">Selecione uma opção do campo tipo de pagamento</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark font-weight-bold" for="observacao-pagamento">Observação de pagamento</label>
                                    <textarea maxlength="200"class="form-control bg-components-form" rows="2" style="resize: none" id="observacao-pagamento" name="observacao-pagamento"></textarea>
                                    <small class="form-text">Limite de 200 caracteres</small>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 mt-md-n5">
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-dark btn-pattern" data-dismiss="modal">Cancelar</button>
                                <button onclick="return validarCamposModal()" id="btn-confirmar-baixa" name="btn-confirmar-baixa" type="submit" class="btn btn-success btn-pattern">Confirmar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </form>


        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>
        <script src="../../assets/my-functions-js/ajax.js"></script>

    </body>
</html>


