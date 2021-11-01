<?php


namespace Src\config;


class Environment
{

    private function __construct(){}

    private function __clone(){}

    /**
     * Função que configura novas variáveis de ambiente do arquivo (.env)
     *
     * @return bool
     */
    public static function adicionarNovasVariaveisDeAmbiente(): bool
    {
        if(!file_exists(PATH_FILE_ENV)){
            return false;
        }

        $lines = file(PATH_FILE_ENV);

        foreach($lines as $line){
            putenv(trim($line));
        }

        return true;
    }
}