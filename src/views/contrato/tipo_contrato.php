<?php
require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\TurmaController;
use Src\controllers\EmpresaController;
use Src\controllers\ColaboradorController;
use Src\controllers\InteressadoController;
use Src\controllers\CadastroBasicoController;
use Src\controllers\ConfiguracaoEmpresaController;

UtilCTRL::validarTipoDeAcessoADM();

$configEmpresaCTRL = new ConfiguracaoEmpresaController();
$dadosEmpresaProprietaria = $configEmpresaCTRL->buscarTodosDadosConfiguracaoEmpresa();


if (Input::post("tipo_contrato", FILTER_SANITIZE_NUMBER_INT) !== null) {

    $tipoContrato = Input::post("tipo_contrato");
    

    $colaboradorCTRL = new ColaboradorController();

    $contrato_revisao_traducao = (
            $tipoContrato == CONTRATO_REVISAO ||
            $tipoContrato == CONTRATO_TRADUCAO
    );

    $contrato_grupo_de_alunos = (
            $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PF_GRUPO_MENSAL ||
            $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PJ_GRUPO_MENSAL||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS
    );

    $contrato_PF = (
            $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PF_GRUPO_MENSAL ||
            $tipoContrato == PF_INDIVIDUAL_ACIMA_DE_20_HORAS ||
            $tipoContrato == PF_INDIVIDUAL_MENSAL ||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
            $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS
    );

    $contrato_PJ = (
            $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS ||
            $tipoContrato == PJ_GRUPO_MENSAL ||
            $tipoContrato == PJ_INDIVIDUAL_ACIMA_DE_20_HORAS ||
            $tipoContrato == PJ_INDIVIDUAL_MENSAL ||
            $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS
    );

    $contrato_termo_de_compromisso = (
        $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS ||
        $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
        $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS
    );

    if ($contrato_revisao_traducao) {

        $revisores = $colaboradorCTRL->buscarColaboradorPorTipo(REVISOR);
        $tradutores = $colaboradorCTRL->buscarColaboradorPorTipo(TRADUTOR);
        
    } else if ($contrato_PF || $contrato_PJ) {

        $cadBasicoCTRL = new CadastroBasicoController();
        $turmaCTRL = new TurmaController();

        $professores = $colaboradorCTRL->buscarColaboradorPorTipo(PROFESSOR);
        $niveis      = $cadBasicoCTRL->buscarTodosCadastrosBasicos(NIVEL);
        $idiomas     = $cadBasicoCTRL->buscarTodosCadastrosBasicos(IDIOMA);
        $cursos      = $cadBasicoCTRL->buscarTodosCadastrosBasicos(CURSO);
        $turmas      = $turmaCTRL->buscarTodasTurmas();
    }

    if ($contrato_PJ) {

        $empresaCTRL = new EmpresaController();

        $empresas = $empresaCTRL->buscarTodasEmpresasParaPreencherCombo();
    }


    if (Input::post("id_aluno", FILTER_SANITIZE_NUMBER_INT) !== null) {
        
        $idAluno = Input::post("id_aluno");
    }
    
    if(Input::post("data_agendamento") !== null){
        
        $data_aula_agendada = Input::post("data_agendamento");
    }

    if (!empty(Input::post("cpf_aluno")) && Input::post("cpf_aluno") !== null) {

        $cpf = Input::post("cpf_aluno");
    }

    if (!empty(Input::post("nome_completo")) && Input::post("nome_completo") !== null) {

        $nomeCompleto = Input::post("nome_completo");
    }
}

?>


<?php if ($contrato_revisao_traducao) : ?>

    <!--*** CONTRATO REVISÃO E TRADUÇÃO ***-->

    <form action="novo_contrato.php" method="POST">

        <input value="<?= $idAluno ?? "" ?>" type="hidden" name="id-interessado">

        <input value="<?= $tipoContrato ?? "" ?>" type="hidden" name="id-tipo-contrato" id="id-tipo-contrato">

        <div class="row">

            <div class="col-md-12">

                <div class="card my-3 main-body">

                    <div class="mb-3 box-shadown-bottom">
                        <h3 class="card-header bg-dark"><em>Cadastro de informações contratuais de <?= $tipoContrato == CONTRATO_REVISAO ? "revisão" : "tradução" ?></em></h3>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <i class="fas fa-circle text-color-campo-obrigatorio"></i>
                                    <span class="font-italic text-dark">Required fields</span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="cpf">CPF</label>
                                    <input value="<?= (isset($cpf) && $cpf != "") ? UtilCTRL::mascaraCPF($cpf) : "" ?>" maxlength="14" onkeypress="return mascaraGenerica(event, this, '###.###.###-##')" id="cpf" name="cpf" type="text" class="form-control form-control-sm <?= (isset($cpf) && $cpf != "") ? "is-valid" : "campo-obrigatorio" ?>" placeholder="CPF" <?= (isset($cpf) && $cpf != "") ? "readonly" : "autocomplete='off'" ?>>
                                    <small id="msg-erro-cpf" class="text-danger invisible">Preencha o campo CPF</small>
                                </div>
                            </div>

                            <?php if ($tipoContrato == CONTRATO_TRADUCAO) : ?>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="input-title text-dark" for="id-tradutor">Tradutor</label>
                                        <select class="custom-select custom-select-sm campo-obrigatorio" id="id-tradutor" name="id-tradutor">
                                            <option value="">Selecione...</option>

                                            <?php for ($i = 0; $i < count($tradutores); $i++) : ?>
                                                <option value="<?= $tradutores[$i]["id_colaborador"] ?>"><?= $tradutores[$i]["nome"] . " " . $tradutores[$i]["sobrenome"] ?></option>
                                            <?php endfor ?>

                                        </select>
                                        <small id="msg-erro-id-tradutor" class="text-danger invisible">Selecione uma opção do campo tradutor</small>
                                    </div>
                                </div>

                            <?php endif ?>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="id-revisor">Revisor</label>
                                    <select class="custom-select custom-select-sm campo-obrigatorio" id="id-revisor" name="id-revisor">
                                        <option value="">Selecione...</option>

                                        <?php for ($i = 0; $i < count($revisores); $i++) : ?>
                                            <option value="<?= $revisores[$i]["id_colaborador"] ?>"><?= $revisores[$i]["nome"] . " " . $revisores[$i]["sobrenome"] ?></option>
                                        <?php endfor ?>

                                    </select>
                                    <small id="msg-erro-id-revisor" class="text-danger invisible">Selecione uma opção do campo revisor</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="data-recebimento-material">Data de recebimento do material</label>
                                    <input maxlength="10" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="form-control form-control-sm campo-obrigatorio" type="date" id="data-recebimento-material" name="data-recebimento-material" placeholder="Data de recebimentodo material" autocomplete="off">
                                    <small id="msg-erro-data-recebimento-material" class="text-danger invisible">Preencha o campo data de recebimento do material</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="data-prazo-entrega">Prazo de entrega</label>
                                    <input maxlength="10" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="form-control form-control-sm campo-obrigatorio" type="date" id="data-prazo-entrega" name="data-prazo-entrega" placeholder="Prazo de entrega-traducao" autocomplete="off">
                                    <small id="msg-erro-data-prazo-entrega" class="text-danger invisible">Preencha o campo prazo de entrega</small>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div id="msg-alerta-dataRecebimento-e-dataPrazoEntrega" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="total-palavras">Número total de palavras</label>
                                    <input maxlength="10" onkeypress="return mascaraGenerica(event, this, '######.###')" type="text" class="form-control form-control-sm bg-components-form" id="total-palavras" name="total-palavras" placeholder="Número total de palavras" autocomplete="off">
                                    <small id="msg-erro-total-palavras" class="text-danger invisible">Preencha o campo número total de palavras</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="total-horas">Total de horas</label>
                                    <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" class="form-control form-control-sm bg-components-form" type="text" id="total-horas" name="total-horas" placeholder="Total de horas" autocomplete="off">
                                    <small id="msg-erro-total-horas" class="text-danger invisible">Preencha o campo total de horas</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="valor-total">Valor total</label>
                                    <input data-moeda class="form-control form-control-sm campo-obrigatorio" type="text" id="valor-total" name="valor-total" placeholder="Valor total R$ 0,00" autocomplete="off">
                                    <small id="msg-erro-valor-total" class="text-danger invisible">Preencha o campo valor total</small>
                                </div>
                                <div id="msg-alerta-valor-total" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                            </div>

                            <div class="col-md-12">
                                <fieldset form="form-novo-contrato" class="border bg-dark">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="sem-entrada" name="forma-de-pagamento" value="sem-entrada" class="custom-control-input" checked>
                                        <label class="custom-control-label text-light" for="sem-entrada">Sem entrada</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="com-entrada" name="forma-de-pagamento" value="com-entrada" class="custom-control-input">
                                        <label class="custom-control-label text-light" for="com-entrada">Com entrada</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="avista" name="forma-de-pagamento" value="avista" class="custom-control-input">
                                        <label class="custom-control-label text-light" for="avista">À vista</label>
                                    </div>
                                </fieldset>
                            </div>
                          
                            <div class="col-md-12 invisible" id="div-valor-entrada">
                                <div class="form-group ">
                                    <label class="input-title text-dark" for="valor-entrada">Valor de entrada</label>
                                    <input data-moeda class="form-control form-control-sm campo-obrigatorio" id="valor-entrada" name="valor-entrada" placeholder="Valor de entrada R$ 0,00" autocomplete="off">
                                    <small id="msg-erro-valor-entrada" class="text-danger invisible">Preencha o campo valor total</small>
                                </div>
                                <div id="msg-alerta-valor-entrada" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="qtde-parcelas">Número de parcelas</label>
                                    <input maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" class="form-control form-control-sm campo-obrigatorio" type="text" id="qtde-parcelas" name="qtde-parcelas" placeholder="Número de parcelas" autocomplete="off">
                                    <small id="msg-erro-qtde-parcelas" class="text-danger invisible">Preencha o campo número de parcelas</small>
                                </div>
                                <div id="msg-alerta-qtde-parcelas" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="valor-parcela">Valor das parcelas</label>
                                    <input data-moeda class="form-control form-control-sm campo-obrigatorio" type="text" id="valor-parcela" name="valor-parcela" placeholder="Valor das parcelas R$0,00" autocomplete="off" readonly>
                                    <small id="msg-erro-valor-parcela" class="text-danger invisible">Preencha o campo valor das parcelas</small>
                                </div>
                                <div id="msg-alerta-valor-parcela" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="dia-vencimento-parcela">Dia de vencimento das parcelas</label>
                                    <input class="form-control form-control-sm campo-obrigatorio" type="date" id="dia-vencimento-parcela" name="dia-vencimento-parcela" placeholder="Dia de vencimento das parcelas" autocomplete="off">
                                    <small id="msg-erro-dia-vencimento-parcela" class="text-danger invisible">Preencha o campo dia de vencimento das parcelas</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div id="msg-alerta-dia-vencimento-parcelas" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="descricao-servico">Descrição do serviço</label>
                                    <textarea class="form-control form-control-sm bg-components-form" style="resize: none" rows="5" type="text" id="descricao-servico" name="descricao-servico" placeholder="Descrição do serviço"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button onclick="return validarFormulario()" name="btn-salvar" class="btn btn-success border-warning btn-pattern" type="submit" id="btn-salvar-contrato-traducao">Salvar</button>
                            </div>

                        </div> <!-- row -->

                    </div> <!-- card-body  -->

                </div><!-- card -->

            </div> <!-- col-md-12  -->

        </div>
        <!--row -->

    </form>

<?php endif ?>


<?php if ($contrato_PF || $contrato_PJ) : ?>

    <div class="row">

        <div class="col-md-12">

            <div class="card my-3 main-body border border-warning">

                <div class="mb-3 border-bottom border-warning">
                    <h3 class="card-header bg-dark"><em>Contrato <?= TIPOS_DE_CONTRATOS[$tipoContrato] ?></em></h3>
                </div>

                <div class="card-body">

                    <form id="form-novo-contrato" action="novo_contrato.php" method="POST">

                        <?php if (!$contrato_grupo_de_alunos) : ?>
                            <input value="<?= $idAluno ?? "" ?>" type="hidden" name="id-aluno[]">
                        <?php endif ?>

                        <input value="<?= $tipoContrato ?? "" ?>" type="hidden" id="id-tipo-contrato" name="id-tipo-contrato">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <i class="fas fa-circle text-color-campo-obrigatorio"></i>
                                    <span class="font-italic text-dark">Required fields</span>
                                </div>
                            </div>

                            <?php if ($contrato_grupo_de_alunos) : ?>

                                <!--*** GRUPO DE ALUNOS ***-->
                                <div class="col-md-12">

                                    <fieldset form="form-novo-contrato" class="border border-warning" id="fieldset-grupo-alunos">

                                        <legend class="text-uppercase text-white">Grupo de alunos</legend>

                                        <div class="form-row mb-3 position-relative">
                                            <div class="col-md-12 d-flex">
                                                <button class="btn btn-success btn-sm" type="button" id="btn-novo-aluno">
                                                    <i class="fas fa-plus"></i>
                                                    Novo
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-row d-flex align-items-center" data-grupo-alunos>

                                            <input value="<?= $idAluno ?? "" ?>" type="hidden" name="id-aluno[]">

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="input-title text-dark">CPF</label>
                                                    <input value="<?= (isset($cpf) && $cpf != "") ? UtilCTRL::mascaraCPF($cpf) : "" ?>" id="cpf-1" name="cpf[]" maxlength="14" onkeypress="return mascaraGenerica(event, this, '###.###.###-##')" type="text" class="form-control form-control-sm <?= (isset($cpf) && $cpf != "") ? "is-valid" : "campo-obrigatorio" ?>" placeholder="CPF" autocomplete="off" readonly>
                                                    <small data-msg-erro-nome-completo id="msg-erro-cpf-1" class="text-danger invisible">Preencha o campo CPF</small>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="input-title text-dark">Nome completo</label>
                                                    <input value="<?= $nomeCompleto ?? "" ?>" id="nome-completo-1" name="nome-completo[]" class="form-control form-control-sm <?= (isset($nomeCompleto) && $nomeCompleto != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" placeholder="Nome" autocomplete="off" readonly>
                                                    <small data-msg-erro-cpf id="msg-erro-nome-completo-1" class="text-danger invisible">Preencha o campo Nome</small>
                                                </div>
                                            </div>

                                            <div class="col-md-2 mt-md-2 p-0" style="white-space: nowrap">
                                                <button onclick="enviarIndexBtnBuscar(event)" data-index="0" name="btn-buscar[]" class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#modal-buscar-aluno" <?= (isset($cpf) && $cpf != "" && isset($nomeCompleto) && $nomeCompleto != "") ? "disabled" : "" ?>>
                                                    <i class="fas fa-search"></i>
                                                    Buscar
                                                </button>
                                                <button name="btn-remover[]" class="btn btn-danger btn-sm" type="button">
                                                    <i class="fas fa-trash"></i>
                                                    Remover
                                                </button>
                                            </div>
                                        </div>

                                    </fieldset>

                                    <div id="msg-alerta-grupo-cpf-vazio" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>

                                </div><!-- FIM GRUPO DE ALUNOS -->

                            <?php endif ?>
                                
                            <!-- PERÍODO DO CONTRATO -->    
                            <div class="col-md-12">

                                <fieldset form="form-novo-contrato" class="border border-warning" id="periodo">
                                    
                                    <legend class="text-uppercase text-white">Período</legend>
                                    
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="data-inicio">Data de início</label>
                                                <input value="<?= (isset($data_aula_agendada) && !empty($data_aula_agendada)) ? $data_aula_agendada : UtilCTRL::dataAtual() ?>" maxlength="10"  type="date" class="obr form-control form-control-sm is-valid" id="data-inicio" name="data-inicio" autocomplete="off">
                                                <small id="msg-erro-data-inicio" class="text-danger invisible">Preencha o campo data de início</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="data-final">Data de término</label>
                                                <input maxlength="10" type="date" class="form-control form-control-sm campo-obrigatorio" id="data-final" name="data-final" placeholder="Data de término do contrato" autocomplete="off">
                                                <small id="msg-erro-data-final" class="text-danger invisible">Preencha o campo <b>data de término</b></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="numero-meses-por-ano">Número de meses por ano</label>
                                                <input class="form-control form-control-sm campo-obrigatorio" id="numero-meses-por-ano" name="numero-meses-por-ano" readonly="">
                                                <small id="msg-erro-numero-meses-por-ano" class="text-danger invisible">Selecione uma opção do campo Número de meses por ano</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div id="datainicio-e-datafinal-alert" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                        </div>
                                    </div>

                                </fieldset>
                                
                            </div><!-- FIM PERÍODO DO CONTRATO -->
                                
                                
                            <!--*** AGENDAMENTOS ***-->
                            <div class="col-md-12">

                                <fieldset class="border-warning" form="form-novo-contrato">

                                    <legend class="text-white">AGENDAMENTO DAS AULAS</legend>

                                    <!-- SEGUNDA-FEIRA -->
                                    <div class="form-row align-items-center mb-2">


                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-segunda-feira" name="dia-semana[]" value="1" disabled>
                                                <label class="custom-control-label font-weight-bold font-italic text-white" id="label-seg" for="checkbox-segunda-feira">
                                                    SEGUNDA-FEIRA
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-auto" id="das-seg" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                        </div>

                                        <div class="col-md-4" id="div-seg-hi" style="display: none">
                                            <label class="sr-only" for="hora-inicio-segunda">Hora do início</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-inicio-segunda" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                            <small id="msg-erro-hora-inicio-segunda" class="text-danger invisible">Preencha o campo hora início</small>
                                        </div>

                                        <div class="col-md-auto" id="as-seg" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                        </div>

                                        <div class="col-md-4" id="div-seg-ht" style="display: none">
                                            <label class="sr-only" for="hora-termino-segunda">Hora do término</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-termino-segunda" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                            <small id="msg-erro-hora-termino-segunda" class="text-danger invisible">Preencha o campo hora término</small>
                                        </div>

                                    </div>
                                    <!--*** Fim opcao segunda-feira ***-->

                                    <div class="form-row mr-md-2">
                                        <div class="col-md-11">
                                            <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                        </div>
                                    </div>

                                    <!-- TERÇA-FEIRA -->
                                    <div class="form-row align-items-center mb-2">

                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-terca-feira" name="dia-semana[]" value="2" disabled>
                                                <label class="custom-control-label font-weight-bold font-italic text-white" id="label-ter" for="checkbox-terca-feira">
                                                    TERÇA-FEIRA
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-auto" id="das-ter" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                        </div>

                                        <div class="col-md-4" id="div-ter-hi" style="display: none">
                                            <label class="sr-only" for="hora-inicio-terca">Hora do início</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-inicio-terca" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                            <small id="msg-erro-hora-inicio-terca" class="text-danger invisible">Preencha o campo hora início</small>
                                        </div>

                                        <div class="col-md-auto" id="as-ter" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                        </div>

                                        <div class="col-md-4" id="div-ter-ht" style="display: none">
                                            <label class="sr-only" for="hora-termino-terca">Hora do término</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-termino-terca" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                            <small id="msg-erro-hora-termino-terca" class="text-danger invisible">Preencha o campo hora término</small>
                                        </div>

                                    </div>
                                    <!--*** Fim opcao terça-feira ***-->

                                    <div class="form-row mr-md-2">
                                        <div class="col-md-11">
                                            <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                        </div>
                                    </div>

                                    <!-- QUARTA-FEIRA -->
                                    <div class="form-row align-items-center mb-2">

                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-quarta-feira" name="dia-semana[]" value="3" disabled>
                                                <label class="custom-control-label font-weight-bold font-italic text-white" id="label-qua" for="checkbox-quarta-feira">
                                                    QUARTA-FEIRA
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-auto" id="das-qua" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                        </div>

                                        <div class="col-md-4" id="div-qua-hi" style="display: none">
                                            <label class="sr-only" for="hora-inicio-quarta">Hora do início</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-inicio-quarta" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                            <small id="msg-erro-hora-inicio-quarta" class="text-danger invisible">Preencha o campo hora início</small>
                                        </div>

                                        <div class="col-md-auto" id="as-qua" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                        </div>

                                        <div class="col-md-4" id="div-qua-ht" style="display: none">
                                            <label class="sr-only" for="hora-termino-quarta">Hora do término</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-termino-quarta" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                            <small id="msg-erro-hora-termino-quarta" class="text-danger invisible">Preencha o campo hora término</small>
                                        </div>

                                    </div>
                                    <!--*** Fim opcao quarta-feira ***-->

                                    <div class="form-row mr-md-2">
                                        <div class="col-md-11">
                                            <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                        </div>
                                    </div>

                                    <!-- QUINTA-FEIRA -->
                                    <div class="form-row align-items-center mb-2">

                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-quinta-feira" name="dia-semana[]" value="4" disabled>
                                                <label class="custom-control-label font-weight-bold font-italic text-white" id="label-qui" for="checkbox-quinta-feira">
                                                    QUINTA-FEIRA
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-auto" id="das-qui" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                        </div>

                                        <div class="col-md-4" id="div-qui-hi" style="display: none">
                                            <label class="sr-only" for="hora-inicio-quinta">Hora do início</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-inicio-quinta" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                            <small id="msg-erro-hora-inicio-quinta" class="text-danger invisible">Preencha o campo hora início</small>
                                        </div>

                                        <div class="col-md-auto" id="as-qui" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                        </div>

                                        <div class="col-md-4" id="div-qui-ht" style="display: none">
                                            <label class="sr-only" for="hora-termino-quinta">Hora do término</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-termino-quinta" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                            <small id="msg-erro-hora-termino-quinta" class="text-danger invisible">Preencha o campo hora término</small>
                                        </div>

                                    </div>
                                    <!--*** Fim opcao quinta-feira ***-->

                                    <div class="form-row mr-md-2">
                                        <div class="col-md-11">
                                            <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                        </div>
                                    </div>

                                    <!-- SEXTA-FEIRA -->
                                    <div class="form-row align-items-center mb-2">

                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-sexta-feira" name="dia-semana[]" value="5" disabled>
                                                <label class="custom-control-label font-weight-bold font-italic text-white" id="label-sex" for="checkbox-sexta-feira">
                                                    SEXTA-FEIRA
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-auto" id="das-sex" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                        </div>

                                        <div class="col-md-4" id="div-sex-hi" style="display: none">
                                            <label class="sr-only" for="hora-inicio-sexta">Hora do início</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-inicio-sexta" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                            <small id="msg-erro-hora-inicio-sexta" class="text-danger invisible">Preencha o campo hora início</small>
                                        </div>

                                        <div class="col-md-auto" id="as-sex" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                        </div>

                                        <div class="col-md-4" id="div-sex-ht" style="display: none">
                                            <label class="sr-only" for="hora-termino-sexta">Hora do término</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-termino-sexta" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                            <small id="msg-erro-hora-termino-sexta" class="text-danger invisible">Preencha o campo hora término</small>
                                        </div>

                                    </div>
                                    <!--*** Fim opcao sexta-feira ***-->

                                    <div class="form-row mr-md-2">
                                        <div class="col-md-11">
                                            <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                        </div>
                                    </div>

                                    <!-- SÁBADO -->
                                    <div class="form-row align-items-center">

                                        <div class="col-md-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-sabado" name="dia-semana[]" value="6" disabled>
                                                <label class="custom-control-label font-weight-bold font-italic text-white" id="label-sab" for="checkbox-sabado">
                                                    SÁBADO
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-auto" id="das-sab" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">DAS</label>
                                        </div>

                                        <div class="col-md-4" id="div-sab-hi" style="display: none">
                                            <label class="sr-only" for="hora-inicio-sabado">Hora do início</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-inicio-sabado" name="hora-inicio[]" placeholder="Hora de início da aula" autocomplete="off">
                                            <small id="msg-erro-hora-inicio-sabado" class="text-danger invisible">Preencha o campo hora início</small>
                                        </div>

                                        <div class="col-md-auto" id="as-sab" style="display: none">
                                            <label class="m-md-0 text-dark font-italic font-weight-bold ">ÀS</label>
                                        </div>

                                        <div class="col-md-4" id="div-sab-ht" style="display: none">
                                            <label class="sr-only" for="hora-termino-sabado-contrato-pf-individual-mensal">Hora do término</label>
                                            <input maxlength="5" onkeypress="return mascaraGenerica(event, this, '##:##')" type="time" class="form-control form-control-sm campo-obrigatorio" id="hora-termino-sabado" name="hora-termino[]" placeholder="Hora do término da aula" autocomplete="off">
                                            <small id="msg-erro-hora-termino-sabado" class="text-danger invisible">Preencha o campo hora término</small>
                                        </div>

                                    </div>
                                    <!--*** Fim opcao sábado ***-->
                                    
                                    <?php if($contrato_termo_de_compromisso): ?>
                                        <div class="form-row align-items-center mt-2">
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkbox-a-combinar" name="dia-semana[]" value="a-combinar" disabled>
                                                    <label class="custom-control-label font-weight-bold font-italic text-white" for="checkbox-a-combinar">
                                                        A COMBINAR
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row mt-2 invisible" id="a-combinar-cargahoraria-e-totalhoras">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="lead text-white">Total de horas</label>
                                                    <input data-moeda maxlength="6" type="text" class="form-control form-control-sm campo-obrigatorio" id="total-horas-a-combinar" name="total-horas-a-combinar" placeholder="Total de horas" autocomplete="off">
                                                    <small id="msg-erro-total-horas-a-combinar" class="text-danger invisible">Preencha o campo total de horas</small>
                                                </div> 
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    
                                    <!-- Carga horária e total de horas no período -->
                                    <div class="form-row mt-md-4" id="carga-horaria-e-total-horas">
                                        <div class="col-md-3 bg-dark rounded shadow mr-md-3">
                                            <div class="form-group  text-center">
                                                <label class="lead text-white" for="carga-horaria">Carga horária semanal</label>
                                                <input value="00:00" type="time" class="form-control form-control-sm text-center text-white bg-dark border-0 border-bottom border-white carga-horaria-e-total-horas" id="carga-horaria" name="carga-horaria" placeholder="Carga horaria semanal" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3 bg-dark rounded shadow invisible" id="col-total-horas">
                                            <div class="form-group  text-center">
                                                <label class="lead text-white" for="total-horas">Total de horas</label>
                                                <input value="" type="text" class="form-control form-control-sm text-center text-white bg-dark border-0 border-bottom border-white carga-horaria-e-total-horas" id="total-horas" name="total-horas" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row mt-md-2 mr-md-2">
                                        <div class="col-md-11">
                                            <div data-msg-alerta-hora-agendamento class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 
                                        </div>
                                    </div>

                                </fieldset>

                                <div id="msg-alerta-hora-agendamento" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div> 

                            </div><!-- FIM col-md-12 agendamentos -->

                            <!--*** INFORMAÇÕES ESSENCIAIS PARA GERAR O CONTRATO ***-->
                            <div class="col-md-12">

                                <fieldset form="form-novo-contrato" class="border border-warning">

                                    <legend class="text-uppercase text-white">Informações essenciais para gerar o contrato</legend>


                                    <?php if ($contrato_PF && !$contrato_grupo_de_alunos) : ?>

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="input-title text-dark" for="cpf">CPF</label>
                                                    <input value="<?= (isset($cpf) && $cpf != "") ? UtilCTRL::mascaraCPF($cpf) : "" ?>" maxlength="14" onkeypress="return mascaraGenerica(event, this, '###.###.###-##')" name="cpf[]" type="text" class="form-control form-control-sm <?= (isset($cpf) && $cpf != "") ? "is-valid" : "campo-obrigatorio" ?>" id="cpf" placeholder="CPF" <?= (isset($cpf) && $cpf != "") ? "readonly" : "autocomplete='off'" ?>>
                                                    <small id="msg-erro-cpf" class="text-danger invisible">Preencha o campo CPF</small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif (($contrato_PJ) && !$contrato_grupo_de_alunos): ?>
                                    
                                        <input value="<?= $cpf ?? "" ?>" maxlength="11"name="cpf[]" type="hidden"  id="cpf" placeholder="cpf[]">
                                        
                                    <?php endif ?>

                                    <?php if ($contrato_PJ) : ?>

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="input-title text-dark" for="id-empresa">Empresa</label>
                                                    <select class="custom-select custom-select-sm campo-obrigatorio" id="id-empresa" name="id-empresa">
                                                        <option value="">Selecione...</option>
                                                            
                                                        <?php for ($i = 0; $i < count($empresas); $i++) : ?>
                                                            <option value="<?= $empresas[$i]["id_empresa"] ?>"><?= $empresas[$i]["razao_social"] ?></option>
                                                        <?php endfor ?>

                                                    </select>
                                                    <small id="msg-erro-id-empresa" class="text-danger invisible">Selecione uma opção do campo empresa</small>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endif ?>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="id-curso">Cursos</label>
                                                <select class="custom-select custom-select-sm campo-obrigatorio" id="id-curso" name="id-curso">
                                                    <option value="">Selecione...</option>
                                                    <?php for ($i = 0; $i < count($cursos); $i++) : ?>
                                                        <option value="<?= $cursos[$i]["id_cadastro_basico"] ?>"><?= $cursos[$i]["nome_cadastro"] ?></option>
                                                    <?php endfor ?>
                                                </select>
                                                <small id="msg-erro-id-curso" class="text-danger invisible">Selecione uma opção do campo cursos</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="id-idioma">Idioma</label>
                                                <select class="custom-select custom-select-sm campo-obrigatorio" id="id-idioma" name="id-idioma">
                                                    <option value="">Selecione...</option>

                                                    <?php for ($i = 0; $i < count($idiomas); $i++) : ?>
                                                        <option value="<?= $idiomas[$i]["id_cadastro_basico"] ?>"><?= $idiomas[$i]["nome_cadastro"] ?></option>
                                                    <?php endfor ?>

                                                </select>
                                                <small id="msg-erro-id-idioma" class="text-danger invisible">Selecione uma opção do campo idioma</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="valor-hora-aula">Valor hora/aula</label>
                                                <input data-moeda class="form-control form-control-sm campo-obrigatorio" id="valor-hora-aula" name="valor-hora-aula" placeholder="Valor hora/aula" readonly>
                                                <small id="msg-erro-valor-hora-aula" class="text-danger invisible">Preencha o campo valor hora/aula</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="valor-total">Valor total</label>
                                                <input data-moeda class="form-control form-control-sm campo-obrigatorio" id="valor-total" name="valor-total" placeholder="R$ 0,00" readonly>
                                                <small id="msg-erro-valor-total" class="text-danger invisible">Preencha o campo valor total</small>
                                            </div>
                                        </div>
                                    </div>

<!--                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="total-horas">Número total de horas</label>
                                                <input data-hora type="text" class="form-control form-control-sm campo-obrigatorio" id="total-horas" name="total-horas" placeholder="Número total de horas" autocomplete="off">
                                                <small id="msg-erro-total-horas" class="text-danger invisible">Preencha o campo número total de horas</small>
                                            </div>
                                            <div id="msg-alerta-total-horas" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="valor-total">Valor total</label>
                                                <input data-moeda class="form-control form-control-sm campo-obrigatorio" id="valor-total" name="valor-total" placeholder="Valor total R$ 0,00" readonly>
                                                <small id="msg-erro-valor-total" class="text-danger invisible">Preencha o campo valor total</small>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <fieldset form="form-novo-contrato" class="border bg-dark">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="sem-entrada" name="forma-de-pagamento" value="sem-entrada" class="custom-control-input" checked disabled>
                                                    <label class="custom-control-label text-light" for="sem-entrada">Sem entrada</label>
                                                </div>

                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="com-entrada" name="forma-de-pagamento" value="com-entrada" class="custom-control-input" disabled>
                                                    <label class="custom-control-label text-light" for="com-entrada">Com entrada</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="avista" name="forma-de-pagamento" value="avista" class="custom-control-input" disabled>
                                                    <label class="custom-control-label text-light" for="avista">À vista</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="form-row invisible" id="div-valor-entrada">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="valor-entrada">Valor de entrada</label>
                                                <input data-moeda class="form-control form-control-sm campo-obrigatorio" id="valor-entrada" name="valor-entrada" placeholder="Valor de entrada R$ 0,00" autocomplete="off">
                                                <small id="msg-erro-valor-entrada" class="text-danger invisible">Preencha o campo valor total</small>
                                            </div>
                                            <div id="msg-alerta-valor-entrada" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="qtde-parcelas">Número de parcelas</label>
                                                <input maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" type="text" class="form-control form-control-sm campo-obrigatorio" id="qtde-parcelas" name="qtde-parcelas" placeholder="Número de parcelas" autocomplete="off">
                                                <small id="msg-erro-qtde-parcelas" class="text-danger invisible">Preencha o campo número de parcelas</small>
                                            </div>
                                            <div id="msg-alerta-qtde-parcelas" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="valor-parcela">Valor da parcela</label>
                                                <input data-moeda class="form-control form-control-sm campo-obrigatorio" id="valor-parcela" name="valor-parcela" placeholder="R$ 0,00" readonly>
                                                <small id="msg-erro-valor-parcela" class="text-danger invisible">Preencha o campo valor da parcela</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="dia-vencimento-parcela">Dia de vencimento das parcelas</label>
                                                <input maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" type="date" class="form-control form-control-sm campo-obrigatorio" id="dia-vencimento-parcela" name="dia-vencimento-parcela" placeholder="Dia de vencimento parcelas" autocomplete="off">
                                                <small id="msg-erro-dia-vencimento-parcela" class="text-danger invisible">Preencha o campo dia de vencimento das parcelas</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="desconto">Desconto(%)</label>
                                                <input data-moeda maxlength="5" onkeypress="return mascaraGenerica(event, this, '#####')" type="text" class="form-control form-control-sm bg-components-form" id="desconto" name="desconto" placeholder="Desconto(%)" autocomplete="off">
                                            </div>
                                            <div id="msg-alerta-desconto" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div id="msg-alerta-dia-vencimento-parcelas" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                        </div>
                                    </div>

<!--                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="data-inicio">Data de início</label>
                                                <input maxlength="10" onkeypress="return mascaraGenerica(event, this, '##/##/####')" type="date" class="form-control form-control-sm campo-obrigatorio" id="data-inicio" name="data-inicio" placeholder="Data de início do contrato" autocomplete="off">
                                                <small id="msg-erro-data-inicio" class="text-danger invisible">Preencha o campo data de início</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="data-final">Data de término</label>
                                                <input maxlength="10" onkeypress="return mascaraGenerica(event, this, '##/##/####')" type="date" class="form-control form-control-sm campo-obrigatorio" id="data-final" name="data-final" placeholder="Data de término do contrato" autocomplete="off">
                                                <small id="msg-erro-data-final" class="text-danger invisible">Preencha o campo <b>data de término</b></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="numero-meses-por-ano">Número de meses por ano</label>
                                                <input class="form-control form-control-sm campo-obrigatorio" id="numero-meses-por-ano" name="numero-meses-por-ano" readonly="">
                                                <small id="msg-erro-numero-meses-por-ano" class="text-danger invisible">Selecione uma opção do campo Número de meses por ano</small>
                                            </div>
                                        </div>
                                    </div>-->

<!--                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div id="datainicio-e-datafinal-alert" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                        </div>
                                    </div>-->

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="local-das-aulas-ministradas">Local onde serão ministradas as aulas</label>
                                                <select class="custom-select custom-select-sm campo-obrigatorio" id="local-das-aulas-ministradas" name="local-das-aulas-ministradas">
                                                    <option value="">Selecione...</option>
                                                    <option value="<?= $dadosEmpresaProprietaria["rua"] . ", " . $dadosEmpresaProprietaria["numero"] . " - " . $dadosEmpresaProprietaria["bairro"] . ", " . $dadosEmpresaProprietaria["cidade"] . " - " . ucfirst(strtolower($dadosEmpresaProprietaria["uf"])) ?>"><?= $dadosEmpresaProprietaria["rua"] . ", " . $dadosEmpresaProprietaria["numero"] . " - " . $dadosEmpresaProprietaria["bairro"] . ", " . $dadosEmpresaProprietaria["cidade"] . " - " . ucfirst(strtolower($dadosEmpresaProprietaria["uf"])) ?></option>
                                                    <option value="online">Online</option>
                                                    <option value="outro-endereco">Outro endereço</option>
                                                </select>
                                                <small id="msg-erro-local-das-aulas-ministradas" class="text-danger invisible">Selecione uma opção do campo Local onde serão ministradas as aulas</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row" id="div-outro-endereco" style="display: none">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="outro-endereco">Outro endereço</label>
                                                <input class="form-control form-control-sm campo-obrigatorio" id="outro-endereco" name="outro-endereco" placeholder="Outro endereço" autocomplete="off">
                                                <small id="msg-erro-outro-endereco" class="text-danger invisible">Preencha o campo outro endereço</small>
                                            </div>
                                        </div>
                                    </div>

<!--                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="carga-horaria">Carga horária semanal</label>
                                                <input data-hora maxlength="5" type="text" class="form-control form-control-sm campo-obrigatorio" id="carga-horaria" name="carga-horaria" placeholder="Carga horaria semanal" autocomplete="off">
                                                <small id="msg-erro-carga-horaria" class="text-danger invisible">Preencha o campo carga horaria semanal</small>
                                                <small id="msg-media-carga-horaria" class="text-warning invisible"></small>
                                            </div>
                                            <div id="msg-alerta-carga-horaria" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                        </div>
                                    </div>-->

                                </fieldset>

                            </div> <!-- FIM campos essenciais para gerar o contrato -->


                            <!-- INFORMAÇÕES ADICIONAIS -->
                            <div class="col-md-12">

                                <fieldset form="form-novo-contrato" class="border border-warning">

                                    <legend class="text-uppercase text-white">Informações adicionais</legend>

                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="id-professor">Professor</label>
                                                <select class="custom-select custom-select-sm bg-components-form" id="id-professor" name="id-professor">
                                                    <option value="">Selecione...</option>

                                                    <?php for ($i = 0; $i < count($professores); $i++) : ?>
                                                        <option value="<?= $professores[$i]["id_colaborador"] ?>"><?= $professores[$i]["nome"] . " " . $professores[$i]["sobrenome"] ?></option>
                                                    <?php endfor ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="id-nivel">Nível</label>
                                                <select class="custom-select custom-select-sm bg-components-form" id="id-nivel" name="id-nivel">
                                                    <option value="">Selecione...</option>

                                                    <?php for ($i = 0; $i < count($niveis); $i++) : ?>
                                                        <option value="<?= $niveis[$i]["id_cadastro_basico"] ?>"><?= $niveis[$i]["nome_cadastro"] ?></option>
                                                    <?php endfor ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="id-turma">Turma</label>
                                                <select class="custom-select custom-select-sm bg-components-form" id="id-turma" name="id-turma">
                                                    <option value="">Não tem vínculo com turma</option>

                                                    <?php for ($i = 0; $i < count($turmas); $i++) : ?>
                                                        <option value="<?= $turmas[$i]["id_turma"] ?>"><?= $turmas[$i]["nome_turma"] ?></option>
                                                    <?php endfor ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="material">Material</label>
                                                <textarea class="form-control form-control-sm bg-components-form" name="material" style="resize: none" rows="5" id="material" placeholder="Anotações sobre material" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="programa">Programa</label>
                                                <textarea class="form-control form-control-sm bg-components-form" name="programa" style="resize: none" rows="5" id="programa" placeholder="Anotações sobre programa" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="input-title text-dark" for="marcacao-geral">Marcação geral</label>
                                                <textarea class="form-control form-control-sm bg-components-form" name="marcacao-geral" style="resize: none" rows="5" id="marcacao-geral" placeholder="Marcações gerais" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>

                            </div> <!-- FIM col-md-12 informações adicionais -->

                            <div class="col-md-12">
                                <button onclick="return validarFormulario()" name="btn-salvar" class="btn btn-success border-warning btn-pattern" type="submit" id="btn-salvar">Salvar</button>
                            </div>

                        </div> <!-- row -->

                    </form> <!-- form -->

                </div> <!-- card-body  -->

            </div> <!-- card -->

        </div><!-- col-md-12 -->

    </div> <!-- row -->

<?php endif ?>

<?php if ($contrato_grupo_de_alunos) : ?>

    <!-- MODAL BUSCAR ALUNO POR NOME -->
    <div class="modal fade" id="modal-buscar-aluno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
            <div class="modal-content main-body border border-warning border-bottom">
                <div class="modal-header border-bottom border-warning bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Buscar interessado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="text-dark font-weight-bold" for="nome-buscar-interessado">Nome</label>
                            <input class="obr form-control form-control-sm campo-obrigatorio-modal" type="text" name="nome-buscar-interessado" id="nome-buscar-interessado" placeholder="Digite o nome do interessado" autocomplete="off">
                            <small id="msg-erro-nome-buscar-interessado" class="text-danger invisible">Preencha o campo nome</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button id="btn-buscar" name="btn-buscar" type="submit" class="btn btn-info btn-sm btn-pattern">Buscar</button>
                    </div>

                    <input id="index" type="hidden">

                    <div class="col-sm-12">

                        <div class="table-responsive">

                            <table class="table table-striped table-dark mt-4">
                                <thead>
                                    <tr>
                                        <th class="line-nowrap">Nome</th>
                                        <th class="line-nowrap">CPF</th>
                                        <th class="line-nowrap">Ação</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-dados-interessados">

                                </tbody>
                            </table>

                        </div>

                        <div id="msg-alerta-buscar-interessados" class="alert alert-info border border-info font-weight-bold invisible" role="alert">
                            Não possui nenhum registro para esse nome digitado
                        </div> 

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

 endif ?>