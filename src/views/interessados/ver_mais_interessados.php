<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\InteressadoController;
use Src\controllers\CadastroBasicoController;
use Src\controllers\ColaboradorController;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

    if(filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT) !== null){
        
        $interessadoCTRL = new InteressadoController();
        $cadBasicoCTRL   = new CadastroBasicoController();
        $colaboradorCTRL = new ColaboradorController();
        
        $id = filter_input(INPUT_GET, "cod");
        
        $interessado = $interessadoCTRL->buscarInteressadoPorId($id);
        
        
        if(!empty($interessado["id_curso"])){
            
            $curso = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_curso"]);
        }
        
        if(!empty($interessado["id_revisao"])){
            
            $revisao = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_revisao"]);
        }
        
        if(!empty($interessado["id_traducao"])){
            
            $traducao = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_traducao"]);
        }
        
        if(!empty($interessado["id_idioma"])){
            
            $idioma = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_idioma"]);
        }
        
        if(!empty($interessado["id_midia"])){
            
            $midia = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_midia"]);
        }
        
        if(!empty($interessado["id_colaborador"])){
            
            $atendente = $colaboradorCTRL->buscarColaboradorPorId($interessado["id_colaborador"]);
            
        }
        
        if(!empty($interessado["id_tipo_contato"])){
            
            $tipo_contato = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_tipo_contato"]);
        }
        
        if(!empty($interessado["id_resultado"])){
            
            $resultado = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_resultado"]);
        }
        
    }

    

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
            <div class="card-header text-left mt-0 header bg-dark border-bottom border-orange">
                <h2>Dados do cadastro do interessado</h2>
                <h5><em>Aqui você pode somente ver os dados do cadastro do interessado</em></h5>
            </div>

            <form id="cadastro-interessados" action="cadastrar_interessados.php" method="POST">

                <div class="card-body main-body">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-title" for="nome">Nome Completo</label>
                                <input value="<?= $interessado["nome"] . " " . $interessado["sobrenome"] ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="nome" name="nome-completo" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="telefone">Telefone</label>
                                <input value="<?= $interessado["telefone"] != "" ? UtilCTRL::mascaraTelefone($interessado["telefone"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="telefone" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="email">Email</label>
                                <input value="<?= $interessado["email"] ?>" class="form-control form-control-sm bg-transparent border text-white" type="email" id="email" name="email" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="cpf">CPF</label>
                                <input value="<?= $interessado["cpf"] != "" ? UtilCTRL::mascaraCPF($interessado["cpf"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cpf" name="cpf" disabled>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="data-nascimento">Data de nascimento</label>
                                <input value="<?= $interessado["data_nascimento"] != "" ? UtilCTRL::dataFormatoBR($interessado["data_nascimento"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="data-nascimento" name="data-nascimento" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="profissao">Profissao</label>
                                <input value="<?= $interessado["profissao"] ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="profissao" name="profissao" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="cep">CEP</label>
                                <input value="<?= $interessado["cep"] != "" ? UtilCTRL::mascaraCEP($interessado["cep"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cep" name="cep" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="rua">Endereço</label>
                                <input value="<?= (isset($interessado["rua"]) && !empty($interessado["rua"])) ? $interessado["rua"] . ", " : "" ?> <?= $interessado["numero"] ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="rua" name="rua" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="bairro">Bairro</label>
                                <input value="<?= $interessado["bairro"] ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="bairro" name="bairro" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="cidade">Cidade</label>
                                <input value="<?= $interessado["cidade"] ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cidade" name="cidade" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="estado">UF</label>
                                <input value="<?= $interessado["uf"] ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="estado" name="estado" disabled>
                            </div>
                        </div>

                        <div class="col-md-12 position-relative mb-md-3">

                            <fieldset id="area-interesse-interessados" class="border"> <!-- form="cadastro-interessados"-->

                                <legend>ÁREA DE INTERESSES</legend>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input <?= isset($curso) ? "checked" : "" ?> type="checkbox" class="custom-control-input bg-transparent border" id="opcao-curso" name="opcao-area-interesse[]" value="1" disabled>
                                    <label class="custom-control-label font-weight-bold font-italic text-dark" for="opcao-curso">
                                        CURSOS
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input <?= isset($traducao) ? "checked" : "" ?> type="checkbox" class="custom-control-input bg-transparent border" id="opcao-traducao" name="opcao-area-interesse[]" value="2" disabled>
                                    <label class="custom-control-label font-weight-bold font-italic text-dark" for="opcao-traducao">
                                        TRADUÇÃO
                                    </label>
                                </div>

                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input <?= isset($revisao) ? "checked" : "" ?> type="checkbox" class="custom-control-input bg-transparent border" id="opcao-revisao" name="opcao-area-interesse[]" value="3" disabled>
                                    <label class="custom-control-label font-weight-bold font-italic text-dark" for="opcao-revisao">
                                        REVISÃO
                                    </label>
                                </div>

                                <div class="mt-3"></div>

                                <div class="form-group mt-3 <?= isset($curso["nome_cadastro"]) ? "" : "invisible" ?>" id="campo-curso">
                                    <label class="input-title" for="curso">Cursos</label>
                                    <input value="<?= isset($curso["nome_cadastro"]) ? $curso["nome_cadastro"] : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="curso" name="curso" disabled>
                                </div>

                                <div class="form-group <?= isset($traducao["nome_cadastro"]) ? "" : "invisible" ?>" id="campo-traducao">
                                    <label class="input-title" for="traducao">Tradução</label>
                                    <input value="<?= $traducao["nome_cadastro"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="traducao" name="traducao" disabled>
                                </div>

                                <div class="form-group <?= isset($revisao["nome_cadastro"]) ? "" : "invisible" ?>" id="campo-revisao">
                                    <label class="input-title" for="revisao">Revisão</label>
                                    <input value="<?= $revisao["nome_cadastro"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="revisao" name="revisao" disabled>
                                </div>

                            </fieldset>

                        </div> <!-- col-md-12 área de interesse -->


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="idioma">Idiomas</label>
                                <input value="<?= $idioma["nome_cadastro"] ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="idioma" name="idioma" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="midia">Mídia</label>
                                <input value="<?= $midia["nome_cadastro"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="midia" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="tipo-contato">Tipo de contato com a escola</label>
                                <input value="<?= $tipo_contato["nome_cadastro"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="tipo-contato" name="tipo-contato" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="atendente">Atendente</label>
                                <input value="<?= (isset($atendente["nome"]) && isset($atendente["sobrenome"])) ? $atendente["nome"] . " " . $atendente["sobrenome"] : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="atendente" name="atendente" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="input-title">Aula experimental agendada ?</label>
                            <div class="card bg-transparent border">
                                <div class="card-body">

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input <?= $interessado["data_agendamento"] == "" ?  "checked" : "" ?> type="radio" id="aula-agendada-nao" name="data-agendamento[]" value="0" class="custom-control-input" disabled>
                                        <label class="custom-control-label text-dark" for="aula-agendada-nao">Não</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input <?= $interessado["data_agendamento"] != "" ? "checked" : "" ?> type="radio" id="aula-agendada-sim" name="data-agendamento[]" value="1" class="custom-control-input"disabled>
                                        <label class="custom-control-label text-dark" for="aula-agendada-sim">Sim</label>
                                    </div>

                                    <div class="custom-control-inline" id="div-data-agendamento"  <?= $interessado["data_agendamento"] != "" ? "style='display: inline-block'" : "style='display: none'" ?> >
                                        <input value="<?= $interessado["data_agendamento"] != "" ? UtilCTRL::dataFormatoBR($interessado["data_agendamento"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="data-agendamento" name="data-agendamento" disabled>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="input-title">Teste de nivelamento/Simulado enviado ?</label>
                            <div class="card bg-transparent border">
                                <div class="card-body">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input <?= $interessado["teste_nivelamento"] == "0" ? "checked" : "" ?> value="0" type="radio" id="simulado-enviado-nao" name="simulado-enviado[]" class="custom-control-input" disabled>
                                        <label class="custom-control-label text-dark" for="simulado-enviado-nao">Não</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input <?= $interessado["teste_nivelamento"] == "1" ? "checked" : "" ?> value="1" type="radio" id="simulado-enviado-sim" name="simulado-enviado[]" class="custom-control-input"disabled>
                                        <label class="custom-control-label text-dark" for="simulado-enviado-sim">Sim</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-md-2">
                            <div class="form-group">
                                <label class="input-title" for="resultado">Resultado</label>
                                <input value="<?= $resultado["nome_cadastro"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" id="resultado" name="resultado" disabled>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-title" for="info-add">Informações adicionais</label>
                                <textarea class="form-control form-control-sm bg-transparent border text-white" style="resize: none" rows="5" type="text" id="info-add" name="info-add" disabled><?= $interessado["informacoes_adicionais"] ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-3">
                            <a href="consultar_interessados.php" class="btn btn-dark btn-pattern">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Voltar
                            </a>
                        </div>

                    </div> <!-- row -->
                </div> <!-- card-body -->
            </form>
        </div> <!-- card -->
    </div> <!-- container -->

    <!-- inclui os scripts globais -->
    <?php include_once "../../templates/_script.php"?>

</body>
</html>
