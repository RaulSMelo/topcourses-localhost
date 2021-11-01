<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\input\Input;
use Src\controllers\InteressadoController;
use Src\controllers\ContratoRevTradController;
use Src\controllers\ContratoCursoController;
use Src\traits\UtilCTRL;
use Src\erro\Erro;

UtilCTRL::validarTipoDeAcessoADM();

    $contrato = true;
    
    if(Input::get("cod", FILTER_SANITIZE_NUMBER_INT) !== null){
        
        $interessadoCTRL = new InteressadoController();
        
        $id = Input::get("cod");
        
        $dados_interessado = $interessadoCTRL->buscarInteressadoPorId($id);
        
    }else if(filter_input(INPUT_POST, "btn-salvar") !== null){
        
        $tipoContrato = Input::post("id-tipo-contrato", FILTER_SANITIZE_NUMBER_INT);
        
        $contratoRevTrad = (
               
                $tipoContrato == CONTRATO_REVISAO ||
                $tipoContrato == CONTRATO_TRADUCAO
            );
        
        $contratoCurso = (
                
                $tipoContrato == PF_GRUPO_ACIMA_DE_20_HORAS                      ||
                $tipoContrato == PF_GRUPO_MENSAL                                 ||
                $tipoContrato == PF_INDIVIDUAL_ACIMA_DE_20_HORAS                 ||
                $tipoContrato == PF_INDIVIDUAL_MENSAL                            ||
                $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
                $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS      ||
                $tipoContrato == PJ_GRUPO_ACIMA_DE_20_HORAS                      ||
                $tipoContrato == PJ_GRUPO_MENSAL                                 ||
                $tipoContrato == PJ_INDIVIDUAL_ACIMA_DE_20_HORAS                 ||
                $tipoContrato == PJ_INDIVIDUAL_MENSAL                            ||
                $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS
            );
        
        if($contratoRevTrad){
            

            
            $contratoRevTradCTRL = new ContratoRevTradController();
            
            $ret = $contratoRevTradCTRL->inserirContratoRevisaoTraducao();
            
            if($ret == 1){
                
                header("LOCATION: ../../contrato-pdf/msg-contrato/mensagem_contrato.php?ret={$ret}");
                exit;
                
            }else {
               
                
                
            }
            
        }else if($contratoCurso){
            
            $contratoCursoCTRL = new ContratoCursoController();
            
            $retorno = $contratoCursoCTRL->inserirContratoCurso();
            
            if(isset($retorno["ret"]) && $retorno["ret"] == 1){
                
                header("LOCATION: ../../contrato-pdf/msg-contrato/mensagem_contrato.php?ret={$retorno['ret']}&id-contrato={$retorno['id-contrato']}&tipo-contrato={$retorno['tipo-contrato']}");
                exit;
                
            }else {
                
                header("LOCATION: ../../contrato-pdf/msg-contrato/mensagem_contrato.php?ret={$retorno}");
                exit;
                
            }
            
        }else{
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Falha ao capturar tipo de contrato");
            
            $ret = -1;
        }
        
    }
?>

<!DOCTYPE html>
<html lang="pt-br" xmlns="http://www.w3.org/1999/html">
    
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Novo contrato</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Novo contrato</h2>
                    <h5><em>Aqui você pode criar um novo contrato</em></h5>
                </div>
                
                <div class="card-body card-body-form">

                    <!--*** DADOS DE INTERESSADOS ***-->
                    <div style="display: block" id="dados-alunos">

                        <div class="row">
                            
                            <input value="<?= $dados_interessado["id_interessado"] ?? "" ?>" type="hidden" id="id-aluno">
                            
                            <input value="<?= $dados_interessado["data_agendamento"] ?? "" ?>" type="hidden" id="data-agendamento">
                            
                            <input value="<?= $dados_interessado["cpf"] ?? "" ?>" type="hidden" id="cpf-aluno">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title" for="nome">Nome completo</label>
                                    <input value="<?=  $dados_interessado["nome"] ?? "" ?> <?=  $dados_interessado["sobrenome"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_interessado) &&  $dados_interessado["nome"] != "" && $dados_interessado["sobrenome"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="nome-completo" name="nome-completo" placeholder="Nome" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="telefone">Telefone</label>
                                    <input value="<?= (isset($dados_interessado) && $dados_interessado["telefone"] != "") ? UtilCTRL::mascaraTelefone($dados_interessado["telefone"]) : "" ?>" class="form-control form-control-sm <?= (isset($dados_interessado) && $dados_interessado["telefone"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="telefone" name="telefone" placeholder="Telefone" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="email">Email</label>
                                    <input value="<?=  $dados_interessado["email"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_interessado) && $dados_interessado["email"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="email" id="email" name="email" placeholder="Email" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="cep">CEP</label>
                                    <input value="<?= (isset($dados_interessado["cep"]) && $dados_interessado["cep"] != "" ) ? UtilCTRL::mascaraCEP($dados_interessado["cep"]) : "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '##.###-###')" type="text" class="form-control form-control-sm <?= (isset($dados_interessado) && $dados_interessado["cep"] != "") ? "is-valid" : "bg-components-form" ?>" id="cep" name="cep" placeholder="CEP" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="endereco">Endereço</label>
                                    <input value="<?= $dados_interessado["rua"] ?? "" ?><?= (isset($dados_interessado["numero"]) && $dados_interessado["numero"] != "") ? ", " . $dados_interessado["numero"] : "" ?>" class="form-control form-control-sm <?= (isset($dados_interessado) && $dados_interessado["rua"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="endereco" name="endereco" placeholder="Endereço" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="complemento">Complemento</label>
                                    <input value="<?= $dados_interessado["complemento"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_interessado) && $dados_interessado["complemento"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="complemento" name="complemento" placeholder="Complemento" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="bairro">Bairro</label>
                                    <input value="<?= $dados_interessado["bairro"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_interessado) && $dados_interessado["bairro"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="bairro" name="bairro" placeholder="Bairro" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="cidade">Cidade</label>
                                    <input value="<?= $dados_interessado["cidade"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_interessado) && $dados_interessado["cidade"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="cidade" name="cidade" placeholder="Cidade" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="uf">UF</label>
                                    <input value="<?= $dados_interessado["uf"] ?? "" ?>" class="form-control form-control-sm <?= (isset($dados_interessado) && $dados_interessado["uf"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="uf" name="uf" placeholder="UF" readonly>
                                </div>
                            </div>

                        </div> <!-- row -->

                    </div> <!-- Fim dados interessados -->

                    <!--OPÇÕES DE INFORMAÇÕES CONTRATUAIS-->
                    <div id="opcoes-informacoes-contratuais">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="card main-body border-orange">

                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-12">

                                                <fieldset id="opcoes-informacoes-contratuais" class="border-warning" form="novo-contrato">

                                                    <legend class="text-white">INFORMAÇÕES CONTRATUAIS</legend>

                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="opcao-contrato-curso" name="tipo-contrato" value="contrato-curso"  class="custom-control-input">
                                                        <label class="custom-control-label font-weight-bold font-italic text-white" for="opcao-contrato-curso">
                                                            CURSO
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="opcao-contrato-traducao" name="tipo-contrato" value="<?= CONTRATO_TRADUCAO ?>" class="custom-control-input">
                                                        <label class="custom-control-label font-weight-bold font-italic text-white" for="opcao-contrato-traducao">
                                                            TRADUÇÃO
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="opcao-contrato-revisao" name="tipo-contrato" value="<?= CONTRATO_REVISAO ?>" class="custom-control-input">
                                                        <label class="custom-control-label font-weight-bold font-italic text-white" for="opcao-contrato-revisao">
                                                            REVISÃO
                                                        </label>
                                                    </div>

                                                </fieldset>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div> <!-- col-->

                        </div> <!-- row -->

                    </div><!-- Fim Opções de informações contratuais-->


                    <!--*** Informações contratuais PF ou PJ ***-->
                    <div id="contrato-curso" style="display: none">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="card my-3 main-body card-opcoes-contratuais">

                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <i class="fas fa-circle text-color-campo-obrigatorio"></i>
                                                    <span class="font-italic text-dark">Required fields</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">

                                                <fieldset class="border-warning" form="form-criar-contrato">

                                                    <legend class="text-white">TIPO DE CLIENTE</legend>

                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="cliente-pf" name="tipo-cliente[]" value="pf" class="custom-control-input">
                                                        <label class="custom-control-label font-weight-bold font-italic text-white" for="cliente-pf">
                                                            PESSOA FÍSICA
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="cliente-pj" name="tipo-cliente[]" value="pj" class="custom-control-input">
                                                        <label class="custom-control-label font-weight-bold font-italic text-white" for="cliente-pj">
                                                            PESSOA JURÍDICA
                                                        </label>
                                                    </div>

                                                    <div class="mt-3"></div>

                                                    <div class="form-group" id="select-pf" style="display: none">
                                                        <label class="input-title text-dark" for="curso">Informações contratuais pessoa física</label>
                                                        <select class="custom-select custom-select-sm campo-obrigatorio" id="select-contrato-pf" name="tipo-contrato">
                                                            <option value="">Selecione...</option>
                                                            <option value="<?= PF_GRUPO_ACIMA_DE_20_HORAS ?>">PF Grupo acima de 20 horas</option>
                                                            <option value="<?= PF_GRUPO_MENSAL ?>">PF Grupo mensal</option>
                                                            <option value="<?= PF_INDIVIDUAL_ACIMA_DE_20_HORAS ?>">PF Individual acima de 20 horas</option>
                                                            <option value="<?= PF_INDIVIDUAL_MENSAL ?>">PF Individual mensal</option>
                                                            <option value="<?= PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ?>">PF INDIVIDUAL - Termo de Compromisso até 20 horas</option>
                                                            <option value="<?= PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS ?>">PF GRUPO - Termo de Compromisso até 20 horas</option>
                                                        </select>
                                                        <small id="msg-erro-select-contrato-pf" class="text-danger invisible">Selecione uma opção do campo <b>informações contratuais pessoa física</b></small>
                                                    </div>

                                                    <div class="form-group" id="select-pj" style="display: none">
                                                        <label class="input-title text-dark" for="curso">Informações contratuais pessoa jurídica</label>
                                                        <select class="custom-select custom-select-sm campo-obrigatorio" id="select-contrato-pj" name="tipo-contrato">
                                                            <option value="">Selecione...</option>
                                                            <option value="<?= PJ_GRUPO_ACIMA_DE_20_HORAS ?>">PJ Grupo acima de 20 horas</option>
                                                            <option value="<?= PJ_GRUPO_MENSAL ?>">PJ Grupo mensal</option>
                                                            <option value="<?= PJ_INDIVIDUAL_ACIMA_DE_20_HORAS ?>">PJ Individual acima de 20 horas</option>
                                                            <option value="<?= PJ_INDIVIDUAL_MENSAL ?>">PJ Individual mensal</option>
                                                            <option value="<?= PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS ?>">PJ - Termo de Compromisso até 20 horas</option>
                                                        </select>
                                                        <small id="msg-erro-select-contrato-pj" class="text-danger invisible">Selecione uma opção do campo <b>informações contratuais pessoa jurídica</b></small>
                                                    </div>

                                                </fieldset>

                                            </div> <!-- FIM Tipo cliente PF | PJ -->

                                        </div> <!-- row  -->

                                    </div> <!-- card-body  -->

                                </div> <!-- card  -->

                            </div> <!-- col-md-12  -->

                        </div> <!-- row  -->

                    </div> <!-- Fim informações contratuais PF ou PJ -->

                </div> <!-- card-body -->
                
            </div> <!-- card -->
            
            <div id="exibir-contrato"></div>
            
        </div> <!-- container -->

        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>
        <script src="../../assets/my-functions-js/novo_contrato.js"></script>
       
    </body>
</html>