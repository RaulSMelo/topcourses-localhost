<?php
require_once(dirname(__DIR__, "2") . "/vendor/autoload.php");

use Src\traits\UtilCTRL;

if (isset($_GET["close"]) && is_numeric($_GET["close"]) && $_GET["close"] == 1) {

    UtilCTRL::deslogarUsuario();
}
?>

<?php if ($_SESSION["tipo-acesso"] == ADM): ?>

<div class="fixed-top bg-dark">

    <div class="row">

        <div class="col-md-12">

            <div class="nav d-flex align-items-center justify-content-between">

                <div class="navbar-brand m-0 pt-md-2 pl-md-5 ml-md-5">
                    <div class="div-logotipo">
                        <img src="<?= DOMINIO ?>/src/assets/img/logotipo-top-courses-800x375.png" alt="Logotipo da escola de idiomas">
                    </div>
                </div>

                <div class="d-flex align-items-center pt-md-3 pr-md-5 mr-md-5">
                    <div>
                        <a class="btn btn-info" href="javascript:history.back()" title="Voltar para página anterior">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Voltar
                        </a>
                    </div>
                    <div class="ml-3">
                        <a href="<?= DOMINIO ?>/src/templates/_menu.php?close=1" class="btn btn-danger" name="btn-deslogar" type="submit">
                            <i class="fas fa-times mr-2"></i>
                            Sair
                        </a>
                    </div>
                </div>

            </div><!-- nav -->

        </div><!-- col-md-12 -->  

    </div><!-- row -->
        

    <nav class="navbar navbar-expand-lg navbar-dark border-bottom-nav">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">

            <ul class="navbar-nav m-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Interessados
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/interessados/cadastrar_interessados.php">Cadastro de interessados</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/interessados/consultar_interessados.php">Consultar interessados</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cadastro básico
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/cadastro_basico/curso.php">Cadastrar cursos</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/cadastro_basico/idioma.php">Cadastrar idiomas</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/cadastro_basico/midia.php">Cadastrar mídias</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/cadastro_basico/nivel.php">Cadastrar níveis</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/cadastro_basico/resultado.php">Cadastrar resultados</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/cadastro_basico/revisao.php">Cadastrar revisões</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/cadastro_basico/tipo_contato.php">Cadastrar tipos de contato</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/cadastro_basico/traducao.php">Cadastrar traduções</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Colaboradores
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/colaboradores/gerenciar_colaborador.php">Cadastrar colaboradores</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/colaboradores/consultar_colaborador.php">Consultar colaboradores</a>

                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Contratos
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/contrato/consultar_contrato.php">Novo contrato | Consultar contratos</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/contrato/relatorio_contratos.php">Relatório de contratos</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Empresas
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/empresas/gerenciar_empresa.php">Cadastrar empresas</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/empresas/consultar_empresa.php">Consultar empresas</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Financeiro
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/financeiro/hora_aula.php">Cadastrar preços das horas/aula</a>
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/financeiro/dar_baixa_parcela.php">Dar baixa em parcelas</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pauta
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/pautas/consultar_pauta.php">Consultar pautas dos alunos</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Turma
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= DOMINIO ?>/src/views/turma/turma.php">Cadastrar Turmas</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= DOMINIO ?>/src/views/alterar_senha/alterar_senha.php">Alterar Senha</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= DOMINIO ?>/src/views/configuracao_empresa/configuracao_empresa.php">Configuração da empresa</a>
                </li>

            </ul>
            
        </div>
        
    </nav>
    
</div>

<?php elseif ($_SESSION["tipo-acesso"] == PROF): ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-bottom-nav">

        <div class="navbar-brand m-0 pt-md-2 pl-md-5 ml-md-5">
            <div class="div-logotipo">
                <img src="<?= DOMINIO ?>/src/assets/img/logotipo-top-courses-800x375.png" alt="Logotipo da escola de idiomas">
            </div>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">

            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <a class="nav-link lead" href="<?= DOMINIO ?>/src/views/pautas/consultar_pauta.php">Consultar pautas dos alunos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link lead" href="<?= DOMINIO ?>/src/views/alterar_senha/alterar_senha.php">Alterar Senha</a>
                </li>
            </ul>

        </div>

        <div class="d-flex align-items-center pt-md-3 pr-md-5 mr-md-5">
            <div>
                <a class="btn btn-info" href="javascript:history.back()" title="Voltar para página anterior">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
            </div>
            <div class="ml-3">
                <a href="<?= DOMINIO ?>/src/templates/_menu.php?close=1" class="btn btn-danger" name="btn-deslogar" type="submit">
                    <i class="fas fa-times mr-2"></i>
                    Sair
                </a>
            </div>
        </div>

    </nav>

<?php endif ?>
