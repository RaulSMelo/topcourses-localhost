<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\traits\UtilCTRL;
use Src\input\Input;
use Src\controllers\ConfiguracaoEmpresaController;

UtilCTRL::validarTipoDeAcessoADM();
    
    $configEmpresaCTRL = new ConfiguracaoEmpresaController();

    if(Input::post("btn-alterar") !== null){  
        
        $ret = $configEmpresaCTRL->alterarDadosConfiguracaoEmpresa();
    }
    
    $empresa = $configEmpresaCTRL->buscarTodosDadosConfiguracaoEmpresa();
    

?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Configuração da empresa</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Configuração da empresa</h2>
                    <h5><em>Aqui você pode alterar os dados da empresa</em></h5>
                </div>
                <div class="card-body card-body-form">

                    <form action="configuracao_empresa.php" method="POST">

                        <div class="row">
                            
                            <div class="col-md-12">
                                <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="razao-social">Razão social</label>
                                    <input value="<?= $empresa["razao_social"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["razao_social"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="razao-social" name="razao-social" placeholder="Razão social" autocomplete="off">
                                    <small id="msg-erro-razao-social" class="text-danger invisible">Preencha o campo <b>razão social</b></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="cnpj">CNPJ</label>
                                    <input value="<?= (isset($empresa) && $empresa["cnpj"] != "") ? UtilCTRL::mascaraCNPJ($empresa["cnpj"]) : "" ?>" maxlength="18" onkeypress="return mascaraGenerica(event, this, '##.###.###/####-##')" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["cnpj"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="cnpj" name="cnpj" placeholder="CNPJ" autocomplete="off">
                                    <small id="msg-erro-cnpj" class="text-danger invisible">Preencha o campo <b>CNPJ</b></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="email-empresa">Email</label>
                                    <input value="<?= $empresa["email"] ?? "" ?>" class="form-control form-control-sm <?= (isset($empresa) && $empresa["email"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="email" id="email-empresa" name="email-empresa" placeholder="Email" autocomplete="off">
                                    <div id="email-alert" class="obr alert alert-danger mensagem-alerta mt-1" role="alert" style="display: none"></div>
                                    <small id="msg-erro-email-empresa" class="text-danger invisible">Preencha o campo <b>email</b></small>
                                </div>
                            </div>

                            <div class="col-md-2 pr-md-2">
                                <div class="form-group">
                                    <label class="input-title" for="ddd">DDD</label>
                                    <input value="<?= (isset($empresa) && $empresa["telefone"] != "") ? UtilCTRL::retornaDDD($empresa["telefone"]) : "" ?>" maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["telefone"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="ddd" name="ddd" placeholder="DDD" autocomplete="off">
                                    <small id="msg-erro-ddd" class="text-danger invisible">Preencha o <b>DDD</b></small>
                                </div>
                            </div>

                            <div class="col-md-4 pl-md-2">
                                <div class="form-group">
                                    <label class="input-title" for="telefone">Telefone</label>
                                    <input value="<?= (isset($empresa) && $empresa["telefone"] != "") ? UtilCTRL::retornaTelefoneSemDDD($empresa["telefone"]) : "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '#####-####')" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["telefone"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="telefone" name="telefone" placeholder="Telefone" autocomplete="off">
                                    <small id="msg-erro-telefone" class="text-danger invisible">Preencha o campo <b>telefone</b></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="cep">CEP</label>
                                    <input value="<?= (isset($empresa) && $empresa["cep"] != "") ? UtilCTRL::mascaraCEP($empresa["cep"]) : "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '##.###-###')" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["cep"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="cep" name="cep" placeholder="CEP" autocomplete="off">
                                    <small class="text-muted m-md-1">Digite o CEP para obter automaticamente o endereço completo</small>
                                    <small id="msg-erro-cep" class="text-danger invisible">Preencha o campo <b>CEP</b></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="rua">Rua</label>
                                    <input value="<?= $empresa["rua"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["rua"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="logradouro" name="rua" placeholder="Rua" autocomplete="off">
                                    <small id="msg-erro-logradouro" class="text-danger invisible">Preencha o campo <b>rua</b></small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-title" for="num">Número</label>
                                    <input value="<?= $empresa["numero"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["numero"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="num" name="numero" placeholder="Número" autocomplete="off">
                                    <small id="msg-erro-num" class="text-danger invisible">Preencha o campo número</small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-title" for="complemento">Complemento</label>
                                    <input value="<?= $empresa["complemento"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($empresa) && $empresa["complemento"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="complemento" name="complemento" placeholder="Complemento" autocomplete="off">
                                    <small id="msg-erro-complemento" class="text-danger invisible">Preencha o campo complemento</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="bairro">Bairro</label>
                                    <input value="<?= $empresa["bairro"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["bairro"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="bairro" name="bairro" placeholder="Bairro" autocomplete="off">
                                    <small id="msg-erro-bairro" class="text-danger invisible">Preencha o campo bairro</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="cidade">Cidade</label>
                                    <input value="<?= $empresa["cidade"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["cidade"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="localidade" name="cidade" placeholder="Cidade" autocomplete="off">
                                    <small id="msg-erro-localidade" class="text-danger invisible">Preencha o campo <b>cidade</b></small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="input-title" for="estado">Estado</label>
                                    <input value="<?= $empresa["estado"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($empresa) && $empresa["estado"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="estado" name="estado" placeholder="Estado" autocomplete="off">
                                    <small id="msg-erro-estado" class="text-danger invisible">Preencha o campo <b>estado</b></small>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="input-title" for="uf">UF</label>
                                    <input value="<?= $empresa["uf"] ?? "" ?>" maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" class="obr form-control form-control-sm text-uppercase <?= (isset($empresa) && $empresa["uf"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="uf" name="uf" placeholder="UF" autocomplete="off">
                                    <small id="msg-erro-uf" class="text-danger invisible">Preencha o campo <b>estado</b></small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title" for="nome-fant">Nome fantasia(opcional)</label>
                                    <input value="<?= $empresa["nome_fantasia"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($empresa) && $empresa["nome_fantasia"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="nome-fant" name="nome-fantasia" placeholder="Nome fantasia" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <button onclick="return validarFormulario()" class="btn btn-success btn-pattern" name="btn-alterar" id="btn-alterar">Confirmar</button>
                                </div>
                            </div>    

                        </div> <!-- row -->

                    </form>

                </div> <!-- card-body -->

            </div> <!-- card -->

        </div> <!-- container -->

        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>

    </body>

</html>

