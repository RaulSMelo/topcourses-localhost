<?php

/* Caminho do arquivo .env */

define("DOMINIO", "https://sistematopcourses.com.br");

define("CAMINHO_BASE", $_SERVER["DOCUMENT_ROOT"]); #/home/sistematopcourse/public_html

define("PATH_FILE_ENV", CAMINHO_BASE . "/.env");

define("PATH_FILE_LOG", CAMINHO_BASE . "/sistematopcourses.com.br/src/log/log.txt");

define("PAGINA_DE_ERRO", DOMINIO . "/src/views/erro/pagina_erro.php");

define("PAGINA_DE_LOGIN", "https://sistematopcourses.com.br/src/views/login/login.php");

define("ID_CONFIGURACAO_EMPRESA", 1);

/* Define as constantes dos tipo de cadastro básico */

define("CURSO", 1);
define("IDIOMA", 2);
define("MIDIA", 3);
define("NIVEL", 4);
define("RESULTADO", 5);
define("REVISAO", 6);
define("TIPO_CONTATO", 7);
define("TRADUCAO", 8);


/* Retorna o nome dos tipo de cadastro básico pelo ID */

define("NOME_TIPO_CADASTRO_BASICO", [
   CURSO        => "Curso", 
   IDIOMA       => "Idioma", 
   MIDIA        => "Mídia", 
   NIVEL        => "Nível", 
   RESULTADO    => "Resultado", 
   REVISAO      => "Revisão", 
   TIPO_CONTATO => "Tipo de contato", 
   TRADUCAO     => "Tradução", 
]);

/*CONTRATOS REVISÃO E TRADUÇÃO*/
define("CONTRATO_REVISAO", 1);
define("CONTRATO_TRADUCAO", 2);

/*CONTRATOS PF*/
define("PF_GRUPO_ACIMA_DE_20_HORAS", 3);
define("PF_GRUPO_MENSAL", 4);
define("PF_INDIVIDUAL_ACIMA_DE_20_HORAS", 5);
define("PF_INDIVIDUAL_MENSAL", 6);

/*TERMO DE COMPROMISSO*/
define("PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS", 7);
define("PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS", 8);

/*CONTRATOS PJ*/
define("PJ_GRUPO_ACIMA_DE_20_HORAS", 9);
define("PJ_GRUPO_MENSAL", 10);
define("PJ_INDIVIDUAL_ACIMA_DE_20_HORAS", 11);
define("PJ_INDIVIDUAL_MENSAL", 12);
define("PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS", 13);

define("TIPOS_DE_CONTRATOS", [
    
    CONTRATO_REVISAO                                => "Revisão",
    CONTRATO_TRADUCAO                               => "Tradução",
    PF_GRUPO_ACIMA_DE_20_HORAS                      => "PF grupo acima de 20 horas",
    PF_GRUPO_MENSAL                                 => "PF grupo mensal",
    PF_INDIVIDUAL_ACIMA_DE_20_HORAS                 => "PF individual acima de 20 horas",
    PF_INDIVIDUAL_MENSAL                            => "PF individual mensal",
    PF_TERMO_DE_COMPROMISSO_INDIVIDUAL_ATE_20_HORAS => "Termo de compromisso até 20 horas PF e PJ",
    PF_TERMO_DE_COMPROMISSO_GRUPO_ATE_20_HORAS      => "Termo de compromisso até 20 horas grupo PF",
    PJ_GRUPO_ACIMA_DE_20_HORAS                      => "PJ grupo acima de 20 horas",
    PJ_GRUPO_MENSAL                                 => "PJ grupo mensal",
    PJ_INDIVIDUAL_ACIMA_DE_20_HORAS                 => "PJ individual acima de 20 horas",
    PJ_INDIVIDUAL_MENSAL                            => "PJ individual mensal",
    PJ_TERMO_DE_COMPROMISSO_ATE_20_HORAS            => "Termo de compromisso até 20 horas PF e PJ"
]);

/* Tipos de colaboradores */

define("ADMINISTRADOR", 1);
define("ATENDENTE", 2);
define("PROFESSOR", 3);
define("REVISOR", 4);
define("SECRETARIA", 5);
define("TRADUTOR", 6);

/* Tipo de endereco*/

define("INTERESSADO", 1);
define("COLABORADOR", 2);
define("EMPRESA", 3);

/*  Tipos de acesso de colaboradoes */

define("ADM", 1);
define("PROF", 2);

/* Situação do contrato */
define("CANCELADO", 0);
define("CONCLUIDO", 1);
define("EM_ANDAMENTO", 2);

define("SITUACAO_CONTRATO", [
    
    CANCELADO    => "Cancelado",
    CONCLUIDO    => "Concluído",
    EM_ANDAMENTO => "Em andamento"
    
]);

/* Situação de pagamentos */

define("ATRASADO", 1);
define("EM_ABERTO", 2);
define("PAGO", 3);

define("SITUACAO_PAGAMENTO", [
    
    CANCELADO => "Cancelado",
    ATRASADO  => "Atrasado",
    EM_ABERTO => "Em aberto",
    PAGO      => "Pago"
]);

/* Tipo de pagamento */

define("BIT_COINS", 1);
define("BOLETO_BANCARIO", 2);
define("CARTAO_DE_CREDITO", 3);
define("CARTAO_DE_DEBITO", 4);
define("CHEQUE", 5);
define("DINHEIRO", 6);
define("DEPOSITO", 7);
define("PIX", 8);
define("TRANFERENCIA", 9);

define("TIPOS_DE_PAGAMENTOS", [
    
    BIT_COINS         => "BIT COINS",
    BOLETO_BANCARIO   => "BOLETO BANCÁRIO",
    CARTAO_DE_CREDITO => "CARTÃO DE CRÉDITO",
    CARTAO_DE_DEBITO  => "CARTÃO DE DÉBITO",
    CHEQUE            => "CHEQUE",
    DINHEIRO          => "DINHEIRO",
    DEPOSITO          => "DEPÓSITO",
    PIX               => "PIX",
    TRANFERENCIA      => "TRANSFERÊNCIA"
    
]);

/* Anotações do professor na pauta do aluno*/

define("ANOTACOES_DO_PROFESSOR", [ ["cor" => "bg-danger", "letra" => "A"], ["cor" => "bg-orange", "letra" => "H"], ["cor" => "bg-success", "letra" => "OK"], ["cor" => "bg-warning", "letra" => "R"], ["cor" => "bg-info", "letra" => "VT"], ["cor" => "bg-apagar-anotacao", "letra" => "<i class='fas fa-chevron-down'></i>"]]);


/* Mensagens de erro padrão */

define("ERRO_DURANTE_A_OPERCAO", "Ocorreu um erro durante a operação");
define("ERRO_CAMPOS_OBRIGATORIOS_VAZIO", "Por favor, preencher todos os campos obrigatórios");
define("OPERACAO_REALIZADA_COM_SUCESSO", "Operação realizada com sucesso");

/* Situacao do colaborador */

define("INATIVO", 0);
define("ATIVO", 1);

define("DIAS_DA_SEMANA", ["domingos", "segundas-feiras", "terças-feiras", "quartas-feiras", "quintas-feiras", "sextas-feiras", "sábados"]);

define("COM_ACENTO", ['à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú']);

define("SEM_ACENTO", ['a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U']);

define("NOME_DOS_MESES_DO_ANO",["01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December"]);


define("NOME_DO_ESTADO_PELA_SIGLA", [
    "AC" => "Acre",
    "AL" => "Alagoas",
    "AP" => "Amapá",
    "AM" => "Amazonas",
    "BA" => "Bahia",
    "CE" => "Ceará",
    "ES" => "Espírito Santo",
    "GO" => "Goiás",
    "MA" => "Maranhão",
    "MT" => "Mato Grosso",
    "MS" => "Mato Grosso do Sul",
    "MG" => "Minas Gerais",
    "PA" => "Pará",
    "PB" => "Paraíba",
    "PR" => "Paraná",
    "PE" => "Pernambuco",
    "PI" => "Piauí",
    "RJ" => "Rio de Janeiro",
    "RN" => "Rio Grande do Norte",
    "RS" => "Rio Grande do Sul",
    "RO" => "Rondônia",
    "RR" => "Roraima",
    "SP" => "São Paulo",
    "SC" => "Santa Catarina",
    "SE" => "Sergipe",
    "TO" => "Tocantins",
    "DF" => "Distrito Federal"]);
