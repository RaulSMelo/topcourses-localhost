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
                font-family: -apple-system,sans-serif;
                font-size: 0.75rem;
                text-align: justify;
                margin: 0 2rem;
            }


            .titulo{
                text-align: center;
                font-weight: bold;
                font-size: 0.75rem;
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

            .nome{
                display: inline-block;
                min-width: 30%;
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
        
        <title>PJ - Individual acima de 20 horas</title>
    </head>
    <body>
        
        <div class="container-contrato">
            
            <header class="titulo">CONTRATO DE PRESTAÇÃO DE SERVIÇOS E OUTRAS AVENÇAS Nº <span class="var"><?= $dados[0]["id_contrato_curso"] ?></span></header>

            <div class="conteudo">
                <p>Por este instrumento particular, de um lado, <span class="bold"><?= $dados[0]["razao_social"] ?></span></p>
                <p>pessoa jurídica de direito privado, sediada a <span><?= $dados[0]["rua"] ?></span>, <span><?= $dados[0]["numero"] ?></span><span><?= !empty($dados[0]["complemento"]) ? " - " . $dados[0]["complemento"] : "" ?></span> - <span><?= $dados[0]["bairro"] ?></span>, cep <span><?= UtilCTRL::mascaraCEP($dados[0]["cep"]) ?></span>, na cidade e comarca de <span><?= $dados[0]["cidade"] ?></span>, estado do <span><?= NOME_DO_ESTADO_PELA_SIGLA[$dados[0]["uf"]] ?></span>, inscrita no CNPJ sob nº <span><?= UtilCTRL::mascaraCNPJ($dados[0]["cnpj"]) ?></span>, neste ato denominada CONTRATANTE; e, de outro, <span><?= $dadosEmpresaContratada["razao_social"] ?></span>, pessoa jurídica de direito privado, sediada à <span><?= $dadosEmpresaContratada["rua"] ?></span>, n° <span><?= $dadosEmpresaContratada["numero"] ?></span> nesta cidade e Comarca de <span><?= $dadosEmpresaContratada["cidade"] ?></span>, Estado do <span><?= ucfirst($dadosEmpresaContratada["estado"]) ?></span>, inscrita no CNPJ sob nº <span><?= UtilCTRL::mascaraCNPJ($dadosEmpresaContratada["cnpj"]) ?></span>, ora representada na forma prevista por seu ato constitutivo e respectivas alterações contratuais, neste ato denominada CONTRATADA, têm certo e ajustado o presente contrato de prestação de serviços e outras avenças, que se regerá pela legislação vigente e pelas cláusulas ou condições seguintes:</p>
                <p>Cláusula Primeira – Por um lado, o CONTRATANTE, empresa estabelecida na cidade de <span><?= $dados[0]["cidade"] ?></span>, possuindo dentre o seu quadro de funcionários, pessoa<b>(s)</b> que necessita<b>(m)</b> do aprendizado do idioma inglês. Por outro lado, a CONTRATADA, empresa especializada na atividade de ensino da língua inglesa, que se encontra há mais de vinte e cinco anos instalada na cidade de Londrina.</p>
                <p>
                    <div>Cláusula Segunda - Face à necessidade do aprendizado do idioma inglês, o CONTRATANTE contrata os serviços da CONTRATADA para:</div>
                    <div>a) avaliação das necessidades da empresa CONTRATANTE e do perfil e nível de conhecimento no idioma inglês do funcionário que se utilizará tal programa;</div>
                    <div>b) instrução necessária durante <span class="bold"><?= $dados[0]["numero_meses_por_ano"] ?> meses</span> ao ano, por meio de aulas ministradas no seguinte local: <span><?= $dados[0]["local_das_aulas"] ?></span>.</div>
                </p>
                <p>Cláusula Terceira - Pelos serviços retro mencionados, o CONTRATANTE pagará à CONTRATADA pela instrução do aluno, necessária durante o período, <span class="var"><?= $dados[0]["qtde_parcelas"] ?></span> parcelas mensais de R$ <span class="bold"><?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_parcela"]) ?></span> referentes ao total de <span class="var"><?= UtilCTRL::formatarHorasEmDecimais($dados[0]["total_horas"]) ?></span> horas a serem ministradas durante o(s) <span class="var"><?= $dados[0]["numero_meses_por_ano"] ?></span> mes(es) de <span class="var"><?= UtilCTRL::dataFormatoBR($dados[0]["data_inicio_contrato"]) ?></span> <b>a</b> <span class="var"><?= UtilCTRL::dataFormatoBR($dados[0]["data_termino_contrato"]) ?></span>. O valor da hora aula é de R$ <span class="bold"><?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_hora_aula"]) ?></span>. Eventual alteração em o noticiado número de horas contratadas no mês, será objeto de alteração proporcional do preço. <?= ($dados[0]["desconto"] != "") ? "<span class='bold'> Para este contrato foi concedido desconto de " . UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["desconto"]) . "%</span>"  : ""  ?></p>
                <p>Cláusula Quarta - Os pagamentos deverão ser realizados por meio de boletos bancários até, no máximo, no <span class="bold"><?= date("d", strtotime($dados[0]["dia_vencimento_parcela"])) ?>°</span> dia do mês a vencer, mediante a apresentação da competente nota fiscal (ou fatura ou recibo).</p>
                <p>Parágrafo Primeiro – Haverá multa moratória equivalente a 2% (cinco por cento) sobre o saldo devedor, em caso de não pagamento até o dia do vencimento descrito no caput desta cláusula.</p>
                <p>Parágrafo Segundo - Ainda em caso de não pagamento da prestação no respectivo vencimento, além da multa moratória e da correção monetária sobre o valor total devido, será facultado à CONTRATADA, rescindir o presente contrato, arcando o CONTRATANTE com as perdas e danos daí inerentes.</p>
                <p>Cláusula Quinta - As aulas a que se refere este contrato, serão ministradas por pessoal especializado da CONTRATADA, nas dependências da <span><?= $dados[0]["local_das_aulas"] ?></span> como previsto na cláusula segunda.</p>
                <p>Cláusula Sexta - É de total responsabilidade da CONTRATADA a orientação técnica sobre a prestação dos serviços retro apontados, competindo-lhe a montagem do programa, escolha do material didático, indicação do professor, orientação didático-pedagógica, além de outras providências que as atividades docentes exigirem.</p>
                <p>Cláusula Sétima - A carga horária será de <span><?= $dados[0]["carga_horaria_semanal"] ?></span> horas, e as aulas serão ministradas nos seguintes dias e horários:

                    <?php for($i = 0; $i < count($agendamentos); $i++): ?>

                        <?php $separador = ($i < (count($agendamentos) -1)) ? "," : "."?>
                        <span class="bold"><?= DIAS_DA_SEMANA[$agendamentos[$i]["dia_da_semana"]] ?></span> <span class="bold">das</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_inicial"]) ?></span> <span class="bold">às</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_final"]) ?></span><?= $separador ?>

                    <?php endfor ?>

                </p>
                <p>Parágrafo Único - Eventual alteração, tanto da carga horária, quanto do horário e dia das aulas, somente poderá dar-se por consenso do CONTRATANTE e CONTRATADA, devendo ser objeto de aditivo contratual. Em caso de atraso do CONTRATANTE, o horário de término da aula se manterá inalterado.</p>
                <p>Cláusula Oitava - Em caso de impossibilidade de realização da aula no horário pactuado, os CONTRATANTES terão direito à reposição da mesma, desde que efetue o devido comunicado à CONTRATADA com antecedência mínima de <b>12 (doze) horas</b>, e reponha a mesma num prazo de 15 (quinze) dias a contar do dia da aula cancelada. O horário da aula de reposição será negociado entre professor e aluno, conforme disponibilidade dos mesmos.</p>
                <p>Cláusula Nona - Este contrato é celebrado em caráter irrevogável e irretratável, onde o CONTRATANTE é solidariamente responsável pela totalidade do pagamento descrito na Cláusula Terceira, sendo as obrigações estabelecidas neste contrato indivisíveis.</p>
                <p>Parágrafo Primeiro - Caso haja dispensa, transferência ou motivo de força maior que impeça o funcionário de assistir às aulas ministradas pela CONTRATADA e, por isso não possa dar continuidade a este contrato a CONTRATANTE poderá rescindir o mesmo, desde que comunique tal fato à CONTRATADA, por escrito, com antecedência mínima de 30 (trinta) dias, persistindo suas obrigações durante este período.</p>
                <p>Cláusula Décima - Eventuais dúvidas ou lides deverão ser dirimidas no foro da Comarca de Londrina, Estado do Paraná, com renúncia de outro qualquer, por melhor e/ou mais privilegiado que seja. E, por haverem assim contratados, firmam o presente contrato lavrado em duas vias de idêntico teor e uma só forma, na presença de testemunhas.</p>
            </div>

            <div class="data">
                <p><?= UtilCTRL::retornaDataPorExtenso($dados[0]["data_registro"]) ?>.</p>
            </div>

            <p class="bold" style="letter-spacing: 1px">CONTRATANTE</p>

            <div class="row-assinatura">
                <span style="text-transform: uppercase"><?= $dados[0]["razao_social"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

            <br>
            <br>

            <p class="bold" style="letter-spacing: 1px">CONTRATADA</p>
            
            <div class="row-assinatura">
                <span style="text-transform: uppercase"><?= $dadosEmpresaContratada["razao_social"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

            <br>
            <br>
            <br>
            <br>

            <div class="">
                <p>Testemunha</p>
            </div>

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
$razaoSocial = implode("-", explode(" ", $dados[0]['razao_social']));
$domPDF->stream("PJ-Individual-acima-de-20-horas__{$razaoSocial}.pdf", ["Attachment" => false]);

?>