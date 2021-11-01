<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\ColaboradorController;
use Src\controllers\TurmaController;
use Src\erro\Erro;
use Src\input\Input;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

$colaboradorCTRL = new ColaboradorController();
$turmaCTRL       = new TurmaController();

if (filter_input(INPUT_POST, "btn-salvar") !== null) {

    $ret = $turmaCTRL->inserirTurma();
    
}else if (filter_input(INPUT_POST, "btn-alterar") !== null) {
        
        $ret = $turmaCTRL->alterarTurma();
   
    
}else if (filter_input(INPUT_POST, "btn-excluir") !== null) {
    
    if(Input::post("id-turma", FILTER_SANITIZE_NUMBER_INT) !== null){
        
        $id = Input::post("id-turma");
        
        $ret = $turmaCTRL->excluirTurma($id);
        
        if($ret == 0){
            
            Erro::setErro("Não foi possível concluir a exclusão. Turma contém vínculo com contrato");
            
            $ret = -1;
        }
        
    }else{
        
        Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Falha ao capturar o id da turma");
        
        $ret = -1;
    }
    
}


$turmas = $turmaCTRL->buscarTodasTurmas();
$professores = $colaboradorCTRL->buscarColaboradorPorTipo(PROFESSOR);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once '../../templates/_head.php' ?>
</head>

<body class="main-body">

    <?php include_once '../../templates/_menu.php' ?>

    <div class="container padding-card-pattern">
        <div class="card my-3 main-card">
            <div class="card-header text-left mt-0 header bg-dark">
                <h2>Cadastro de Turmas</h2>
                <h5><em>Aqui você pode cadastrar as turmas</em></h5>
            </div>
            <div class="card-body card-body-form">

                <div class="row">

                    <div class="col-md-12">
                        <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                    </div>

                    <div class="col-12">

                        <form action="turma.php" method="POST">

                            <div class="form-group">
                                <i class="fas fa-circle text-color-campo-obrigatorio"></i>
                                <span class="font-italic">Required fields</span>
                            </div>

                            <div class="form-group">
                                <label class="input-title" for="turma">Nome da turma</label>
                                <input class="form-control form-control-sm campo-obrigatorio" id="nome-turma" name="nome-turma" placeholder="Nome da turma" autocomplete="off">
                                <small id="msg-erro-nome-turma" class="text-danger invisible">Preencha o campo <b>nome da turma</b></small>
                            </div>

                            <div class="form-group">
                                <label class="input-title" for="professor">Professor</label>
                                <select class="custom-select custom-select-sm campo-obrigatorio" id="id-colaborador" name="id-colaborador">
                                    <option value="">Selecione...</option>
                                    <?php for ($i = 0; $i < count($professores); $i++) : ?>
                                        <option value="<?= $professores[$i]["id_colaborador"] ?>"><?= $professores[$i]["nome"] . " " . $professores[$i]["sobrenome"] ?></option>
                                    <?php endfor ?>
                                </select>
                                <small id="msg-erro-id-colaborador" class="text-danger invisible">Preencha o campo professor</small>
                            </div>

                            <button onclick="return validarFormulario()" class="btn btn-success btn-pattern" name="btn-salvar" id="btn-salvar">Salvar</button>

                        </form>

                        <hr>


                        <?php if (isset($turmas) && count($turmas) > 0) : ?>

                            <div class="table-responsive">

                                <table class="table table-striped table-dark mt-4 ">

                                    <thead>
                                        <tr>
                                            <th class="line-nowrap">Nome da turma</th>
                                            <th>Professor</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php for ($i = 0; $i < count($turmas); $i++) : ?>

                                            <tr>
                                                <td class="line-nowrap"><?= $turmas[$i]["nome_turma"] ?></td>
                                                <td class="line-nowrap"><?= $turmas[$i]["nome"] . " " . $turmas[$i]["sobrenome"] ?></td>
                                                <td class="line-nowrap">
                                                    <a onclick="modalAlterarTurma('<?= $turmas[$i]["id_turma"] ?>', '<?= $turmas[$i]["nome_turma"] ?>', '<?= $turmas[$i]["id_colaborador"] ?>')" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-alterar-turma">
                                                        <i class="fas fa-pencil-alt"></i>
                                                        Alterar
                                                    </a>
                                                    <a onclick="modalExcluirTurma('<?= $turmas[$i]["id_turma"] ?>', '<?= $turmas[$i]["nome_turma"] ?>', '<?= $turmas[$i]["nome"] . " " . $turmas[$i]["sobrenome"] ?>')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-excluir-turma">
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

                    </div>
                    <!--col-12-->
                </div> <!-- row -->
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- container -->

    <form action="turma.php" method="POST">

        <!-- Modal alterar turma -->
        <div class="modal fade" id="modal-alterar-turma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
                <div class="modal-content main-body border border-warning border-bottom">
                    <div class="modal-header border-bottom border-warning bg-warning">
                        <h5 class="modal-title text-dark" id="exampleModalLabel">Confirmação de Alteraração</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input id="id-turma-alterar" name="id-turma" type="hidden">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-title text-dark" for="nome-modal-alterar-turma">Nome da turma</label>
                                <input class="form-control text-dark campo-obrigatorio-modal" name="nome-turma" id="nome-turma-modal-alterar">
                                <small id="msg-erro-nome-turma-modal-alterar" class="text-danger invisible">Preencha o campo nome da turma</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-title text-dark" for="modal-alterar-id-colaborador">Proferssor</label>
                                <select class="custom-select campo-obrigatorio-modal" type="text" name="id-colaborador" id="modal-alterar-id-colaborador">
                                    <option value="">Selecione...</option>
                                    <?php for ($i = 0; $i < count($professores); $i++) : ?>
                                        <option value="<?= $professores[$i]["id_colaborador"] ?>"><?= $professores[$i]["nome"] . " " . $professores[$i]["sobrenome"] ?></option>
                                    <?php endfor ?>
                                </select>
                                <small id="msg-erro-modal-alterar-id-colaborador" class="text-danger invisible">Selecione uma opção do campo professor</small>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary btn-pattern" data-dismiss="modal">Cancelar</button>
                            <button onclick="return validarCamposModal()" name="btn-alterar" type="submit" class="btn btn-success btn-pattern">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <form action="turma.php" method="POST">
        
        <!-- Modal excluir turma -->
        <div class="modal fade" id="modal-excluir-turma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
                <div class="modal-content main-body border border-danger border-bottom">
                    <div class="modal-header border-bottom border-danger bg-danger">
                        <h5 class="modal-title text-light" id="exampleModalLabel">Confirmação de exclusão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input id="id-turma-excluir" name="id-turma" type="hidden">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-title text-dark" for="nome-modal-excluir-turma">Nome da turma</label>
                                <input class="form-control text-dark font-weight-bold bg-transparent border border" disabled name="nome-turma-modal-excluir" id="nome-turma-modal-excluir">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="input-title text-dark" for="modal-excluir-professor-turma">Professor</label>
                                <input class="form-control text-dark font-weight-bold bg-transparent border" disabled type="text" name="modal-excluir-id-colaborador" id="modal-excluir-id-colaborador">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h5 class="py-3 pl-md-3 bg-danger text-light rounded">Tem certeza que deseja excluir essa turma ?</h5>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary btn-pattern" data-dismiss="modal">Cancelar</button>
                            <button name="btn-excluir" type="submit" class="btn btn-danger btn-pattern">Excluir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <!-- inclui os scripts globais -->
    <?php include_once "../../templates/_script.php" ?>

</body>

</html>