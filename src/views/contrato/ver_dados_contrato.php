<?php
require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\InteressadoController;
use Src\controllers\CadastroBasicoController;
use Src\input\Input;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

    if (Input::get("cod", FILTER_SANITIZE_NUMBER_INT) !== null) {

        $interessadoCTRL = new InteressadoController();
        $cadBasicoCTRL = new CadastroBasicoController();

        $id = Input::get("cod");

        $interessado = $interessadoCTRL->buscarInteressadoPorId($id);

        if (!empty($interessado["id_midia"])) {

            $midia = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_midia"]);
        }

        if (!empty($interessado["id_resultado"])) {

            $resultado = $cadBasicoCTRL->buscarUmCadastroBasico($interessado["id_resultado"]);
        }

        $like = Input::get("like");
        $situacao = Input::get("situacao", FILTER_SANITIZE_NUMBER_INT) ?? "";
        
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
<?php include_once '../../templates/_head.php' ?>

        <title>Dados do cliente | Novo ou Consultar contrato</title>
    </head>

    <body class="main-body">
<?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark border-bottom border-orange">
                    <h2>Dados do cliente</h2>
                    <h5><em>Aqui você pode somente ver os dados do cadastro do cliente</em></h5>
                </div>

                <form id="cadastro-interessados" action="cadastrar_interessados.php" method="POST">

                    <div class="card-body main-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="nome-completo">Nome Completo</label>
                                    <input value="<?= $interessado["nome"] ?? "" ?> <?= $interessado["sobrenome"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="nome-completo" name="nome-completo" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="telefone">Telefone</label>
                                    <input value="<?= (isset($interessado["telefone"]) && $interessado["telefone"] != "") ? UtilCTRL::mascaraTelefone($interessado["telefone"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="telefone" name="telefone" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="email">Email</label>
                                    <input value="<?= $interessado["email"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="email" id="email" name="email">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="cpf">CPF</label>
                                    <input value="<?= (isset($interessado["cpf"]) && $interessado["cpf"] != "") ? UtilCTRL::mascaraCPF($interessado["cpf"]) : "" ?>" class="form-control form-control-sm bg-components-form bg-transparent border text-white" type="text" id="cpf" name="cpf" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="profissao">Profissao</label>
                                    <input value="<?= $interessado["profissao"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="profissao" name="profissao" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="cep">CEP</label>
                                    <input value="<?= (isset($interessado["cep"]) && $interessado["cep"] != "") ? UtilCTRL::mascaraCEP($interessado["cep"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cep" name="cep" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="rua">Endereço</label>
                                    <input value="<?= $interessado["rua"] ?? "" ?><?= (isset($interessado["rua"]) && isset($interessado["numero"]) && $interessado["rua"] != "" && $interessado["numero"] != "") ? ", " . $interessado["numero"] : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="rua" name="rua" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="bairro">Bairro</label>
                                    <input value="<?= $interessado["bairro"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" id="bairro" name="bairro" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="cidade">Cidade</label>
                                    <input value="<?= $interessado["cidade"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cidade" name="cidade" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="estado">UF</label>
                                    <input value="<?= $interessado["uf"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="estado" name="estado" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="midia">Mídia</label>
                                    <input value="<?= (isset($midia) && $midia != "") ? $midia["nome_cadastro"] : "" ?>" class="form-control form-control-sm bg-transparent border text-white" id="midia" name="midia" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-title" for="resultado">Resultado</label>
                                    <input value="<?= (isset($resultado) && $resultado != "") ? $resultado["nome_cadastro"] : "" ?>" class="form-control form-control-sm bg-transparent border text-white" id="resultado" name="resultado" disabled>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title" for="info-add">Informações adicionais</label>
                                    <textarea class="form-control form-control-sm bg-transparent border text-white" style="resize: none" rows="5" type="text" id="info-add" name="info-add" disabled><?= $interessado["informacoes_adicionais"] ?? "" ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <a href="consultar_contrato.php?like=<?= $like ?? "" ?>&situacao=<?= $situacao ?? "" ?>" class="btn btn-dark btn-pattern">
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
<?php include_once "../../templates/_script.php" ?>

    </body>
</html>

