<?php


namespace Src\log;


use Monolog\Formatter\HtmlFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TelegramBotHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use MonologPHPMailer\PHPMailerHandler;
use Monolog\Formatter\LineFormatter;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;
use Src\config\Environment;
use Src\traits\UtilCTRL;

class Log
{

    /**
     * Contante do valor padrão de email que envia os logs
     * @var string
     */
    private const FROM_EMAIL = "log.projetos.web@gmail.com";

    /**
     * Contante do valor padrão do nome que envia os logs
     * @var string
     */
    private const FROM_NAME = "SISTEMA TOP COURSES";

    /**
     * Contante do valor do assunto do email
     * @var string
     */
    private const SUBJECT = "ALERTA DE ERRO - SISTEMA TOP COURSES";

    /**
     * Constante do valor padrão do nome do canal do monolog
     * @var string
     */
    private const CANAL_MONOLOG = "WEB";


    /** @var Logger  */
    private Logger $log;

    /** @var PHPMailer  */
    private PHPMailer $email;

    /**
     * Guarda a mensagem de log informada  no construtor da classe
     * @var string
     */
    private string $mensagem;

    /** @var PHPMailerException */
    private PHPMailerException $erro;

    public function __construct(string $mensagem = "")
    {
        $this->mensagem = $mensagem;
    }

    public function enviarLogDeErro(\Exception $exception, string $canal = self::CANAL_MONOLOG, string $subject = self::SUBJECT, string $from_email =  self::FROM_EMAIL, string $from_name = self::FROM_NAME)
    {

        UtilCTRL::fusoBR();
        Environment::adicionarNovasVariaveisDeAmbiente();

        $this->email = new PHPMailer(true);
        $this->log   = new Logger($canal);

        try {

            //$this->email->SMTPDebug = 1;
            $this->email->isSMTP();
            $this->email->SMTPAuth   = true;
            $this->email->setLanguage("br");
            $this->email->CharSet    = getenv("SMTP_CHARSET");
            $this->email->Host       = getenv("SMTP_HOST");
            $this->email->Username   = getenv("SMTP_USER");
            $this->email->Password   = getenv("SMTP_PASSWORD");
            $this->email->SMTPSecure = getenv("SMTP_SECURE");
            $this->email->Subject    = $subject;
            $this->email->setFrom(getenv("SMTP_USER"), getenv("SMTP_PROJETO"));       #QUEM ENVIA O EMAIL
            $this->email->addAddress($from_email, getenv("SMTP_NAME_DESENVOLVEDOR")); #QUEM RECEBE O EMAIL

            
            $this->log->pushProcessor(new IntrospectionProcessor);
            $this->log->pushProcessor(new MemoryUsageProcessor);
            $this->log->pushProcessor(new WebProcessor);
            $this->log->pushHandler(new StreamHandler(PATH_FILE_LOG, Logger::ALERT));

            $telegram = new TelegramBotHandler(getenv("TOKEN_API_TELEGRAM"), getenv("CHANNEL_API_TELEGRAM"), Logger::ALERT);
            $telegram->setFormatter(new LineFormatter("[%datetime%] \n%level_name%: %message%", "d/m/Y - H:i:s"));
            $this->log->pushHandler($telegram);

            $this->log->pushProcessor(function ($record){

                $record["extra"]["USER_AGENTE"] = $_SERVER["HTTP_USER_AGENT"];

                return $record;
            });

            $handler = new PHPMailerHandler($this->email);
            $handler->setFormatter(new HtmlFormatter);
            $this->log->pushHandler($handler);
            
            $pilha_de_metodos = [];

            for($i = 0; $i < count($exception->getTrace()); $i++){

                $pilha_de_metodos[$i]["ARQUIVO"] = $exception->getTrace()[$i]["file"];
                $pilha_de_metodos[$i]["CLASSE"]  = $exception->getTrace()[$i]["class"];
                $pilha_de_metodos[$i]["FUNÇÃO"]  = $exception->getTrace()[$i]["function"];
                $pilha_de_metodos[$i]["LINHA"]   = $exception->getTrace()[$i]["line"];
            }

            $this->log->alert($this->mensagem,[
                "Data/Hora"         => date("d/m/Y H:i:s"),
                "Classe de exceção" => $exception::class,
                "Classe"            => $exception->getTrace()[0]["class"],
                "Método"            => $exception->getTrace()[0]["function"],
                "Arquivo"           => $exception->getFile(),
                "Linha do erro"     => $exception->getLine(),
                "getMessage()"      => $exception->getMessage(),
                "Pilha de chamadas" => $pilha_de_metodos
            ]);


        }catch (\Exception $e){
            
            echo CAMINHO_BASE; exit;
            
            $this->erro = $e;
        }
    }

    public function getErro(): ?PHPMailerException
    {
        return $this->erro;
    }


}