<?php


namespace Src\controllers;

use Src\dao\LoginDao;
use Src\erro\Erro;
use Src\traits\UtilCTRL;

class LoginController 
{
    public function validarLogin($login, $senha) 
    {
        if(!empty(trim($login))){
            
            if(!empty(trim($senha))){
                
                $dao = new LoginDao();
        
                $dadosLogin = $dao->validarLogin($login);

                if (count($dadosLogin) == 1) {

                    if (UtilCTRL::validarSenhaLogin($senha, $dadosLogin[0]["senha"])) {

                        UtilCTRL::criarSessaoDoUsuario($dadosLogin[0]["id_colaborador"], $dadosLogin[0]["tipo_acesso"], $dadosLogin[0]["nome"], $dadosLogin[0]["sobrenome"]);
                        
                        if ($dadosLogin[0]["tipo_acesso"] == ADM) {

                            header("LOCATION: " . DOMINIO . "/src/views/interessados/cadastrar_interessados.php");
                            exit;

                        } else if ($dadosLogin[0]["tipo_acesso"] == PROF) {

                            header("LOCATION: " . DOMINIO . "/src/views/pautas/consultar_pauta.php");
                            exit;
                        }

                    } else {

                        Erro::setErro("Usuário e/ou senha inválidos");

                        return -1;
                    }

                } else {

                    Erro::setErro("Usuário e/ou senha inválidos");

                    return -1;
                }
            }else{
                
                Erro::setErro("O campo senha não pode ser vazio");

                return 0;
            }
            
        }else{
            
            Erro::setErro("O campo usuário não pode ser vazio");

            return 0;
        }        
    }
}
