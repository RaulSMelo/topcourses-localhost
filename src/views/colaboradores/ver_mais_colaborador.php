<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\erro\Erro;
use Src\traits\UtilCTRL;
use Src\controllers\ColaboradorController;

UtilCTRL::validarTipoDeAcessoADM();


if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT) !== null) {

    $colaboradorCTRL = new ColaboradorController();

    $id = filter_input(INPUT_GET, "cod");

    $resultado = $colaboradorCTRL->buscarColaboradorPorId($id);

    if (is_array($resultado)) {

        $nomes_tipos = $colaboradorCTRL->buscarNomeTipoColaboradorPorId($id);

        if (!is_string($nomes_tipos)) {

            $ret = $nomes_tipos;
        }

        $colaboradores = $resultado;
        
    } else {

        Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possével carregar os dados");

        $ret = -1;
    }
    
    $like = filter_input(INPUT_GET, "like", FILTER_SANITIZE_STRING);
    
}


?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once '../../templates/_head.php' ?>
    <title>Cadastro de colaboradores</title>
</head>

<body class="main-body">

    <?php include_once '../../templates/_menu.php' ?>

    <div class="container padding-card-pattern">
        <div class="card my-3 main-card">
            <div class="card-header text-left mt-0 header border-orange bg-dark">
                <h2>Dados do cadastro do colaborador</h2>
                <h5><em>Aqui você pode somente ver os dados do cadastro do colaborador</em></h5>
            </div>

            <div class="card-body main-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="opcoes-tipo-colaboradores">Tipo de colaborador</label>
                            <input value="<?= $nomes_tipos ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" name="tipo-colaboradores" id="tipo-colaboradores" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="tipo-acesso">Tipo de acesso</label>
                            <select class="custom-select custom-select-sm bg-transparent border text-white" name="tipo-acesso" id="tipo-acesso" disabled>
                                <option value="1" <?= (isset($colaboradores["tipo_acesso"]) && $colaboradores["tipo_acesso"] == "1") ? "selected" : "" ?>>Administrador(a) geral</option>
                                <option value="2" <?= (isset($colaboradores["tipo_acesso"]) && $colaboradores["tipo_acesso"] == "2") ? "selected" : "" ?>>Professor(a) pauta</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="nome">Nome Completo</label>
                            <input value="<?= $colaboradores["nome"] ?? "" ?> <?= $colaboradores["sobrenome"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="nome-completo" name="nome-completo" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="cpf">CPF</label>
                            <input value="<?= (isset($colaboradores["cpf"]) && !empty($colaboradores["cpf"])) ? UtilCTRL::mascaraCPF($colaboradores["cpf"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cpf" name="cpf" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="email">Email</label>
                            <input value="<?= $colaboradores["email"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="email" id="email" name="email" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="telefone">Telefone</label>
                            <input value="<?= $colaboradores["telefone"] != "" ?  UtilCTRL::mascaraTelefone($colaboradores["telefone"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="telefone" name="telefone" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="telefone-opcional-colaborador">Telefone opcional</label>
                            <input value="<?= $colaboradores["telefone_opcional"] != "" ?  UtilCTRL::mascaraTelefone($colaboradores["telefone_opcional"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="telefone-opcional-colaborador" name="telefone-opcional-colaborador" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="cep">CEP</label>
                            <input value="<?= $colaboradores["cep"] != "" ? UtilCTRL::mascaraCEP($colaboradores["cep"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cep" name="cep" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="rua">Rua</label>
                            <input value="<?= (isset($colaboradores["rua"]) && !empty($colaboradores["rua"]) && isset($colaboradores["numero"]) && !empty($colaboradores["numero"])) ? $colaboradores["rua"] . ", " . $colaboradores["numero"]  : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="rua" name="rua" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="bairro">Bairro</label>
                            <input value="<?= $colaboradores["bairro"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="bairro" name="bairro" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="cidade">Cidade</label>
                            <input value="<?= $colaboradores["cidade"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cidade" name="cidade" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="estado">Estado</label>
                            <input value="<?= $colaboradores["uf"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="estado" name="estado" disabled>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <a href="consultar_colaborador.php?like=<?= $like ?? "" ?>" class="btn btn-dark btn-pattern">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Voltar
                        </a>
                    </div>

                </div> <!-- row -->

            </div> <!-- card-body -->

        </div> <!-- card -->

    </div> <!-- container -->

    <!-- inclui os scripts globais -->
    <?php include_once "../../templates/_script.php" ?>

</body>

</html>