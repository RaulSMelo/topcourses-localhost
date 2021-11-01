<?php

namespace Src\erro;

class Erro {
    
    private static array $erro = [];
    
    public static function getErro(): array 
    {
        return self::$erro;
    }

    public static function setErro($erro): void 
    {
        array_push(self::$erro, $erro);
    }

}
    
