<?php


namespace Src\models;

use Src\input\Input;
use Src\traits\UtilCTRL;
use Src\models\AgendamentoModel;

class ContratoCursoModel 
{
    
    private array $idAluno;
    private array $cpf;
    private $idContratoCurso;
    private $idTipoContrato;
    private $idCurso;
    private $idIdioma;
    private $valorHoraAula;
    private $totalHoras;
    private $valorEntrada;
    private $qtdeParcelas;
    private $valorParcela;
    private $desconto;
    private $valorTotal;
    private $diaVencimentoParcela;
    private $dataInicioContrato;
    private $dataTerminoContrato;
    private $numeroMesesPorAno;
    private $localDasAulas;
    private $cargaHorariaSemanal;
    private $idProfessor;
    private $idNivel;
    private $idTurma;
    private $material;
    private $programa;
    private $marcacaoGeral;
    private $idEmpresa;
    private $idUserLogado;
    private $dataRegistro;
    private $situacao;
    private AgendamentoModel $agendamento;

    
    public function __construct() 
    {
        $this->getContratoCursoModel();
        $this->agendamento = new AgendamentoModel();
    }
    
    public function getIdAluno(): array 
    {
        return $this->idAluno;
    }

    public function getCpf(): array {
        return $this->cpf;
    }

    public function getIdContratoCurso() 
    {
        return $this->idContratoCurso;
    }

    public function getIdTipoContrato() 
    {
        return $this->idTipoContrato;
    }

    public function getIdCurso() {
        return $this->idCurso;
    }
    
    public function getIdIdioma() 
    {
        return $this->idIdioma;
    }

    
    public function getValorHoraAula() 
    {
        return $this->valorHoraAula;
    }

    public function getTotalHoras() 
    {
        return $this->totalHoras;
    }

    public function getValorEntrada() 
    {
        return $this->valorEntrada;
    }

    public function getQtdeParcelas() 
    {
        return $this->qtdeParcelas;
    }

    public function getValorParcela() 
    {
        return $this->valorParcela;
    }

    public function getDesconto() 
    {
        return $this->desconto;
    }

    public function getValorTotal() 
    {
        return $this->valorTotal;
    }

    public function getDiaVencimentoParcela() 
    {
        return $this->diaVencimentoParcela;
    }

    public function getDataInicioContrato() 
    {
        return $this->dataInicioContrato;
    }

    public function getDataTerminoContrato() 
    {
        return $this->dataTerminoContrato;
    }

    public function getNumeroMesesPorAno() 
    {
        return $this->numeroMesesPorAno;
    }

    public function getLocalDasAulas()
    {
        return $this->localDasAulas;
    }

    public function getCargaHorariaSemanal() 
    {
        return $this->cargaHorariaSemanal;
    }

    public function getIdProfessor() 
    {
        return $this->idProfessor;
    }

    public function getIdNivel() 
    {
        return $this->idNivel;
    }

    public function getIdTurma() 
    {
        return $this->idTurma;
    }

    public function getMaterial() 
    {
        return $this->material;
    }

    public function getPrograma() 
    {
        return $this->programa;
    }

    public function getMarcacaoGeral()
    {
        return $this->marcacaoGeral;
    }

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }

    public function getIdUserLogado()
    {
        return $this->idUserLogado;
    }

    public function getDataRegistro() 
    {
        return $this->dataRegistro;
    }

    public function getSituacao() 
    {
        return $this->situacao;
    }

    public function getAgendamento(): AgendamentoModel
    {
        return $this->agendamento;
    }

    public function setIdAluno(array $idAluno)
    {
        $this->idAluno = $idAluno;
    }

    public function setCpf(array $cpf)
    {
        $this->cpf = $cpf;
    }

    public function setIdContratoCurso($idContratoCurso)
    {
        $this->idContratoCurso = $idContratoCurso;
    }

    public function setIdTipoContrato($idTipoContrato)
    {
        $this->idTipoContrato = $idTipoContrato;
    }

    public function setIdCurso($idCurso)
    {
        $this->idCurso = $idCurso;
    }
    
    public function setIdIdioma($idIdioma)
    {
        $this->idIdioma = $idIdioma;
    }

    
    public function setValorHoraAula($valorHoraAula)
    {
        $this->valorHoraAula = $valorHoraAula;
    }

    public function setTotalHoras($totalHoras)
    {
        $this->totalHoras = $totalHoras;
    }

    public function setValorEntrada($valorEntrada)
    {
        $this->valorEntrada = $valorEntrada;
    }

    public function setQtdeParcelas($qtdeParcelas)
    {
        $this->qtdeParcelas = $qtdeParcelas;
    }

    public function setValorParcela($valorParcela)
    {
        $this->valorParcela = $valorParcela;
    }

    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;
    }

    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
    }

    public function setDiaVencimentoParcela($diaVencimentoParcela)
    {
        $this->diaVencimentoParcela = $diaVencimentoParcela;
    }

    public function setDataInicioContrato($dataInicioContrato)
    {
        $this->dataInicioContrato = $dataInicioContrato;
    }

    public function setDataTerminoContrato($dataTerminoContrato)
    {
        $this->dataTerminoContrato = $dataTerminoContrato;
    }

    public function setNumeroMesesPorAno($numeroMesesPorAno)
    {
        $this->numeroMesesPorAno = $numeroMesesPorAno;
    }

    public function setLocalDasAulas($localDasAulas)
    {
        $this->localDasAulas = $localDasAulas;
    }

    public function setCargaHorariaSemanal($cargaHorariaSemanal)
    {
        $this->cargaHorariaSemanal = $cargaHorariaSemanal;
    }

    public function setIdProfessor($idProfessor)
    {
        $this->idProfessor = $idProfessor;
    }

    public function setIdNivel($idNivel)
    {
        $this->idNivel = $idNivel;
    }

    public function setIdTurma($idTurma)
    {
        $this->idTurma = $idTurma;
    }

    public function setMaterial($material)
    {
        $this->material = $material;
    }

    public function setPrograma($programa)
    {
        $this->programa = $programa;
    }

    public function setMarcacaoGeral($marcacaoGeral)
    {
        $this->marcacaoGeral = $marcacaoGeral;
    }

    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function setIdUserLogado($idUserLogado)
    {
        $this->idUserLogado = $idUserLogado;
    }

    public function setDataRegistro($dataRegistro)
    {
        $this->dataRegistro = $dataRegistro;
    }

    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }

    public function setAgendamento(AgendamentoModel $agendamento) 
    {
        $this->agendamento = $agendamento;
    }

    
        
    private function getContratoCursoModel() 
    {
        $obj = $this->getInput();
        
        $this->setIdAluno($obj->idAluno);
        $this->setCpf($obj->cpf);
        $this->setIdContratoCurso($obj->idContratoCurso);
        $this->setIdTipoContrato($obj->idTipoContrato);
        $this->setIdCurso($obj->idCurso);
        $this->setIdIdioma($obj->idIdioma);
        $this->setValorHoraAula(UtilCTRL::formatoDecimalDB(trim($obj->valorHoraAula)));
        $this->setTotalHoras(UtilCTRL::formatoDecimalDB(trim($obj->totalHoras)));
        $this->setValorEntrada(trim($obj->valorEntrada) != "" ? UtilCTRL::formatoDecimalDB(trim($obj->valorEntrada)) : null);
        $this->setQtdeParcelas(trim($obj->qtdeParcelas));
        $this->setValorParcela(UtilCTRL::formatoDecimalDB(trim($obj->valorParcela)));
        $this->setDesconto(trim($obj->desconto) != "" ? UtilCTRL::formatoDecimalDB(trim($obj->desconto)) : null);
        $this->setValorTotal(UtilCTRL::formatoDecimalDB(trim($obj->valorTotal)));
        $this->setDiaVencimentoParcela(trim($obj->diaVencimentoParcela));
        $this->setDataInicioContrato(trim($obj->dataInicio));
        $this->setDataTerminoContrato(trim($obj->dataFinal));
        $this->setNumeroMesesPorAno(trim($obj->numeroMesesPorAno));
        $this->setLocalDasAulas($obj->localDasAulas == "outro-endereco" ? trim($obj->outroEndereco) : trim($obj->localDasAulas));
        $this->setCargaHorariaSemanal(UtilCTRL::formatoDecimalDB(UtilCTRL::formatarHorasEmDecimais(trim($obj->cargaHorariaSemanal))));
        $this->setIdProfessor(trim($obj->idProfessor) != "" ? trim($obj->idProfessor) : null);
        $this->setIdNivel(trim($obj->idNivel) != "" ? trim($obj->idNivel) : null);
        $this->setIdTurma(trim($obj->idTurma) != "" ? trim($obj->idTurma) : null);
        $this->setMaterial(trim($obj->material) != "" ? trim($obj->material) : null);
        $this->setPrograma(trim($obj->programa) != "" ? trim($obj->programa) : null);
        $this->setMarcacaoGeral(trim($obj->marcacaoGeral) != "" ? trim($obj->marcacaoGeral) : null);
        $this->setIdEmpresa(trim($obj->idEmpresa) != "" ? trim($obj->idEmpresa) : null);
        $this->setIdUserLogado(trim($obj->idUserLogado));
        $this->setDataRegistro(trim($obj->dataRegistro));
        $this->setSituacao(trim($obj->situacao));
        
        return $this;
        
    }
    
    private function getInput()
    {
        return (object)[
            
            "idAluno"              => $_POST["id-aluno"] ?? [],
            "cpf"                  => $_POST["cpf"] ?? [],
            "idContratoCurso"      => Input::post("id-contrato-curso", FILTER_SANITIZE_NUMBER_INT),
            "idTipoContrato"       => Input::post("id-tipo-contrato", FILTER_SANITIZE_NUMBER_INT),
            "idCurso"              => Input::post("id-curso", FILTER_SANITIZE_NUMBER_INT),
            "idIdioma"             => Input::post("id-idioma", FILTER_SANITIZE_NUMBER_INT),
            "valorHoraAula"        => Input::post("valor-hora-aula"),
            "totalHoras"           => Input::post("total-horas"),
            "valorEntrada"         => Input::post("valor-entrada"),
            "outroEndereco"        => Input::post("outro-endereco"),
            "qtdeParcelas"         => Input::post("qtde-parcelas", FILTER_SANITIZE_NUMBER_INT),
            "valorParcela"         => Input::post("valor-parcela"),
            "desconto"             => Input::post("desconto"),
            "valorTotal"           => Input::post("valor-total"),
            "diaVencimentoParcela" => Input::post("dia-vencimento-parcela"),
            "dataInicio"           => Input::post("data-inicio"),
            "dataFinal"            => Input::post("data-final"),
            "numeroMesesPorAno"    => Input::post("numero-meses-por-ano", FILTER_SANITIZE_NUMBER_INT),
            "localDasAulas"        => Input::post("local-das-aulas-ministradas"),
            "cargaHorariaSemanal"  => Input::post("carga-horaria"),
            "idProfessor"          => Input::post("id-professor", FILTER_SANITIZE_NUMBER_INT),
            "idNivel"              => Input::post("id-nivel", FILTER_SANITIZE_NUMBER_INT),
            "idTurma"              => Input::post("id-turma", FILTER_SANITIZE_NUMBER_INT),
            "material"             => Input::post("material"),
            "programa"             => Input::post("programa"),
            "marcacaoGeral"        => Input::post("marcacao-geral"),
            "idEmpresa"            => Input::post("id-empresa", FILTER_SANITIZE_NUMBER_INT),
            "idUserLogado"         => UtilCTRL::idUserLogado(),
            "dataRegistro"         => UtilCTRL::dataAtual(),
            "situacao"             => Input::post("situacao", FILTER_SANITIZE_NUMBER_INT)
        ];
    }
    
    
}
