<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\AlterarSenhaController;
use Src\traits\UtilCTRL;
use Src\input\Input;

UtilCTRL::validarSessao();

    if(Input::post("btn-alterar") !== null){
        
        $alterarSenhaCTRL = new AlterarSenhaController();
        
        $senhaAtual     = trim(Input::post("senha-atual"));
        $novaSenha      = trim(Input::post("nova-senha"));
        $confirmarSenha = trim(Input::post("confirmar-nova-senha"));
        
        $ret = $alterarSenhaCTRL->buscarSenhaAtual($senhaAtual, $novaSenha, $confirmarSenha);
        
    }
    
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once '../../templates/_head.php' ?>
    <title>Alterar senha</title>
</head>

<body class="main-body">

    <?php include_once '../../templates/_menu.php' ?>

    <div class="container padding-card-pattern">
        <div class="card my-3 main-card">
            <div class="card-header text-left mt-0 header bg-dark">
                <h2>Alterar senha</h2>
                <h5><em>Aqui você alterar sua atual</em></h5>
            </div>
            <div class="card-body card-body-form">
                
                <div class="row">
                    
                    <div class="col-md-12">

                        <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>

                        <form action="alterar_senha.php" method="POST">
                            
                            <div class="form-group">
                                <label class="input-title" for="senha-atual">Senha atual</label>
                                <input class="form-control form-control-sm campo-obrigatorio" type="password" id="senha-atual" name="senha-atual" placeholder="Digite sua senha atual" autocomplete="off">
                                <small id="msg-erro-senha-atual" class="text-danger invisible">Preencha o campo senha atual</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="input-title" for="nova-senha">Nova senha</label>
                                <input class="form-control form-control-sm campo-obrigatorio" type="password" id="nova-senha" name="nova-senha" placeholder="Digite sua nova senha" autocomplete="off">
                                <small class="text-muted">Sua nova senha deve ter no mínimo 4 (quatro) caracteres.</small>
                                <small id="msg-erro-nova-senha" class="text-danger invisible">Preencha o campo nova senha</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="input-title" for="confirmar-nova-senha">Confirmar nova senha</label>
                                <input class="form-control form-control-sm campo-obrigatorio" type="password" id="confirmar-nova-senha" name="confirmar-nova-senha" placeholder="Confirme sua nova senha" autocomplete="off">
                                <small id="msg-erro-confirmar-nova-senha" class="text-danger invisible">Preencha o campo confirmar senha</small>
                            </div>

                            <button onclick="return validarFormulario()" class="btn btn-success btn-pattern" name="btn-alterar" id="btn-alterar">Confirmar</button>

                        </form>

                    </div> <!-- col-12 -->

                </div> <!-- row -->

            </div> <!-- card-body -->
            
        </div> <!-- card -->
        
    </div> <!-- container -->
    
    <!-- inclui os scripts globais -->
    <?php include_once "../../templates/_script.php" ?>

</body>

</html>

