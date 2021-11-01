<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\erro\Erro;
use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\ColaboradorController;

UtilCTRL::validarTipoDeAcessoADM();

$colaboradorCTRL = new ColaboradorController();

if (Input::post("btn-salvar") !== null) {

    $ret = $colaboradorCTRL->inserirColaborador();
    
} else if (Input::post("btn-alterar") !== null) {

    $id = Input::post("id-colaborador", FILTER_SANITIZE_NUMBER_INT);

    $ret = $colaboradorCTRL->alterarColaborador();

    if ($ret == 1) {

        header("LOCATION: gerenciar_colaborador.php?cod={$id}&ret={$ret}");
        
    } else {

        $colaboradores = $colaboradorCTRL->buscarColaboradorPorId($id);

        $arrayIdTipo = $colaboradorCTRL->buscarIdTipoColaboradores($id);
    }
    
} else if (Input::get("cod", FILTER_SANITIZE_NUMBER_INT) !== null) {


    $id = filter_input(INPUT_GET, "cod");

    $resultado = $colaboradorCTRL->buscarColaboradorPorId($id);

    if (is_array($resultado)) {

        $colaboradores = $resultado;

        $arrayIdTipo = $colaboradorCTRL->buscarIdTipoColaboradores($id);
        
    } else if (is_numeric($resultado)) {

        Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possével carregar os dados");

        $ret = -1;
    }
    
    $like = Input::get("like", FILTER_SANITIZE_STRING);
    
}

$tipos_colaboradores = $colaboradorCTRL->buscarTiposDeColaboradores();


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once '../../templates/_head.php' ?>
    <title><?= isset($colaboradores) ? "Alterar" : "Cadastro de" ?> colaboradores</title>
</head>

<body class="main-body">

    <?php include_once '../../templates/_menu.php' ?>

    <div class="container padding-card-pattern">

        <div class="card my-3 main-card">
            <div class="card-header text-left mt-0 header bg-dark">
                <h2><?= isset($colaboradores) ? "Alterar" : "Cadastro de" ?> colaboradores</h2>
                <h5><em>Aqui você pode <?= isset($colaboradores) ? "alterar" : "cadastrar" ?> os colaboradores da empresa</em></h5>
            </div>

            <form action="gerenciar_colaborador.php" method="POST">

                <div class="card-body card-body-form">

                    <div class="row">

                        <div class="col-md-12">
                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <i class="fas fa-circle text-color-campo-obrigatorio"></i>
                                <span class="font-italic">Required fields</span>
                            </div>
                        </div>

                        <!-- INPUT ID-COLABORADOR -->
                        <input type="hidden" id="id-colaborador" name="id-colaborador" value="<?= $colaboradores["id_colaborador"] ?? "" ?>">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="opcoes-tipo-colaboradores">Tipo de colaborador</label>
                                <select multiple="multiple" class="obr d-none campo-obrigatorio" name="opcoes-tipos-colaboradores[]" id="opcoes-tipo-colaboradores">

                                    <?php if (isset($colaboradores)) : ?>

                                        <?php for ($i = 0; $i < count($tipos_colaboradores); $i++) : ?>

                                            <?php

                                            $checked = "";

                                            for ($j = 0; $j < count($arrayIdTipo); $j++) {

                                                if ($tipos_colaboradores[$i]["id_tipo_colaborador"] == $arrayIdTipo[$j]["id_tipo_colaborador"]) {

                                                    $checked = "selected";

                                                    break;
                                                }
                                            }

                                            ?>

                                            <option value="<?= $tipos_colaboradores[$i]["id_tipo_colaborador"] ?>" <?= $checked ?>> <?= $tipos_colaboradores[$i]["nome_tipo"] ?></option>

                                        <?php endfor ?>

                                    <?php else : ?>

                                        <?php for ($i = 0; $i < count($tipos_colaboradores); $i++) : ?>
                                            <option value="<?= $tipos_colaboradores[$i]["id_tipo_colaborador"] ?>"><?= $tipos_colaboradores[$i]["nome_tipo"] ?></option>
                                        <?php endfor ?>

                                    <?php endif ?>

                                </select>
                                <small id="msg-erro-opcoes-tipo-colaboradores" class="text-danger invisible">Selecione uma opção do campo <b>tipo de colaborador</b></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="tipo-acesso">Tipo de acesso</label>
                                <select class="obr custom-select custom-select-sm <?= (isset($colaboradores) && $colaboradores["tipo_acesso"] != "") ? "is-valid" : "campo-obrigatorio" ?>"" name=" tipo-acesso" id="tipo-acesso">
                                    <option value="">Selecione...</option>
                                    <option value="1" <?= (isset($colaboradores) && $colaboradores["tipo_acesso"] == "1") ? "selected" : "" ?>>Administrador - (Geral)</option>
                                    <option value="2" <?= (isset($colaboradores) && $colaboradores["tipo_acesso"] == "2") ? "selected" : "" ?>>Professor(a) - (Pauta)</option>
                                </select>
                                <small id="msg-erro-tipo-acesso" class="text-danger invisible">Selecione uma opção do campo <b>tipo de acesso</b></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="nome">Nome</label>
                                <input value="<?= $colaboradores["nome"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["nome"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="nome" name="nome" placeholder="Nome completo" autocomplete="off">
                                <small id="msg-erro-nome" class="text-danger invisible">Preencha o campo nome</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="sobrenome">Sobrenome</label>
                                <input value="<?= $colaboradores["sobrenome"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["sobrenome"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="sobrenome" name="sobrenome" placeholder="Sobrenome" autocomplete="off">
                                <small id="msg-erro-sobrenome" class="text-danger invisible">Preencha o campo sobrenome</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="email">Email</label>
                                <input value="<?= $colaboradores["email"] ?? "" ?>" class="obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["email"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="email" id="email" name="email" placeholder="Email" autocomplete="off">
                                <div id="email-alert" class="alert alert-danger mt-1 mensagem-alerta" role="alert" style="display: none"></div>
                                <small id="msg-erro-email" class="text-danger invisible">Preencha o campo email</small>
                            </div>
                        </div>

                        <div class="col-md-2 pr-md-2">
                            <div class="form-group">
                                <label class="input-title" for="ddd">DDD</label>
                                <input value="<?= (isset($colaboradores) && $colaboradores["telefone"] != "") ? UtilCTRL::retornaDDD($colaboradores["telefone"]) : "" ?>" maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" class="obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["telefone"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="ddd" name="ddd" placeholder="DDD" autocomplete="off">
                                <small id="msg-erro-ddd" class="text-danger invisible">Preencha o <b>DDD</b></small>
                            </div>
                        </div>

                        <div class="col-md-4 pl-md-2">
                            <div class="form-group">
                                <label class="input-title" for="telefone">Telefone</label>
                                <input value="<?= (isset($colaboradores) && $colaboradores["telefone"] != "") ? UtilCTRL::retornaTelefoneSemDDD($colaboradores["telefone"]) : "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '#####-####')" class="obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["telefone"] != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="telefone" name="telefone" placeholder="Telefone" autocomplete="off">
                                <small id="msg-erro-telefone" class="text-danger invisible">Preencha o campo <b>telefone</b></small>
                            </div>
                        </div>

                        <div class="col-md-1 pr-md-2">
                            <div class="form-group">
                                <label class="input-title" for="ddd-telefone-opcional-colaborador">DDD</label>
                                <input value="<?= (isset($colaboradores) && $colaboradores["telefone_opcional"] != "") ? UtilCTRL::retornaDDD($colaboradores["telefone_opcional"]) : "" ?>" maxlength="2" onkeypress="return mascaraGenerica(event, this, '##')" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["telefone_opcional"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="ddd-telefone-opcional-colaborador" name="ddd-telefone-opcional" placeholder="DDD" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-5 pl-md-2">
                            <div class="form-group">
                                <label class="input-title" for="telefone-opcional-colaborador">Telefone opcional</label>
                                <input value="<?= (isset($colaboradores) && $colaboradores["telefone_opcional"] != "") ? UtilCTRL::retornaTelefoneSemDDD($colaboradores["telefone_opcional"]) : "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '#####-####')" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["telefone_opcional"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="telefone-opcional-colaborador" name="telefone-opcional" placeholder="Telefone" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="cpf">CPF</label>
                                <input value="<?= (isset($colaboradores) && $colaboradores["cpf"] != "") ? UtilCTRL::mascaraCPF($colaboradores["cpf"]) : ""  ?>" maxlength="14" onkeypress="return mascaraGenerica(event, this, '###.###.###-##')" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["cpf"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="cpf" name="cpf" placeholder="CPF" autocomplete="off">
                            </div>
                        </div>

                        <input type="hidden" name="id-endereco" value="<?= $colaboradores["id_endereco"] ?? "" ?>">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="cep">CEP</label>
                                <input value="<?= (isset($colaboradores) && $colaboradores["cep"] != "") ? UtilCTRL::mascaraCEP($colaboradores["cep"]) : "" ?>" maxlength="10" onkeypress="return mascaraGenerica(event, this, '##.###-###')" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["cep"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="cep" name="cep" placeholder="CEP" autocomplete="off">
                                <small class="text-muted m-md-1">Digite o CEP para obter automaticamente o endereço completo</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="rua">Rua</label>
                                <input value="<?= $colaboradores["rua"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["rua"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="logradouro" name="rua" placeholder="Rua" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-title" for="num">Número</label>
                                <input value="<?= $colaboradores["numero"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["numero"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="num" name="numero" placeholder="Número" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-title" for="complemento">Complemento</label>
                                <input value="<?= $colaboradores["complemento"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["complemento"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="complemento" name="complemento" placeholder="Complemento" autocomplete="off">
                                <small id="msg-erro-complemento" class="text-danger invisible">Preencha o campo <b>complemento</b></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="bairro">Bairro</label>
                                <input value="<?= $colaboradores["bairro"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["bairro"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="bairro" name="bairro" placeholder="Bairro" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="cidade">Cidade</label>
                                <input value="<?= $colaboradores["cidade"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["cidade"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="localidade" name="cidade" placeholder="Cidade" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-title" for="estado">UF</label>
                                <input value="<?= $colaboradores["uf"] ?? "" ?>" class="nao-obr form-control form-control-sm <?= (isset($colaboradores) && $colaboradores["cidade"] != "") ? "is-valid" : "bg-components-form" ?>" type="text" id="uf" name="uf" placeholder="Estado" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="modal-footer border-0 pr-0">
                                <?php if (isset($colaboradores)) : ?>
                                    <a href="consultar_colaborador.php?like=<?= $like ?? "" ?>" class="btn btn-secondary btn-pattern">
                                        Cancelar
                                    </a>
                                <?php endif ?>
                                <button onclick="return validarFormulario()" class="btn <?= isset($colaboradores) ? "btn-success" : "btn-success" ?> btn-pattern" type="submit" name="<?= isset($colaboradores) ? "btn-alterar" : "btn-salvar" ?>" id="btn-salvar"><?= isset($colaboradores) ? "Alterar" : "Salvar" ?></button>
                            </div>
                        </div>

                    </div> <!-- row -->
                </div> <!-- card-body -->
            </form>
        </div> <!-- card -->
    </div> <!-- container -->

    <!-- inclui os scripts globais -->
    <?php include_once "../../templates/_script.php" ?>
    <script src="../../assets/my-functions-js/ajax.js"></script>


    <!-- Initialize the plugin: -->
    <script>
        
        $(document).ready(function() {
            
            let opcoesSelecionadas = 0;

            $('#opcoes-tipo-colaboradores').multiselect({
                
                buttonTextAlignment: "left",
                buttonWidth: "100%",
                
                onChange: function(option, checked, select) {
                    
                    opcoesSelecionadas = $("#opcoes-tipo-colaboradores option:selected");
                                      
                    if(opcoesSelecionadas.length > 0){
                        
                        if(this.$button[0].classList.contains("is-invalid")){
                            
                            this.$button[0].classList.remove("is-invalid");
                        }
                        
                        this.$button[0].classList.remove("campo-obrigatorio");
                        this.$button[0].classList.add("is-valid");
                        
                    }else{
                        
                        this.$button[0].classList.remove("is-valid");
                        this.$button[0].classList.add("campo-obrigatorio");
                        
                    }
                },

                buttonClass: "custom-select custom-select-sm campo-obrigatorio",
                allSelectedText: "Todas opções selecionadas"
            });
            
            if($("#opcoes-tipo-colaboradores option:selected").length > 0){

                const campo_multiselect = $("span.multiselect-native-select div.btn-group button.multiselect");
                
                campo_multiselect[0].classList.remove("campo-obrigatorio");
                campo_multiselect[0].classList.add("is-valid");
            }
        });

        
    </script>


</body>

</html>