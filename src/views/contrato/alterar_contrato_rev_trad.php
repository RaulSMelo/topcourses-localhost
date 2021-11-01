<?php
require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\ColaboradorController;
use Src\controllers\ContratoRevTradController;

UtilCTRL::validarTipoDeAcessoADM();

    $colaboradorCTRL = new ColaboradorController();
    $contratoRevTradCTRL = new ContratoRevTradController();

    if (filter_input(INPUT_POST, "btn-alterar") !== null) {

        $id = Input::post("id-contrato-rev-trad", FILTER_SANITIZE_NUMBER_INT);

        $ret = $contratoRevTradCTRL->alterarContratoRevTrad();
        
        header("Location: alterar_contrato_rev_trad.php?id={$id}&ret={$ret}");
        
    } else if (Input::get("id", FILTER_SANITIZE_NUMBER_INT) !== null) {

        $id = Input::get("id");

        $dados_contrato = $contratoRevTradCTRL->buscarTodosOsDadosContratoRevTradPorId($id);
        
    }

$tradutores = $colaboradorCTRL->buscarColaboradorPorTipo(TRADUTOR);
$revisores = $colaboradorCTRL->buscarColaboradorPorTipo(REVISOR);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Alterar contrato de <?= strtolower(TIPOS_DE_CONTRATOS[$dados_contrato["id_tipo_contrato"]]); ?></title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Alterar contrato de <?= strtolower(TIPOS_DE_CONTRATOS[$dados_contrato["id_tipo_contrato"]]); ?></h2>
                    <h5><em>Aqui você pode alterar o contrato de <?= strtolower(TIPOS_DE_CONTRATOS[$dados_contrato["id_tipo_contrato"]]); ?> que ainda está em aberto</em></h5>
                </div>
                <div class="card-body card-body-form">

                    <!-- CAMPOS QUE NÃO PODEM SER ALTERADOS -->
                    <div class="row">

                        <div class="col-12">
                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                        </div>

                        <div class="col-md-12">

                            <div class="card my-3 main-body card-opcoes-contratuais">

                                <div class="mb-3 box-shadown-bottom">
                                    <h3 class="card-header bg-dark"><em>Informações do contrato de <?= strtolower(TIPOS_DE_CONTRATOS[$dados_contrato["id_tipo_contrato"]]); ?> que <u class="text-uppercase">não podem ser alteradas</u></em></h3>
                                </div>

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="nome">Nome completo</label>
                                                <input value="<?= $dados_contrato["nome"] ?? "" ?> <?= $dados_contrato["sobrenome"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_contrato["nome"]) && isset($dados_contrato["sobrenome"]) && $dados_contrato["nome"] != "" && $dados_contrato["sobrenome"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="nome-completo" name="nome-completo" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="cpf">CPF</label>
                                                <input value="<?= (isset($dados_contrato["cpf"]) && $dados_contrato["cpf"] != "") ? UtilCTRL::mascaraCPF($dados_contrato["cpf"]) : "" ?>" maxlength="14" onkeypress="return mascaraGenerica(event, this, '###.###.###-##')" id="cpf" name="cpf" type="text" class="form-control form-control-sm <?= (isset($dados_contrato["cpf"]) && $dados_contrato["cpf"] != "") ? "is-valid" : "campo-obrigatorio" ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="telefone">Telefone</label>
                                                <input value="<?= (isset($dados_contrato) && $dados_contrato["telefone"] != "") ? UtilCTRL::mascaraTelefone($dados_contrato["telefone"]) : "" ?>" class="form-control form-control-sm <?= (isset($dados_contrato["telefone"]) && $dados_contrato["telefone"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="telefone" name="telefone" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="email">Email</label>
                                                <input value="<?= $dados_contrato["email"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_contrato["email"]) && $dados_contrato["email"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="email" id="email" name="email" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="data-recebimento">Data de recebimento do material</label>
                                                <input value="<?= $dados_contrato["data_recebimento_material"] ?? "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="form-control form-control-sm <?= (isset($dados_contrato["data_recebimento_material"]) && $dados_contrato["data_recebimento_material"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="data-recebimento" name="data-recebimento" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="data-prazo-entrega">Prazo de entrega</label>
                                                <input value="<?= $dados_contrato["data_prazo_entrega"] ?? "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="form-control form-control-sm <?= (isset($dados_contrato["data_prazo_entrega"]) && $dados_contrato["data_prazo_entrega"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="data-prazo-entrega" name="data-prazo-entrega" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="valor-total">Valor total</label>
                                                <input value="<?= (isset($dados_contrato["valor_total"]) && $dados_contrato["valor_total"] != "") ? UtilCTRL::formatoMoedaBRSemSifrao($dados_contrato["valor_total"]) : "" ?>" data-moeda class="form-control form-control-sm <?= (isset($dados_contrato["valor_total"]) && $dados_contrato["valor_total"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="valor-total" name="valor-total" disabled>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="qtde-parcelas">Número de parcelas</label>
                                                <input value="<?= $dados_contrato["qtde_parcelas"] ?? "" ?>" maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" class="form-control form-control-sm <?= (isset($dados_contrato["qtde_parcelas"]) && $dados_contrato["qtde_parcelas"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="qtde-parcelas" name="qtde-parcelas" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="valor-parcela">Valor das parcelas</label>
                                                <input value="<?= (isset($dados_contrato["valor_parcela"]) && $dados_contrato["valor_parcela"] != "") ? UtilCTRL::formatoMoedaBRSemSifrao($dados_contrato["valor_parcela"]) : "" ?>" data-moeda class="form-control form-control-sm <?= (isset($dados_contrato["valor_parcela"]) && $dados_contrato["valor_parcela"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="valor-parcela" name="valor-parcela" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title" for="dia-vencimento-parcela">Dia de vencimento das parcelas</label>
                                                <input value="<?= $dados_contrato["dia_vencimento_parcela"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_contrato["dia_vencimento_parcela"]) && $dados_contrato["dia_vencimento_parcela"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="dia-vencimento-parcela" name="dia-vencimento-parcela" disabled>
                                            </div>
                                        </div>

                                    </div> <!-- row -->    

                                </div> <!-- card-body -->

                            </div> <!-- card -->

                        </div> <!-- col-md-12 -->

                    </div> <!-- row -->

                    <!--*** ALTERAR CAMPOS CONTRATOS REVISÃO E TRADUÇÃO ***-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="card my-3 main-body card-opcoes-contratuais">
                                <div class="mb-3 box-shadown-bottom">
                                    <h3 class="card-header bg-dark"><em>Informações contratuais de <?= strtolower(TIPOS_DE_CONTRATOS[$dados_contrato["id_tipo_contrato"]]); ?> que <u class="text-uppercase">podem ser alteradas</u></em></h3>
                                </div>
                                <div class="card-body">

                                    <form  action="alterar_contrato_rev_trad.php" method="POST">

                                        <div class="row">

                                            <input value="<?= $dados_contrato["id_contrato_rev_trad"] ?? "" ?>" type="hidden" name="id-contrato-rev-trad">
                                            
                                            <input value="<?= $dados_contrato["id_tipo_contrato"] ?? "" ?>" type="hidden" name="id-tipo-contrato">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="input-title" for="situacao">Situação</label>
                                                    <select class="obr custom-select custom-select-sm is-valid" name="situacao" id="situacao">
                                                        <option value="<?= CANCELADO ?>" <?= (isset($dados_contrato["situacao"]) && $dados_contrato["situacao"] == CANCELADO) ? "selected" : "" ?>>Cancelado</option>
                                                        <option value="<?= CONCLUIDO ?>" <?= (isset($dados_contrato["situacao"]) && $dados_contrato["situacao"] == CONCLUIDO) ? "selected" : "" ?>>Concluído</option>
                                                        <option value="<?= EM_ANDAMENTO ?>" <?= (isset($dados_contrato["situacao"]) && $dados_contrato["situacao"] == EM_ANDAMENTO) ? "selected" : "" ?>>Em andamento</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php if (isset($dados_contrato["id_tipo_contrato"]) && $dados_contrato["id_tipo_contrato"] == CONTRATO_TRADUCAO): ?>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="input-title" for="id-tradutor">Tradutor</label>
                                                        <select class="obr custom-select custom-select-sm <?= (isset($dados_contrato["id_tradutor"]) && $dados_contrato["id_tradutor"] != "") ? "is-valid" : "campo-obrigatorio" ?>" id="id-tradutor" name="id-tradutor">
                                                            <option value="">Selecione</option>

                                                            <?php for ($i = 0; $i < count($tradutores); $i++): ?>
                                                                <option value="<?= $tradutores[$i]["id_colaborador"] ?>" <?= ($tradutores[$i]["id_colaborador"] == $dados_contrato["id_tradutor"]) ? "selected" : "" ?>><?= $tradutores[$i]["nome"] . " " . $tradutores[$i]["sobrenome"] ?></option>
                                                            <?php endfor ?>

                                                        </select>
                                                        <small id="msg-erro-id-tradutor" class="text-danger invisible">Selecione uma opção do campo tradutor</small>
                                                    </div>
                                                </div>

                                            <?php endif ?>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="input-title" for="id-revisor">Revisor</label>
                                                    <select class="obr custom-select custom-select-sm <?= (isset($dados_contrato["id_revisor"]) && $dados_contrato["id_revisor"] != "") ? "is-valid" : "campo-obrigatorio" ?>" id="id-revisor" name="id-revisor">
                                                        <option value="">Selecione</option>

                                                        <?php for ($i = 0; $i < count($revisores); $i++): ?>
                                                            <option value="<?= $revisores[$i]["id_colaborador"] ?>" <?= ($revisores[$i]["id_colaborador"] == $dados_contrato["id_revisor"]) ? "selected" : "" ?>><?= $revisores[$i]["nome"] . " " . $revisores[$i]["sobrenome"] ?></option>
                                                        <?php endfor ?>

                                                    </select>
                                                    <small id="msg-erro-id-revisor" class="text-danger invisible">Selecione uma opção do campo revisor</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="input-title" for="total-palavras">Número total de palavras</label>
                                                    <input value="<?= $dados_contrato["total_palavras"] ?? "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '##########')"  type="text" class="nao-obr form-control form-control-sm <?= (isset($dados_contrato["total_palavras"]) && $dados_contrato["total_palavras"] != "") ? "is-valid" : "bg-components-form" ?>" id="total-palavras" name="total-palavras" placeholder="Número total de palavras" autocomplete="off">
                                                    <small id="msg-erro-total-palavras" class="text-danger invisible">Preencha o campo número total de palavras</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="input-title" for="total-horas">Total de horas</label>
                                                    <input value="<?= $dados_contrato["total_horas"] ?? "" ?>" maxlength="3" onkeypress="return mascaraGenerica(event, this, '###')" class="nao-obr form-control form-control-sm <?= (isset($dados_contrato["total_horas"]) && $dados_contrato["total_horas"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="total-horas" name="total-horas" placeholder="Total de horas" autocomplete="off">
                                                    <small id="msg-erro-total-horas" class="text-danger invisible">Preencha o campo total de horas</small>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="input-title" for="descricao-servico">Descrição do serviço</label>
                                                    <textarea class="nao-obr form-control form-control-sm <?= (isset($dados_contrato["descricao_servico"]) && $dados_contrato["descricao_servico"] != "") ? "is-valid" : "bg-components-form" ?>" style="resize: none" rows="5" type="text" id="descricao-servico" name="descricao-servico" placeholder="Descrição do serviço"><?= $dados_contrato["descricao_servico"] ?? "" ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="input-title" for="marcacoes-gerais">Marcações gerais de alterações</label>
                                                    <textarea class="nao-obr form-control form-control-sm <?= (isset($dados_contrato["marcacoes_gerais"]) && $dados_contrato["marcacoes_gerais"] != "") ? "is-valid" : "bg-components-form" ?>" style="resize: none" rows="5" id="marcacao-geral" name="marcacao-geral" placeholder="Marcações gerais"><?= $dados_contrato["marcacoes_gerais"] ?? "" ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="modal-footer border-0 pr-0">
                                                    <a href="consultar_historico_contrato.php?cod=<?= $dados_contrato["id_interessado"] ?>" class="btn btn-dark btn-pattern">
                                                        <i class="fas fa-arrow-left mr-2"></i>
                                                        Voltar
                                                    </a>
                                                    <button onclick="return validarFormulario(event)" class="btn btn-success btn-pattern" type="submit" name="btn-alterar" id="btn-salvar">Alterar</button>
                                                </div>
                                            </div>

                                        </div> <!-- row -->

                                    </form>

                                </div> <!-- card-body  -->

                            </div><!-- card  -->

                        </div> <!-- col-md-12  -->

                    </div> <!--row -->



                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- container -->


        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>

    </body>
</html>

