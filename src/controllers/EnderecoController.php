<?php

namespace Src\controllers;

use Src\models\EnderecoModel;
use Src\validate\ValidarCampos;

class EnderecoController
{

    public function getEnderecoController()
    {    
        
        $endereco = new EnderecoModel();

        $validarEndereco = ValidarCampos::validarCamposEndereco($endereco);

        if ($validarEndereco) {
  
            return $endereco;
                    
        } else {
            
            return $validarEndereco;
        }
    }
}
