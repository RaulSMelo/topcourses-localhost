<?php

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\erro\Erro;
use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\ColaboradorController;

UtilCTRL::validarTipoDeAcessoADM();

$colaboradorCTRL = new ColaboradorController();


if (Input::post("btn-buscar") !== null) {

    if (Input::post("nome-colaborador") !== null) {

        $nome_completo = UtilCTRL::retornaNomeEsobrenome(Input::post("nome-colaborador"));
        $nome          = trim($nome_completo["nome"]);
        $sobrenome     = $nome_completo["sobrenome"] ?? "";
        
        $resultado = $colaboradorCTRL->buscarColaboradorPorNome($nome, $sobrenome);

        if (is_array($resultado)) {
            
            $colaboradores = $resultado;

        } else {

            $ret = $resultado;
        }
    } else {

        Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo nome não pode ser vazio");

        $ret = 0;
    }
    
}else if(Input::post("btn-excluir") !== null){
    
    if(Input::post("id-excluir-int-col-emp", FILTER_SANITIZE_NUMBER_INT) !== null){
        
        $id = Input::post("id-excluir-int-col-emp");
        
        $ret = $colaboradorCTRL->excluirColaborador($id);
        
        if(Input::post("filtro-nome") !== null){
           
            $nome_completo = UtilCTRL::retornaNomeEsobrenome(Input::post("filtro-nome"));
            $nome          = trim($nome_completo["nome"]);
            $sobrenome     = trim($nome_completo["sobrenome"]) ?? "";
            
            $colaboradores = $colaboradorCTRL->buscarColaboradorPorNome($nome, $sobrenome); 

        }
        
            
    }else{
        
        Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Falha ao capturar o id do colaborador");
        
        $ret = -1;
    }

    
}else if (Input::get("like") !== Null) {

    $nome_completo = UtilCTRL::retornaNomeEsobrenome(filter_input(INPUT_GET, "like"));
    $nome          = trim($nome_completo["nome"]);
    $sobrenome     = trim($nome_completo["sobrenome"]) ?? "";
    
    if(!empty($nome)){
        
        $colaboradores = $colaboradorCTRL->buscarColaboradorPorNome($nome, $sobrenome);
    }
    
    if(Input::post("nome-colaborador") !== null){
       
        $nome_completo = UtilCTRL::retornaNomeEsobrenome(Input::post("nome-colaborador"));
        $nome          = trim($nome_completo["nome"]);
        $sobrenome     = trim($nome_completo["sobrenome"]) ?? "";
    }
    
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once '../../templates/_head.php' ?>
    <title>Consultar colaboradores</title>
</head>

<body class="main-body">

    <?php include_once '../../templates/_menu.php' ?>

    <div class="container padding-card-pattern">
        <div class="card my-3 main-card">
            <div class="card-header text-left mt-0 header bg-dark">
                <h2>Consultar colaboradores</h2>
                <h5><em>Aqui você pode consultar, alterar e excluir os colaboradores</em></h5>
            </div>
            <div class="card-body card-body-form">

                <div class="row">

                    <div class="col-12">

                        <?php include_once(dirname(__DIR__, "2") . "/templates/_mensagens.php") ?>

                        <form action="consultar_colaborador.php" method="POST">
                            <div class="form-group">
                                <label class="input-title" for="nome-nome-colaborador">Nome do colaborador</label>
                                <input value="<?= $nome ?? "" ?> <?= $sobrenome ?? "" ?>" class="obr form-control form-control-sm <?= (isset($nome) && !empty($nome)) ? "is-valid" : "campo-obrigatorio" ?>" type="text" id="nome-colaborador" name="nome-colaborador" placeholder="Nome" autocomplete="off">
                                <small id="msg-erro-nome-colaborador" class="text-danger invisible">Preencha o campo <b>nome do colaborador</b></small>
                            </div>

                            <button onclick="return validarFormulario()" class="btn btn-info btn-pattern" name="btn-buscar" id="btn-buscar">Buscar</button>
                        </form>

                        <hr>

                        <?php if (isset($colaboradores) && count($colaboradores) > 0) : ?>

                            <div class="table-responsive">

                                <table class="table table-striped table-dark mt-4 ">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th class="line-nowrap">Tipos de colaboradores</th>
                                            <th>Email</th>
                                            <th>Telefone</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php for ($i = 0; $i < count($colaboradores); $i++) : ?>

                                            <tr>
                                                <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top"><em><?= $colaboradores[$i]["nome"] . " " . $colaboradores[$i]["sobrenome"] ?></em></td>
                                                <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top">
                                                    <?php 

                                                        $nomes_dos_tipos_de_colaboradores = explode("-", $colaboradores[$i]["nome-tipo"]);

                                                        foreach ($nomes_dos_tipos_de_colaboradores as $nome_do_tipo){

                                                            echo $nome_do_tipo . "<br>";
                                                        }
                                                    ?>
                                                </td>
                                                <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top"><?= $colaboradores[$i]["email"] ?></td>
                                                <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top"><?= $colaboradores[$i]["telefone"] != "" ? UtilCTRL::mascaraTelefone($colaboradores[$i]["telefone"]) : "" ?></td>
                                                <td class="line-nowrap align-middle border-left-0 border-right-0 border-bottom border-top">
                                                    <a href="gerenciar_colaborador.php?cod=<?= $colaboradores[$i]["id_colaborador"] ?>&like=<?= $nome ?? "" ?><?= $like ?? "" ?>" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>
                                                        Alterar
                                                    </a>
                                                    <a onclick="modalExcluirIntColEmp('<?= $colaboradores[$i]["id_colaborador"] ?>', '<?= $colaboradores[$i]["nome"] . " " . $colaboradores[$i]["sobrenome"] ?>', '<?= $colaboradores[$i]["email"] ?>', '<?= $colaboradores[$i]["telefone"] != "" ? UtilCTRL::mascaraTelefone($colaboradores[$i]["telefone"]) : ""  ?>', '<?= $nome ?? ""?> <?= $sobrenome ?? "" ?>', 'esse colaborador')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-excluir-int-col-emp">
                                                        <i class="far fa-trash-alt"></i>
                                                        Excluir
                                                    </a>
                                                    <a href="ver_mais_colaborador.php?cod=<?= $colaboradores[$i]["id_colaborador"] ?>&like=<?= $nome ?? "" ?><?= $like ?? "" ?>" class="btn btn-info btn-sm">
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

    <form action="consultar_colaborador.php" method="POST">
        
        <?php include_once ("../../templates/_modal_excluir_int_col_emp.php") ?>

    </form>

    <!-- inclui os scripts globais -->
    <?php include_once "../../templates/_script.php" ?>

</body>

</html>