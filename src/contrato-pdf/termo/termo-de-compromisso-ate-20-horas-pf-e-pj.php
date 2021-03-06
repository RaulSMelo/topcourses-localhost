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
    
    $tipoContratoPF = (
        $tipoContrato == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS ||
        $tipoContrato == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS
    );
        
    $tipoContratoPJ = (
        $tipoContrato == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS 
    );

    $dadosEmpresaContratada = $configEmpresaCTRL->buscarTodosDadosConfiguracaoEmpresa();
    $agendamentos = $agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato, true);
    $dados = $contratoCursoCTRL->buscarTodosOsDadosDoContratoCursoPorID($idContrato, $tipoContrato);
    
    $a_combinar = UtilCTRL::qtdeDiasEntreDataInicioEDataFinal($dados[0]["data_inicio_contrato"], $dados[0]["data_termino_contrato"]) == $dados[0]["dias_agendados"];
    
//    dd([
//        "RETORNO-DA-FUNCAO" => UtilCTRL::qtdeDiasEntreDataInicioEDataFinal($dados[0]["data_inicio_contrato"], $dados[0]["data_termino_contrato"]),
//        "COUNT-MYSQL" => $dados[0]["dias_agendados"]
//    ]);

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
                margin-bottom: 3rem;
            }

            .data{
                margin-top: 4rem;
                margin-bottom: 4rem;
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

        <title>Termo de compromisso at?? 20 horas - PF e PJ</title>
    </head>
    <body>

        <div class="container-contrato">

            <header class="titulo">TERMO DE COMPROMISSO N?? -  <span class="var"><?= $dados[0]["id_contrato_curso"] ?></span></header>


            <div class="conteudo">
                <p><b>CONTRATANTE: </b><span class="bold"><?= ($tipoContratoPF) ? $dados[0]["nome"] . " " . $dados[0]["sobrenome"] : $dados[0]["razao_social"] ?></span>, <b><?= ($tipoContratoPF) ? "CPF" : "CNPJ" ?></b> <span class="bold"><?= ($tipoContratoPF) ? UtilCTRL::mascaraCPF($dados[0]["cpf"]) : UtilCTRL::mascaraCNPJ($dados[0]["cnpj"]) ?>.</span></p>
                <p><b>CONTRATADA: </b><span><?= $dadosEmpresaContratada["razao_social"] ?></span>, <span><?= $dadosEmpresaContratada["rua"] ?></span>, <span><?= $dadosEmpresaContratada["numero"] ?></span>, <span><?= $dadosEmpresaContratada["cidade"] ?></span>, <span><?= $dadosEmpresaContratada["estado"] ?></span>, CNPJ <span><?= UtilCTRL::mascaraCNPJ($dadosEmpresaContratada["cnpj"]) ?>.</span></p>

                <br>
                <br>
                <br>

                <p>- O CONTRATANTE contrata os servi??os da CONTRATADA para instru????o necess??ria no per??odo de <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_inicio_contrato"]) ?></span> <b>a</b> <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_termino_contrato"]) ?></span>, por meio de aulas ministradas no seguinte local:  <span class="bold"><?= $dados[0]["local_das_aulas"] ?></span>.</p>
                <p>- Pelos servi??os o CONTRATANTE pagar?? ?? CONTRATADA <span class="bold"><?= $dados[0]["qtde_parcelas"] ?></span><span class="bold"> parcela(s) de R$ <?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_parcela"]) ?></span> referente(s) ao total de <span class="bold"><?= UtilCTRL::arredondarHoras($dados[0]["total_horas"]) ?> horas</span> a serem ministradas durante o per??odo, sendo o valor da hora/aula de <span class="bold">R$ <?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_hora_aula"]) ?></span>. <?= ($dados[0]["desconto"] != "") ? "<span class='bold'> Para este contrato foi concedido " . UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["desconto"]) . "% de desconto.</span>" : ""  ?></p>
                <p>- Os pagamentos dever??o ser realizados por meio de boletos banc??rios ou transfer??ncia banc??ria at?? no m??ximo no dia  <span class="var"><?= date("d", strtotime($dados[0]["dia_vencimento_parcela"])) ?></span>, mediante a apresenta????o da competente nota fiscal (ou fatura ou recibo). Haver?? multa morat??ria equivalente a 2% (dois por cento) sobre o saldo devedor e juros di??rios de 0,1%, em caso de n??o pagamento at?? o dia do vencimento.</p>
                <p>- ?? de total responsabilidade da CONTRATADA a orienta????o t??cnica sobre a presta????o dos servi??os, competindo-lhe a montagem do programa, escolha do material did??tico, indica????o do professor, orienta????o did??tico-pedag??gica e outras provid??ncias necess??rias.</p>
                
                <?php if($a_combinar): ?>
                    <p>- A carga hor??ria ser?? ministrada <b>em dias e hor??rios a serem negociados entre professor e aluno.</b> </p>
                <?php else: ?>
                    <p>- A carga hor??ria de <span class="bold"><?= $dados[0]["carga_horaria_semanal"] ?> horas(a)</span> ser?? ministrada nos seguintes dias e hor??rios: <b>??s</b>
                     
                        <?php for($i = 0; $i < count($agendamentos); $i++): ?>

                            <?php $separador = ($i < (count($agendamentos) -1)) ? "," : "."?>
                            <span class="bold"><?= DIAS_DA_SEMANA[$agendamentos[$i]["dia_da_semana"]] ?></span> <span class="bold">das</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_inicial"]) ?></span> <span class="bold">??s</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_final"]) ?></span><?= $separador ?>

                        <?php endfor ?>
                            
                    </p>
                <?php endif ?>
                
                <p>- Eventual altera????o do hor??rio e dia das aulas s?? poder?? ser feita por consenso do CONTRATANTE e CONTRATADA.</p>
                <p>- Em caso de impossibilidade de realiza????o da aula no hor??rio fixado, o CONTRATANTE ter?? direito ?? reposi????o da mesma, desde que efetue comunicado ?? CONTRATADA com anteced??ncia <b>m??nima de 12 horas e reponha a mesma num prazo de 15 dias a contar do dia da aula cancelada.</b></p>
            </div>

            <div class="data">
                <p><?= UtilCTRL::retornaDataPorExtenso($dados[0]["data_registro"]) ?>.</p>
            </div>

            <div class="row-assinatura">
                <span style="text-transform: uppercase"><?= ($tipoContratoPF) ? $dados[0]["nome"] . " " . $dados[0]["sobrenome"] : $dados[0]["razao_social"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

            <br>

            <div class="row-assinatura">
                <span style="text-transform: uppercase"><?= $dadosEmpresaContratada["razao_social"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

        </div>
    </body>
</html>

<?php
$domPDF->loadHtml(ob_get_clean());
$domPDF->setPaper("A4");
$domPDF->render();
$domPDF->stream("PF-Individual-Termo-de-compromisso-ate-20-horas__{$dados[0]['nome']}.pdf", ["Attachment" => false]);
?>