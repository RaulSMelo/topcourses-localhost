((win, doc) => {
"use strict";

    /* Função AJAX para validar os campos email das tela interessado, colaborador e empresa */
    
//    (win.validarEmail = () => {
//
//        const campoEmailPessoa = doc.getElementById("email");
//        const campoEmailEmpresa = doc.getElementById("email-empresa");
//
//        if (campoEmailPessoa !== null) {
//
//            const alertaEmailInvalido = doc.getElementById("email-alert");
//
//            campoEmailPessoa.addEventListener("change", () => {
//
//                if (campoEmailPessoa.value.trim() != "") {
//
//                    const idInteressado = doc.getElementById("id-interessado");
//                    const idColaborador = doc.getElementById("id-colaborador");
//                    const email = campoEmailPessoa.value;
//                    let id = 0;
//
//                    if (idInteressado !== null && idInteressado.value.trim() !== "") {
//
//                        id = idInteressado.value;
//
//                    } else if (idColaborador !== null && idColaborador.value.trim() !== "") {
//
//                        id = idColaborador.value;
//                    }
//
//                    $.ajax({
//
//                        url: "../../validate/ValidarEmail.php",
//                        method: "POST",
//                        dataType: "json",
//                        data: {
//                            email_pessoa: email,
//                            id:           id
//                        },
//
//                        success: function (response) {
//
//                            if (response.cont_email == 1) {
//
//                                campoEmailPessoa.classList.remove("campo-obrigatorio");
//                                campoEmailPessoa.classList.remove("is-valid");
//                                campoEmailPessoa.classList.add("is-invalid");
//                                campoEmailPessoa.value = "";
//                                campoEmailPessoa.focus();
//                                alertaEmailInvalido.innerHTML = "";
//                                alertaEmailInvalido.style.display = "block";
//                                alertaEmailInvalido.innerHTML = `O email <strong><em>${campoEmailPessoa.value}</em></strong> já existe na base de dados`;
//
//                            } else if (response.erro == -1) {
//
//                                campoEmailPessoa.classList.remove("campo-obrigatorio");
//                                campoEmailPessoa.classList.remove("is-valid");
//                                campoEmailPessoa.classList.add("is-invalid");
//                                campoEmailPessoa.value = "";
//                                campoEmailPessoa.focus();
//                                alertaEmailInvalido.innerHTML = "";
//                                alertaEmailInvalido.style.display = "block";
//                                alertaEmailInvalido.innerHTML = `O email <strong><em>${campoEmailPessoa.value}</em></strong> não é válido`;
//
//                            } else {
//
//                                alertaEmailInvalido.innerHTML = "";
//                                alertaEmailInvalido.style.display = "none";
//                                campoEmailPessoa.classList.remove("is-invalid");
//                                campoEmailPessoa.classList.add("is-valid");
//                            }
//                        },
//
//                        error: function (XMLHttpRequest) {
//
//                            alertaEmailInvalido.innerHTML = `Ocorreu um erro a verificar o email. Certifiquice que o email informado esteja correto`;
//                            console.log(XMLHttpRequest.responseText);
//                        }
//                    });
//
//                } else {
//
//                    alertaEmailInvalido.innerHTML = "";
//                    alertaEmailInvalido.style.display = "none";
//                    campoEmailPessoa.classList.remove("is-invalid");
//                }
//
//            });
//
//
//        } else if (campoEmailEmpresa !== null) {
//
//            const alertaEmailInvalido = doc.getElementById("email-alert");
//
//            campoEmailEmpresa.addEventListener("change", () => {
//
//                if (campoEmailEmpresa.value != "") {
//
//                    const idempresa = doc.getElementById("id-empresa");
//                    const email = campoEmailEmpresa.value;
//                    let id = 0;
//
//                    if (idempresa !== null && idempresa !== "") {
//
//                        id = idempresa.value;
//                    }
//
//                    $.ajax({
//
//                        url: "../../validate/ValidarEmail.php",
//                        method: "POST",
//                        dataType: "json",
//                        data: {
//                            email_empresa: email,
//                            id:            id
//                        },
//
//                        success: function (response) {
//
//                            if (response.cont_email == 1) {
//
//                                campoEmailEmpresa.classList.remove("campo-obrigatorio");
//                                campoEmailEmpresa.classList.add("is-invalid");
//                                campoEmailEmpresa.value = "";
//                                campoEmailEmpresa.focus();
//                                alertaEmailInvalido.innerHTML = "";
//                                alertaEmailInvalido.style.display = "block";
//                                alertaEmailInvalido.innerHTML = `O email <strong><em>${email}</em></strong> já existe na base de dados`;
//
//                            } else if (response.erro == -1) {
//
//                                campoEmailEmpresa.classList.remove("campo-obrigatorio");
//                                campoEmailEmpresa.classList.add("is-invalid");
//                                campoEmailEmpresa.value = "";
//                                campoEmailEmpresa.focus();
//                                alertaEmailInvalido.innerHTML = "";
//                                alertaEmailInvalido.style.display = "block";
//                                alertaEmailInvalido.innerHTML = `O email <strong><em>${email}</em></strong> não é um email válido`;
//
//                            } else {
//                                alertaEmailInvalido.innerHTML = "";
//                                alertaEmailInvalido.style.display = "none";
//                                campoEmailEmpresa.classList.remove("is-invalid");
//                                campoEmailEmpresa.classList.add("is-valid");
//                            }
//                        },
//
//                        error: function (XMLHttpRequest) {
//
//                            alertaEmailInvalido.innerHTML = `Ocorreu um erro a verificar o email. Certifiquice que o email informado esteja correto`;
//                            console.log(XMLHttpRequest.responseText);
//                        }
//
//                    });
//
//                }
//
//            });
//
//        }
//
//    })();
    
    
    
    /* Função AJAX para validar os campos datas  */
    ( win.validarDatas = () => {
        
//        const idTipoContrato = doc.getElementById("id-tipo-contrato")
//        
//        console.log();
        
        const dataNascimento          = doc.getElementById("data-nascimento");
        const dataAgendamento         = doc.getElementById("data-agendamento");
        const dataInicio              = doc.getElementById("data-inicio");
        const dataFinal               = doc.getElementById("data-final");
        const dataRecebimentoMaterial = doc.getElementById("data-recebimento-material");
        const dataPrazoEntrega        = doc.getElementById("data-prazo-entrega");
        
        if(dataNascimento !== null){
            
            const alertaDtNasc = doc.getElementById("data-nascimento-alert");
            
            dataNascimento.addEventListener("blur", () => {
                
                if(dataNascimento.value.trim() !== ""){
                    
                    win.ajaxDatas(dataNascimento.value, null, null, null, null, null);
                    
                }else{
                    
                    alertaDtNasc.innerHTML = "";
                    alertaDtNasc.style.display = "none";
                    dataNascimento.classList.remove("is-invalid");
                    dataNascimento.classList.remove("is-valid");
                    dataNascimento.classList.add("bg-components-form");
                }
                
            });
         
        }
        
        
        if(dataInicio !== null && dataFinal !== null){
            
            const alertaDtIniDtFim = doc.getElementById("datainicio-e-datafinal-alert");
            
            dataInicio.addEventListener("blur", () => {
                
                const checkBoxDiaSemana = doc.getElementsByName("dia-semana[]");
                
                if(dataInicio.value.trim() !== "" && dataFinal.value.trim() !== ""){
                    
                    const camposHoraInicio = doc.getElementsByName("hora-inicio[]");
                    const camposHoraTermino = doc.getElementsByName("hora-termino[]");
                    
                    if(camposHoraInicio && camposHoraTermino){
                        
                        if(camposHoraInicio.length > 0 && camposHoraTermino.length > 0){
                            
                            win.calcularCargaHoraria(camposHoraInicio, camposHoraTermino);
                        }
                    }
                    
                    win.ajaxDatas(null, null, dataInicio.value, dataFinal.value, null, null, null);
                    
                    checkBoxDiaSemana.forEach(dia => {
                        
                        dia.removeAttribute("disabled");
                        
                    });
                    
                }else if (dataInicio.value.trim() === ""){
                    
                    alertaDtIniDtFim.innerHTML = "";
                    alertaDtIniDtFim.style.display = "none";
                    dataInicio.classList.remove("is-invalid");
                    dataInicio.classList.remove("is-valid");
                    dataInicio.classList.add("campo-obrigatorio");
                    
                }else if(dataInicio.value.trim() !== "" || dataFinal.value.trim() !== ""){
                        
                    checkBoxDiaSemana.forEach(dia => {
                        
                        dia.setAttribute("disabled", true);
                        
                    });
                }
                
            });
            
            dataFinal.addEventListener("blur", () => {
                
                const checkBoxDiaSemana = doc.getElementsByName("dia-semana[]");
                
                if(dataInicio.value.trim() !== "" && dataFinal.value.trim() !== ""){
                    
                    const camposHoraInicio = doc.getElementsByName("hora-inicio[]");
                    const camposHoraTermino = doc.getElementsByName("hora-termino[]");
                    
                    if(camposHoraInicio && camposHoraTermino){
                        
                        if(camposHoraInicio.length > 0 && camposHoraTermino.length > 0){
                            
                            win.calcularCargaHoraria(camposHoraInicio, camposHoraTermino);
                        }
                    }
                    
                    win.ajaxDatas(null, null, dataInicio.value, dataFinal.value, null, null, null);
                    
                    checkBoxDiaSemana.forEach(dia => {
                        
                        dia.removeAttribute("disabled");
                        
                    });
                    
                }else if (dataFinal.value.trim() === ""){
                    
                    alertaDtIniDtFim.innerHTML = "";
                    alertaDtIniDtFim.style.display = "none";
                    dataFinal.classList.remove("is-invalid");
                    dataFinal.classList.remove("is-valid");
                    dataFinal.classList.add("campo-obrigatorio");
                    
                }else if(dataFinal.value.trim() !== "" || dataInicio.value.trim() !== ""){
                        
                    checkBoxDiaSemana.forEach(dia => {
                        
                        dia.setAttribute("disabled", true);
                        
                    });
                }
                
            });
            
        }
        
        if(dataRecebimentoMaterial !== null && dataPrazoEntrega !== null){
            
            const msgAlertaDtRecebimentoDtPrazoEntrega = doc.getElementById("msg-alerta-dataRecebimento-e-dataPrazoEntrega");
            
            dataRecebimentoMaterial.addEventListener("blur", () => {
                
                if(dataRecebimentoMaterial.value.trim() !== "" && dataPrazoEntrega.value.trim() !== ""){
                    
                    win.ajaxDatas(null, null, null, null, dataRecebimentoMaterial.value, dataPrazoEntrega.value, null);
                    
                }else if(dataRecebimentoMaterial.value.trim() !== ""){
                    
                    msgAlertaDtRecebimentoDtPrazoEntrega.innerHTML     = "";
                    msgAlertaDtRecebimentoDtPrazoEntrega.style.display = "none";
                    dataRecebimentoMaterial.classList.remove("is-invalid");
                    dataRecebimentoMaterial.classList.remove("campo-obrigatorio");
                    dataRecebimentoMaterial.classList.add("is-valid");
                }
                
            });
            
            dataPrazoEntrega.addEventListener("blur", () => {
                
                if(dataPrazoEntrega.value.trim() !== "" && dataRecebimentoMaterial.value.trim() !== ""){

                    win.ajaxDatas(null, null, null, null, dataRecebimentoMaterial.value, dataPrazoEntrega.value, null);
                    
                }else if(dataPrazoEntrega.value.trim() !== ""){
                      
                    msgAlertaDtRecebimentoDtPrazoEntrega.innerHTML     = "";
                    msgAlertaDtRecebimentoDtPrazoEntrega.style.display = "none";
                    dataPrazoEntrega.classList.remove("is-invalid");
                    dataPrazoEntrega.classList.remove("campo-obrigatorio");
                    dataPrazoEntrega.classList.add("is-valid");
                }
            });
            
        }
        
        
    })();
    
    win.ajaxDatas = (dataNascimento, dataAgendamento, dataInicio, dataFinal, dataRecebimentoMateria, dataPrazoEntrega) => {
        
        
        $.ajax({
            
            url:      "../../validate/ValidarDatas.php",
            method:   "POST",
            dataType: "json",
            data:{
                data_nascimento:           dataNascimento,
                data_agendamento:          dataAgendamento,
                data_inicio:               dataInicio,
                data_final:                dataFinal,
                data_recebimento_material: dataRecebimentoMateria,
                data_prazo_entrega:        dataPrazoEntrega,
            },
            
            success: function(response){
                
                if(response.idAlerta === "data-nascimento-alert"){
                    
                    const dataNasc        = doc.getElementById("data-nascimento");
                    const msgAlertaDtNasc = doc.getElementById("data-nascimento-alert");
                    
                    if(response.ret){
                        
                        msgAlertaDtNasc.innerHTML = "";
                        msgAlertaDtNasc.style.display = "none";
                        dataNasc.classList.remove("is-invalid");
                        dataNasc.classList.add("is-valid");
                        
                    }else if(response.erro){

                        msgAlertaDtNasc.value = "";
                        msgAlertaDtNasc.innerHTML = response.erro;
                        msgAlertaDtNasc.style.display = "block";
                        dataNasc.classList.remove("is-valid");
                        dataNasc.classList.add("is-invalid");
                        dataNasc,value = "";
                        dataNasc.focus();
                    }
 
                }else if(response.idAlerta === "data-agendamento-alert"){
                    
                    const dataAgend        = doc.getElementById("data-agendamento");
                    const msgAlertaDtAgend = doc.getElementById("data-agendamento-alert");
                    
                    if(response.ret){
                        
                        msgAlertaDtAgend.innerHTML = "";
                        msgAlertaDtAgend.style.display = "none";
                        dataAgend.classList.remove("is-invalid");
                        dataAgend.classList.add("is-valid");
                        
                    }else if(response.erro){
                        
                        msgAlertaDtAgend.innerHTML = "";
                        msgAlertaDtAgend.innerHTML = response.erro;
                        msgAlertaDtAgend.style.display = "inline-block";
                        dataAgend.classList.remove("is-valid");
                        dataAgend.classList.add("is-invalid");
                        dataAgend.value = "";
                        dataAgend.focus();
                    }
                    
                }else if(response.idAlerta === "datainicio-e-datafinal-alert"){
                    
                    const dataIni             = doc.getElementById("data-inicio");
                    const dataFim             = doc.getElementById("data-final");
                    const msgAlertaDtIniDtFim = doc.getElementById("datainicio-e-datafinal-alert");
                    const numeroMesesPorAno   = doc.getElementById("numero-meses-por-ano");
                    const checkboxDiaSemana  = doc.getElementsByName("dia-semana[]");
                    
                    if(response.ret){
                        
                        msgAlertaDtIniDtFim.innerHTML = "";
                        msgAlertaDtIniDtFim.style.display = "none";
                        dataIni.classList.remove("is-invalid");
                        dataIni.classList.add("is-valid");
                        dataFim.classList.remove("is-invalid");
                        dataFim.classList.add("is-valid");
                        
                        if(numeroMesesPorAno !== null){
                            
                            if(parseInt(response.qtdeMeses) > 0){
                                
                                numeroMesesPorAno.value = response.qtdeMeses;
                                numeroMesesPorAno.classList.remove("campo-obrigatorio");
                                numeroMesesPorAno.classList.add("is-valid");
                                
                            }
                        }
                        
                    }else if(response.erro){
                        
                        msgAlertaDtIniDtFim.innerHTML = "";
                        msgAlertaDtIniDtFim.innerHTML = response.erro;
                        msgAlertaDtIniDtFim.style.display = "block";
                        dataIni.classList.remove("is-valid");
                        dataIni.classList.add("is-invalid");
                        dataFim.classList.remove("is-valid");
                        dataFim.classList.add("is-invalid");
                        dataIni.value = "";
                        dataFim.value = "";
                        dataIni.focus();
                        
                        checkboxDiaSemana.forEach(dia => {
                        
                            dia.setAttribute("disabled", true);

                        });
                    }
                }else if(response.idAlerta === "msg-alerta-dataRecebimento-e-dataPrazoEntrega"){
                    
                    const dataRecebMat                      = doc.getElementById("data-recebimento-material");
                    const dataPrazoEntrega                  = doc.getElementById("data-prazo-entrega");
                    const msgAlertaDtRecebMatDtPrazoEntrega = doc.getElementById(response.idAlerta);
                    
                    if(response.ret){
                        
                        msgAlertaDtRecebMatDtPrazoEntrega.innerHTML     = "";
                        msgAlertaDtRecebMatDtPrazoEntrega.style.display = "none";
                        dataRecebMat.classList.remove("is-invalid");
                        dataRecebMat.classList.add("is-valid");
                        dataPrazoEntrega.classList.remove("is-invalid");
                        dataPrazoEntrega.classList.add("is-valid");
                        
                        
                    }else if(response.erro){
                        
                        msgAlertaDtRecebMatDtPrazoEntrega.innerHTML = "";
                        msgAlertaDtRecebMatDtPrazoEntrega.innerHTML = response.erro;
                        msgAlertaDtRecebMatDtPrazoEntrega.style.display = "block";
                        dataRecebMat.classList.remove("is-valid");
                        dataRecebMat.classList.add("is-invalid");
                        dataPrazoEntrega.classList.remove("is-valid");
                        dataPrazoEntrega.classList.add("is-invalid");
                        dataRecebMat.value = "";
                        dataPrazoEntrega.value = "";
                        dataRecebMat.focus();
                        
                    }
                    
                }else if(response.idAlerta === "msg-alerta-dia-vencimento-parcelas"){
                    
                    const diaVencParc          = doc.getElementById("dia-vencimento-parcela");
                    const msgAlertaDiaVencParc = doc.getElementById(response.idAlerta);
                    
                    if(response.ret){
                        
                        msgAlertaDiaVencParc.innerHTML     = "";
                        msgAlertaDiaVencParc.style.display = "none";
                        diaVencParc.classList.remove("is-invalid");
                        diaVencParc.classList.add("is-valid");
                        
                    }else if(response.erro){
                        
                        msgAlertaDiaVencParc.innerHTML = "";
                        msgAlertaDiaVencParc.innerHTML = response.erro;
                        msgAlertaDiaVencParc.style.display = "block";
                        diaVencParc.classList.remove("is-valid");
                        diaVencParc.classList.add("is-invalid");
                        diaVencParc.value = "";
                        diaVencParc.focus();
                    }
                    
                }
                
            },
            
            error: function(XMLHttpRequest){
                
                console.log(XMLHttpRequest.responseText);
            }
        });      
    };
    
    (win.buscarValorHoraAula = () => {
        
        const idIdioma      = doc.getElementById("id-idioma");
        const valorHoraAula = doc.getElementById("valor-hora-aula");
        const totalHoras    = doc.getElementById("total-horas");
        const valorTotal    = doc.getElementById("valor-total");
        const qtdeParcelas  = doc.getElementById("qtde-parcelas");
        const valorParcela  = doc.getElementById("valor-parcela");
        const valorEntrada  = doc.getElementById("valor-entrada");
        
        if(idIdioma !== null){
            
            idIdioma.addEventListener("change", () => {

                if(idIdioma.value !== ""){

                    $.ajax({

                        url:      "../../ajax/buscarValorHoraAula.php",
                        method:   "POST",
                        data: {
                           id_idioma: idIdioma.value 
                        },

                        success: (response) => {

                            if(response !== ""){

                                valorHoraAula.value = response;
                                valorHoraAula.classList.remove("campo-obrigatorio");
                                valorHoraAula.classList.remove("is-invalid");
                                valorHoraAula.classList.add("is-valid");
                                valorHoraAula.classList.add("font-weight-bold");

                                localStorage.valorHoraAula = response;

                                let resultado = win.dispararCalculoValorTotal(valorHoraAula.value, totalHoras.value);

                                if(resultado){

                                    valorTotal.value = "";
                                    valorTotal.value = parseFloat(resultado).toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});;
                                    valorTotal.classList.remove("campo-obrigatorio");
                                    valorTotal.classList.remove("is-invalid");
                                    valorTotal.classList.add("is-valid");
                                    valorTotal.classList.add("font-weight-bold");
                                    doc.getElementById("sem-entrada").focus();

                                    win.calcularValorParcela(valorTotal.value, qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);

                                    win.habilitarInputsRadiosFormaDePagamento();

                                }else{

                                    valorTotal.value = "";
                                    valorTotal.classList.remove("is-valid");
                                    valorTotal.classList.remove("is-invalid");
                                    valorTotal.classList.remove("font-weight-bold");
                                    valorTotal.classList.add("campo-obrigatorio");
                                }

                            }else{

                                valorHoraAula.value = "";
                                valorHoraAula.classList.remove("is-valid");
                                valorHoraAula.classList.remove("font-weight-bold");
                                valorHoraAula.classList.add("campo-obrigatorio");

                                valorTotal.value = "";
                                valorTotal.classList.remove("is-valid");
                                valorTotal.classList.remove("font-weight-bold");
                                valorTotal.classList.add("campo-obrigatorio");
                        }

                        },

                        error: (XMLHttpRequest) => {

                            console.log(XMLHttpRequest.responseText);
                        }

                    });
                }else{

                    valorHoraAula.value = "";
                    valorHoraAula.classList.remove("is-valid");
                    valorHoraAula.classList.remove("font-weight-bold");
                    valorHoraAula.classList.add("campo-obrigatorio");
                }

            });
        }
            
    })();
    

})(window, document);


