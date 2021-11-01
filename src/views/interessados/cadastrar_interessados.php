<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\CadastroBasicoController;
use Src\controllers\InteressadoController;
use Src\controllers\ColaboradorController;
use Src\traits\UtilCTRL;


UtilCTRL::validarTipoDeAcessoADM();

$interessadoCTRL = new InteressadoController();
$cadBasicoCTRL   = new CadastroBasicoController();
$colaboradorCTRL = new ColaboradorController();

if (isset($_POST["btn-salvar"])) {

    $ret = $interessadoCTRL->inserirInteressado();
    
}

$cursos         = $cadBasicoCTRL->buscarTodosCadastrosBasicos(CURSO);
$traducoes      = $cadBasicoCTRL->buscarTodosCadastrosBasicos(TRADUCAO);
$revisoes       = $cadBasicoCTRL->buscarTodosCadastrosBasicos(REVISAO);
$idiomas        = $cadBasicoCTRL->buscarTodosCadastrosBasicos(IDIOMA);
$midias         = $cadBasicoCTRL->buscarTodosCadastrosBasicos(MIDIA);
$tipos_contatos = $cadBasicoCTRL->buscarTodosCadastrosBasicos(TIPO_CONTATO);
$resultados     = $cadBasicoCTRL->buscarTodosCadastrosBasicos(RESULTADO);
$atendentes     = $colaboradorCTRL->buscarColaboradorPorTipo(ATENDENTE);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once '../../templates/_head.php' ?>

    <title>Cadastro de interessados</title>
</head>

<body class="main-body">
    <?php include_once '../../templates/_menu.php' ?>

    <div class="container padding-card-pattern">
        <div class="card my-3 main-card">
            <div class="card-header text-left mt-0 header bg-dark">
                <h2>Cadastro de interessados</h2>
                <h5><em>Aqui você pode cadastrar os dados de interessados</em></h5>
            </div>

            <form id="cadastro-interessados" action="cadastrar_interessados.php" method="POST">

                <div class="card-body card-body-form">

                    <div class="row">

                        <div class="col-12">
                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <i class="fas fa-circle text-color-campo-obrigatorio"></i>
                                <span class="font-italic">Required fields</span>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="nome">Nome</label>
                                <input class="form-control form-control-sm campo-obrigatorio" type="text" id="nome" name="nome" placeholder="Nome" autocomplete="off">
                                <small id="msg-erro-nome" class="text-danger invisible">Preencha o campo <b>nome</b></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="sobrenome">Sobrenome</label>
                                <input class="form-control form-control-sm bg-components-form" type="text" id="sobrenome" name="sobrenome" placeholder="sobrenome" autocomplete="off">
                                <small id="msg-erro-sobrenome" class="text-danger invisible">Preencha o campo <b>sobrenome</b></small>
                            </div>
                        </div>

                        <div class="col-md-12 position-relative mb-md-3">

                            <fieldset id="area-interesse-interessados" form="cadastro-interessados">
                                <!-- form="cadastro-interessados"-->

                                <legend class="text-uppercase">Área de interesse</legend>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="opcao-curso" name="opcao-area-interesse[]" value="1">
                                    <label class="custom-control-label font-weight-bold font-italic text-dark" for="opcao-curso">
                                        CURSOS
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="opcao-traducao" name="opcao-area-interesse[]" value="2">
                                    <label class="custom-control-label font-weight-bold font-italic text-dark" for="opcao-traducao">
                                        TRADUÇÃO
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="opcao-revisao" name="opcao-area-interesse[]" value="3">
                                    <label class="custom-control-label font-weight-bold font-italic text-dark" for="opcao-revisao">
                                        REVISÃO
                                    </label>
                                </div>

                                <div class="mt-3"></div>

                                <div class="form-group invisible mt-3" id="campo-curso">
                                    <label class="input-title" for="curso">Cursos</label>
                                    <select class="custom-select custom-select-sm campo-obrigatorio" id="curso" name="curso">
                                        <option value="">Selecione...</option>

                                        <?php for ($i = 0; $i < count($cursos); $i++) : ?>
                                            <option value="<?= $cursos[$i]["id_cadastro_basico"] ?>"><?= $cursos[$i]["nome_cadastro"] ?></option>
                                        <?php endfor ?>

                                    </select>
                                    <small id="msg-erro-curso" class="text-danger invisible">Selecione uma opção do campo <b>cursos</b></small>
                                </div>

                                <div class="form-group invisible" id="campo-traducao">
                                    <label class="input-title" for="traducao">Tradução</label>
                                    <select class="custom-select custom-select-sm campo-obrigatorio" id="traducao" name="traducao">
                                        <option value="">Selecione...</option>

                                        <?php for ($i = 0; $i < count($traducoes); $i++) : ?>
                                            <option value="<?= $traducoes[$i]["id_cadastro_basico"] ?>"><?= $traducoes[$i]["nome_cadastro"] ?></option>
                                        <?php endfor ?>

                                    </select>
                                    <small id="msg-erro-traducao" class="text-danger invisible">Selecione uma opção do campo <b>tradução</b></small>
                                </div>

                                <div class="form-group invisible" id="campo-revisao">
                                    <label class="input-title" for="revisao">Revisão</label>
                                    <select class="custom-select custom-select-sm campo-obrigatorio" id="revisao" name="revisao">
                                        <option value="">Selecione...</option>

                                        <?php for ($i = 0; $i < count($revisoes); $i++) : ?>
                                            <option value="<?= $revisoes[$i]["id_cadastro_basico"] ?>"><?= $revisoes[$i]["nome_cadastro"] ?></option>
                                        <?php endfor ?>

                                    </select>
                                    <small id="msg-erro-revisao" class="text-danger invisible">Selecione uma opção do campo <b>revisão</b></small>
                                </div>

                            </fieldset>
                            <small id="msg-erro-area-interesse-interessados" class="position-absolute text-danger mt-n2 invisible">Escolha no mínimo uma opção: <em><b>CURSOS - TRADUÇÃO - REVISÃO</b></em></small>

                        </div> <!-- col-md-12 área de interesse -->


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="idioma">Idiomas</label>
                                <select class="custom-select custom-select-sm campo-obrigatorio" id="idioma" name="idioma">
                                    <option value="">Selecione...</option>

                                    <?php for ($i = 0; $i < count($idiomas); $i++) : ?>
                                        <option value="<?= $idiomas[$i]["id_cadastro_basico"] ?>"><?= $idiomas[$i]["nome_cadastro"] ?></option>
                                    <?php endfor ?>

                                </select>
                                <small id="msg-erro-idioma" class="text-danger invisible">Selecione uma opção do campo idiomas</small>
                            </div>
                        </div>

                        <div class="col-md-2 pr-md-2">
                            <div class="form-group">
                                <label class="input-title" for="ddd">DDD</label>
                                <input maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" class="form-control form-control-sm campo-obrigatorio" type="text" id="ddd" name="ddd" placeholder="DDD" autocomplete="off">
                                <small id="msg-erro-ddd" class="text-danger invisible">Preencha o <b>DDD</b></small>
                            </div>
                        </div>

                        <div class="col-md-4 pl-md-2">
                            <div class="form-group">
                                <label class="input-title" for="telefone">Telefone</label>
                                <input maxlength="10" onkeypress="return mascaraGenerica(event, this, '#####-####')" class="form-control form-control-sm campo-obrigatorio" type="text" id="telefone" name="telefone" placeholder="Telefone" autocomplete="off">
                                <small id="msg-erro-telefone" class="text-danger invisible">Preencha o campo <b>telefone</b></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="email">Email</label>
                                <input class="form-control form-control-sm bg-components-form" type="email" id="email" name="email" placeholder="Email" autocomplete="off">
                                <div id="email-alert" class="alert alert-danger mensagem-alerta mt-1" role="alert" style="display: none"></div>
                                <small id="msg-erro-email" class="text-danger invisible">Preencha o campo email</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="midia">Mídia</label>
                                <select class="custom-select custom-select-sm bg-components-form" id="midia" name="midia">
                                    <option value="">Selecione...</option>

                                    <?php for ($i = 0; $i < count($midias); $i++) : ?>
                                        <option value=" <?= $midias[$i]["id_cadastro_basico"] ?>"><?= $midias[$i]["nome_cadastro"] ?></option>
                                    <?php endfor ?>

                                </select>
                                <small id="msg-erro-midia" class="text-danger invisible">Selecione uma opção do campo <b>mídia</b></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="tipo-contato">Tipo de contato com a escola</label>
                                <select class="custom-select custom-select-sm campo-obrigatorio" id="tipo-contato" name="tipo-contato">
                                    <option value="">Selecione...</option>

                                    <?php for ($i = 0; $i < count($tipos_contatos); $i++) : ?>
                                        <option value="<?= $tipos_contatos[$i]["id_cadastro_basico"] ?>"><?= $tipos_contatos[$i]["nome_cadastro"] ?></option>
                                    <?php endfor ?>

                                </select>
                                <small id="msg-erro-tipo-contato" class="text-danger invisible">Selecione uma opção do campo <b>tipo de contato com a escola</b></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="atendente">Atendente</label>
                                <select class="custom-select custom-select-sm campo-obrigatorio" id="atendente" name="atendente">
                                    <option value="">Selecione...</option>

                                    <?php for ($i = 0; $i < count($atendentes); $i++) : ?>
                                        <option value="<?= $atendentes[$i]["id_colaborador"] ?>"><?= $atendentes[$i]["nome"] . " " . $atendentes[$i]["sobrenome"] ?></option>
                                    <?php endfor ?>

                                </select>
                                <small id="msg-erro-atendente" class="text-danger invisible">Selecione uma opção do campo <b>atendente</b></small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-title" for="cpf">CPF</label>
                                <input maxlength="14" onkeypress="return mascaraGenerica(event, this, '###.###.###-##')" class="form-control form-control-sm bg-components-form" type="text" id="cpf" name="cpf" placeholder="CPF" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="data-nascimento">Data de nascimento</label>
                                <input class="form-control form-control-sm bg-components-form" type="date" id="data-nascimento" name="data-nascimento" placeholder="Data de nascimento" autocomplete="off">
                                <div id="data-nascimento-alert" class="alert alert-danger mensagem-alerta mt-1" role="alert" style="display: none"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="profissao">Profissao</label>
                                <input class="form-control form-control-sm bg-components-form" type="text" id="profissao" name="profissao" placeholder="Profissão" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="cep">CEP</label>
                                <input maxlength="10" onkeypress="return mascaraGenerica(event, this, '##.###-###')" class="form-control form-control-sm bg-components-form" type="text" id="cep" name="cep" placeholder="CEP" autocomplete="off">
                                <small class="text-muted m-md-1">Digite o CEP para obter automaticamente o endereço completo</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="rua">Rua</label>
                                <input class="form-control form-control-sm bg-components-form" type="text" id="logradouro" name="rua" placeholder="Rua" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-title" for="num">Número</label>
                                <input class="form-control form-control-sm bg-components-form" type="text" id="num" name="numero" placeholder="Número" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-title" for="complemento">Complemento</label>
                                <input class="form-control form-control-sm bg-components-form" type="text" id="complemento" name="complemento" placeholder="Complemento" autocomplete="off">
                                <small id="msg-erro-complemento" class="text-danger invisible">Preencha o campo <b>complemento</b></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="bairro">Bairro</label>
                                <input class="form-control form-control-sm bg-components-form" type="text" id="bairro" name="bairro" placeholder="Bairro" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="cidade">Cidade</label>
                                <input class="form-control form-control-sm bg-components-form" type="text" id="localidade" name="cidade" placeholder="Cidade" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="estado">UF</label>
                                <input class="form-control form-control-sm bg-components-form" type="text" id="uf" name="uf" placeholder="UF" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="input-title">Aula experimental agendada ?</label>
                            <div class="card bg-components-form">
                                <div class="card-body">

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="aula-agendada-nao" name="aula-agendada[]" value="0" class="custom-control-input">
                                        <label class="custom-control-label" for="aula-agendada-nao">Não</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="aula-agendada-sim" name="aula-agendada[]" value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="aula-agendada-sim">Sim</label>
                                    </div>

                                    <div class="custom-control-inline" id="div-data-agendamento" style="display: none">
                                        <input maxlength="10" onkeypress="return mascaraGenerica(event, this, '##/##/####')" type="date" class="form-control form-control-sm text-center campo-obrigatorio" id="data-agendamento" name="data-agendamento" placeholder="Digite a data" autocomplete="off">
                                        <small id="msg-erro-data-agendamento" class="text-danger invisible">Preencha o campo <b>data de agendamento</b></small>
                                    </div>

                                </div>
                            </div>
                            
                            <div id="data-agendamento-alert" class="alert alert-danger mensagem-alerta mt-1" role="alert" style="display: none"></div>
                        
                        </div>

                        <div class="col-md-6">
                            <label class="input-title">Teste de nivelamento/Simulado enviado ?</label>
                            <div class="card bg-components-form">
                                <div class="card-body">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="simulado-enviado-nao" name="simulado-enviado" value="0" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="simulado-enviado-nao">Não</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="simulado-enviado-sim" name="simulado-enviado" value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="simulado-enviado-sim">Sim</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-md-3">
                            <div class="form-group">
                                <label class="input-title" for="resultado">Resultado</label>
                                <select class="custom-select custom-select-sm bg-components-form" id="resultado" name="resultado">
                                    <option value="">Selecione...</option>

                                    <?php for ($i = 0; $i < count($resultados); $i++) : ?>
                                        <option value="<?= $resultados[$i]["id_cadastro_basico"] ?>"><?= $resultados[$i]["nome_cadastro"] ?></option>
                                    <?php endfor ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-title" for="info-add">Informações adicionais</label>
                                <textarea class="form-control form-control-sm bg-components-form" style="resize: none" rows="5" type="text" id="info-add" name="informacoes-adicionais" placeholder="Informaçãoes adicionais" autocomplete="off"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <button onclick="return validarFormulario(event)" class="btn btn-success btn-pattern" type="submit" data-form="cadastrar-interessado" name="btn-salvar" id="btn-salvar">Salvar</button>
                        </div>

                    </div> <!-- row -->
                </div> <!-- card-body -->
            </form>
        </div> <!-- card -->
    </div> <!-- container -->

    <!-- inclui os scripts globais -->

    <?php include_once "../../templates/_script.php" ?>
    <script src="../../assets/my-functions-js/interessados.js"></script>
    <script src="../../assets/my-functions-js/ajax.js"></script>

</body>

</html>