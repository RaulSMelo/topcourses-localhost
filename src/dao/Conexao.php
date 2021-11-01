<?php

namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\config\Environment;


class Conexao
{
    
    private static string $driver;
    private static string $database;
    private static string $db_charset;
    private static string $host;
    private static string $user;
    private static string $password;
    private static $connection;
    private static PDO $pdo;
    
    private function __construct(\PDO $pdo = null)
    {
        self::$pdo = $pdo;
    }
    
    private function __clone() {}
    
    private static function definirVariaveisConfigDSN() 
    {
        Environment::adicionarNovasVariaveisDeAmbiente();

        self::$driver     = getenv("DB_DRIVER");
        self::$database   = getenv("DB_NAME");
        self::$db_charset = getenv("DB_CHARSET");
        self::$host       = getenv("DB_HOST");
        self::$user       = getenv("DB_USER");
        self::$password   = getenv("DB_PASSWORD");

    }
    
    private static function getAttributesPDO()
    {  
        return [
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => true
            ],
        ];
    }

    private static function getDNS() 
    {
        self::definirVariaveisConfigDSN();
        
        return self::$driver . ":host=" . self::$host . ";dbname=" . self::$database . ";" . "charset=" . self::$db_charset;
        
    }


    private static function getInstance(): ?self
    {
        try {
            
            if(self::$connection == null){

                self::$connection = new self(new PDO(self::getDNS(), self::$user, self::$password, self::getAttributesPDO()));
                
            }
            
            return self::$connection;
            
        } catch (\PDOException $e) {

            (new Log("ERRO de conexão com banco de dados"))->enviarLogDeErro($e);
            
            header("LOCATION: " . PAGINA_DE_ERRO);
            
            exit;
        }
    }

    public static function obterConexao(): ?\PDO 
    {
        self::getInstance();
        
        return self::$pdo;
    }
    
    
}
