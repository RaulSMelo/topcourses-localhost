<?php


namespace Src\models;

use Src\models\PessoaModel;
use Src\traits\UtilCTRL;
use Src\input\Input;

class ColaboradorModel extends PessoaModel
{
    private $idColaborador;
    private array $tipoColaborador;
    private $tipoAcesso;
    private $telefoneOpcional;
    private $login;
    private $senha;
    private $idUserLogado;
    private $situacao;
    
    public function __construct() 
    {
        $this->getColaboradorModel();
    }
    
    
    public function getTipoColaborador():array 
    {
        return $this->tipoColaborador;
    }

    public function setTipoColaborador(array $tipoColaborador): void 
    {
        $this->tipoColaborador = $tipoColaborador;
    }

        
    public function getIdColaborador() 
    {
        return $this->idColaborador;
    }

    public function getTipoAcesso() 
    {
        return $this->tipoAcesso;
    }

    public function getTelefoneOpcional() 
    {
        return $this->telefoneOpcional;
    }

    public function getLogin() 
    {
        return $this->login;
    }

    public function getSenha() 
    {
        return $this->senha;
    }

    public function getIdUserLogado() 
    {
        return $this->idUserLogado;
    }
    
    public function getSituacao() 
    {
        return $this->situacao;
    }

    public function setIdColaborador($idColaborador): void 
    {
        $this->idColaborador = $idColaborador;
    }

    public function setTipoAcesso($tipoAcesso): void 
    {
        $this->tipoAcesso = $tipoAcesso;
    }

    public function setTelefoneOpcional($telefoneOpcional): void 
    {
        $this->telefoneOpcional = $telefoneOpcional;
    }

    public function setLogin($login): void 
    {
        $this->login = $login;
    }

    public function setSenha($senha): void 
    {
        $this->senha = $senha;
    }

    public function setIdUserLogado($idUserLogado): void 
    {
        $this->idUserLogado = $idUserLogado;
    }
    

    public function setSituacao($situacao): void 
    {
        $this->situacao = $situacao;
    }

    
    
    private function getColaboradorModel() {
        
        $obj = $this->getInputColaborador();

        $this->setIdColaborador($obj->idColaborador);
        $this->setTipoColaborador($obj->opcoesTiposColaboradores ?? []);
        $this->setTipoAcesso($obj->tipoAcesso);
        $this->setNome(trim($obj->nome));
        $this->setSobrenome(trim($obj->sobrenome));
        $this->setEmail(trim($obj->email));
        $this->setTelefone(trim($obj->ddd) . UtilCTRL::retiraMascara(trim($obj->telefone)));
        $this->setTelefoneOpcional(trim($obj->dddTelefoneOpcional) . UtilCTRL::retiraMascara(trim($obj->telefoneOpcional)));
        $this->setCpf(UtilCTRL::retiraMascara(trim($obj->cpf))); 
        $this->setLogin(trim($obj->email));
        $this->setSenha(UtilCTRL::senhaHash(trim($obj->nome) . " " . trim($obj->sobrenome)));
        $this->setIdUserLogado($obj->idUserLogado);
        $this->setDataRegistro(trim($obj->dataRegistro));
        $this->setSituacao($obj->situacao);

        return $this;
        
    }

    
    private function getInputColaborador() 
    {
        return(object)[
            
            "idColaborador"            => Input::post("id-colaborador", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "opcoesTiposColaboradores" => $_POST["opcoes-tipos-colaboradores"] ?? null,
            "tipoAcesso"               => Input::post("tipo-acesso", FILTER_SANITIZE_NUMBER_INT) ?? null,
            "dataRegistro"             => UtilCTRL::dataAtual() ?? null,
            "nome"                     => Input::post("nome") ?? null,
            "sobrenome"                => Input::post("sobrenome") ?? null,
            "email"                    => Input::post("email", FILTER_VALIDATE_EMAIL) ?? null,
            "ddd"                      => Input::post("ddd") ?? null,
            "telefone"                 => Input::post("telefone") ?? null,
            "dddTelefoneOpcional"      => Input::post("ddd-telefone-opcional") ?? null,
            "telefoneOpcional"         => Input::post("telefone-opcional") ?? null,
            "cpf"                      => Input::post("cpf") ?? null,
            "idUserLogado"             => UtilCTRL::idUserLogado(),
            "situacao"                 => ATIVO,
        ];
    }


}
