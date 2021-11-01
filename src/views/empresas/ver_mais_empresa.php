<?php 

require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Src\controllers\EmpresaController;
use Src\input\Input;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();
    
    if(Input::get("cod", FILTER_SANITIZE_NUMBER_INT) !== null){
        
        $empresaCTRL = new EmpresaController();
        $id = Input::get("cod");
        
        $empresa = $empresaCTRL->buscarEmpresaPorId($id);
        
        $like = Input::get("like") ?? null;
        
    }

?>


<!DOCTYPE html>
<html>
<head>
    <?php include_once '../../templates/_head.php' ?>
    <title>Cadastro de empresas</title>
</head>

<body class="main-body">

<?php include_once '../../templates/_menu.php' ?>

<div class="container padding-card-pattern">
    <div class="card my-3 main-card">
        <div class="card-header text-left mt-0 header bg-dark">
            <h2>Dados da empresa</h2>
            <h5><em>Aqui você pode somente ver os dados da empresa</em></h5>
        </div>
        <form action="" method="POST">
            <div class="card-body main-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="razao-social">Razão social</label>
                            <input value="<?= $empresa["razao_social"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" id="razao-social" name="razao-social" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="cnpj">CNPJ</label>
                            <input value="<?= (isset($empresa) && $empresa["cnpj"] != "") ? UtilCTRL::mascaraCNPJ($empresa["cnpj"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cnpj" name="cnpj" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="email">Email</label>
                            <input value="<?= $empresa["email"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="email" id="email" name="email" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="telefone">Telefone</label>
                            <input value="<?= (isset($empresa) && $empresa["telefone"] != "") ? UtilCTRL::mascaraTelefone($empresa["telefone"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="telefone" name="telefone" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="cep">CEP</label>
                            <input value="<?= (isset($empresa) && $empresa["cep"] != "") ? UtilCTRL::mascaraCEP($empresa["cep"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cep" name="cep" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="rua">Endereço</label>
                            <input value="<?= $empresa["rua"] ?? "" ?> ,  <?= $empresa["numero"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="rua" name="rua" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="bairro">Bairro</label>
                            <input value="<?= $empresa["bairro"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="bairro" name="bairro" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="cidade">Cidade</label>
                            <input value="<?= $empresa["cidade"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="cidade" name="cidade" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="estado">UF</label>
                            <input value="<?= $empresa["uf"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="estado" name="estado" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-title" for="telefone-opcinal-empresa">Telefone para contato(opcional)</label>
                            <input value="<?= (isset($empresa) && $empresa["telefone_opcional"] != "") ? UtilCTRL::mascaraTelefone($empresa["telefone_opcional"]) : "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="telefone-opcinal-empresa" name="telefone-opcinal-empresa" disabled>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="input-title" for="nome-fant">Nome fantasia(opcional)</label>
                            <input value="<?= $empresa["nome_fantasia"] ?? "" ?>" class="form-control form-control-sm bg-transparent border text-white" type="text" id="nome-fant" name="nome-fant" disabled>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-12 mt-3">
                        <a href="consultar_empresa.php?like=<?= $like ?? "" ?>" class="btn btn-dark btn-pattern">
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
<?php include_once "../../templates/_script.php"?>

</body>
</html>