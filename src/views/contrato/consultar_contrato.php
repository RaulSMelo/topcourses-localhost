<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\InteressadoController;
use Src\input\Input;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

    $interessadoCTRL = new InteressadoController();
    
    if(filter_input(INPUT_POST, "btn-buscar") !== null){
        
        $nome = Input::post("nome");
        $situacao = Input::post("situacao", FILTER_SANITIZE_NUMBER_INT) ?? "";
        
        $resultado = $interessadoCTRL->filtrarInteressadosPorNomeEsituacaoContrato($nome, $situacao);
        
        if(is_array($resultado)){
            
            if(count($resultado) > 0){
                
                $interessados = $resultado;
                
            }else{
                
                $ret = 2;
            }
            
        }else{
            
            $ret = $resultado;
        }     
    
        
    }else if(Input::get("like") !== null && is_string(Input::get("like"))){
        
        $nome = Input::get("like");
        
        if(Input::get("situacao", FILTER_SANITIZE_NUMBER_INT) !== null){
            
            $situacao = Input::get("situacao");
        }
        
        $interessados = $interessadoCTRL->filtrarInteressadosPorNomeEsituacaoContrato($nome, $situacao);
        
    }
    
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once '../../templates/_head.php' ?>
        <title>Novo ou consultar contratos</title>
    </head>

    <body class="main-body">

        <?php include_once '../../templates/_menu.php' ?>

        <div class="container padding-card-pattern">
            <div class="card my-3 main-card">
                <div class="card-header text-left mt-0 header bg-dark">
                    <h2>Novo contrato | Consultar contratos </h2>
                    <h5><em>Aqui você pode consultar contratos histórico de contratos  ou criar um novo contrato</em></h5>
                </div>

                <div class="card-body card-body-form">


                    <div class="row mb-3">

                        <div class="col-12">

                            <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>

                            <form action="" method="POST">

                                <div class="form-row">  
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="input-title" for="nome">Nome</label>
                                            <input value="<?= $nome ?? "" ?>" class="obr form-control form-control-sm <?= isset($nome) && $nome != "" ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="nome" name="nome" placeholder="Digite o nome que deseje buscar os dados" autocomplete="off">
                                            <small id="msg-erro-nome" class="text-danger invisible" >Por favor, informe o campo nome</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="input-title" for="situacao">Situação</label>
                                            <select class="nao-obr custom-select custom-select-sm bg-components-form" name="situacao" id="situacao">
                                                <option value="">Todos</option>
                                                <option value="<?= CANCELADO ?>" <?= isset($situacao) && $situacao == CANCELADO ? "selected" : "" ?>>Cancelado</option>
                                                <option value="<?= CONCLUIDO ?>" <?= isset($situacao) && $situacao == CONCLUIDO ? "selected" : "" ?>>Concluído</option>
                                                <option value="<?= EM_ANDAMENTO ?>" <?= isset($situacao) && $situacao == EM_ANDAMENTO ? "selected" : "" ?>>Em andamento</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-12">
                                        <button onclick="return validarFormulario()" name="btn-buscar"  class="btn btn-primary btn-pattern">Pesquisar</button>
                                    </div>   
                                </div>

                            </form>

                            <hr>

                            <?php if(isset($interessados) && count($interessados) > 0): ?>
                            
                                <div class="table-responsive">

                                    <table class="table table-striped table-dark mt-4">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Telefone</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php for($i = 0; $i < count($interessados); $i++): ?>
                                            
                                                <tr>
                                                    <td class="line-nowrap"><?= $interessados[$i]["nome"] . " " . $interessados[$i]["sobrenome"] ?></td>
                                                    <td class="line-nowrap"><?= $interessados[$i]["email"] ?></td>
                                                    <td class="line-nowrap"><?= $interessados[$i]["telefone"] != "" ? UtilCTRL::mascaraTelefone($interessados[$i]["telefone"]) : "" ?></td>
                                                    <td class="line-nowrap">
                                                        <a href="ver_dados_contrato.php?cod=<?= $interessados[$i]["id_interessado"] ?>&like=<?= $nome ?? "" ?>&situacao=<?= $situacao ?? "" ?>" class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                            Ver dados
                                                        </a>
                                                        <a href="novo_contrato.php?cod=<?= $interessados[$i]["id_interessado"] ?>" class="btn btn-success btn-sm">
                                                            <i class="fas fa-plus"></i>
                                                            Novo contrato
                                                        </a>
                                                        
                                                        <?php if($interessados[$i]["qtde_contrato_curso"] > 0 || $interessados[$i]["qtde_contrato_rev_trad"] > 0 ): ?>
                                                            <a href="consultar_historico_contrato.php?cod=<?= $interessados[$i]["id_interessado"] ?>" class="btn btn-warning btn-sm">
                                                                 <i class="fas fa-history"></i>
                                                                  Histórico contratos
                                                            </a>
                                                        <?php endif ?>
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

        <!-- inclui os scripts globais -->
        <?php include_once "../../templates/_script.php" ?>

    </body>
</html>
