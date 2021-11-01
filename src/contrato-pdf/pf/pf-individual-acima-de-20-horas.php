<?php

require_once dirname(__DIR__,"3") . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Src\controllers\ContratoCursoController;
use Src\controllers\AgendamentoController;
use Src\controllers\ConfiguracaoEmpresaController;
use Src\input\Input;
use Src\traits\UtilCTRL;

UtilCTRL::validarTipoDeAcessoADM();

    if(Input::get("tipo-contrato", FILTER_SANITIZE_NUMBER_INT) !== null && Input::get("id-contrato", FILTER_SANITIZE_NUMBER_INT) !== null){
        
        $contratoCursoCTRL = new ContratoCursoController(false);
        $agendamentoCTRL   = new AgendamentoController(false);
        $configEmpresaCTRL = new ConfiguracaoEmpresaController();
        $idContrato   = Input::get("id-contrato");
        $tipoContrato = Input::get("tipo-contrato");
        
        $dadosEmpresaContratada = $configEmpresaCTRL->buscarTodosDadosConfiguracaoEmpresa();
        $agendamentos = $agendamentoCTRL->buscarAgendamentosPorIdDoContrato($idContrato, true);
        $dados = $contratoCursoCTRL->buscarTodosOsDadosDoContratoCursoPorID($idContrato, $tipoContrato);
        
    }
    
    $domPDF = new Dompdf();

    ob_start();

?>

<!DOCTYPE html>
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
                font-family: Arial,sans-serif;
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
            
            .testemunha-1{
                display: inline-block;
                float: left;
                font-weight: bold;
            }
            
            .testemunha-2{
                display: inline-block;
                float: right;
                font-weight: bold;
            }

        </style>
        
        <link rel="shortcut icon" href="../../assets/img/icon-pdf.ico" type="image">
        
        <title>PF - Individual acima de 20 horas</title>
    </head>
    <body>
        
        <div class="container-contrato">
            
            <header class="titulo">CONTRATO DE PRESTAÇÃO DE SERVIÇOS E OUTRAS AVENÇAS Nº <span><?= $dados[0]["id_contrato_curso"] ?></span></header>

            <br>

            <div class="conteudo">
                <p>Por este instrumento particular, de um lado o (a) senhor (a): <span class="bold"><?= $dados[0]["nome"] . " " . $dados[0]["sobrenome"] ?></span>, <b>CPF</b> <span class="bold"><?= UtilCTRL::mascaraCPF($dados[0]["cpf"]) ?></span>, neste ato denominado CONTRATANTE; e, de outro, <span><?= $dadosEmpresaContratada["razao_social"] ?></span>, pessoa jurídica de direito privado, sediada na <span><?= $dadosEmpresaContratada["rua"] ?></span>, nº <span><?= $dadosEmpresaContratada["numero"] ?></span>, nesta cidade e Comarca de <span><?= $dadosEmpresaContratada["cidade"] ?></span>, Estado do <span><?= ucfirst($dadosEmpresaContratada["estado"])?></span>, inscrita no CGC/MF sob número <span><?= UtilCTRL::mascaraCNPJ($dadosEmpresaContratada["cnpj"]) ?></span>, ora representada na forma prevista por seu ato constitutivo e respectivas alterações contratuais, neste ato denominada CONTRATADA, têm certo e ajustado o presente contrato de prestação de serviços e outras avenças, que se regerá pela legislação vigente e pelas cláusulas ou condições seguintes:</p>
                <p>Cláusula Primeira – Por um lado, o CONTRATANTE‚ pessoa física que necessita do aprendizado do idioma <span><?= $dados[0]["idioma"] ?></span>. Por outro lado, a CONTRATADA‚ empresa especializada na atividade de ensino da língua <span><?= UtilCTRL::idiomaNoFeminino($dados[0]["idioma"]) ?></span>, que se encontra há mais de quinze anos instalada na cidade de <span><?= $dadosEmpresaContratada["cidade"] ?></span>.</p>
                <p>Cláusula Segunda - Face à necessidade do aprendizado do idioma <span><?= $dados[0]["idioma"] ?></span>, o CONTRATANTE contrata os serviços da CONTRATADA para instrução necessária no período de <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_inicio_contrato"]) ?></span> <b>a</b> <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_termino_contrato"]) ?></span> por meio de aulas ministradas no seguinte local: <span class="bold"><?= $dados[0]["local_das_aulas"] ?></span>.</p>
                <p>Cláusula Terceira - Pelos serviços retro mencionados, o CONTRATANTE pagará à CONTRATADA <b>R$</b> <span class="bold"><?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_total"]) ?></span> referente ao total de <span class="bold"><?= UtilCTRL::arredondarHoras($dados[0]["total_horas"]) ?> horas</span> a serem ministradas durante o período, sendo o valor da hora/aula de <span class="bold"><?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_hora_aula"]) ?></span>. Eventual alteração no noticiado número de horas contratadas será objeto de alteração proporcional do preço. <?= ($dados[0]["desconto"] != "") ? "<span class='bold'> Para este contrato foi concedido desconto de " . UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["desconto"]) . "%.</span>"  : ""  ?></p>
                <p>Cláusula Quarta - Os pagamentos deverão ser realizados por meio de boletos bancários ou transferência bancária até no máximo no dia <span class="bold"><?= date("d", strtotime($dados[0]["dia_vencimento_parcela"])) ?> do mês a vencer </span>, mediante a apresentação da competente nota fiscal (ou fatura ou recibo).</p>
                <p>Parágrafo Primeiro - Haverá multa moratória equivalente a 2% (dois por cento) sobre o saldo devedor e juros diários de 0,1%, em caso de não pagamento até o dia do vencimento.</p>
                <p>Parágrafo Segundo - Ainda em caso de não pagamento da prestação no respectivo vencimento, além da multa moratória e da correção monetária sobre o valor total devido, será facultado à CONTRATADA, rescindir o presente contrato, arcando o CONTRATANTE com as perdas e danos daí inerentes.</p>                                                                                                                       
                <p>Cláusula Quinta - As aulas a que se refere este contrato serão ministradas por pessoal especializado da CONTRATADA, no local previsto na cláusula segunda. </p>
                <p>Cláusula Sexta - É de total responsabilidade da CONTRATADA a orientação técnica sobre a prestação dos serviços retro apontados, competindo-lhe a montagem do programa, escolha do material didático, indicação do professor, orientação didático-pedagógica e outras providências que as atividades docentes exigirem.</p>
                
                <p>Cláusula Sétima - A carga horária será de <span class="bold"><?= $dados[0]["carga_horaria_semanal"] ?> hora(s) por semana</span> e as aulas serão ministradas nos seguintes dias e horários: <b>às</b>
     
                    <?php for($i = 0; $i < count($agendamentos); $i++): ?>

                        <?php $separador = ($i < (count($agendamentos) -1)) ? "," : "."?>
                        <span class="bold"><?= DIAS_DA_SEMANA[$agendamentos[$i]["dia_da_semana"]] ?></span> <span class="bold">das</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_inicial"]) ?></span> <span class="bold">às</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_final"]) ?></span><?= $separador ?>

                    <?php endfor ?>

                </p>
                
                <p>Parágrafo Único - Eventual alteração, tanto da carga horária, quanto do horário e dia das aulas, somente poderá dar-se por consenso do CONTRATANTE e CONTRATADA. Em caso de atraso do CONTRATANTE, o horário de término da aula manter-se-á inalterado.</p>
                <p>Cláusula Oitava - Em caso de impossibilidade de realização da aula no horário pactuado, o CONTRATANTE terá direito à reposição da mesma, desde que com antecedência mínima de <b>12 (doze) horas</b>, efetue o devido comunicado à CONTRATADA e reponha a mesma em um prazo de 15 (quinze) dias a contar do dia da aula cancelada.</p>
                <p>Cláusula Nona - Este contrato é celebrado em caráter irrevogável e irretratável, e o CONTRATANTE é solidariamente responsável pela totalidade do pagamento descrito na Cláusula Terceira, sendo as obrigações estabelecidas neste contrato indivisíveis</p>
                <p>Parágrafo Primeiro - Caso o CONTRATANTE venha a ficar impedido de assistir às aulas ministradas pela CONTRATADA e, por isso, não possa dar continuidade a este contrato, deverá comunicar tal fato por escrito, com antecedência mínima de <b>30 (trinta) dias</b>, persistindo suas obrigações durante este período. </p>
                <p>Cláusula Décima - O CONTRATANTE é responsável pela totalidade do pagamento descrito na Cláusula Terceira, sendo, portanto, indivisíveis as obrigações neste contrato estabelecidas.</p> 
                <p>Cláusula Décima Primeira - Eventuais dúvidas ou lides deverão ser dirimidas no foro da Comarca de Londrina, Paraná, com renúncia de outro qualquer, por melhor e/ou mais privilegiado que seja. E, por haverem assim contratados, firmam este contrato, lavrado em duas vias de idêntico teor, na presença de testemunhas.</p>
            </div>

            <div class="data">
                <p><?= UtilCTRL::retornaDataPorExtenso($dados[0]["data_registro"]) ?>.</p>
            </div>

            <p>CONTRATANTE</p>

            <div class="row-assinatura">
                <span style="text-transform: uppercase"><?= $dados[0]["nome"] . " " . $dados[0]["sobrenome"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

            <br>

            <p>CONTRATADA</p>

            <div class="row-assinatura">
                <span class="var"><?= $dadosEmpresaContratada["razao_social"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

            <br>

            <p>Testemunhas:</p>

            <div class="row-assinatura">
                <span class="testemunha-1">_____________________________________</span><span class="testemunha-2">_____________________________________</span>
            </div>
            
        </div>
    </body>
</html>

<?php

$domPDF->loadHtml(ob_get_clean());
$domPDF->setPaper("A4");
$domPDF->render();
$domPDF->stream("PF-Individual-acima-de-20-horas__{$dados[0]['nome']}.pdf", ["Attachment" => false]);

?>