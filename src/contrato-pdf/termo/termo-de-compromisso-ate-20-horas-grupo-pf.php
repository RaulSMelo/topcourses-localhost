<?php
require_once dirname(__DIR__, "3") . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Src\controllers\ContratoCursoController;
use Src\controllers\AgendamentoController;
use Src\controllers\ConfiguracaoEmpresaController;
use Src\input\Input;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

if (Input::get("tipo-contrato", FILTER_SANITIZE_NUMBER_INT) !== null && Input::get("id-contrato", FILTER_SANITIZE_NUMBER_INT) !== null) {

    $contratoCursoCTRL = new ContratoCursoController(false);
    $agendamentoCTRL = new AgendamentoController(false);
    $configEmpresaCTRL = new ConfiguracaoEmpresaController();
    $idContrato = Input::get("id-contrato");
    $tipoContrato = Input::get("tipo-contrato");

    $dadosEmpresaContratada = $configEmpresaCTRL->buscarTodosDadosConfiguracaoEmpresa();
    $agendamentos = $agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato, true);
    $dados = $contratoCursoCTRL->buscarTodosOsDadosDoContratoCursoPorID($idContrato, $tipoContrato);

    $valor_parcela_cada_aluno = number_format((float)($dados[0]["valor_parcela"] / count($dados)), 2, ",", ".");
}

$domPDF = new Dompdf();

ob_start();
?>

<!doctype html>

<html lang="pt-br">

    <head>

        <style>

            @page{
                margin: 1rem 3rem 0 3rem;
            }

            body{
                position: relative;
            }

            .container-contrato{
                font-family: -apple-system,sans-serif;
                font-size: .75rem;
                text-align: justify;
                margin: 0 2rem;
            }


            .titulo{
                text-align: center;
                font-weight: bold;
                font-size: 0.875rem;
                margin-bottom: 2rem;
            }

            .data{
                margin-top: 3rem;
                margin-bottom: 3rem;
                font-size: 0.75rem;
            }

            .row-assinatura{
                margin: 3rem 0;
            }

            .tracejado{
                display: inline-block;
                float: right;
                font-weight: bold;
            }

            .bold{
                font-weight: bold;
            }

            .var{
                color: #000;
                font-weight: bold;
                text-transform: uppercase;
            }

        </style>
        
        <link rel="shortcut icon" href="../../assets/img/icon-pdf.ico" type="image">

        <title>PF Grupo - Termo de compromisso at?? 20 horas</title>

    </head>

    <body>

        <div class="container-contrato">

            <header class="titulo">TERMO DE COMPROMISSO N?? -  <span class="var"><?= $dados[0]["id_contrato_curso"] ?></span></header>


            <div class="conteudo">

                <p><b>CONTRATANTES: </b>

                    <?php $nomes = "" ?>

                    <?php for($i =0; $i < count($dados); $i++): ?>

                        <?php $nomes .= $dados[$i]["nome"] . "-" ?>

                        <?php $separador = ($i == (count($dados) -2)) ? " e" : "," ?>

                        <span class="bold"><?= $dados[$i]["nome"] . " " . $dados[$i]["sobrenome"] ?></span>, <span class="bold">CPF</span> <span class="bold"><?= UtilCTRL::mascaraCPF($dados[$i]["cpf"]) ?></span><?= ($i == (count($dados) -1)) ? "" : $separador ?>

                    <?php endfor ?>

                .</p>

                <p><b>CONTRATADA: </b><span><?= $dadosEmpresaContratada["razao_social"] ?></span>, <span><?= $dadosEmpresaContratada["rua"] ?></span>, <span><?= $dadosEmpresaContratada["numero"] ?></span>, <span><?= $dadosEmpresaContratada["cidade"] ?></span>, <span><?= $dadosEmpresaContratada["estado"] ?></span>, CNPJ <span><?= UtilCTRL::mascaraCNPJ($dadosEmpresaContratada["cnpj"]) ?>.</span></p>

                <br>

                <p>- OS CONTRATANTES contrata os servi??os da CONTRATADA para instru????o necess??ria no per??odo de <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_inicio_contrato"]) ?></span> <b>a</b> <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_termino_contrato"]) ?></span>, por meio de aulas ministradas no seguinte local:  <span class="bold"><?= $dados[0]["local_das_aulas"] ?></span>.</p>
                <p>- Pelos servi??os os CONTRATANTES pagar?? ?? CONTRATADA <span class="bold"><?= $dados[0]["qtde_parcelas"] ?></span><span class="bold"> parcela(s) de R$ <?= $valor_parcela_cada_aluno ?></span> referente ao total de <span class="bold"><?= UtilCTRL::arredondarHoras($dados[0]["total_horas"]) ?> horas</span> a serem ministradas durante o per??odo, sendo o valor da hora/aula de <span class="bold">R$ <?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_hora_aula"]) ?></span>. <?= ($dados[0]["desconto"] != "") ? "<span class='bold'> Para este contrato foi concedido " . UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["desconto"]) . "% de desconto.</span>"  : ""  ?></p>
                <p>- Os pagamentos dever??o ser realizados at?? no m??ximo no dia <span class="var"><?= date("d", strtotime($dados[0]["dia_vencimento_parcela"])) ?></span>, mediante a apresenta????o da competente nota fiscal (ou fatura ou recibo). Haver?? multa morat??ria equivalente a 2% (dois por cento) sobre o saldo devedor e juros di??rios de 0,1%, em caso de n??o pagamento at?? o dia do vencimento.</p>
                <p>- ?? de total responsabilidade da CONTRATADA a orienta????o t??cnica sobre a presta????o dos servi??os, competindo-lhe a montagem do programa, escolha do material did??tico, indica????o do professor, orienta????o did??tico-pedag??gica e outras provid??ncias necess??rias.</p>
                <p>- A carga hor??ria de <span class="bold"><?= $dados[0]["carga_horaria_semanal"] ?> horas</span> ser?? ministrada <b>em dias e hor??rios a serem negociados entre professor e aluno.</b> Em caso de atraso dos CONTRATANTES, o hor??rio de t??rmino da aula n??o ser?? alterado.  </p>
                <p>- Eventual altera????o do hor??rio e dia das aulas s?? poder?? ser feita por consenso dos CONTRATANTES e CONTRATADA.</p>
                <p>- Em caso de impossibilidade de realiza????o da aula no hor??rio fixado, o CONTRATANTE ter?? direito ?? reposi????o da mesma, desde que efetue comunicado ?? CONTRATADA com anteced??ncia <b>m??nima de 12 horas e reponha a mesma num prazo de 15 dias a contar do dia da aula cancelada.</b></p>
            </div>

            <div class="data">
                <p><?= UtilCTRL::retornaDataPorExtenso($dados[0]["data_registro"]) ?>.</p>
            </div>

            <p>CONTRATANTES:</p>

            <?php for($i = 0; $i < count($dados); $i++): ?>
                <div class="row-assinatura">
                    <span style="text-transform: uppercase"><?= $dados[$i]["nome"] . " " . $dados[$i]["sobrenome"] ?></span><span class="tracejado">_______________________________________________</span>
                </div>
            <?php endfor ?>

            <p>CONTRATADA:</p>

            <div class="row-assinatura">
                <span class="var"><?= $dadosEmpresaContratada["razao_social"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

        </div>
    </body>
</html>

<?php
$domPDF->loadHtml(ob_get_clean());
$domPDF->setPaper("A4");
$domPDF->render();
$domPDF->stream("PF-Grupo-Termo-de-compromisso-ate-20-horas__{$nomes}.pdf", ["Attachment" => false]);
?>