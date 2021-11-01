<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\CadastroBasicoController;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

$cadBasicoCTRL  = new CadastroBasicoController();

if (isset($_POST["btn-salvar"])) {

    $ret = $cadBasicoCTRL->inserirCadastroBasico(RESULTADO);
    
}else if (isset($_POST["btn-alterar"])) {

    $ret = $cadBasicoCTRL->alterarCadastroBasico(RESULTADO);
    
}else if (isset($_POST["btn-excluir"])) {

    $ret = $cadBasicoCTRL->excluirCadastroBasico();
    
}

$resultados = $cadBasicoCTRL->buscarTodosCadastrosBasicos(RESULTADO);

?>

<!DOCTYPE html>
<html>

<head lang="pt-br">
    <?php include_once '../../templates/_head.php' ?>
    <title>Cadastro de resultados</title>
</head>

<body class="main-body">

    <?php include_once '../../templates/_menu.php' ?>

    <div class="container padding-card-pattern">
        <div class="card my-3 main-card">
            <div class="card-header text-left mt-0 header bg-dark">
                <h2>Cadastro de resultados</h2>
                <h5><em>Aqui você pode cadastrar, alterar e excluir os possíveis resultados</em></h5>
            </div>
            <div class="card-body card-body-form">

                <div class="row">

                    <div class="col-12">

                        <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>

                        <form action="resultado.php" method="POST">
                            <div class="form-group">
                                <label class="input-title" for="nome-resultado">Nome do resultado</label>
                                <input class="form-control form-control-sm campo-obrigatorio" type="text" id="nome-resultado" name="nome-cadastro" placeholder="Nome do resultado" autocomplete="off">
                                <small id="msg-erro-nome-resultado" class="text-danger invisible">Preencha o campo nome do resultado</small>
                            </div>
                            <button onclick="return validarFormulario()" class="btn btn-success btn-pattern" name="btn-salvar" id="btn-salvar">Salvar</button>
                        </form>

                        <hr>

                        <?php if (count($resultados) > 0) : ?>

                            <div class="table-responsive">

                                <table class="table table-striped table-dark mt-4 ">
                                    <thead>
                                        <tr>
                                            <th>Resultados</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php for ($i = 0; $i < count($resultados); $i++) : ?>

                                            <tr>
                                                <td class="line-nowrap"><?= $resultados[$i]["nome_cadastro"] ?></td>
                                                <td class="line-nowrap">
                                                    <a onclick="modalAlterarCadastroBasico('<?= $resultados[$i]["id_cadastro_basico"] ?>', '<?= $resultados[$i]["nome_cadastro"] ?>')" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-alterar">
                                                        <i class="fas fa-pencil-alt"></i>
                                                        Alterar
                                                    </a>
                                                    <a onclick="modalExcluirCadastroBasico('<?= $resultados[$i]["id_cadastro_basico"] ?>', '<?= $resultados[$i]["nome_cadastro"] ?>')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-excluir">
                                                        <i class="far fa-trash-alt"></i>
                                                        Excluir
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

    <form action="resultado.php" method="POST">
        <!--INCLUINDO MODAL EXCLUIR-->
        <?php include_once "../../templates/_modal_excluir.php" ?>

        <!--INCLUINDO MODAL ALTERAR-->
        <?php include_once "../../templates/_modal_alterar.php" ?>
    </form>

    <!-- inclui os scripts globais -->
    <?php include_once "../../templates/_script.php" ?>

</body>

</html>