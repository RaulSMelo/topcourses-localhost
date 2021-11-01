<?php


namespace Src\controllers;

use Src\dao\ColaboradorDao;
use Src\erro\Erro;
use Src\models\ColaboradorModel;
use Src\validate\ValidarCampos;

class ColaboradorController
{
    private ColaboradorDao $dao;
    private EnderecoController $endereco;
    private ColaboradorModel $colaborador;

    public function __construct()
    {
        $this->dao         = new ColaboradorDao();
        $this->endereco    = new EnderecoController();
    }


    public function inserirColaborador()
    {
        $colaboradorModel = new ColaboradorModel();
        
        $validarCamposColaborador = ValidarCampos::validarCamposColaboradores($colaboradorModel, false);

        if (!is_numeric($validarCamposColaborador)) {

            return $this->dao->inserirColaborador($colaboradorModel);
            
        } else {

            return $validarCamposColaborador;
        }
    }

    public function alterarColaborador()
    {
        $colaboradorModel = new ColaboradorModel();
        
        $validarCamposColaborador = ValidarCampos::validarCamposColaboradores($colaboradorModel);

        if (is_bool($validarCamposColaborador)) {

            return $this->dao->alterarColaborador($colaboradorModel);
            
        } else {

            return $validarCamposColaborador;
        }
    }
    
    public function excluirColaborador(int $id)
    {
        return $this->dao->excluirColaboradores($id); 
    }

    public function buscarTiposDeColaboradores()
    {
        return $this->dao->buscarTiposDeColaboradores();
    }

    public function buscarColaboradorPorTipo($tipoColaborador)
    {
        return $this->dao->buscarColaboradorPorTipo($tipoColaborador);
    }

    public function buscarColaboradorPorId(int $id)
    {

        return $this->dao->buscarColaboradorPorId($id);
    }

    public function buscarColaboradorPorNome($nome, $sobrenome)
    {

        $resultados     = $this->dao->buscarColaboradorPorNome($nome, $sobrenome);
        $colaboradores  = $this->dao->buscarColaboradorPorNome($nome, $sobrenome, true);
        
        if (count($resultados) > 0) {

            for ($i = 0; $i < count($colaboradores); $i++) {

                $nome_tipo = "";

                for ($j = 0; $j < count($resultados); $j++) {

                    if ($colaboradores[$i]["id_colaborador"] == $resultados[$j]["id_colaborador"]) {

                        $nome_tipo .= $resultados[$j]["nome_tipo_colaborador"] . " - ";
                    }
                }

                $colaboradores[$i]["nome-tipo"] = substr($nome_tipo, 0, -2);
            }
        }

        return count($colaboradores) > 0 ? $colaboradores : 2;
    }

    public function buscarIdTipoColaboradores(int $id)
    {
        return $this->dao->buscarIdTipoColaboradores($id);
    }

    public function buscarNomeTipoColaboradorPorId(int $id)
    {
        $resultado = $this->dao->buscarNomeTipoColaboradorPorId($id);

        if (is_array($resultado)) {

            $nomes = "";

            for ($i = 0; $i < count($resultado); $i++) {

                $nomes .= $resultado[$i]["nome_tipo"] . " - ";
            }

            return substr($nomes, 0, -2);
        } else {

            Erro::setErro(ERRO_DURANTE_A_OPERCAO . ". Não foi possível carregar os nomes dos tipos de colaboradores");

            return -1;
        }
    }
}
