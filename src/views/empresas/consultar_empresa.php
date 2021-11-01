<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\EmpresaController;
use Src\input\Input;
use Src\erro\Erro;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();
    
    $empresaCTRL = new EmpresaController();

    if(filter_input(INPUT_POST, "btn-buscar") !== null){
        
        if(Input::post("nome-empresa") !== null){
            
            $nome = trim(Input::post("nome-empresa"));
            
            $resultado = $empresaCTRL->buscarEmpresaPorRazaoScialOuPorNomeFantasia($nome);
            
            if(is_array($resultado) && count($resultado) > 0){
                
                $empresas = $resultado;
                
            }else{

                $ret = 2;
            }
            
        }       
    }else if (filter_input(INPUT_POST, "btn-excluir") !== null) {
        
        if(Input::post("id-excluir-int-col-emp", FILTER_SANITIZE_NUMBER_INT) !== null){
            
            $id = Input::post("id-excluir-int-col-emp");

            $ret = $empresaCTRL->excluirEmpresa($id);

            if($ret == 0){

                Erro::setErro("Não foi possível concluir a exclusão. Empresa contém vínculo com contrato");

                $ret = -1;

            }

            if(Input::post("filtro-nome") !== null){

                $nome = Input::post("filtro-nome");

                $empresas = $empresaCTRL->buscarEmpresaPorRazaoScialOuPorNomeFantasia($nome);

                if(count($empresas) == 0){

                    $ret = 2;
                }
            }
            
        }else{
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Falha ao capturar o id da empresa");
        
            $ret = -1;
        }
        
    }else if (Input::get("like") !== null){
        
        $nome = Input::get("like");
        
        $empresas = $empresaCTRL->buscarEmpresaPorRazaoScialOuPorNomeFantasia($nome);
        
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Consultar Empresas</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Consultar empresas</h2>
                    <h5><em>Aqui você pode consultar, alterar e excluir os dados das empresas cadastradas</em></h5>
                </div>
                <div class="card-body card-body-form">
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>
                        </div>
                        
                        <div class="col-12">

                            <form action="" method="POST">
                                <div class="form-group">
                                    <label class="input-title" for="nome-empresa">Nome da empresa </label>
                                    <input value="<?= $nome ?? "" ?>" class="obr form-control form-control-sm <?= (isset($nome) && $nome != "" || isset($like) && $like != "") ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="nome-empresa" name="nome-empresa" placeholder="Nome da empresa" autocomplete="off">
                                    <small id="msg-erro-nome-empresa" class="text-danger invisible">Preencha o campo <b>nome da empresa</b></small>
                                </div>
                                <button onclick="return validarFormulario()" class="btn btn-info btn-pattern" type="submit" name="btn-buscar" id="btn-buscar">Buscar</button>
                            </form>

                            <hr>
                             
                            <?php if(isset($empresas) && count($empresas) > 0): ?>
                            
                                <div class="table-responsive">

                                    <table class="table table-striped table-dark mt-4 ">
                                        <thead>
                                            <tr>
                                                <th class="td-line-nowrap">Razão social</th>
                                                <th class="td-line-nowrap">Nome fantasia</th>
                                                <th class="td-line-nowrap">Email</th>
                                                <th class="td-line-nowrap">Telefone</th>
                                                <th class="td-line-nowrap">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        <?php for ($i = 0; $i < count($empresas); $i++): ?>

                                            <tr>
                                                <td class="line-nowrap"><?= $empresas[$i]["razao_social"] ?></td>
                                                <td class="line-nowrap"><?= $empresas[$i]["nome_fantasia"] ?></td>
                                                <td class="line-nowrap"><?= $empresas[$i]["email"] ?></td>
                                                <td class="line-nowrap"><?= ($empresas[$i]["telefone"] != "") ? UtilCTRL::mascaraTelefone($empresas[$i]["telefone"]) : "" ?></td>
                                                <td class="line-nowrap">
                                                    <a href="gerenciar_empresa.php?cod=<?= $empresas[$i]["id_empresa"] ?>&like=<?= $nome ?? "" ?><?= $like ?? "" ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>
                                                        Alterar
                                                    </a>
                                                    <a  onclick="modalExcluirIntColEmp('<?= $empresas[$i]["id_empresa"] ?>', '<?= $empresas[$i]["razao_social"] ?>', '<?= $empresas[$i]["email"] ?>', '<?= $empresas[$i]["telefone"] ?>', '<?= $nome ?? ""?>','essa empresa')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-excluir-int-col-emp">
                                                        <i class="far fa-trash-alt"></i>
                                                        Excluir
                                                    </a>
                                                    <a href="ver_mais_empresa.php?cod=<?= $empresas[$i]["id_empresa"] ?>&like=<?= $nome ?? "" ?><?= $like ?? "" ?>" class="btn btn-info btn-sm">
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
                            
                        </div> <!-- col-12 -->
                    </div> <!-- row -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- container -->

        <form action="consultar_empresa.php" method="POST">
           
            <?php include_once ("../../templates/_modal_excluir_int_col_emp.php") ?>

        </form>

        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>

    </body>
</html>


