<?php

namespace Src\traits;

use Src\erro\Erro;
use DateInterval;
use DatePeriod;
use DateTime;

class UtilCTRL
{

    public static function validarData($data): bool
    {

        if (strpos($data, "-")) {

            $ex = explode("-", $data);

            return self::checarDataValida($ex, false);
            
        } else if (strpos("/", $data)) {

            $ex = explode("/", $data);

            return self::checarDataValida($ex);
        }
    }
    
    private static function checarDataValida($arrayData, $formatoBR = true): bool
    {
        $dia = "";
        $mes = "";
        $ano = "";

        if ($formatoBR) {

            $dia = $arrayData[0];
            $mes = $arrayData[1];
            $ano = $arrayData[2];
        } else {
            $ano = $arrayData[0];
            $mes = $arrayData[1];
            $dia = $arrayData[2];
        }

        return checkdate($mes, $dia, $ano);
    }

    public static function dataAtual(): string
    {
        self::fusoBR();
        return date("Y-m-d");
    }
    
    public static function fusoBR(): string
    {
        return date_default_timezone_set("America/Sao_Paulo");
    }

    public static function config_locale_BR(): string
    {
        return setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    }

    public static function dataFormatoBR(string $data): string
    {
        $ex = explode("-", $data);
        return "{$ex[2]}/{$ex[1]}/{$ex[0]}";
    }

    public static function dataFormatoDB(string $data): string
    {
        $ex = explode("/", $data);
        return "{$ex[2]}-{$ex[1]}-{$ex[0]}";
    }

    public static function retiraMascara($campo): string
    {
        return preg_replace("/[^0-9]/", "", $campo);
    }

    public static function senhaHash(string $nome_sobrenome): string
    {
        $senha = self::retirarEspacosNomeEsobrenome(trim($nome_sobrenome));
        
        return password_hash($senha, PASSWORD_DEFAULT);
    }
    
    public static function validarSenhaLogin($senha, $hash): bool
    {
        return password_verify($senha, $hash);
    }

    public static function retirarEspacosNomeEsobrenome(string $nome_sobrenome): string
    {
        $nome_normalizado = preg_replace("/\s{2,}/", " ", $nome_sobrenome);
        
        $ex = explode(" ", $nome_normalizado);
        
        return strtolower($ex[0] . "." . $ex[count($ex) -1]);
    }

    public static function mascaraTelefone($telefone)
    {
        return substr($telefone, 0, 2) . " " . substr($telefone, 2, -4) . "-" . substr($telefone, -4);
    }


    public static function retornaDDD($telefone)
    {
        return substr($telefone, 0, 2);
    }

    public static function retornaTelefoneSemDDD($telefone)
    {
        return substr($telefone, 2, -4) . "-" . substr($telefone, -4);
    }

    public static function mascaraCPF($cpf)
    {
        return substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9, 2);
    }
    
    public static function mascaraCNPJ($cnpj)
    {
        return substr($cnpj, 0, 2) . "." . substr($cnpj, 2, 3) . "." . substr($cnpj, 5, 3) . "/" . substr($cnpj, 8, 4) . "-" . substr($cnpj, 12, 2);
    }
    
    

    public static function mascaraCEP($cep)
    {
        return substr($cep, 0, 2) . "." . substr($cep, 2, 3) . "-" . substr($cep, 5, 3);
    }

    public static function validarDataRegistro(string $data)
    {
        $dataAtual = self::dataAtual();
        
        if (empty($data)) {

            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Data de registro não ser vazia");

            return -1;
            
        } else {

            if (!self::validarData($data)) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Data de registro não é uma data válida");

                return -1;
            }

            if (strtotime($data) != strtotime($dataAtual)) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Data de registro não corresponde com a data atual");

                return -1;
            }
        }

        return true;
    }

    public static function validarDataNascimento(string $data)
    {
        
        $dataFormatoBR      = self::dataFormatoBR($data);
        $dataAtual          = self::dataAtual();
        $dataAtualFormatoBR = self::dataFormatoBR($dataAtual);
        
        if (!empty($data) && !self::validarData($data)) {

            Erro::setErro("Data de nascimento <em><strong>{$dataFormatoBR}</strong></em> não é uma data válida");

            return -1;
        }

         
        if (strtotime($data) >= strtotime($dataAtual)) {

            Erro::setErro("Data de nascimento informada <em><strong>{$dataFormatoBR}</strong></em> não pode ser igual ou maior que a data atual - <em><strong>{$dataAtualFormatoBR}</strong></em>");
            
            return -1;
        }

        return true;
    }


    public static function validarDataInformadaEmaiorQueDataAtual(string $labelData, string $data)
    {
        $dataFormatoBR      = self::dataFormatoBR($data);
        $dataAtual          = self::dataAtual();
        $dataAtualFormatoBR = self::dataFormatoBR($dataAtual);
        
        if (!empty($data) && !self::validarData($data)) {

            Erro::setErro("{$labelData} <em><strong>{$dataFormatoBR}</strong></em> não é uma data válida");

            return -1;
        }

        if (strtotime($data) < strtotime($dataAtual)) {

            Erro::setErro("{$labelData} informado <em><strong>{$dataFormatoBR}</strong></em> não pode ser menor que a data atual - <em><strong>{$dataAtualFormatoBR}</strong></em>");

            return -1;
        }

        return true;
    }

    public static function validarDataInicioEdataFinal(string $labelData1, string $labelData2, string $dataInicio, string $dataFinal)
    {
        
        $dtIni = self::dataFormatoBR($dataInicio);
        $dtFim = self::dataFormatoBR($dataFinal);

        if(empty($dataInicio) || empty($dataFinal)){


            Erro::setErro("Os campos {$labelData1} e {$labelData2} não podem ser vazios");

            return 0;
            
        }else{

            if (!self::validarData($dataInicio)) {

                Erro::setErro("{$labelData1} informada <em><strong>{$dtIni}</strong></em> não é uma data válida");
    
                return -1;
            }
    
            if (!self::validarData($dataFinal)) {
    
                Erro::setErro("{$labelData2} informada <em><strong>{$dtFim}</strong></em> não é uma data válida");
    
                return -1;
            }

            if (strtotime($dataInicio) > strtotime($dataFinal)) {
                
                Erro::setErro("{$labelData1} informada <em><strong>{$dtIni}</strong></em> não pode ser maior que a {$labelData2} informada <em><strong>{$dtFim}</strong></em>");
    
                return -1;
            }
        }

        return true;
    }
    
    public static function retornaQtdeDeMesesDeUmPeriodo($dataInicio, $dataFinal) 
    {
        if(self::validarData($dataInicio) && self::validarData($dataFinal)){
            
            $dtIni = new DateTime($dataInicio);
            $dtFim = new DateTime($dataFinal);
            
            $diffPeriodo = $dtIni->diff($dtFim);
            
            $meses       = $diffPeriodo->m + ($diffPeriodo->y * 12);
            $dias        = $diffPeriodo->d;
            
            $resultado = ($dias >= 15) ? $meses + 1 : $meses; 
            
            return $resultado;
        }
    }

    public static function formatoMoedaBRComSifrao($valor) 
    {
       return 'R$ ' . number_format($valor, 2, ",", ".");
    }
    
    public static function formatoMoedaBRSemSifrao($valor) 
    {
       return number_format($valor, 2, ",", ".");
    }
    
    public static function formatoDecimalDB($valor)
    {
        
        $num_format = str_replace(".", "", $valor);
 
        return str_replace(",", ".", $num_format);
    }
    
    public static function retornaNomeEsobrenome($nome) 
    {
        $nome_normalizado = preg_replace("/\s{2,}/", " ", $nome);
        
        $ex = explode(" ", trim($nome_normalizado));
        
        if(count($ex) > 1){
           
            $sobrenome = implode(" ", array_filter($ex, fn($key) => $key > 0, ARRAY_FILTER_USE_KEY)); 

            return ["nome" => $ex[0], "sobrenome" => $sobrenome];
            
        }else{
            
            return ["nome" => $ex[0]];
        }
        
    }
    
    public static function somarMesesData($data, $num) 
    {
        return date("Y-m-d", strtotime("+{$num} month", strtotime($data)));
    }
    
    public static function PegarDataDosDiasDaSemanaAgendamento($diasSemana, $dataInicio, $dataFinal) 
    {
        
        self::fusoBR();
        
        if(self::validarData($dataInicio) && self::validarData($dataFinal)){
            
            $dtIni     = new DateTime($dataInicio);
            $dtFim     = new DateTime($dataFinal);
            $intervalo = new DateInterval("P1D");
            $periodo   = new DatePeriod($dtIni, $intervalo, $dtFim);
            $datas     = [];
            
            
            if(!in_array("a-combinar", $diasSemana)){
                
                foreach ($periodo as $data){
                    
                    foreach ($diasSemana as $dia){
                        
                        if($data->format("w") == $dia){
                            
                            $datas[$dia][] = $data->format("Y-m-d"); 
                            
                        }
                    }
                }
                
            }else if(count($diasSemana) == 1 && in_array("a-combinar", $diasSemana)){
                
                for($i = 0; strtotime(date("Y-m-d", strtotime("+{$i} days", strtotime($dataInicio)))) <= strtotime($dataFinal); $i++){ 
                    $datas[] = date("Y-m-d", strtotime("+{$i} days", strtotime($dataInicio)));
                }
                
            } 
        }
        
        return $datas;      
    }
    
    public static function gerarDatasParaNovoAgendamento($dataInicio, $dataFinal) 
    {
        $datas = [];
        
        for($i = 0; strtotime(date("Y-m-d", strtotime("+{$i} days", strtotime($dataInicio)))) <= strtotime($dataFinal); $i++){ 
            $datas[] = date("Y-m-d", strtotime("+{$i} days", strtotime($dataInicio)));
        }
        
        return $datas;
    }
    
    public static function somarHorasDosDiasAgendados($arrPeriodo, $arrDiasSemana, $arrHrIni, $arrHrFim)
    {

        $dataBase = $date = DateTime::createFromFormat('H:i:s', '00:00:00');

            for ($i = 0; $i < count($arrDiasSemana); $i++){

                for ($j = 0; $j < count($arrPeriodo[$arrDiasSemana[$i]]); $j++){

                    $horaInicio = DateTime::createFromFormat('H:i', $arrHrIni[$i]);
                    $horaFinal  = DateTime::createFromFormat('H:i', $arrHrFim[$i]);

                    $diff_hrFim_hrIni = DateTime::createFromFormat("H:i", $horaFinal->diff($horaInicio)->format('%H:%I'));

                    $diff = $dataBase->diff($diff_hrFim_hrIni);

                    $date->add($diff);
                }
            }

            $interval = $dataBase->diff($date);

            $hours = $interval->format('%H') + ($interval->format('%a') * 24);

            $horasCalculadas = $hours . $interval->format(':%I');

        return $horasCalculadas;
    }
    
    public static function validarHorasAgendamento($totalHoras, $totalHorasDiasAgendados)
    {
        $exTotalHoras = explode(":", $totalHoras);
        $exTotalHorasDiasAgendados = explode(":", $totalHorasDiasAgendados);
        
        $minutosInformados = ($exTotalHoras == 2) ? (int)$exTotalHoras[0] * 60 + (int)$exTotalHoras[1] : (int)$exTotalHoras[0] * 60;
        $minutosAgendados  = ($exTotalHorasDiasAgendados == 2) ? (int)$exTotalHorasDiasAgendados[0] * 60 + (int)$exTotalHorasDiasAgendados[1] : (int)$exTotalHorasDiasAgendados[0] * 60;
        
        return $minutosAgendados <= $minutosInformados;
    }
    
    public static function gerarCaminhoParaPDF($tipoContrato) 
    {
        $caminho_arq_pdf = "";
        $pasta_PF = DOMINIO . "/src/contrato-pdf/pf";
        $pasta_PJ = DOMINIO . "/src/contrato-pdf/pj";
        $pasta_TERMO = DOMINIO . "/src/contrato-pdf/termo";
        
        switch ($tipoContrato){
            
            case PF_GRUPO_ACIMA_DE_20_HORAS:
                
                $caminho_arq_pdf = $pasta_PF . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", TIPOS_DE_CONTRATOS[PF_GRUPO_ACIMA_DE_20_HORAS]) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;
            
            case PF_GRUPO_MENSAL:
                
                $caminho_arq_pdf = $pasta_PF . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", TIPOS_DE_CONTRATOS[PF_GRUPO_MENSAL]) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;
            
            case PF_INDIVIDUAL_ACIMA_DE_20_HORAS:
                
                $caminho_arq_pdf = $pasta_PF . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", TIPOS_DE_CONTRATOS[PF_INDIVIDUAL_ACIMA_DE_20_HORAS]) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;
            
            case PF_INDIVIDUAL_MENSAL:
                
                $caminho_arq_pdf = $pasta_PF . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", TIPOS_DE_CONTRATOS[PF_INDIVIDUAL_MENSAL]) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;
            
            case PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS:
                
                $caminho_arq_pdf = $pasta_TERMO . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", UtilCTRL::retornaPalavraSemAcento(TIPOS_DE_CONTRATOS[PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS])) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;

            case PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS:

                $caminho_arq_pdf = $pasta_TERMO . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", UtilCTRL::retornaPalavraSemAcento(TIPOS_DE_CONTRATOS[PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS])) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");

                break;
            
            case PJ_GRUPO_ACIMA_DE_20_HORAS:
                
                $caminho_arq_pdf = $pasta_PJ . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", self::retornaPalavraSemAcento(TIPOS_DE_CONTRATOS[PJ_GRUPO_ACIMA_DE_20_HORAS])) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;
            
            case PJ_GRUPO_MENSAL:
                
                $caminho_arq_pdf = $pasta_PJ . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", TIPOS_DE_CONTRATOS[PJ_GRUPO_MENSAL]) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                
                break;
            case PJ_INDIVIDUAL_ACIMA_DE_20_HORAS:
                
                $caminho_arq_pdf = $pasta_PJ . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", TIPOS_DE_CONTRATOS[PJ_INDIVIDUAL_ACIMA_DE_20_HORAS]) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;
            
            case PJ_INDIVIDUAL_MENSAL:
                
                $caminho_arq_pdf = $pasta_PJ . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", TIPOS_DE_CONTRATOS[PJ_INDIVIDUAL_MENSAL]) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;
            
            case PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS:
                
                $caminho_arq_pdf = $pasta_TERMO . DIRECTORY_SEPARATOR . strtolower(str_replace(" ", "-", self::retornaPalavraSemAcento(TIPOS_DE_CONTRATOS[PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS])) . ".php?tipo-contrato={$tipoContrato}&id-contrato=");
                
                break;
        }
        
        return $caminho_arq_pdf;
        
    }
    
    public static function retornaDataPorExtenso($data) 
    {
       self::fusoBR();
       self::config_locale_BR();

       $mes = ucfirst(strftime("%B", strtotime($data)));

       return strftime("Londrina, %d de " . $mes . " de %Y", strtotime($data));
    }
    
    public static function formatarHoras($hora)
    {
        return substr($hora, 0, 5);
    }

    public static function formatarHorasEmDecimais($hora)
    {
        $hora_min = self::formatarHoras($hora);

        $ex = explode(":", $hora_min);

        if($ex[1] == "00"){
            return $ex[0];
        }else{
            return rtrim(self::formatoMoedaBRSemSifrao((int)$ex[0] + (int)$ex[1] / 60), "0");
        }

    }
    
    public static function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {
 
        $singular = null;
        $plural = null;
 
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
 
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezessete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
 
 
        if ( $bolPalavraFeminina )
        {
        
            if ($valor == 1) 
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else 
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            
            
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
            
            
        }
 
 
        $z = 0;
 
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
 
        for ( $i = 0; $i < count( $inteiro ); $i++ ) 
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }
 
        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
                
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
                
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
 
        $rt = mb_substr( $rt, 1 );
 
        return($rt ? trim( $rt ) : "zero");
 
    }
    
    public static function retornaPalavraSemAcento($palavara) 
    {
       return str_replace(COM_ACENTO, SEM_ACENTO, $palavara);  
    }
    
    public static function retornaAnoContrato($dataInicio, $dataFinal) 
    {
       $anoIni = date("Y", strtotime($dataInicio));
       $anoFim = date("Y", strtotime($dataFinal));
       
       return ($anoIni == $anoFim) ? $anoIni : $anoIni . "/" . $anoFim;  
    }
    
    public static function retornaQtdeDatasAgendadasPorMes($agendamentos) 
    {
        
        $dias = [];
    
        for($i = 0; $i < count($agendamentos); $i++){
            $dias[$i+1] = date("m", strtotime($agendamentos[$i]["data_dia_semana"]));
        }


        return array_count_values($dias); 
    }
    
    public static function retornaTotalDiasAgendadosNoMes($agendamentos, $mes) :array
    {
        self::fusoBR();
        
        $meses = [];
        $datas = [];
        $idAgendamentos = [];
        
        
        
        foreach ($agendamentos as $data){
            
            if(date("m", strtotime($data["data_dia_semana"])) == $mes){
                
                $meses[date("d", strtotime($data["data_dia_semana"]))] = $mes;
                $datas[$data["id_agendamento"]] = $data["data_dia_semana"];
                $idAgendamentos[] = $data["id_agendamento"];
            }
        }
        
        return ["mes" => $meses, "data-completa" => $datas, "id-agendamento" => $idAgendamentos];
    }
    
    public static function retornaAnotacoesDaAula($anotacoesAulas , $idAgendamento) 
    {
        
        if(count($anotacoesAulas) > 0){
                
            foreach ($anotacoesAulas as $key => $value){

                if($value["id_agendamento"] == $idAgendamento){

                    return ["id_anotacao_aula" => $value["id_anotacao_aula"], "anotacoes_aula" => $value["anotacoes_aula"]];
                }
            }
        }
        
        return "";
        
    }
    
    public static function retornaDatasInformadasParaAlterar($datas) 
    {
        $dias = [];
        
        foreach ($datas as $key => $value){
            
            foreach ($value as $data){
                
                 $dias[] = $data; 
            }
        }
        
        return $dias;
    }


    public static function iniciar_sessao() {
        
        if (!isset($_SESSION)) {
            
            #header("Cache-Control: no cache");
            #session_cache_limiter("private_no_expire");
            
            return session_start();
        }
    }
    
    public static function criarSessaoDoUsuario($idUsuario, $tipoAcesso, $nome, $sobrenome) 
    {
        self::iniciar_sessao();
        
        $_SESSION["id-usuario"]  = $idUsuario;
        $_SESSION["tipo-acesso"] = $tipoAcesso;
        $_SESSION["nome"]        = $nome . " " . $sobrenome;
        
    }
    
    public static function validarSessao() 
    {
        self::iniciar_sessao();
        
        if(!isset($_SESSION["id-usuario"]) || !isset($_SESSION["tipo-acesso"]) || !isset($_SESSION["nome"])){
            
            header("LOCATION: " . PAGINA_DE_LOGIN);
            exit;
        }
    }
    
    public static function validarTipoDeAcessoADM() 
    {
        self::validarSessao();
        
        if($_SESSION["tipo-acesso"] != ADM){
            
            self::deslogarUsuario();
        }
    }

    public static function destruirSessaoDoUsuario()
    {
        self::iniciar_sessao();

        unset($_SESSION["id-usuario"]);
        unset($_SESSION["tipo-acesso"]);
        unset($_SESSION["nome"]);

    }
    
    public static function deslogarUsuario() 
    {
        self::destruirSessaoDoUsuario();
        
        header("LOCATION: " . PAGINA_DE_LOGIN);
        exit;
    }
    
    public static function idUserLogado() 
    {
        self::iniciar_sessao();
        
        return $_SESSION["id-usuario"];
    }
    
    public static function idiomaNoFeminino(string $nome_idioma) {
        
        $nome_idioma_sem_acento = strtolower(self::retornaPalavraSemAcento($nome_idioma));
        
        $idioma_no_feminino = '';
        
        switch ($nome_idioma_sem_acento) {
            case "ingles":
                $idioma_no_feminino = "inglesa";
                break;
            case "portugues":
                $idioma_no_feminino = "portuguesa";
                break;
            case "frances":
                $idioma_no_feminino = "francesa";
                break;
            case "espanhol":
                $idioma_no_feminino = "espanhola";
                break;
            case "alemao":
                $idioma_no_feminino = "alemã";
                break;
            case "italiano":
                $idioma_no_feminino = "italiana";
                break;

        }
        
        return $idioma_no_feminino;
    }
    
    public static function arredondarHoras($total_horas) {
        
        $ex = explode(".", $total_horas);
        
        if($ex[1] == "00"){
            return $ex[0];
        }else{
            return str_replace(".", ",", $total_horas);
        }
    }
    
    public static function qtdeDiasEntreDataInicioEDataFinal($data_inicio, $data_final) {
        
        $dt_ini = new DateTime($data_inicio);
        $dt_fim = new DateTime($data_final);
        
        $dias = $dt_fim->diff($dt_ini);
        
        return $dias->days + 1;
    }
}