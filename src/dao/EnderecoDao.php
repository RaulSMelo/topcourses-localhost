<?php


namespace Src\dao;

use PDO;
use Src\log\Log;
use Src\dao\Conexao;
use Src\dao\sql\EnderecoSQL;
use Src\models\EnderecoModel;
use Src\controllers\EnderecoController;

class EnderecoDao
{
    private static PDO $conn;
    private static EnderecoController $enderecoCTRL;
    private static $endereco;


    public static function inserirOUalterarEndereco($tipoEndereco, $id)
    {
        self::$conn         = Conexao::obterConexao();
        self::$enderecoCTRL = new EnderecoController();
        self::$endereco     = self::$enderecoCTRL->getEnderecoController();

        if (self::$endereco instanceof EnderecoModel) {
            
            if (empty($id)) {

                if ($tipoEndereco == COLABORADOR) {

                    self::$endereco->setIdColaborador($id);
                    self::$endereco->setIdEmpresa(null);
                    self::$endereco->setIdInteressado(null);
                    
                } else if ($tipoEndereco == EMPRESA) {

                    self::$endereco->setIdColaborador(null);
                    self::$endereco->setIdEmpresa($id);
                    self::$endereco->setIdInteressado(null);
                    
                } else if ($tipoEndereco == INTERESSADO) {

                    self::$endereco->setIdColaborador(null);
                    self::$endereco->setIdEmpresa(null);
                    self::$endereco->setIdInteressado($id);
                }

                try {
                    
                    dd( ["1" => "DENTRO DO INSERIR", "ENDERECO" => self::$endereco] );
                    
                    $stmt = self::$conn->prepare(EnderecoSQL::inserirEndereco());
                    $i = 1;
                    $stmt->bindValue($i++, self::$endereco->getCep());
                    $stmt->bindValue($i++, self::$endereco->getRua());
                    $stmt->bindValue($i++, self::$endereco->getNumero());
                    $stmt->bindValue($i++, self::$endereco->getComplemento());
                    $stmt->bindValue($i++, self::$endereco->getBairro());
                    $stmt->bindValue($i++, self::$endereco->getCidade());
                    $stmt->bindValue($i++, self::$endereco->getUf());
                    $stmt->bindValue($i++, self::$endereco->getIdColaborador());
                    $stmt->bindValue($i++, self::$endereco->getIdEmpresa());
                    $stmt->bindValue($i++, self::$endereco->getIdInteressado());
                    $stmt->bindValue($i++, self::$endereco->getIdUserLogado());
                    $stmt->bindValue($i++, self::$endereco->getDataRegistro());

                    $stmt->execute();

                    return true;
                    
                } catch (\PDOException $e) {
                    
                    (new Log("ERRO ao inserir o endereço"))->enviarLogDeErro($e);
                    
                    header("LOCATION: " . PAGINA_DE_ERRO);
                    
                    exit;
                }
                
                
            } else if (!empty(trim($id))) {
                
                try {
                    
                    $stmt = self::$conn->prepare(EnderecoSQL::verificarSeExisteEnderecoCadastrado($tipoEndereco));
                    $stmt->bindValue(1, $id);
                    $stmt->execute();
                    
                    $idEndereco = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($tipoEndereco == COLABORADOR) {

                        self::$endereco->setIdColaborador($id);
                        self::$endereco->setIdEmpresa(null);
                        self::$endereco->setIdInteressado(null);

                    } else if ($tipoEndereco == EMPRESA) {

                        self::$endereco->setIdColaborador(null);
                        self::$endereco->setIdEmpresa($id);
                        self::$endereco->setIdInteressado(null);

                    } else if ($tipoEndereco == INTERESSADO) {

                        self::$endereco->setIdColaborador(null);
                        self::$endereco->setIdEmpresa(null);
                        self::$endereco->setIdInteressado($id);
                    }
                    
                    if(empty($idEndereco)){
                        
                        //dd( ["1" => "DENTRO ALTERAR - SEM ID ENDERECO", "ENDERECO" => self::$endereco] );
                        
                        $stmt = self::$conn->prepare(EnderecoSQL::inserirEndereco());
                        $i = 1;
                        $stmt->bindValue($i++, self::$endereco->getCep());
                        $stmt->bindValue($i++, self::$endereco->getRua());
                        $stmt->bindValue($i++, self::$endereco->getNumero());
                        $stmt->bindValue($i++, self::$endereco->getComplemento());
                        $stmt->bindValue($i++, self::$endereco->getBairro());
                        $stmt->bindValue($i++, self::$endereco->getCidade());
                        $stmt->bindValue($i++, self::$endereco->getUf());
                        $stmt->bindValue($i++, self::$endereco->getIdColaborador());
                        $stmt->bindValue($i++, self::$endereco->getIdEmpresa());
                        $stmt->bindValue($i++, self::$endereco->getIdInteressado());
                        $stmt->bindValue($i++, self::$endereco->getIdUserLogado());
                        $stmt->bindValue($i++, self::$endereco->getDataRegistro());

                        $stmt->execute();

                        return true;
                        
                    }else{
                        
//                        dd( [
//                                "2" => "DENTRO ALTERAR - COM ID ENDERECO", 
//                                "ENDERECO" => self::$endereco, 
//                                "ID-ENDERECO" => $idEndereco
//                            ] );
                    
                        $stmt = self::$conn->prepare(EnderecoSQL::alterarEndereco());
                        $i = 1;
                        $stmt->bindValue($i++, self::$endereco->getCep());
                        $stmt->bindValue($i++, self::$endereco->getRua());
                        $stmt->bindValue($i++, self::$endereco->getNumero());
                        $stmt->bindValue($i++, self::$endereco->getComplemento());
                        $stmt->bindValue($i++, self::$endereco->getBairro());
                        $stmt->bindValue($i++, self::$endereco->getCidade());
                        $stmt->bindValue($i++, self::$endereco->getUf());
                        $stmt->bindValue($i++, $idEndereco['id_endereco']);

                        $stmt->execute();

                        return true;
                    }
                    
                } catch (\PDOException $e) {
                    
                    (new Log("ERRO ao alterar o endereço"))->enviarLogDeErro($e);
                    
                    header("LOCATION: " . PAGINA_DE_ERRO);
                    
                    exit;
                    
                }
                
            }
        } else {
            
            return self::$endereco;
        }
    }
}
