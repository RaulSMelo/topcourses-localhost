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
        $nomes = "";

        $valor_parcela_cada_aluno = number_format((float)($dados[0]["valor_parcela"] / count($dados)), 2, ",", ".");
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
                font-family: Arial, sans-serif;
                font-size: .75rem;
                text-align: justify;
                margin: 0 2rem;
            }


            .titulo{
                text-align: center;
                font-weight: bold;
                font-size: 0.75rem;
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
        
        <title>PF - Grupo mensal</title>
    </head>
    <body>
        
        <div class="container-contrato">
            
            <header class="titulo">CONTRATO DE PRESTAÇÃO DE SERVIÇOS E OUTRAS AVENÇAS Nº <span><?= $dados[0]["id_contrato_curso"] ?></span></header>

            <br>
            <br>

            <div class="conteudo">
                <p>Por este instrumento particular, de um lado os/as senhores (as):


                    <?php for($i =0; $i < count($dados); $i++): ?>

                        <?php $nomes .= $dados[$i]["nome"] . "-" ?>

                        <?php $separador = ($i == (count($dados) -2)) ? " e" : "," ?>

                        <span class="bold"><?= $dados[$i]["nome"] . " " . $dados[$i]["sobrenome"] ?></span>, <span class="bold">CPF</span> <span class="bold"><?= UtilCTRL::mascaraCPF($dados[$i]["cpf"]) ?></span><?= ($i == (count($dados) -1)) ? "" : $separador ?>

                    <?php endfor ?>

                </p>

                <p>neste ato denominados CONTRATANTES; e, de outro, <span><?= $dadosEmpresaContratada["razao_social"] ?></span>, pessoa jurídica de direito privado, sediada à <span><?= $dadosEmpresaContratada["rua"] ?></span>, <span><?= $dadosEmpresaContratada["numero"] ?></span>, nesta cidade e Comarca de <span><?= $dadosEmpresaContratada["cidade"] ?></span>, Estado do <span><?= ucfirst($dadosEmpresaContratada["estado"]) ?></span>, inscrita no CGC/MF sob número <span><?= UtilCTRL::mascaraCNPJ($dadosEmpresaContratada["cnpj"]) ?></span>, ora representada na forma prevista por seu ato constitutivo e respectivas alterações contratuais, neste ato denominada CONTRATADA, têm certo e ajustado o presente contrato de prestação de serviços e outras avenças, que se rege pela legislação vigente e pelas cláusulas ou condições seguintes: </p>
                <p>Cláusula Primeira – Por um lado, os CONTRATANTES, pessoas físicas que necessitam do aprendizado do idioma <span><?= $dados[0]["idioma"] ?></span>. Por outro lado, a CONTRATADA‚ empresa especializada na atividade de ensino da língua <span><?= UtilCTRL::idiomaNoFeminino($dados[0]["idioma"]) ?></span>, que se encontra há mais de quinze anos instalada na cidade de <span><?= $dadosEmpresaContratada["cidade"] ?></span>. </p>
                <p>Cláusula Segunda - Face à necessidade do aprendizado do idioma <span><?= $dados[0]["idioma"] ?></span>, os CONTRATANTES contratam os serviços da CONTRATADA para:</p>
                <p>a) avaliação das necessidades individuais dos CONTRATANTES e nível de conhecimento que cada um deles possui do idioma; </p>
                <p>b) instrução necessária durante <span class="var"><?= $dados[0]["numero_meses_por_ano"] ?></span>  meses por ano, por meio de aulas ministradas no seguinte local: <span class="bold"><?= $dados[0]["local_das_aulas"] ?></span>.</p>
                <p>Cláusula Terceira - Pelos serviços retro mencionados, CADA CONTRATANTE pagará à CONTRATADA pela instrução do grupo, necessária durante <span class="bold"><?= $dados[0]["numero_meses_por_ano"] ?></span> <b>meses</b> ao ano, o equivalente a <span class="bold"><?= $dados[0]["qtde_parcelas"] ?></span> parcelas mensais de <span class="bold">R$ <?= $valor_parcela_cada_aluno ?></span>.</p>
                <p>Parágrafo Primeiro- O valor acima se refere ao total de horas contratadas multiplicado pelo valor da hora aula, <span class="bold">R$ <?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_hora_aula"]) ?></span>, e dividido pelo número de meses do contrato. <span class="bold"><?= ($dados[0]["desconto"] != "") ? "<span class='bold'>Para este contrato foi concedido " . UtilCTRL::formatoMoedaBRSemSifrao($dados[0]['desconto']) . "% de desconto.</span>" : "" ?></span></p>
                <p>Cláusula Quarta - O valor dos serviços mencionados na cláusula terceira, retro, será reajustado anualmente, em janeiro de cada ano, com base no aumento de nossos custos, ou qualquer índice definido pelo Governo Federal.</p>
                <p>Cláusula Quinta - Os pagamentos deverão ser realizados por meio de boletos bancários até no máximo no dia <span><?= date("d", strtotime($dados[0]["dia_vencimento_parcela"])) ?></span> do mês a vencer, mediante a apresentação da competente nota fiscal (ou fatura ou recibo).</p>
                <p>Parágrafo Primeiro - Haverá multa moratória equivalente a 2% (dois por cento) sobre o saldo devedor e juros diários de 0,1% em caso de não pagamento até o dia do vencimento. </p>
                <p>Parágrafo Segundo - Ainda em caso de não pagamento da prestação no respectivo vencimento, além da multa moratória e da correção monetária sobre o valor total devido, será facultado à CONTRATADA, rescindir o presente contrato, arcando o CONTRATANTE com as perdas e danos daí inerentes. </p>
                <p>Cláusula Sexta - As aulas a que se refere este contrato serão ministradas por pessoal especializado da CONTRATADA, no local previsto na cláusula segunda.</p>
                <p>Cláusula Sétima - É de total responsabilidade da CONTRATADA a orientação técnica sobre a prestação dos serviços retro apontados, competindo-lhe a montagem do programa, escolha do material didático, indicação do professor, orientação didático-pedagógica, além de outras providências que as atividades docentes exigirem. </p>
                                                            
                <p>Cláusula Oitva - A carga horária será de <span class="bold"><?= $dados[0]["carga_horaria_semanal"] ?> hora(s)  por semana</span> e as aulas serão ministradas nos seguintes dias e horários: <b>às</b>

                    <?php for($i = 0; $i < count($agendamentos); $i++): ?>

                        <?php $separador = ($i < (count($agendamentos) -1)) ? "," : "."?>
                        <span class="bold"><?= DIAS_DA_SEMANA[$agendamentos[$i]["dia_da_semana"]] ?></span> <span class="bold">das</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_inicial"]) ?></span> <span class="bold">às</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_final"]) ?></span><?= $separador ?>

                    <?php endfor ?>

                </p>
                <p>Parágrafo Único - Eventual alteração, tanto da carga horária, quanto do horário e dia das aulas, somente poderá dar-se por consenso dos CONTRATANTES e CONTRATADA. Em caso de atraso dos CONTRATANTES, o horário de término da aula se manterá inalterado. </p>
                <p>Cláusula Nona - Em caso de impossibilidade de realização da aula no horário pactuado, os CONTRATANTES terão direito à reposição da mesma, desde que efetue o devido comunicado à CONTRATADA com antecedência mínima de <b>12 (doze) horas</b>, e reponha a mesma num prazo de 15 (quinze) dias a contar do dia da aula cancelada. O horário da aula de reposição será negociado entre professor e aluno, conforme disponibilidade dos mesmos. </p>
                <p>Cláusula Décima - O presente contrato vigorará por <span class="bold"><?= $dados[0]["numero_meses_por_ano"] ?> meses</span>, iniciando-se em <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_inicio_contrato"]) ?></span> com término previsto para <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_termino_contrato"]) ?></span>.</p>
                <p>Cláusula Décima Primeira - Este contrato é celebrado em caráter irrevogável e irretratável, podendo, porém, ser rescindido por qualquer de suas cláusulas e condições. </p>
                <p>Parágrafo Primeiro - Caso um ou mais CONTRATANTES por ventura venha, por motivo de força maior, a ficar impedido de assistir às aulas ministradas pela CONTRATADA e, por isso, não possa dar continuidade a este contrato, deverá comunicar tal fato à CONTRATADA, por escrito, com antecedência mínima de 30 (trinta) dias, persistindo suas obrigações durante este período.</p>
                <p>Parágrafo Segundo - Na hipótese prevista no parágrafo primeiro, retro, os demais CONTRATANTES darão continuidade a este contrato, mantendo-o em todos os seus termos. </p>
                <p>Cláusula Décima Segunda - OS CONTRATANTES são responsáveis pela totalidade do pagamento descrito na Cláusula Terceira, sendo, portanto, indivisíveis as obrigações neste contrato estabelecidas. </p>
                <p>Cláusula Décima Terceira - Eventuais dúvidas ou lides deverão ser dirimidas no foro da Comarca de Londrina, Estado do Paraná, com renúncia de outro qualquer, por melhor e/ou mais privilegiado que seja. E, por haverem assim contratados, firmam o presente contrato lavrado em duas vias de idêntico teor e uma só forma, na presença de testemunhas.</p>
            </div>

            <div class="data">
                <p><?= UtilCTRL::retornaDataPorExtenso($dados[0]["data_registro"]) ?>.</p>
            </div>

            <p>CONTRATANTES</p>
            
            <?php for($i = 0; $i < count($dados); $i++): ?>
                <div class="row-assinatura">
                    <span class="var"><?= $dados[$i]["nome"] . " " . $dados[$i]["sobrenome"] ?></span><span class="tracejado">_______________________________________________</span>
                </div>
            <?php endfor ?>

            <br>

            <p>CONTRATADA</p>

            <div class="row-assinatura">
                <span class="bold nome">G & S SOCIEDADE SIMPLES LTDA</span><span class="tracejado">_______________________________________________</span>
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
$nomes = substr($nomes, 0, -1);
$domPDF->stream("PF-Grupo-mensal__{$nomes}.pdf", ["Attachment" => false]);

?>