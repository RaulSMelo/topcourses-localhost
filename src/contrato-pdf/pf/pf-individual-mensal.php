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
                font-size: 0.875rem;
                margin-bottom: 3rem;
            }

            .paragrafo-2{
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
        
        <title>PF - Individual mensal</title>
    </head>
    <body>
        
        <div class="container-contrato">
            
            <header class="titulo">CONTRATO DE PRESTA????O DE SERVI??OS E OUTRAS AVEN??AS N?? <span><?= $dados[0]["id_contrato_curso"] ?></span></header>

            <div class="conteudo">
                <p>Por este instrumento particular, de um lado o (a) senhor (a): <span class="bold"><?= $dados[0]["nome"] . " " . $dados[0]["sobrenome"] ?></span><b>, CPF</b> <span class="bold"><?= UtilCTRL::mascaraCPF($dados[0]["cpf"]) ?></span>, neste ato denominado CONTRATANTE; e, de outro, <span><?= $dadosEmpresaContratada["razao_social"] ?></span>, pessoa jur??dica de direito privado, sediada ?? <span><?= $dadosEmpresaContratada["rua"] ?></span>, n?? <span><?= $dadosEmpresaContratada["numero"] ?></span>, nesta cidade e Comarca de <span><?= $dadosEmpresaContratada["cidade"] ?></span>, Estado do <span><?= ucfirst($dadosEmpresaContratada["estado"])?></span>, inscrita no CGC/MF sob n??mero <span><?= UtilCTRL::mascaraCNPJ($dadosEmpresaContratada["cnpj"]) ?></span>, ora representada na forma prevista por seu ato constitutivo e respectivas altera????es contratuais, neste ato denominada CONTRATADA, t??m certo e ajustado o presente contrato de presta????o de servi??os e outras aven??as, que se rege pela legisla????o vigente e pelas cl??usulas ou condi????es seguintes:</p>
                <p>Cl??usula Primeira ??? Por um lado o CONTRATANTE, pessoa f??sica que necessita do aprendizado do idioma ingl??s. Por outro lado, a CONTRATADA??? empresa especializada na atividade de ensino da l??ngua inglesa, que se encontra h?? mais de quinze anos instalada na cidade de Londrina. </p>
                <p>Cl??usula Segunda - Face ?? necessidade do aprendizado do idioma <span><?= $dados[0]["idioma"] ?></span>, o CONTRATANTE contrata os servi??os da CONTRATADA para instru????o necess??ria durante <span class="bold"><?= $dados[0]["numero_meses_por_ano"] ?></span> <span class="bold">(<?= UtilCTRL::valorPorExtenso($dados[0]["numero_meses_por_ano"], false, false) ?>)</span> meses por ano, por meio de aulas ministradas no seguinte local: <span class="bold"><?= $dados[0]["local_das_aulas"] ?></span>.</p>
                <p>Cl??usula Terceira - Pelos servi??os retro mencionados, o CONTRATANTE pagar?? a CONTRATADA pela instru????o do aluno, necess??ria durante <span class="bold"><?= $dados[0]["numero_meses_por_ano"] ?></span> meses ao ano, o equivalente a <span class="bold"><?= $dados[0]["qtde_parcelas"] ?></span><span class="bold"> parcelas de R$ <?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_parcela"]) ?></span>.</p>
                <p>Par??grafo Primeiro - O valor acima se refere ao total de horas contratadas multiplicado pelo valor da hora aula, R$ <span><?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_hora_aula"]) ?></span>, e dividido pelo n??mero de meses do contrato. <?= ($dados[0]["desconto"] != "") ? "<span class='bold'> Para este contrato foi concedido desconto de " . UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["desconto"]) . "%.</span>"  : ""  ?></p>
                <p>Cl??usula Quarta - O valor dos servi??os mencionados na cl??usula terceira, retro, ser?? reajustado anualmente, em janeiro de cada ano, com base no aumento de nossos custos, ou qualquer ??ndice definido pelo Governo Federal.</p>
                <p>Cl??usula Quinta - Os pagamentos dever??o ser realizados por meio de boletos banc??rios ou transfer??ncia banc??ria at?? no m??ximo no dia <span class="bold"><?= date("d", strtotime($dados[0]["dia_vencimento_parcela"])) ?> do m??s a vencer</span>, mediante a apresenta????o da competente nota fiscal (ou fatura ou recibo).</p>
                <p>Par??grafo Primeiro - Haver?? multa morat??ria equivalente a 2% (dois por cento) sobre o saldo devedor e juros di??rios de 0,1%, em caso de n??o pagamento at?? o dia do vencimento.</p>
                <p>Par??grafo Segundo - Ainda em caso de n??o pagamento da presta????o no respectivo vencimento, al??m da multa morat??ria e da corre????o monet??ria sobre o valor total devido, ser?? facultado ?? CONTRATADA, rescindir o presente contrato, arcando o CONTRATANTE com as perdas e danos da?? inerentes.</p> 
                <p>Cl??usula Sexta - As aulas a que se refere este contrato ser??o ministradas por pessoal especializado da CONTRATADA, no local previsto na cl??usula segunda. </p>
                <p>Cl??usula S??tima - ?? de total responsabilidade da CONTRATADA a orienta????o t??cnica sobre a presta????o dos servi??os retro apontados, competindo-lhe a montagem do programa, escolha do material did??tico, indica????o do professor, orienta????o did??tico-pedag??gica, al??m de outras provid??ncias que as atividades docentes exigirem.</p>
                
                <p>Cl??usula Oitava - A carga hor??ria ser?? de <span class="bold"><?= $dados[0]["carga_horaria_semanal"] ?> hora(s)  por semana</span> e as aulas ser??o ministradas nos seguintes dias e hor??rios: <b>??s</b>

                    <?php for($i = 0; $i < count($agendamentos); $i++): ?>

                        <?php $separador = ($i < (count($agendamentos) -1)) ? "," : "."?>
                        <span class="bold"><?= DIAS_DA_SEMANA[$agendamentos[$i]["dia_da_semana"]] ?></span> <span class="bold">das</span> <span class="bold"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_inicial"]) ?></span> <span class="bold">??s</span> <span class="bold"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_final"]) ?></span><?= $separador ?>

                    <?php endfor ?>

                </p>
                
                <p>Par??grafo ??nico - Eventual altera????o, tanto da carga hor??ria, quanto do hor??rio e dia das aulas, somente poder?? dar-se por consenso do CONTRATANTE e CONTRATADA. Em caso de atraso do CONTRATANTE, o hor??rio de t??rmino da aula se manter-se-?? inalterado.</p>
                <p>Cl??usula Nona - Em caso de impossibilidade de realiza????o da aula no hor??rio pactuado, o CONTRATANTE ter?? direito ?? reposi????o da mesma, desde que efetue o devido comunicado ?? CONTRATADA com anteced??ncia m??nima de 12 (doze) horas, e reponha a mesma em um prazo de 15 dias a contar do dia da aula cancelada. O hor??rio da aula de reposi????o ser?? negociado entre professor e aluno, conforme disponibilidade dos mesmos.</p>
                <p>Cl??usula D??cima - O presente contrato vigorar?? por <span class="var"><?= $dados[0]["numero_meses_por_ano"] ?></span> meses, iniciando-se em <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_inicio_contrato"]) ?></span> com t??rmino previsto para <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_termino_contrato"]) ?></span>.</p>
                <p>Cl??usula D??cima Primeira - Este contrato ?? celebrado em car??ter irrevog??vel e irretrat??vel, podendo, por??m, ser rescindido por qualquer de suas cl??usulas e condi????es.</p>
                <p>Par??grafo Primeiro - Caso o CONTRATANTE venha a ficar impedido de assistir ??s aulas ministradas pela CONTRATADA e, por isso n??o possa dar continuidade a este contrato, dever?? comunicar tal fato ?? CONTRATADA, por escrito, com anteced??ncia m??nima de 30 (trinta) dias, persistindo suas obriga????es durante este per??odo. </p>
                <p>Cl??usula D??cima Segunda - O CONTRATANTE ?? respons??vel pela totalidade do pagamento descrito na Cl??usula Terceira, sendo, portanto, indivis??veis as obriga????es neste contrato estabelecidas. </p>
                <p>Cl??usula D??cima Terceira - Eventuais d??vidas ou lides dever??o ser dirimidas no foro da Comarca de Londrina, Estado do Paran??, com ren??ncia de outro qualquer, por melhor e/ou mais privilegiado que seja. E, por haverem assim contratados, firmam o presente contrato lavrado em duas vias de id??ntico teor e uma s?? forma, na presen??a de testemunhas. </p>
            </div>

            <div class="data">
                <p><?= UtilCTRL::retornaDataPorExtenso($dados[0]["data_registro"]) ?>.</p>
            </div>

            <div>
                <p>CONTRATANTE</p>
            </div>

            <div class="row-assinatura">
                <span style="text-transform: uppercase"><?= $dados[0]["nome"] . " " . $dados[0]["sobrenome"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

            <div>
                <p>CONTRATADA</p>
            </div>

            <div class="row-assinatura">
                <span class="var"><?= $dadosEmpresaContratada["razao_social"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

            <div class="">
                <p>Testemunhas:</p>
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
$domPDF->stream("PF-Individual-mensal__{$dados[0]['nome']}.pdf", ["Attachment" => false]);

?>
