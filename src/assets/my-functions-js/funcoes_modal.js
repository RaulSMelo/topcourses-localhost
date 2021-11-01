window.modalAlterarCadastroBasico = (id, nome) => {
  const idAlterar = document.getElementById("id-cadastro-basico-alterar");
  const nomeAlterar = document.getElementById("nome-cadastro-basico-alterar");
  idAlterar.value = id;
  nomeAlterar.value = nome;

  if (nomeAlterar.value != "") {
    nomeAlterar.classList.remove("campo-obrigatorio-modal");
    nomeAlterar.classList.add("is-valid");
  }
};

window.modalExcluirCadastroBasico = (id, nome) => {
  const idExcluir = document.getElementById("id-cadastro-basico-excluir");
  const nomeExcluir = document.getElementById("nome-cadastro-basico-excluir");
  idExcluir.value = id;
  nomeExcluir.value = nome;
};

window.modalExcluirIntColEmp = (id, nome, email, telefone, filtro_nome, nome_tipo) => {
  const idIntColEmp       = document.getElementById("id-excluir");
  const nomeIntColEmp     = document.getElementById("nome-modal-excluir");
  const emailIntColEmp    = document.getElementById("email-modal-excluir");
  const telefoneIntColEmp = document.getElementById("telefone-modal-excluir");
  const filtroNome        = document.getElementById("filtro-nome");
  const nomeTipo          = document.getElementById("tipo");

  idIntColEmp.value       = id;
  nomeIntColEmp.value     = nome;
  emailIntColEmp.value    = email;
  telefoneIntColEmp.value = telefone;
  filtroNome.value        = filtro_nome;
  nomeTipo.innerHTML      = nome_tipo;
  
};

window.modalAlterarTurma = (id, nomeTurma, idColaborador) => {
  const id_turma = document.getElementById("id-turma-alterar");
  const nome_turma = document.getElementById("nome-turma-modal-alterar");
  const id_colaborador = document.getElementById(
    "modal-alterar-id-colaborador"
  );

  id_turma.value = id;
  nome_turma.value = nomeTurma;
  id_colaborador.value = idColaborador;

  if (nome_turma.value != "") {
    nome_turma.classList.remove("campo-obrigatorio-modal");
    nome_turma.classList.add("is-valid");
  }

  if (id_colaborador.value != "") {
    id_colaborador.classList.remove("campo-obrigatorio-modal");
    id_colaborador.classList.add("is-valid");
  }
};

window.modalExcluirTurma = (id, nomeTurma, idColaborador) => {
  const id_turma = document.getElementById("id-turma-excluir");
  const nome_turma = document.getElementById("nome-turma-modal-excluir");
  const id_colaborador = document.getElementById("modal-excluir-id-colaborador");

  id_turma.value = id;
  nome_turma.value = nomeTurma;
  id_colaborador.value = idColaborador;
};

window.modalAlterarHoraAula = (id, idIdioma, valorHoraAula) => {
    
    const id_hora_aula    = document.getElementById("id-alterar-hora-aula");
    const id_idioma       = document.getElementById("modal-alterar-idioma-hora-aula");
    const valor_hora_aula = document.getElementById("modal-alterar-valor-hora-aula");
    
    id_hora_aula.value    = id;
    id_idioma.value       = idIdioma;
    valor_hora_aula.value = valorHoraAula;
    
    if(id_idioma.value != ""){
        
        id_idioma.classList.remove("campo-obrigatorio-modal");
        id_idioma.classList.add("is-valid");
    }
    
    if(valor_hora_aula.value != ""){
        
        valor_hora_aula.classList.remove("campo-obrigatorio-modal");
        valor_hora_aula.classList.add("is-valid");
    }
    
};

window.modalExcluirHoraAula = (id, idioma, valorHoraAula) => {
    
    const id_hora_aula    = document.getElementById("id-excluir-hora-aula");
    const id_idioma       = document.getElementById("modal-excluir-idioma-hora-aula");
    const valor_hora_aula = document.getElementById("modal-excluir-valor-hora-aula");
    
    id_hora_aula.value    = id;
    id_idioma.value       = idioma;
    valor_hora_aula.value = valorHoraAula;
};

window.modalDarBaixaEmParcela = (id, nomeAluno, numeroParcela, valorParcela, valorPago, dataVencimento, tipoPagamento, dataPagamento, idTipoPagamento, observacaoPagamento, idInteressado, idTipoContrato, idContrato) => {
    
    const idDarBaixaParcela      = document.getElementById("id-dar-baixa-parcela");
    const nome                   = document.getElementById("nome");
    const parcela                = document.getElementById("parcela");
    const numeroDaParcela        = document.getElementById("numero-parcela");
    const div_valor_pago         = document.getElementById("div-valor-pago");
    const input_valor_pago       = document.getElementById("valor-pago");
    const diaVencimento          = document.getElementById("dia-vencimento");
    const divValorParcela        = document.getElementById("div-valor-parcela");
    const inputTipoPag           = document.getElementById("input-tipo-pagamento");
    const inputDataPag           = document.getElementById("input-data-pagamento");
    const divTipoPag             = document.getElementById("div-tipo-pagamento");
    const divDataPag             = document.getElementById("div-data-pagamento");
    const selectTipoPag          = document.getElementById("tipo-pagamento");
    const valor_parcela          = document.getElementById("valor-parcela");
    const obsPag                 = document.getElementById("observacao-pagamento");
    const valor_parcela_vindo_DB = document.getElementById("valor-parcela-vindo-do-DB");
    const id_interessado         = document.getElementById("id-interessado");
    const id_tipo_contrato       = document.getElementById("id-tipo-contrato");
    const id_contrato            = document.getElementById("id-contrato");
    const form_row_valor_parcela = document.getElementById("form-row-valor-parcela");
    const form_row_tipo_pagamento = document.getElementById("form-row-tipo-pagamento");
    const btn_confirmar_baixa     = document.getElementById("btn-confirmar-baixa");
    

    idDarBaixaParcela.value      = id;
    nome.value                   = nomeAluno;
    numeroDaParcela.value        = numeroParcela.toString().split(" de ")[0];
    divValorParcela.value        = valorParcela;
    parcela.value                = numeroParcela;
    diaVencimento.value          = dataVencimento;
    obsPag.value                 = observacaoPagamento;
    valor_parcela.value          = valorParcela.toString().replace("R$", "");
    valor_parcela_vindo_DB.value = valorParcela.toString().replace("R$", "");
    id_interessado.value         = idInteressado;
    id_tipo_contrato.value       = idTipoContrato;
    id_contrato.value            = idContrato;
    
    if(valor_parcela.value !== ""){
        
        valor_parcela.classList.remove("campo-obrigatorio-modal");
        valor_parcela.classList.add("is-valid");
        
    }else{
        
        valor_parcela.classList.remove("is-valid");
        valor_parcela.classList.remove("is-invalid");
        valor_parcela.classList.add("campo-obrigatorio-modal");
    }
        
    if(valorPago !== "" && dataPagamento !== ""){
        
        form_row_valor_parcela.style.display  = "none";
        form_row_tipo_pagamento.style.display = "none";
        btn_confirmar_baixa.style.display     = "none";
        obsPag.setAttribute("disabled", true);
        
    }else{
        
        form_row_valor_parcela.style.display  = "block";
        form_row_tipo_pagamento.style.display = "block";
        btn_confirmar_baixa.style.display     = "block";
        obsPag.removeAttribute("disabled");
        
    }    
    
    if(valorPago !== ""){
        
        input_valor_pago.value = valorPago;
        div_valor_pago.style.display = "block";
        
    }else{
        
        inputTipoPag.value = "";
        div_valor_pago.style.display = "none";
    }
    
    if(tipoPagamento !== ""){
        
        inputTipoPag.value = tipoPagamento;
        divTipoPag.style.display = "block";
        
    }else{
        
        inputTipoPag.value = "";
        divTipoPag.style.display = "none";
    }
    
    if(dataPagamento !== ""){
        
        inputDataPag.value = dataPagamento;
        divDataPag.style.display = "block";
        
    }else{
        
         inputDataPag.value = "";
         divDataPag.style.display = "none";
    }
    
    if(idTipoPagamento !== ""){
        
        selectTipoPag.value = idTipoPagamento;
        selectTipoPag.classList.remove("campo-obrigatorio-modal");
        selectTipoPag.classList.add("is-valid");
        
    }else{
        
        selectTipoPag.value = "";
        selectTipoPag.classList.remove("is-valid");
        selectTipoPag.classList.add("campo-obrigatorio-modal");
    }
 

};

window.enviarIndexBtnBuscar = (evt) => {
    
    const index = document.getElementById("index");
    
    index.value = evt.target.dataset.index;
    
};

window.preencherDadosInteressadoContratoGrupo = (id, cpf, nome) => { 
    
    const inputID   = document.getElementsByName("id-aluno[]");
    const inputCPF  = document.getElementsByName("cpf[]");
    const inputNome = document.getElementsByName("nome-completo[]");
    const index     = parseInt(document.getElementById("index").value);
    const tabelaBuscarInteressados   = document.getElementById("tabela-dados-interessados");
    const nomeModalbuscarInteressado = document.getElementById("nome-buscar-interessado");
    const msgAlertaGrupoCPFvazio     = document.getElementById("msg-alerta-grupo-cpf-vazio");
    const arrayIdsInteressado        = [];
    
    if(cpf !== ""){
        
        inputID.forEach(idAluno => {
            arrayIdsInteressado.push(idAluno.value);
        });
        
        if(!arrayIdsInteressado.includes(id)){
            
            inputID[index].value   = id;
            inputCPF[index].value  = cpf;
            inputNome[index].value = nome;

            inputCPF[index].classList.remove("campo-obrigatorio");
            inputCPF[index].classList.add("is-valid");
            inputNome[index].classList.remove("campo-obrigatorio");
            inputNome[index].classList.add("is-valid");

            nomeModalbuscarInteressado.value = "";
            nomeModalbuscarInteressado.classList.remove("is-valid");
            nomeModalbuscarInteressado.classList.add("campo-obrigatorio-modal");

            tabelaBuscarInteressados.innerHTML = "";

            msgAlertaGrupoCPFvazio.innerHTML     = "";
            msgAlertaGrupoCPFvazio.style.display = "none";
            
        }else{
            
            nomeModalbuscarInteressado.value = "";
            nomeModalbuscarInteressado.classList.remove("is-valid");
            nomeModalbuscarInteressado.classList.add("campo-obrigatorio-modal");

            tabelaBuscarInteressados.innerHTML   = "";

            msgAlertaGrupoCPFvazio.innerHTML     = "O interessado já existe na lista";
            msgAlertaGrupoCPFvazio.style.display = "block";
        }
        
        
    }else{
        
        nomeModalbuscarInteressado.value = "";
        nomeModalbuscarInteressado.classList.remove("is-valid");
        nomeModalbuscarInteressado.classList.add("campo-obrigatorio-modal");

        tabelaBuscarInteressados.innerHTML   = "";
        
        msgAlertaGrupoCPFvazio.innerHTML     = "A opção escolhida não possui CPF cadastrado. Retorne ao formulário de alterar cadastro de interessado e cadastre o CPF";
        msgAlertaGrupoCPFvazio.style.display = "block";
    }
    
      
    $("#modal-buscar-aluno").modal("hide");
    
};