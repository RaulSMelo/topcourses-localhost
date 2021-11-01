<?php


namespace Src\controllers;

use Src\erro\Erro;
use Src\dao\AlterarSenhaDao;
use Src\traits\UtilCTRL;

class AlterarSenhaController 
{
    
    public function buscarSenhaAtual($senhaAtual, $novaSenha, $confirmarSenha) 
    {
        if(!empty($senhaAtual)){
            
            if(!empty($novaSenha)){
                
                if(!empty($confirmarSenha)){
                    
                    $alterarSenhaDao =  new AlterarSenhaDao();
                    
                    $senhaHash = $alterarSenhaDao->buscarSenhaAtual(UtilCTRL::idUserLogado());
                    
                    if(UtilCTRL::validarSenhaLogin($senhaAtual, $senhaHash)){
                        
                        if(strlen($novaSenha) >= 4 || strlen($confirmarSenha) >= 4){
                            
                            if(strlen(trim($novaSenha)) == strlen(trim($confirmarSenha))){
                        
                            if(trim($novaSenha) == trim($confirmarSenha)){
                                
                                    $novaSenhaHash = password_hash(trim($novaSenha), PASSWORD_DEFAULT);

                                    return $alterarSenhaDao->alterarSenha($novaSenhaHash, UtilCTRL::idUserLogado());

                                }else{

                                    Erro::setErro("Campo nova senha é diferente do campo confirmar senha");

                                    return -1;
                                }

                            }else{

                                Erro::setErro("Campo nova senha é diferente do campo confirmar senha");

                                return -1;   
                            }
                            
                            
                        }else{
                            
                            Erro::setErro("Preencher no mínimo 4 (quatro) caracteres");

                            return -1;
                        }
                        
                    }else{
                        
                        Erro::setErro("Senha atual incorreta");

                        return -1;
                    }
                    
            
                }else{

                    Erro::setErro("Campo confirmar senha não pode ser vazio");

                    return 0;
                }
            
            }else{

                Erro::setErro("Campo nova senha não pode ser vazio");

                return 0;
            }
            
        }else{
            
            Erro::setErro("Campo senha atual não pode ser vazio");
            
            return 0;
        }
        
    }
}
