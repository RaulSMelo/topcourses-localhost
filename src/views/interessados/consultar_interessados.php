<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\InteressadoController;
use Src\controllers\CadastroBasicoController;
use Src\models\InteressadoModel;

UtilCTRL::validarTipoDeAcessoADM();

    $cadBasicoCTRL    = new CadastroBasicoController();
    $interessadoCTRL  = new InteressadoController();
    $interessadoModel = new InteressadoModel();
    
    if(filter_input(INPUT_POST, "btn-buscar") !== null){
        
        $data_inicio = Input::post("data-inicio") ?? null;
        $data_final  = Input::post("data-final") ?? null;
        $id_curso    = Input::post("curso", FILTER_SANITIZE_NUMBER_INT) ?? null;
        $id_traducao = Input::post("traducao", FILTER_SANITIZE_NUMBER_INT) ?? null;
        $id_revisao  = Input::post("revisao", FILTER_SANITIZE_NUMBER_INT) ?? null;
        
        $nome = "";
        $sobrenome = "";
        
        if(Input::post("nome") !== null){
            
            $nome_completo = UtilCTRL::retornaNomeEsobrenome(Input::post("nome"));
            $nome          = trim($nome_completo["nome"]);
            $sobrenome     = $nome_completo["sobrenome"] ?? "";
        }
        
        $interessados = $interessadoCTRL->filtrarBuscaInteressados($data_inicio, $data_final, $nome, $sobrenome, $id_curso, $id_traducao, $id_revisao);
        
        if(is_array($interessados)){
            
            
            if(count($interessados) == 0){
                
                $ret = 2;
            }
            
        }else{
            
            $ret = $interessados;
        }
 
    }else if (filter_input(INPUT_POST, "btn-excluir") !== null){
        
        if(Input::post("id-excluir-int-col-emp", FILTER_SANITIZE_NUMBER_INT) !== null){
            
            $id  = Input::post("id-excluir-int-col-emp");
            
            $ret = $interessadoCTRL->excluirInteressado($id);
            
        }else{
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id para realizar a exclusão");
            
            $ret -1;
        }
        
    }else if (filter_input(INPUT_GET, "ret", FILTER_SANITIZE_NUMBER_INT) !== null){
        
        $ret = filter_input(INPUT_GET, "ret");
        
    }
    
    $cursos    = $cadBasicoCTRL->buscarTodosCadastrosBasicos(CURSO);
    $revisoes  = $cadBasicoCTRL->buscarTodosCadastrosBasicos(REVISAO);
    $traducoes = $cadBasicoCTRL->buscarTodosCadastrosBasicos(TRADUCAO);
    
    

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Consultar interessados</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Consultar interessados</h2>
                    <h5><em>Aqui você pode consultar, alterar e excluir os interessados</em></h5>
                </div>
                <div class="card-body card-body-form">
                    
                    <div class="row">
                        
                        <div class="col-12">
                            
                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                            
                            <form action="consultar_interessados.php" method="POST">
                                
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="input-title" for="data-inicio">Data início</label>
                                            <input value="<?= $data_inicio ?? "" ?>" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="form-control form-control-sm <?= (isset($data_inicio) && !empty($data_inicio)) ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="data-inicio" name="data-inicio" placeholder="Data início" autocomplete="off">
                                            <small id="msg-erro-data-inicio" class="text-danger invisible">Preencha o campo data início</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="input-title" for="data-final">Data final</label>
                                            <input value="<?= $data_final ?? "" ?>" onkeypress="return mascaraGenerica(event, this, '##/##/####')" class="form-control form-control-sm <?= (isset($data_final) && !empty($data_final)) ? "is-valid" : "campo-obrigatorio" ?>" type="date" id="data-final" name="data-final" placeholder="Data final" autocomplete="off">
                                            <small id="msg-erro-data-final" class="text-danger invisible">Preencha o campo data final</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div id="datainicio-e-datafinal-alert" class="alert alert-danger mensagem-alerta" role="alert" style="display: none"></div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-title" for="nome">Nome</label>
                                            <input value="<?= $nome ?? "" ?> <?= $sobrenome ?? "" ?>" class="form-control form-control-sm <?= (isset($nome) && !empty($nome) ) ? "is-valid" : "bg-components-form" ?>" type="text" id="nome" name="nome" placeholder="Nome" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group" id="campo-curso">
                                            <label class="input-title" for="curso">Cursos</label>
                                            <select class="custom-select custom-select-sm <?= (isset($id_curso) && !empty($id_curso))? "is-valid" : "bg-components-form" ?>" id="curso" name="curso">
                                                <option value="">Selecione...</option>
                                                
                                                <?php for ($i = 0; $i < count($cursos); $i++) : ?>
                                                    <option value="<?= $cursos[$i]["id_cadastro_basico"] ?>" <?= (isset($id_curso) && $id_curso == $cursos[$i]["id_cadastro_basico"]) ? "selected" : "" ?>><?= $cursos[$i]["nome_cadastro"] ?></option>
                                                <?php endfor; ?>
                                               
                                            </select>
                                            <small id="msg-erro-curso" class="text-danger invisible">Selecione uma opção do campo <b>cursos</b></small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group " id="campo-traducao">
                                            <label class="input-title" for="traducao">Tradução</label>
                                            <select class="custom-select custom-select-sm <?= (isset($id_traducao) && !empty($id_traducao)) ? "is-valid" : "bg-components-form" ?>" id="traducao" name="traducao">
                                                <option value="">Selecione...</option>
                                                
                                                <?php for ($i = 0; $i < count($traducoes); $i++) : ?>
                                                    <option value="<?= $traducoes[$i]["id_cadastro_basico"] ?>" <?= (isset($id_traducao) && $id_traducao == $traducoes[$i]["id_cadastro_basico"]) ? "selected" : "" ?>><?= $traducoes[$i]["nome_cadastro"] ?></option>
                                                <?php endfor; ?>
                                                
                                            </select>
                                            <small id="msg-erro-traducao" class="text-danger invisible">Selecione uma opção do campo <b>tradução</b></small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group " id="campo-revisao">
                                            <label class="input-title" for="revisao">Revisão</label>
                                            <select class="custom-select custom-select-sm <?= (isset($id_revisao) && !empty($id_revisao)) ? "is-valid" : "bg-components-form" ?>" id="revisao" name="revisao">
                                                <option value="">Selecione...</option>
                                                
                                                <?php for ($i = 0; $i < count($revisoes); $i++) : ?>
                                                    <option value="<?= $revisoes[$i]["id_cadastro_basico"] ?>" <?= (isset($id_revisao) && $id_revisao == $revisoes[$i]["id_cadastro_basico"]) ? "selected" : "" ?>><?= $revisoes[$i]["nome_cadastro"] ?></option>
                                                <?php endfor; ?>
                                                    
                                            </select>
                                            <small id="msg-erro-revisao" class="text-danger invisible">Selecione uma opção do campo <b>revisão</b></small>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12">
                                        <button onclick="return validarFormulario()" class="btn btn-info btn-pattern" type="submit" name="btn-buscar" id="btn-buscar">Buscar</button>
                                    </div>
                                </div>
                                
                            </form>
                            
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-12" id="tabela-cansultar-interessados">
                            
                            <?php if(isset($interessados) && count($interessados) > 0):?>

                                <div class="table-responsive">

                                    <table class="table table-striped table-dark mt-4 ">

                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Telefone</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php for ($i = 0; $i < count($interessados); $i++): ?>
                                            
                                                <tr>
                                                    <td class="line-nowrap"><?= $interessados[$i]["nome"] . " " . $interessados[$i]["sobrenome"] ?></td>
                                                    <td class="line-nowrap"><?= $interessados[$i]["email"] ?></td>
                                                    <td class="line-nowrap"><?= UtilCTRL::mascaraTelefone($interessados[$i]["telefone"]) ?></td>
                                                    <td class="line-nowrap">
                                                        <a onclick="capturarFiltrosConsultaInteressado('<?= $interessados[$i]["id_interessado"] ?>','alterar')" name="btn-alterar" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-pencil-alt"></i>
                                                            Alterar
                                                        </a>
                                                        <a onclick="modalExcluirIntColEmp('<?= $interessados[$i]["id_interessado"] ?>', '<?= $interessados[$i]["nome"] . " " . $interessados[$i]["sobrenome"] ?>', '<?= $interessados[$i]["email"] ?>', '<?= UtilCTRL::mascaraTelefone($interessados[$i]["telefone"]) ?>', null, 'esse interessado')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-excluir-int-col-emp">
                                                            <i class="far fa-trash-alt"></i>
                                                            Excluir
                                                        </a>
                                                        <a onclick="capturarFiltrosConsultaInteressado('<?= $interessados[$i]["id_interessado"] ?>','ver_mais')"  class="btn btn-info btn-sm">
                                                            <i class="far fa-eye"></i>
                                                            Ver mais
                                                        </a>
                                                    </td>
                                                </tr>
                                            
                                            <?php endfor ?>

                                        </tbody>
                                    </table>

                                </div> <!-- table-responsive --> 
                            
                            <?php endif ?>
                            
                        </div> <!-- col-12 tabela consultar interessados  -->
                    </div> <!-- row -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- container -->
        

        <form action="consultar_interessados.php" method="POST">
            
            <?php include_once ("../../templates/_modal_excluir_int_col_emp.php") ?>

        </form>

        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>
        <script src="../../assets/my-functions-js/ajax.js"></script>
        <script src="../../assets/my-functions-js/local_storage.js"></script>

    </body>
</html>

