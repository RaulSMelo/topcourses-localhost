<?php
require_once(dirname(__DIR__, "3") . "/vendor/autoload.php");

use Dompdf\Dompdf;
use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\controllers\RelatorioContratoController;

if (Input::post("btn-imprimir-relatorio-contratos") !== null) {

    $filtros = [
        "data-inicio"   => Input::post("data-inicio"),
        "data-final"    => Input::post("data-final"),
        "nome"          => Input::post("nome"),
        "sobrenome"     => Input::post("sobrenome"),
        "tipo-contrato" => Input::post("id-tipo-contrato"),
        "situacao"      => Input::post("situacao")
    ];

    $relatorioContratoCTRL = new RelatorioContratoController();

    $dadosRelatorio      = $relatorioContratoCTRL->buscarRelatoriosContratos($filtros);
    $somaTotalDosValores = $relatorioContratoCTRL->somaDosValoresDosContratos($filtros);
    $nomes_dos_contratos = $relatorioContratoCTRL->buscarRelatoriosContratos($filtros, false);

}

$domPDF = new Dompdf();

ob_start();

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <style>

            @page{
                margin: 2.5rem 1rem;
            }

            body{
                font-family: -apple-system,sans-serif;
                margin: 0;
                padding: 0;
            }
            
            .header{
                background-color: #343a40;
                border: 1px solid #000; 
                height: 40px;
                line-height: 30px;
            }
            
            .header h4{
                color: #fff;
                text-align: center;
                margin: auto 0;
            }

            .container-resultado-pesquisa{
                border: 1px solid #000;
                padding: 1rem; 
                margin-top: -1px;
                margin-bottom: 1rem;
            }

            .dados-da-pesquisa{
                margin-left: -12px;
                margin-right: 12px;
            }
            
            table{
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #000;
                font-size: 0.68rem;
                padding: 1rem;
                margin: 0 auto;
            }
            
            table thead tr th{
                border: 1px solid #343a40;
                background-color: #343a40;
                color: #fff;
                height: 30px;
                font-size: 14px !important;
                text-align: left;
                padding: 8px;
            }
            
            table th{
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;
            }
            
            table td{
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;
                padding: 8px;
            }
            
            .line-nowrap{
                white-space: nowrap;
            }
            
            .desc-pesquisa{
                line-height: 30px;
            }
            
            .desc-pesquisa .titulo-desc-pesquisa{
                display: inline-block;
                width: 200px;
            }
            
            .desc-pesquisa .dados-desc-pesquisa{
                display: inline-block;
            }
            
            .desc-pesquisa .qtde-de-contratos{
                display: inline
            }
            
            .desc-pesquisa .qtde-e-valor-dos-contratos{
                display: inline;
               
            }
            
        </style>

        <title>Relatório de contratos</title>
    </head>
    <body>

        <div class="header">
            <h4 class="titulo">Resultado da pesquisa</h4>
        </div>

        <div class="container-resultado-pesquisa">
            
            <div class="desc-pesquisa">
                <div class="titulo-desc-pesquisa">
                    <label>Período: </label>
                </div>
                <div class="dados-desc-pesquisa">
                    <label class=""><?= (isset($filtros["data-inicio"]) && !empty($filtros["data-inicio"]) && isset($filtros["data-final"]) && !empty($filtros["data-final"]) ) ? UtilCTRL::dataFormatoBR($filtros["data-inicio"]) . "  à  " . UtilCTRL::dataFormatoBR($filtros["data-final"]) : "" ?></label>
                </div> 
            </div>

            <div class="desc-pesquisa">
                <div class="titulo-desc-pesquisa">
                    <label>Tipo do contrato: </label>
                </div>
                <div class="dados-desc-pesquisa">
                    <label class=""><?= (isset($filtros["tipo-contrato"]) && !empty($filtros["tipo-contrato"])) ? TIPOS_DE_CONTRATOS[$filtros["tipo-contrato"]] : "Todos" ?></label>
                </div>
            </div>

            <div class="desc-pesquisa">
                <div class="titulo-desc-pesquisa">
                    <label class="titulo-desc-pesquisa">Situação: </label>
                </div>
                <div class="dados-desc-pesquisa">
                    <label class=""><?= (isset($filtros["situacao"]) && !empty($filtros["situacao"])) ? SITUACAO_CONTRATO[$filtros["situacao"]] : "Todos" ?></label>
                </div>
            </div>
            
            <hr style="color: #808080">
            
            <div class="desc-pesquisa qtde-e-valor-dos-contratos">
                <div class="qtde-de-contratos">
                    <div class="titulo-desc-pesquisa">
                        <label class="titulo-desc-pesquisa"><em><b>Total de Contratos: </b></em></label>
                    </div>
                    <div class="dados-desc-pesquisa">
                        <label class=""><b><?= isset($dadosRelatorio) ? count($dadosRelatorio) : "" ?></b></label>
                    </div>
                </div>
                <div class="valor-total-dos-contratos">
                    <div class="titulo-desc-pesquisa">
                        <label><em><b>Valor total dos contratos: </b></em></label>
                    </div>
                    <div class="dados-desc-pesquisa">
                        <label class="valor-total"><b><?= (isset($somaTotalDosValores) && !empty($somaTotalDosValores)) ? UtilCTRL::formatoMoedaBRComSifrao($somaTotalDosValores) : "" ?></b></label>
                    </div>
                </div>
            </div>

        </div>

        <div class="dados-da-pesquisa">

            <table>
                <thead>
                    <tr>
                        <th>Nomes</th>
                        <th>Tipos de contrato</th>
                        <th>Período</th>
                        <th>Situação</th>
                        <th>Valores</th>
                    </tr>
                </thead>
                <tbody>

                    <?php for ($i = 0; $i < count($dadosRelatorio); $i++): ?> 
                    
                        <?php
                                            
                            $inicio_tag_a = "";
                            $fim_tag_a    = "";

                            if($dadosRelatorio[$i]["tipo_contrato"] >= 3 && $dadosRelatorio[$i]["tipo_contrato"] <= 13){

                                $caminho_pdf = UtilCTRL::gerarCaminhoParaPDF($dadosRelatorio[$i]["tipo_contrato"]) . $dadosRelatorio[$i]["id_contrato"];

                                $inicio_tag_a = "<a href='{$caminho_pdf}' target='_blank'>";
                                $fim_tag_a    = "</a>";
                            } 


                        ?>

                        <tr>
                            <td class="line-nowrap align-middle">
                                <em>
                                    <?php for ($j = 0; $j < count($nomes_dos_contratos); $j++): ?>
                                        
                                        <?php if ($dadosRelatorio[$i]["id_contrato"] == $nomes_dos_contratos[$j]["id_contrato"] && $dadosRelatorio[$i]["tipo_contrato"] == $nomes_dos_contratos[$j]["tipo_contrato"]): ?>

                                            <?= $nomes_dos_contratos[$j]["nome"] . " " . $nomes_dos_contratos[$j]["sobrenome"] . "<br>" ?>

                                        <?php endif ?>

                                    <?php endfor ?>
                                </em>
                            </td>
                            <td class="line-nowrap align-middle"><?= $inicio_tag_a ?><?= TIPOS_DE_CONTRATOS[$dadosRelatorio[$i]["tipo_contrato"]] ?><?= $fim_tag_a ?></a></td>
                            <td class="line-nowrap align-middle"><?= UtilCTRL::dataFormatoBR($dadosRelatorio[$i]["data_inicio"]) . " à " . UtilCTRL::dataFormatoBR($dadosRelatorio[$i]["data_final"]) ?></td>
                            <td class="line-nowrap align-middle"><?= SITUACAO_CONTRATO[$dadosRelatorio[$i]["situacao"]] ?></td>
                            <td class="line-nowrap align-middle"><?= UtilCTRL::formatoMoedaBRComSifrao($dadosRelatorio[$i]["valor_total"]) ?></td>
                        </tr>

                    <?php endfor ?>

                </tbody>
            </table>
        </div>

    </body>
</html>

<?php

$domPDF->loadHtml(ob_get_clean());
$domPDF->setPaper("A4");
$domPDF->render();
$data = date("d-m-Y");
$domPDF->stream("relatorio_contratos_{$data}.pdf", ["Attachment" => false]);

?>



