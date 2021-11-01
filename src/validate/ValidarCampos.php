<?php

namespace Src\validate;

use Src\models\EnderecoModel;
use Src\models\InteressadoModel;
use Src\models\ColaboradorModel;
use Src\models\CadastroBasicoModel;
use Src\models\EmpresaModel;
use Src\models\TurmaModel;
use Src\models\HoraAulaModel;
use Src\models\ContratoRevisaoTraducaoModel;
use Src\models\ContratoCursoModel;
use Src\models\DarBaixaEmParcelaModel;
use Src\models\PautaAlunoModel;
use Src\models\AnotacaoAulaModel;
use Src\models\ConfiguracaoEmpresaModel;
use Src\traits\UtilCTRL;
use Src\erro\Erro;

class ValidarCampos
{

    public static function validarCamposCadastroBasico(CadastroBasicoModel $cadBasico, bool $validarId = true): bool|int
    {

        if ($validarId) {

            if (empty($cadBasico->getIdCadastroBasicoAlterar())) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Id capturado não é válido");

                return -1;
            }
        }

        if (empty($cadBasico->getNomeCadastro())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . " Campo nome não pode ser vazio vazio");

            return 0;
        }

        if ($validarId == false) {

            if (empty($cadBasico->getTipoCadastro())) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . " Problema ao capturar o id do tipo de cadastro. Id vazio");

                return -1;
            } else {

                if ($cadBasico->getTipoCadastro() < 1 || $cadBasico->getTipoCadastro() > 8) {

                    Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Id do tipo de cadastro não é válido");

                    return -1;
                }
            }

            if (empty($cadBasico->getIdUserLogado())) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Erro ao capturar o id do usuário logado");

                return -1;
            }


            if (is_numeric($retDataRegistro = UtilCTRL::validarDataRegistro($cadBasico->getDataRegistro()))) {

                return $retDataRegistro;
            }
        }

        return true;
    }

    public static function validarCamposInteressados(InteressadoModel $interessado, bool $validarId = true)
    {

        if ($validarId) {

            if (empty($interessado->getIdInteressado()) || $interessado->getIdInteressado() == null) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Erro ao capturar o id do interessado");

                return -1;
            }
        }

        if (empty($interessado->getNome())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo nome não pode ser vazio vazio");

            return 0;
        }

//        if (empty($interessado->getSobrenome())) {
//
//            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo sobrenome não pode ser vazio");
//
//            return 0;
//        }

        if (empty($interessado->getIdCurso()) && empty($interessado->getIdRevisao()) && empty($interessado->getIdTraducao())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Selecione no mínimo uma opção CURSO, TRADUÇÃO ou REVISÃO");

            return 0;
        }

        if (!(strlen($interessado->getTelefone()) >= 10 && strlen($interessado->getTelefone()) <= 11)) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Preencha os campos DDD e telefone corretamente");

            return 0;
        }

//        if (empty($interessado->getEmail())) {
//
//            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo email não pode ser vazio");
//
//            return 0;
//        }
//
//        if (empty($interessado->getIdMidia())) {
//
//            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo mídia não pode ser vazio");
//
//            return 0;
//        }

        if (empty($interessado->getIdTipoContato())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo tipo de contato com a escola não pode ser vazio");

            return 0;
        }

        if (empty($interessado->getIdColaborador())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo atendente não pode ser vazio");

            return 0;
        }

        if (!empty($interessado->getCpf()) && strlen($interessado->getCpf()) != 11) {

            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Campo CPF não está preenchido corretamente");

            return -1;
        }

        if (!empty($interessado->getDataNascimento())) {

            if (is_numeric($retDataNascimento = UtilCTRL::validarDataNascimento($interessado->getDataNascimento()))) {

                return $retDataNascimento;
            }
        }

        if ($validarId == false && !empty($interessado->getDataAgendamento())) {

            if (is_numeric($ret = UtilCTRL::validarData($interessado->getDataAgendamento()))) {

                return $ret;
            }
        }

        if ($validarId == false) {

            if (empty($interessado->getIdUserLogado())) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Erro ao capturar id usuário logado");

                return -1;
            }

            if (is_numeric($retDataRegistro = UtilCTRL::validarDataRegistro($interessado->getDataRegistro()))) {

                return $retDataRegistro;
            }
        }

        return true;
    }

    public static function validarCamposFiltrosConsultaInteressado($data_inicio, $data_final): bool|int
    {

        if (is_numeric($ret = UtilCTRL::validarDataInicioEdataFinal("Data início", "data final", $data_inicio, $data_final))) {

            return $ret;
        }

        return true;
    }


    public static function validarCamposColaboradores(ColaboradorModel $colaborador, bool $validarId = true): bool|int
    {

        if ($validarId) {

            if (empty($colaborador->getIdColaborador())) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Id do colaborador não é válido");

                return -1;
            }
        }

        if (empty($colaborador->getTipoColaborador())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo tipo de colaborador não pode ser vazio");

            return 0;
        }

        if (empty($colaborador->getTipoAcesso())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo tipo de acesso não pode ser vazio");

            return 0;
        }

        if (empty($colaborador->getNome())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo nome não pode ser vazio");

            return 0;
        }

        if (empty($colaborador->getSobrenome())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo sobrenome não pode ser vazio");

            return 0;
        }

        if (empty($colaborador->getEmail())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo email não pode ser vazio");

            return 0;
        }

        if (empty($colaborador->getTelefone())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". O Campo telefone não pode ser vazio");

            return 0;
        } else {

            if (!(strlen($colaborador->getTelefone()) >= 10 && strlen($colaborador->getTelefone()) <= 11)) {

                Erro::setErro("Os campos DDD e Telefone precisam ser preenchidos corretamente");

                return 0;
            }
        }

        if ($validarId == false) {

            if (empty($colaborador->getIdUserLogado())) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Id do usuário logado não é válido");

                return -1;
            }

            if (is_numeric($ret = UtilCTRL::validarDataRegistro($colaborador->getDataRegistro()))) {

                return $ret;
            }
        }

        return true;
    }

    public static function validarCamposEndereco(EnderecoModel $endereco): bool|int
    {
        

        $i = 0;

        if (!empty($endereco->getCep())) {

            if (strlen(UtilCTRL::retiraMascara($endereco->getCep())) != 8) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". O campo CEP é inválido");

                return -1;
            }

            $i++;
        }

        if (!empty($endereco->getRua())) {

            $i++;
        }

        if (!empty($endereco->getNumero())) {

            $i++;
        }

        if (!empty($endereco->getBairro())) {

            $i++;
        }

        if (!empty($endereco->getCidade())) {

            $i++;
        }

        if (!empty($endereco->getUf())) {

            if (strlen($endereco->getUf()) != 2) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". O campo UF é inválido");

                return -1;
            }

            $i++;
        }

        $inserir = false;

        if ($i >= 0 && $i <= 6) {

            $inserir = true;
        }
        
        $existe_id = empty($endereco->getIdEndereco()) ? false : true;

        if ($inserir && $existe_id == false) {


            if (empty($endereco->getIdUserLogado()) || $endereco->getIdUserLogado() === null) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Id do usuário logado não é válido");

                return -1;
            }

            if (is_numeric($retDataRegistro = UtilCTRL::validarDataRegistro($endereco->getDataRegistro()))) {

                return $retDataRegistro;
            }
        }

        return (!empty($endereco->getIdEndereco())) ? true : $inserir;
    }


    public static function validarCamposEmpresa(EmpresaModel $empresa, bool $validarId = true): bool|int
    {

        if ($validarId && empty($empresa->getIdEmpresa())) {

            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id da empresa");

            return -1;
        }

        if ($validarId && empty($empresa->getEndereco()->getIdEndereco())) {

            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do endereço");

            return -1;
        }

        if (empty($empresa->getRazaoSocial())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo razão social não pode ser vazio");

            return 0;
        }

        if (empty($empresa->getCnpj())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo CNPJ não pode ser vazio");

            return 0;
        }

        if (empty($empresa->getEmail())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo email não pode ser vazio");

            return 0;
        }

        if (empty($empresa->getTelefone())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Os Campos DDD e telefone não podem ser vazios");

            return 0;
        } else {

            if (!(strlen($empresa->getTelefone()) >= 10 && strlen($empresa->getTelefone()) <= 11)) {

                Erro::setErro("Os campos DDD e Telefone precisam ser preenchidos corretamente");

                return 0;
            }
        }

        if (!empty($empresa->getTelefoneOpcional())) {

            if (!(strlen($empresa->getTelefoneOpcional()) >= 10 && strlen($empresa->getTelefoneOpcional()) <= 11)) {

                Erro::setErro("Os campos DDD e TelefoneOpcional precisam ser preenchidos corretamente");

                return 0;
            }
        }

        if (empty($empresa->getEndereco()->getCep())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo CEP não pode ser vazio");

            return 0;
        }

        if (empty($empresa->getEndereco()->getRua())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo rua não pode ser vazio");

            return 0;
        }

        if (empty($empresa->getEndereco()->getNumero())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo número não pode ser vazio");

            return 0;
        }

        if (empty($empresa->getEndereco()->getBairro())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo bairro não pode ser vazio");

            return 0;
        }

        if (empty($empresa->getEndereco()->getCidade())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo cidade não pode ser vazio");

            return 0;
        }

        if (empty($empresa->getEndereco()->getUf())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo UF não pode ser vazio");

            return 0;
        } else {

            if (strlen($empresa->getEndereco()->getUf()) != 2) {

                Erro::setErro("Campo UF não está preenchido corretamente");

                return 0;
            }
        }

        if ($validarId == false) {

            if (empty($empresa->getIdUserLogado())) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Id do usuário logado é invalido");

                return -1;
            }

            if (is_numeric($ret = UtilCTRL::validarDataRegistro($empresa->getDataRegistro()))) {

                return $ret;
            }
        }

        return true;
    }

    public static function validarCamposTurma(TurmaModel $turma, $validarId = true)
    {
        if ($validarId && empty($turma->getIdTurma())) {

            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id da turma");

            return -1;
        }

        if (empty($turma->getNomeTurma())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo nome da turma não pode ser vazio");

            return 0;
        }

        if (empty($turma->getIdColaborador())) {

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo professor não pode ser vazio");

            return 0;
        }

        if ($validarId == false) {

            if (empty($turma->getIdUserLogado())) {

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do usuário logado");

                return -1;
            }

            if (is_numeric($ret = UtilCTRL::validarDataRegistro($turma->getDataRegistro()))) {

                return $ret;
            }
        }

        return true;
    }
    
    public static function validarCamposHoraAula(HoraAulaModel $horaAula, $validarId = true) 
    {
        if($validarId && empty($horaAula->getIdHoraAula())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id da hora aula");

            return -1;
        }
        
        if(empty($horaAula->getIdIdioma())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo idioma não pode ser vazio");

            return 0;
        }
        
        if(empty($horaAula->getValorHoraAula())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo valor hora/aula não pode ser vazio");

            return 0;
        }
        
        if($validarId == false){
            
            if(empty($horaAula->getIdUserLogado())){
                
                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do usuário logado");

                return -1;
            }
            
            if(is_numeric($ret = UtilCTRL::validarDataRegistro($horaAula->getDataRegistro()))){
                
                return $ret;
            }
        }
        
        return true;
    }
    
    public static function validarCamposContratoRevTrad(ContratoRevisaoTraducaoModel $contratoRevTrad, bool $validarId = true) 
    {
        if($validarId){
            
            if(empty($contratoRevTrad->getIdContratoRevTrad())){

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do contrato");

                return -1;
            }
            
            if(empty($contratoRevTrad->getSituacao())){

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar a situação do contrato");

                return -1;  

            }
        
        }else{
            
            if(empty($contratoRevTrad->getCpfAluno())){

                Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo CPF não pode ser vazio");

                return 0;
                
            }else{
                
                if(strlen($contratoRevTrad->getCpfAluno()) != 11){
                    
                    Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". CPF informado é inválido");

                    return -1;
                }
            }

            if(empty($contratoRevTrad->getIdInteressado())){

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do interessado");

                return -1;
            }

            if(empty($contratoRevTrad->getDataRecebimentoMaterial())){

                Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo data de recebimento do material não pode ser vazio");

                return 0;

            }

            if(empty($contratoRevTrad->getDataPrazoEntrga())){

                Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo data do prazo de entrega não pode ser vazio");

                return 0;

            }
            
            if(!empty($contratoRevTrad->getDataRecebimentoMaterial()) && !empty($contratoRevTrad->getDataPrazoEntrga())){
                
                if(is_numeric($ret = UtilCTRL::validarDataInicioEdataFinal("Data de Recebimento do material", "data do prazo de entrega", $contratoRevTrad->getDataRecebimentoMaterial(), $contratoRevTrad->getDataPrazoEntrga()))){
                    
                    return $ret;
                }
                
            }

            if(empty($contratoRevTrad->getValorTotal())){

                Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo valor total não pode ser vazio");

                return 0;

            }else{
                
                if($contratoRevTrad->getValorTotal() == 0){
                    
                    Erro::setErro("Campo valor total é exigído um valor maior que 0,00");
                    
                    return -1;
                }
            }

            if(empty($contratoRevTrad->getQtdeParcelas())){

                Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo número de parcelas não pode ser vazio");

                return 0;

            }else{
                
                if($contratoRevTrad->getQtdeParcelas() == 0){
                    
                    Erro::setErro("Campo Número de parcela precisa ser informado no mínimo 1 parcela");
                    
                    return -1;
                }
            }

            if(empty($contratoRevTrad->getValorParcela())){

                Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo valor das parcelas não pode ser vazio");

                return 0;

            }else{
                
                if($contratoRevTrad->getValorParcela() == 0){
                    
                    Erro::setErro("Campo valor da parcela é exigído um valor maior que 0,00");
                    
                    return -1;
                }
            }

            if(empty($contratoRevTrad->getDiaVencimentoParcela())){

                Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo dia de vencimento das parcelas não pode ser vazio");

                return 0;

            }else{
                
                if(is_numeric($ret = UtilCTRL::validarDataInformadaEmaiorQueDataAtual("Dia de vencimento das parcelas", $contratoRevTrad->getDiaVencimentoParcela()))){
                    
                    return $ret;
                }
            }
            
            
            if(empty($contratoRevTrad->getIdUserLogado())){

                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do usuário logado");

                return -1;    
            }

            if(is_numeric($ret = UtilCTRL::validarDataRegistro($contratoRevTrad->getDataRegistro()))){

                return $ret;
            }
        }
        
        if(empty($contratoRevTrad->getIdTipoContrato())){

            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o tipo de contrato");

            return -1;
        }
        
        if($contratoRevTrad->getIdTipoContrato() == CONTRATO_TRADUCAO){
                
            if(empty($contratoRevTrad->getIdTradutor())){

                Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo tradutor não pode ser vazio");

                return 0;
            }
        }
        
        if(empty($contratoRevTrad->getIdRevisor())){

            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo revisor não pode ser vazio");

            return 0;
        }
            
        return true;
    }
    
    public static function validarCamposFiltroDarBaixaEmParcela($dataInicio, $dataFinal) 
    {
        if(is_numeric($ret = UtilCTRL::validarDataInicioEdataFinal("Data início", "data final", $dataInicio, $dataFinal))){
            
            return $ret;
        }
        
        return true;
    }
   
    public static function validarCamposRegistrarBaixaParcela(DarBaixaEmParcelaModel $darBaixaParcela) 
    {
        
        if(empty($darBaixaParcela->getIdInteressado())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do aluno");

            return -1;
        }
        
        if(empty($darBaixaParcela->getIdDarBaixaParcela())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id da parcela");

            return -1;
        }
        
        
        if(empty($darBaixaParcela->getValorParcelaPago())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo valor da parcela não pode se vazio");
            
            return 0;
        }
        
        if(empty($darBaixaParcela->getValorParcelaVindoDB())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO. ". Não foi possível capturar o valor da parcela");
            
            return -1;
        }
        
        if(empty($darBaixaParcela->getTipoPagamento())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo tipos de pagamentos não pode se vazio");
            
            return 0;
        }
        
        if($darBaixaParcela->getDataRegistroPagamento() != ""){
            
            if(is_numeric($ret = UtilCTRL::validarDataRegistro($darBaixaParcela->getDataRegistroPagamento()))){

                return $ret;
            }
        }
        
        return true;
    }
    
    public static function validarCamposContratoCurso(ContratoCursoModel $contratoCurso, bool $validarId = true) 
    {
       
        if($validarId && empty($contratoCurso->getIdContratoCurso())){
           
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do contrato curso");
            
            return -1;
        }
        
        if(!$validarId && count($contratoCurso->getIdAluno()) == 0){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id(s) do(s) aluno(s)");
            
            return -1;
        }
        
        if(!$validarId && count($contratoCurso->getCpf()) == 0){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o cpf do(s) aluno(s)");
            
            return -1;
        }
        
        if(empty($contratoCurso->getIdTipoContrato())){
           
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do tipo de contrato");
            
            return -1;
            
        }
        
        if(!$validarId && empty($contratoCurso->getIdCurso())){
           
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo curso não pode se vazio");
            
            return 0;
            
        }
        
        if(!$validarId && empty($contratoCurso->getValorHoraAula())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo valor da hora/aula não pode se vazio");
            
            return 0;
            
        }else if(!$validarId){
            
            if((float)$contratoCurso->getValorHoraAula() <= 0){
               
                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Campo valor da hora/aula precisa ser maior que 0,00");
            
                return -1;
            }
        }
        
        if(!$validarId && empty($contratoCurso->getTotalHoras())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo número total de horas não pode se vazio");
            
            return 0;
            
        }else if(!$validarId){
            
            if((int)$contratoCurso->getTotalHoras() <= 0){
                
                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Campo número total de horas precisa ser maior que 0");
            
                return -1;
            }
        }
        
        if(!$validarId && empty($contratoCurso->getValorTotal())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo valor total não pode se vazio");
            
            return 0;
        }else if(!$validarId){
            
            if((float)$contratoCurso->getValorTotal() <= 0){
                
                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Campo valor total precisa ser maior que 0");
            
                return -1;
            }
        }
        
        if(!$validarId && empty($contratoCurso->getLocalDasAulas())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo local das aulas ministradas não pode se vazio");
            
            return 0;
        }
        
        if(!$validarId && empty($contratoCurso->getQtdeParcelas())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo número de parcelas não pode se vazio");
            
            return 0;
        }else if(!$validarId){
            
            if((int)$contratoCurso->getQtdeParcelas() <= 0){
                
                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Campo número de parcelas precisa ser maior que 0");
            
                return -1;
            }
        }
        
        if(!$validarId && empty($contratoCurso->getValorParcela())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo valor da parcela não pode se vazio");
            
            return 0;
            
        }else if(!$validarId){
            
            if((float)$contratoCurso->getValorParcela() <= 0){
                
                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Campo valor da parcela precisa ser maior que 0,00");
            
                return -1;
                
            }
        }
        
        if(!$validarId && empty($contratoCurso->getDiaVencimentoParcela())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo dia de vencimento da parcela não pode se vazio");
            
            return 0;
        }
        
        if(empty($contratoCurso->getDataInicioContrato())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo data início do contrato não pode se vazio");
            
            return 0;
        }
        
        if(empty($contratoCurso->getDataTerminoContrato())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo data término do contrato não pode se vazio");
            
            return 0;
        }
        
        if(!empty($contratoCurso->getDataInicioContrato()) && !empty($contratoCurso->getDataTerminoContrato())){
            
            if(is_numeric($ret = UtilCTRL::validarDataInicioEdataFinal("Data inicio", "data final", $contratoCurso->getDataInicioContrato(), $contratoCurso->getDataTerminoContrato()))){
                
                return $ret;
            }
        }
        
        if(!$validarId && empty($contratoCurso->getNumeroMesesPorAno())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo número de meses por ano não pode se vazio");
            
            return 0;
            
        }
        
        if($contratoCurso->getIdTipoContrato() == PJ_GRUPO_ACIMA_DE_20_HORAS      ||
           $contratoCurso->getIdTipoContrato() == PJ_GRUPO_MENSAL                 ||
           $contratoCurso->getIdTipoContrato() == PJ_INDIVIDUAL_ACIMA_DE_20_HORAS ||
           $contratoCurso->getIdTipoContrato() == PJ_INDIVIDUAL_MENSAL            ||
           $contratoCurso->getIdTipoContrato() == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS)
        {
            if(empty($contratoCurso->getIdEmpresa())){
                
                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id da empresa");
            
                return -1;
            }
        }
        
        if(!$validarId && empty($contratoCurso->getCargaHorariaSemanal())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO . ". Campo carga horária não pode se vazio");
            
            return 0;
        }
        
        if(count($contratoCurso->getAgendamento()->getDiaDaSemana()) == 0){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Quadro agendamento das aulas, precisa no mínimo de uma opção selecionada");
            
            return -1;
            
        }else{
            
            $diasSemana = $contratoCurso->getAgendamento()->getDiaDaSemana();
            
            if(!in_array("a-combinar", $diasSemana)){
               
                $array_horaInicio = $contratoCurso->getAgendamento()->getHoraInicial();
                $array_horaFinal  = $contratoCurso->getAgendamento()->getHoraFinal();
                
                for($i = 0; $i < count($diasSemana); $i++){  

                    if(empty($array_horaInicio[$i]) || empty($array_horaFinal[$i])){
                        
                        Erro::setErro(ERRO_DURANTE_A_OPERCAO  . ". Campos hora início e hora final não podem ser vazio se selecionados");

                        return -1;
                    }
                }
                
            }
        }
        
        if($contratoCurso->getIdTipoContrato() == PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS||
           $contratoCurso->getIdTipoContrato() == PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS ||
           $contratoCurso->getIdTipoContrato() == PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS){
            
            if(strtotime($contratoCurso->getTotalHoras()) > strtotime("20:00")){
                
                Erro::setErro("O campo total de horas não pode ser superior a 20 horas");
            
                return -1;
            }
        }
        
        if($validarId == false){
            
            if(empty($contratoCurso->getIdUserLogado())){
               
                Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do usuário logado");
            
                return -1;
            }
            
            if(is_numeric($ret = UtilCTRL::validarDataRegistro($contratoCurso->getDataRegistro()))){
                
                return $ret;
            }
        }
               
        return true;
    }
    
    public static function validarCamposPautaAluno(PautaAlunoModel $pautaModel, bool $validarId = true) 
    {
        if($validarId && empty($pautaModel->getIdPautaAluno())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id da pauta do aluno");
            
            return -1;
        }
        
        if(empty($pautaModel->getIdAlununo())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do aluno");
            
            return -1;
        }
        
        if(empty($pautaModel->getIdContratoCurso())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do contrato");
            
            return -1;
        }
        
        if(strlen($pautaModel->getAnotacaoProfessor()) == 0){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar a anotação selecionada");
            
            return -1;
        }
        
        if(empty($pautaModel->getIdAgendamento())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do agendamento");
            
            return -1;
        }
        
        return true;
    }
    
    public static function validarCamposAnotacaoAula(AnotacaoAulaModel $anotacaoModel, bool $validarId = true) 
    {
        if($validarId && empty($anotacaoModel->getIdAnotacaoAula())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id da anotação da aula");
            
            return -1;
        }
        
        if(empty($anotacaoModel->getAnotacaoAula())){
            
            Erro::setErro("Não é possível salvar uma anotação vazia");
            
            return -1;
        }
        
        if($validarId == false && empty($anotacaoModel->getIdAgendamento())){
            
            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível capturar o id do agendamento");
            
            return -1;
        }
        
        return true;
    }
    
    public static function validarCamposRelatoriosContratos($dataInicio, $dataFinal) 
    {   
        return UtilCTRL::validarDataInicioEdataFinal("data início", "data final", $dataInicio, $dataFinal);
    }
    
    public static function validarCamposConfiguracaoEmpresa(ConfiguracaoEmpresaModel $configEmpresaModel)
    {
        if(empty($configEmpresaModel->getRazaoSocial())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo razão social não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getCnpj())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo CNPJ não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getEmail())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo email não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getTelefone())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo telefone não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getCep())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo CEP não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getRua())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo rua não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getNumero())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo número não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getBairro())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo bairro não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getCidade())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo cidade não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getEstado())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo estado não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getUf())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". campo UF não pode ser vazio");
            
            return 0;
        }
        
        if(empty($configEmpresaModel->getIdUserLogado())){
            
            Erro::setErro(ERRO_CAMPOS_OBRIGATORIOS_VAZIO .  ". ID do usuário logado inválido");
            
            return -1;
        }
        
        if(empty($configEmpresaModel->getDataRegistro())){
            
            Erro::setErro("Não foi possível capturar a data do cadastro");
            
            return 0;
            
        }else{
            
            if(is_numeric($ret = UtilCTRL::validarDataRegistro($configEmpresaModel->getDataRegistro()))){

                return $ret;
            }
        }
        
        return true;
    }
    
}
