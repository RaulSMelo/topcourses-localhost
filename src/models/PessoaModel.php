<?php

namespace Src\models;

abstract class PessoaModel
{
    private $idPessoa;
    private $nome;
    private $sobrenome;
    private $email;
    private $telefone;
    private $cpf;
    private $dataRegistro;

    
    public function getIdPessoa() 
    {
        return $this->idPessoa;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function getSobrenome() 
    {
        return $this->sobrenome;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function getTelefone() 
    {
        return $this->telefone;
    }

    public function getCpf() 
    {
        return $this->cpf;
    }
    
    public function getDataRegistro() 
    {
        return $this->dataRegistro;
    }

    public function setIdPessoa($idPessoa): void 
    {
        $this->idPessoa = $idPessoa;
    }

    public function setNome($nome): void 
    {
        $this->nome = $nome;
    }

    public function setSobrenome($sobrenome): void 
    {
        $this->sobrenome = $sobrenome;
    }

    public function setEmail($email): void 
    {
        $this->email = $email;
    }

    public function setTelefone($telefone): void 
    {
        $this->telefone = $telefone;
    }

    public function setCpf($cpf): void 
    {
        $this->cpf = $cpf;
    }
    
    public function setDataRegistro($dataRegistro): void 
    {
        $this->dataRegistro = $dataRegistro;
    }


}
