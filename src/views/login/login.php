<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\input\Input;
use Src\controllers\LoginController;
use Src\traits\UtilCTRL;

UtilCTRL::destruirSessaoDoUsuario();

    if(Input::post("btn-logar") !== null){
        
        $loginCTRL = new LoginController();

        $login = trim(Input::post("usuario"));
        $senha = trim(Input::post("senha"));
        
        $ret = $loginCTRL->validarLogin($login, $senha);
        
    }


?>

<!doctype html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Top courses | login</title>

    </head>

    <body class="body-login">

        <div class="container">
            <div class="card card-login-main card-login mx-auto text-center bg-dark">
                <div class="card-header-login mx-auto bg-dark text-center">
                    <div class="div-logotipo-login mx-auto mb-3">
                        <img src="../../assets/img/logotipo-top-courses-800x375.png" class="w-75" alt="Logotipo da escola">
                    </div>
                    
                    <span class="logo_title mt-5">Entre com seus dados</span>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                            
                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                    
                            <form action="" method="post">

                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" id="usuario" name="usuario" class="form-control form-control-login" placeholder="Usuário" autocomplete="off">
                                    <small id="msg-erro-usuario" class="text-danger invisible">Preencha o campo usuário</small>
                                </div>

                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" id="senha" name="senha" class="form-control form-control-login" placeholder="Senha" autocomplete="off">
                                    <small id="msg-erro-senha" class="text-danger invisible">Preencha o campo senha</small>
                                </div>

                                <div class="form-group">
                                    <input onclick="return validarFormulario()" type="submit" id="btn-logar" name="btn-logar" value="Login" class="btn btn-outline-danger-login float-right login_btn">
                                </div>

                            </form>
                            
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>

        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php"?>

    </body>
</html>