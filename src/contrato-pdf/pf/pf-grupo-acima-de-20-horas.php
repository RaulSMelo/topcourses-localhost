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
                font-family: -apple-system,sans-serif;
                font-size: .75rem;
                text-align: justify;
                margin: 3rem 2rem;
            }


            .titulo{
                text-align: left;
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
        
        <title>PF - Grupo acima de 20 horas</title>
    </head>
    <body>
        
        <div class="container-contrato">

            <header class="titulo">CONTRATO DE PRESTA????O DE SERVI??OS E OUTRAS AVEN??AS N?? <span><?= $dados[0]["id_contrato_curso"] ?></span></header>

            <br>
            <br>

            <div class="conteudo">
                    
                <p>Por este instrumento particular, de um lado os/as senhores (as):

                    <?php $nomes = "" ?>

                    <?php for($i =0; $i < count($dados); $i++): ?>

                        <?php $nomes .= $dados[$i]["nome"] . "-" ?>

                        <?php $separador = ($i == (count($dados) -2)) ? " e" : "," ?>

                        <span class="bold"><?= $dados[$i]["nome"] . " " . $dados[$i]["sobrenome"] ?></span>, <span class="bold">CPF</span> <span class="bold"><?= UtilCTRL::mascaraCPF($dados[$i]["cpf"]) ?></span><?= ($i == (count($dados) -1)) ? "" : $separador ?>

                    <?php endfor ?>
                neste ato denominados CONTRATANTES; e, de  outro, <span><?= $dadosEmpresaContratada["razao_social"] ?></span>, pessoa jur??dica de direito privado, sediada na <span><?= $dadosEmpresaContratada["rua"] ?></span>, n?? <span><?= $dadosEmpresaContratada["numero"] ?></span>, nesta cidade e Comarca de <span><?= $dadosEmpresaContratada["cidade"] ?></span>, Estado do <span><?= $dadosEmpresaContratada["estado"] ?></span>, inscrita no CGC/MF sob n??mero <span><?= UtilCTRL::mascaraCNPJ($dadosEmpresaContratada["cnpj"]) ?></span>, ora representada na forma prevista por seu ato constitutivo e respectivas altera????es contratuais, neste ato denominada CONTRATADA, t??m certo e ajustado o presente contrato de presta????o de servi??os e outras aven??as, que se reger?? pela legisla????o vigente e pelas cl??usulas ou condi????es seguintes:
                </p>
                <p>Cl??usula Primeira ??? Por um lado, os CONTRATANTES, pessoas f??sicas que necessitam do aprendizado do idioma <span><?= $dados[0]["idioma"] ?></span>. Por outro lado, a CONTRATADA??? empresa especializada na atividade de ensino da l??ngua <span><?= UtilCTRL::idiomaNoFeminino($dados[0]["idioma"]) ?></span>, que se encontra h?? mais de quinze anos instalada na cidade de <span><?= $dadosEmpresaContratada["cidade"] ?></span>.</p>
                <p>Par??grafo Primeiro - Os CONTRATANTES ser??o avaliados e formar??o grupos de no m??ximo <span><?= count($dados) ?></span> (<span><?= UtilCTRL::valorPorExtenso(count($dados),false, true) ?></span>) pessoas.</p>
                <p>Par??grafo Segundo - Entende-se por grupo aquele formado por um ou mais elementos que, durante o mesmo hor??rio de aula, siga o mesmo m??todo de aprendizado, com as mesmas li????es.</p>
                <p>Cl??usula Segunda - Face ?? necessidade do aprendizado do idioma <span><?= $dados[0]["idioma"] ?></span>, os CONTRATANTES contratam os servi??os da CONTRATADA para instru????o necess??ria no per??odo de <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_inicio_contrato"]) ?></span> <b>a</b> <span class="bold"><?= UtilCTRL::dataFormatoBR($dados[0]["data_termino_contrato"]) ?></span>, por meio de aulas ministradas no seguinte local: <span><?= $dados[0]["local_das_aulas"] ?></span>.</p>
                <p>Cl??usula Terceira - Pelos servi??os retro mencionados, CADA CONTRATANTE pagar?? ?? CONTRATADA pela instru????o do grupo, <span class="var"><?= $dados[0]["qtde_parcelas"] ?></span> <b>parcela(s)</b> no valor de <b>R$</b> <span class="var"><?= $valor_parcela_cada_aluno ?> </span>  referente(s) ao total de <span class="bold"><?= UtilCTRL::arredondarHoras($dados[0]["total_horas"]) ?> horas</span> a serem ministradas durante o per??odo, sendo o valor da hora-aula <span class="var">R$ <?= UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["valor_hora_aula"]) ?></span>. Eventual altera????o no noticiado n??mero de horas contratadas ser?? objeto de altera????o proporcional do pre??o.<?= ($dados[0]["desconto"] != "") ? "<span class='bold'> Para este contrato foi concedido desconto de " . UtilCTRL::formatoMoedaBRSemSifrao($dados[0]["desconto"]) . "%.</span> "  : ""  ?></p>
                <p>Cl??usula Quarta - Os pagamentos dever??o ser realizados at?? no m??ximo no dia <span><?= date("d", strtotime($dados[0]["dia_vencimento_parcela"])) ?></span> dos meses a vencer, mediante a apresenta????o da competente nota fiscal (ou fatura ou recibo).</p>
                <p>Par??grafo Primeiro - Haver?? multa morat??ria equivalente a 2% (dois por cento) sobre o saldo devedor e juros di??rios de 0,1%, em caso de n??o pagamento at?? o dia do vencimento.</p>
                <p>Par??grafo Segundo - Ainda em caso de n??o pagamento da presta????o no respectivo vencimento, al??m da multa morat??ria e da corre????o monet??ria sobre o valor total devido, ser?? facultado ?? CONTRATADA, rescindir o presente contrato, arcando os CONTRATANTES com as perdas e danos da?? inerentes.</p>
                <p>Cl??usula Quinta - As aulas a que se refere este contrato ser??o ministradas por pessoal especializado da CONTRATADA, no local previsto na cl??usula segunda.</p>
                <p>Cl??usula Sexta - ?? de total responsabilidade da CONTRATADA a orienta????o t??cnica sobre a presta????o dos servi??os retro apontados, competindo-lhe a montagem do programa, escolha do material did??tico, indica????o do professor, orienta????o did??tico-pedag??gica, al??m de outras provid??ncias que as atividades docentes exigirem.</p>
                <p>Cl??usula S??tima - A carga hor??ria ser?? de <span class="bold"><?= $dados[0]["carga_horaria_semanal"] ?> hora(s) por semana</span> e as aulas ser??o ministradas nos seguintes dias e hor??rios: <b>??s</b>
     
                    <?php for($i = 0; $i < count($agendamentos); $i++): ?>

                        <?php $separador = ($i < (count($agendamentos) -1)) ? "," : "."?>
                        <span class="bold"><?= DIAS_DA_SEMANA[$agendamentos[$i]["dia_da_semana"]] ?></span> <span class="bold">das</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_inicial"]) ?></span> <span class="bold">??s</span> <span class="var"><?= UtilCTRL::formatarHoras($agendamentos[$i]["hora_final"]) ?></span><?= $separador ?>

                    <?php endfor ?>

                </p>
                                                                                                                                                                                    
                <p>Par??grafo ??nico - Eventual altera????o, tanto da carga hor??ria, quanto do hor??rio e dia das aulas, somente poder?? dar-se por consenso dos CONTRATANTES e CONTRATADA. Em caso de atraso dos CONTRATANTES, o hor??rio de t??rmino da aula manter-se-?? inalterado.</p>
                <p>Cl??usula Oitava - Em caso de impossibilidade de realiza????o da aula no hor??rio pactuado, os CONTRATANTES ter??o direito ?? reposi????o da mesma, desde que efetuem o devido comunicado ?? CONTRATADA com anteced??ncia m??nima de <b>12 (doze) horas</b>, e reponham a mesma num prazo de 15 (quinze) dias a contar do dia da aula cancelada. O hor??rio da aula de reposi????o ser?? negociado entre professor e alunos, conforme disponibilidade dos mesmos.</p>
                <p>Cl??usula Nona - Este contrato ?? celebrado em car??ter irrevog??vel e irretrat??vel e os CONTRATANTES s??o solidariamente respons??veis pela totalidade do pagamento descrito na Cl??usula Terceira, sendo as obriga????es estabelecidas neste contrato indivis??veis.</p>
                <p>Par??grafo Primeiro - Caso um ou mais CONTRATANTES venha a ficar impedido de dar continuidade a este contrato, dever?? comunicar ?? CONTRATADA, por escrito, com anteced??ncia m??nima de <b>30 (trinta) dias</b>, persistindo suas obriga????es durante este per??odo.</p>
                <p>Par??grafo Segundo - Na hip??tese prevista no par??grafo primeiro, retro, os demais CONTRATANTES dar??o continuidade a este contrato, mantendo-o em todos os seus termos. </p>   
                <p>Cl??usula D??cima - OS CONTRATANTES s??o respons??veis pela totalidade do pagamento descrito na Cl??usula Terceira, sendo, portanto, indivis??veis as obriga????es neste contrato estabelecidas. </p>
                <p>Cl??usula D??cima Primeira - Eventuais d??vidas ou lides dever??o ser dirimidas no foro da Comarca de Londrina, Paran??, com ren??ncia de outro qualquer, por melhor e/ou mais privilegiado que seja. E, por haverem assim contratados, firmam este contrato, lavrado em duas vias de id??ntico teor, na presen??a de testemunhas</p>
            </div>

            <div class="data">
                <p class="bold"><?= UtilCTRL::retornaDataPorExtenso($dados[0]["data_registro"]) ?>.</p>
            </div>
            
            <?php for($i = 0; $i < count($dados); $i++): ?>
                <div class="row-assinatura">
                    <span style="text-transform: uppercase"><?= $dados[$i]["nome"] . " " . $dados[$i]["sobrenome"] ?></span><span class="tracejado">_______________________________________________</span>
                </div>
            <?php endfor ?>

            <br>

            <div class="row-assinatura">
                <span class="var"><?= $dadosEmpresaContratada["razao_social"] ?></span><span class="tracejado">_______________________________________________</span>
            </div>

            <br>
            <br>
            <br>

            <p>TESTEMUNHAS:</p>

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
$domPDF->stream("PF-Grupo-acima-de-20-horas__{$nomes}.pdf", ["Attachment" => false]);

?>

