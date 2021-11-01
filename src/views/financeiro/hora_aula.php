<?php 

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\CadastroBasicoController;
use Src\controllers\HoraAulaController;
use Src\input\Input;
use Src\erro\Erro;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

    
    $cadBasicoCTRL = new CadastroBasicoController();
    $horaAulaCTRL  = new HoraAulaController();
    
    if(filter_input(INPUT_POST, "btn-salvar") !== null){
        
        $ret = $horaAulaCTRL->inserirHoraAula();
        
    }else if (filter_input(INPUT_POST, "btn-alterar") !== null){
        
        $ret = $horaAulaCTRL->alterarHoraAula();
        
    }else if (filter_input(INPUT_POST, "btn-excluir") !== null){
        
        if(Input::post("id-hora-aula", FILTER_SANITIZE_NUMBER_INT) !== null){
            
            $id = Input::post("id-hora-aula");
            
            $ret = $horaAulaCTRL->excluirHoraAula($id);
            
        }else{
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Falha ao capturar o id da hora/aula");
            
            $ret -1;
        }
        
    }
        
    $horasAulas = $horaAulaCTRL->buscarTodasHorasAulas();
    $idiomas    = $cadBasicoCTRL->buscarTodosCadastrosBasicos(IDIOMA);    
?>

<!DOCTYPE html>
<html lang="pt-bt">

    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Cadastro de preços da hora aula</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Cadastro de preços das horas/aula</h2>
                    <h5><em>Aqui você pode cadastrar os preços de uma(1) hora de aula respectivo ao indioma</em></h5>
                </div>
                <div class="card-body card-body-form">

                    <div class="row">
                        
                        <div class="col-md-12">
                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <i class="fas fa-circle text-color-campo-obrigatorio"></i>
                                <span class="font-italic">Required fields</span>
                            </div>
                        </div>

                        <div class="col-12">

                            <form action="" method="POST">

                                <div class="form-group">
                                    <label class="input-title" for="idioma">Idiomas</label>
                                    <select class="custom-select custom-select-sm campo-obrigatorio" id="idioma" name="id-idioma" autocomplete="off">
                                        <option value="">Selecione...</option>
                                        <?php for($i = 0; $i < count($idiomas); $i++): ?>
                                            <option value="<?= $idiomas[$i]["id_cadastro_basico"] ?>"><?= $idiomas[$i]["nome_cadastro"] ?></option>
                                        <?php endfor ?>
                                    </select>
                                    <small id="msg-erro-idioma" class="text-danger invisible">Selecione uma opção do campo idiomas</small>
                                </div>

                                <div class="form-group">
                                    <label class="input-title" for="valor-hora-aula">Preço hora/aula</label>
                                    <input data-moeda class="form-control form-control-sm campo-obrigatorio" type="text" id="valor-hora-aula" name="valor-hora-aula" placeholder="Preço" autocomplete="off">
                                    <small id="msg-erro-valor-hora-aula" class="text-danger invisible">Preencha o campo preço hora/aula</small>
                                </div>

                                <button onclick="return validarFormulario()" class="btn btn-success btn-pattern" name="btn-salvar" id="btn-salvar">Salvar</button>

                            </form>

                            <hr>
                            
                            <?php if(isset($horasAulas) && count($horasAulas) > 0): ?>

                                <div class="table-responsive">

                                    <table class="table table-striped table-dark mt-4">

                                        <thead>
                                            <tr>
                                                <th>Indiomas</th>
                                                <th>Preços</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php for($i = 0; $i < count($horasAulas); $i++): ?>
                                            
                                                <tr>
                                                    <td class="line-nowrap"><?= $horasAulas[$i]["nome_cadastro"] ?></td>
                                                    <td class="line-nowrap"><?= (isset($horasAulas[$i]["valor_hora_aula"]) && $horasAulas[$i]["valor_hora_aula"] != "") ? UtilCTRL::formatoMoedaBRComSifrao($horasAulas[$i]["valor_hora_aula"]) : "" ?></td>
                                                    <td class="line-nowrap">
                                                        <a onclick="modalAlterarHoraAula('<?= $horasAulas[$i]["id_hora_aula"] ?>', '<?= $horasAulas[$i]["id_idioma"] ?>', '<?= UtilCTRL::formatoMoedaBRSemSifrao($horasAulas[$i]["valor_hora_aula"]) ?>')" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-alterar-hora-aula">
                                                            <i class="fas fa-pencil-alt"></i>
                                                            Alterar
                                                        </a>
                                                        <a onclick="modalExcluirHoraAula('<?= $horasAulas[$i]["id_hora_aula"] ?>', '<?= $horasAulas[$i]["nome_cadastro"] ?>', '<?= UtilCTRL::formatoMoedaBRComSifrao($horasAulas[$i]["valor_hora_aula"]) ?>')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-excluir-hora-aula">
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

        <form action="hora_aula.php" method="POST">

            <!-- Modal alterar turma -->
            <div class="modal fade" id="modal-alterar-hora-aula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
                    <div class="modal-content main-body border border-warning border-bottom">
                        <div class="modal-header border-bottom border-warning bg-warning">
                            <h5 class="modal-title text-dark" id="exampleModalLabel">Confirmação de Alteraração</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <input id="id-alterar-hora-aula" name="id-hora-aula" type="hidden">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="modal-alterar-idioma-hora-aula">Idiomas</label>
                                    <select class="custom-select campo-obrigatorio-modal" type="text" name="id-idioma" id="modal-alterar-idioma-hora-aula" >
                                        <option value="">Selecione...</option>
                                        <?php for($i = 0; $i < count($idiomas); $i++): ?>
                                            <option value="<?= $idiomas[$i]["id_cadastro_basico"] ?>"><?= $idiomas[$i]["nome_cadastro"] ?></option>
                                        <?php endfor ?>
                                    </select>
                                    <small id="msg-erro-modal-alterar-idioma-hora-aula" class="text-danger invisible">Selecione uma opção do campo idiomas</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="modal-alterar-valor-hora-aula">Preço hora/aula</label>
                                    <input data-moeda class="form-control text-dark campo-obrigatorio-modal" name="valor-hora-aula" id="modal-alterar-valor-hora-aula" >
                                    <small id="msg-erro-modal-alterar-valor-hora-aula" class="text-danger invisible">Preencha o campo preço hora/aula</small>
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
        
        <form action="hora_aula.php" method="POST">

            <!-- Modal excluir turma -->
            <div class="modal fade" id="modal-excluir-hora-aula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
                    <div class="modal-content main-body border border-danger border-bottom">
                        <div class="modal-header border-bottom border-danger bg-danger">
                            <h5 class="modal-title text-light" id="exampleModalLabel">Confirmação de exclusão</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <input id="id-excluir-hora-aula" name="id-hora-aula" type="hidden">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="modal-excluir-idioma-hora-aula">Idioma</label>
                                    <input class="form-control text-dark font-weight-bold bg-transparent border border" disabled name="idioma" id="modal-excluir-idioma-hora-aula" >
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="input-title text-dark" for="modal-excluir-valor-hora-aula">Preço hora/aula</label>
                                    <input class="form-control text-dark font-weight-bold bg-transparent border" disabled type="text" name="valor-hora-aula" id="modal-excluir-valor-hora-aula">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h5 class="py-3 pl-md-3 bg-danger text-light rounded">Tem certeza que deseja excluir esse preço da hora/aula?</h5>
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

