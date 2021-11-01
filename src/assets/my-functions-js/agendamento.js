( (doc, win) => {
"use strict";

    (win.configurarAgendamento = () => {


        /*SEGUNDA-FEIRA*/
        const horaInicioSegunda  = doc.getElementById("div-seg-hi");
        const horaTerminoSegunda = doc.getElementById("div-seg-ht");
        const prepDASseg         = doc.getElementById("das-seg");
        const prepASseg          = doc.getElementById("as-seg");
        const inputHIseg         = doc.getElementById("hora-inicio-segunda");
        const inputHTseg         = doc.getElementById("hora-termino-segunda");
        const labelSeg           = doc.getElementById("label-seg");

        /*TERÇA-FEIRA*/
        const horaInicioTerca  = doc.getElementById("div-ter-hi");
        const horaTerminoTerca = doc.getElementById("div-ter-ht");
        const prepDASter       = doc.getElementById("das-ter");
        const prepASter        = doc.getElementById("as-ter");
        const inputHIter       = doc.getElementById("hora-inicio-terca");
        const inputHTter       = doc.getElementById("hora-termino-terca");
        const labelTer         = doc.getElementById("label-ter");

        /*QUARTA-FEIRA*/
        const horaInicioQuarta  = doc.getElementById("div-qua-hi");
        const horaTerminoQuarta = doc.getElementById("div-qua-ht");
        const prepDASqua        = doc.getElementById("das-qua");
        const prepASqua         = doc.getElementById("as-qua");
        const inputHIqua        = doc.getElementById("hora-inicio-quarta");
        const inputHTqua        = doc.getElementById("hora-termino-quarta");
        const labelQua          = doc.getElementById("label-qua");

        /*QUINTA-FEIRA*/
        const horaInicioQuinta  = doc.getElementById("div-qui-hi");
        const horaTerminoQuinta = doc.getElementById("div-qui-ht");
        const prepDASqui        = doc.getElementById("das-qui");
        const prepASqui         = doc.getElementById("as-qui");
        const inputHIqui        = doc.getElementById("hora-inicio-quinta");
        const inputHTqui        = doc.getElementById("hora-termino-quinta");
        const labelQui          = doc.getElementById("label-qui");

        /*SEXTA-FEIRA*/
        const horaInicioSexta  = doc.getElementById("div-sex-hi");
        const horaTerminoSexta = doc.getElementById("div-sex-ht");
        const prepDASsex       = doc.getElementById("das-sex");
        const prepASsex        = doc.getElementById("as-sex");
        const inputHIsex       = doc.getElementById("hora-inicio-sexta");
        const inputHTsex       = doc.getElementById("hora-termino-sexta");
        const labelSex         = doc.getElementById("label-sex");

        /*SÁBADO*/
        const horaInicioSabado  = doc.getElementById("div-sab-hi");
        const horaTerminoSabado = doc.getElementById("div-sab-ht");
        const prepDASsab        = doc.getElementById("das-sab")
        const prepASsab         = doc.getElementById("as-sab")
        const inputHIsab        = doc.getElementById("hora-inicio-sabado");
        const inputHTsab        = doc.getElementById("hora-termino-sabado");
        const labelSab          = doc.getElementById("label-sab");

        const checkboxDiaSemana = doc.getElementsByName("dia-semana[]");
        
        const colunaCargaHorariaETotalHorasACombinar = doc.getElementById("a-combinar-cargahoraria-e-totalhoras");
        const inputTotalHorasACombinar = doc.getElementById("total-horas-a-combinar");
        const inputTotalHoras  = doc.getElementById("total-horas");
        const inputCargaHoraria = doc.getElementById("carga-horaria");
        const colunaTotalHoras = doc.getElementById("col-total-horas");

        checkboxDiaSemana.forEach(dia => {

            dia.addEventListener("change", () => {

                if (dia.checked) {

                    if (dia.value === "1") {
                        
                        habilitarCamposAgendamentos(horaInicioSegunda, horaTerminoSegunda, prepDASseg, prepASseg, labelSeg);
                        ocultarCampoTotalHoras(colunaCargaHorariaETotalHorasACombinar, inputTotalHoras, inputCargaHoraria, colunaTotalHoras);
                        
                    } else if (dia.value === "2") {

                        habilitarCamposAgendamentos(horaInicioTerca, horaTerminoTerca, prepDASter, prepASter, labelTer);
                        ocultarCampoTotalHoras(colunaCargaHorariaETotalHorasACombinar, inputTotalHorasACombinar, inputTotalHoras, inputCargaHoraria, colunaTotalHoras);
                        
                    } else if (dia.value === "3") {

                        habilitarCamposAgendamentos(horaInicioQuarta, horaTerminoQuarta, prepDASqua, prepASqua, labelQua);
                        ocultarCampoTotalHoras(colunaCargaHorariaETotalHorasACombinar, inputTotalHorasACombinar, inputTotalHoras, inputCargaHoraria, colunaTotalHoras);

                    } else if (dia.value === "4") {

                        habilitarCamposAgendamentos(horaInicioQuinta, horaTerminoQuinta, prepDASqui, prepASqui, labelQui);
                        ocultarCampoTotalHoras(colunaCargaHorariaETotalHorasACombinar, inputTotalHorasACombinar, inputTotalHoras, inputCargaHoraria, colunaTotalHoras);

                    } else if (dia.value === "5") {

                        habilitarCamposAgendamentos(horaInicioSexta, horaTerminoSexta, prepDASsex, prepASsex, labelSex);
                        ocultarCampoTotalHoras(colunaCargaHorariaETotalHorasACombinar, inputTotalHorasACombinar, inputTotalHoras, inputCargaHoraria, colunaTotalHoras);

                    } else if (dia.value === "6") {

                        habilitarCamposAgendamentos(horaInicioSabado, horaTerminoSabado, prepDASsab, prepASsab, labelSab);
                        ocultarCampoTotalHoras(colunaCargaHorariaETotalHorasACombinar, inputTotalHorasACombinar, inputTotalHoras, inputCargaHoraria, colunaTotalHoras);

                    } else if (dia.value === "a-combinar") {
                        
                        checkboxDiaSemana.forEach((dia, index) => {

                            if (index === 0) {

                                desabilitarCamposAgendamentos(horaInicioSegunda, horaTerminoSegunda, prepDASseg, prepASseg, inputHIseg, inputHTseg, labelSeg, dia);
                                
                            } else if (index === 1) {

                                desabilitarCamposAgendamentos(horaInicioTerca, horaTerminoTerca, prepDASter, prepASter, inputHIter, inputHTter, labelTer, dia);

                            } else if (index === 2) {

                                desabilitarCamposAgendamentos(horaInicioQuarta, horaTerminoQuarta, prepDASqua, prepASqua, inputHIqua, inputHTqua, labelQua, dia);

                            } else if (index === 3) {

                                desabilitarCamposAgendamentos(horaInicioQuinta, horaTerminoQuinta, prepDASqui, prepASqui, inputHIqui, inputHTqui, labelQui, dia);

                            } else if (index === 4) {

                                desabilitarCamposAgendamentos(horaInicioSexta, horaTerminoSexta, prepDASsex, prepASsex, inputHIsex, inputHTsex, labelSex, dia);

                            } else if (index === 5) {

                                desabilitarCamposAgendamentos(horaInicioSabado, horaTerminoSabado, prepDASsab, prepASsab, inputHIsab, inputHTsab, labelSab, dia);
                            
                            } else if (index === 6) {

                                mostrarCampoTotalHoras(colunaCargaHorariaETotalHorasACombinar, inputTotalHoras, inputCargaHoraria);
                            }
                           
                        });
                    }

                } else {
                    
                    const msgAlertaHoraAgendamento = doc.querySelectorAll("[data-msg-alerta-hora-agendamento]");

                    if (dia.value === "1") {

                        desabilitarCamposAgendamentos(horaInicioSegunda, horaTerminoSegunda, prepDASseg, prepASseg, inputHIseg, inputHTseg, labelSeg);
                        ocultarMsgAlertaHorasAgendamento(msgAlertaHoraAgendamento, 0);
                        
                    } else if (dia.value === "2") {
                        
                        desabilitarCamposAgendamentos(horaInicioTerca, horaTerminoTerca, prepDASter, prepASter, inputHIter, inputHTter, labelTer);
                        ocultarMsgAlertaHorasAgendamento(msgAlertaHoraAgendamento, 1);
                        
                    } else if (dia.value === "3") {

                        desabilitarCamposAgendamentos(horaInicioQuarta, horaTerminoQuarta, prepDASqua, prepASqua, inputHIqua, inputHTqua, labelQua);
                        ocultarMsgAlertaHorasAgendamento(msgAlertaHoraAgendamento, 2);
                        
                    } else if (dia.value === "4") {

                        desabilitarCamposAgendamentos(horaInicioQuinta, horaTerminoQuinta, prepDASqui, prepASqui, inputHIqui, inputHTqui, labelQui);
                        ocultarMsgAlertaHorasAgendamento(msgAlertaHoraAgendamento, 3);
                        
                    } else if (dia.value === "5") {

                        desabilitarCamposAgendamentos(horaInicioSexta, horaTerminoSexta, prepDASsex, prepASsex, inputHIsex, inputHTsex, labelSex);
                        ocultarMsgAlertaHorasAgendamento(msgAlertaHoraAgendamento, 4);
                        
                    } else if (dia.value === "6") {

                        desabilitarCamposAgendamentos(horaInicioSabado, horaTerminoSabado, prepDASsab, prepASsab, inputHIsab, inputHTsab, labelSab);
                        ocultarMsgAlertaHorasAgendamento(msgAlertaHoraAgendamento, 5);
                    
                    } else if (dia.value === "a-combinar") {

                        ocultarMsgAlertaHorasAgendamento(msgAlertaHoraAgendamento, 6);
                        ocultarCampoTotalHoras(colunaCargaHorariaETotalHorasACombinar, inputTotalHorasACombinar, inputTotalHoras, inputCargaHoraria, colunaTotalHoras);
                    }
                }
            });

        });
    })();

    const habilitarCamposAgendamentos = (horaInicio, horaTermino, prepAS, prepDAS, labelDia) => {
        
        if(doc.getElementById("checkbox-a-combinar")){
            doc.getElementById("checkbox-a-combinar").checked = false;
        }
        horaInicio.style.display  = "block";
        horaTermino.style.display = "block";
        prepAS.style.display      = "block";
        prepDAS.style.display     = "block";
        labelDia.classList.remove("text-white");
        labelDia.classList.add("text-dark");

    };

    const desabilitarCamposAgendamentos = (horaInicio, horaTermino, prepAS, prepDAS, inputHI, inputHT, labelDia, checkboxDia) => {
        
        horaInicio.style.display  = "none";
        horaTermino.style.display = "none";
        prepAS.style.display      = "none";
        prepDAS.style.display     = "none";
        inputHI.value             = "";
        inputHT.value             = "";
        inputHI.classList.remove("is-valid");
        inputHI.classList.remove("is-invalid");
        inputHI.classList.add("campo-obrigatorio");
        inputHT.classList.remove("is-valid");
        inputHT.classList.remove("is-invalid");
        inputHT.classList.add("campo-obrigatorio");
        labelDia.classList.remove("text-dark");
        labelDia.classList.add("text-white");
        checkboxDia !== undefined ? checkboxDia.checked = false : null;
    };
    
    const ocultarMsgAlertaHorasAgendamento = (msgAlertaHoraAgendamento, index) => {
        
        msgAlertaHoraAgendamento[index].value = "";
        msgAlertaHoraAgendamento[index].style.display = "none";
        
    };
    
    const mostrarCampoTotalHoras = (colunaCargaHorariaETotalHorasACombinar, inputTotalHoras, inputCargaHoraria) => {
       
        if( colunaCargaHorariaETotalHorasACombinar && 
            inputTotalHoras && 
            inputCargaHoraria)
        {
            colunaCargaHorariaETotalHorasACombinar.classList.remove("invisible");
            
            inputTotalHoras.value = "";
            inputCargaHoraria.value = "00:00";
        
            win.calcularValorTotal();
        }
        

    };
    
    const ocultarCampoTotalHoras = (colunaCargaHorariaETotalHorasACombinar, inputTotalHorasACombinar, inputTotalHoras, inputCargaHoraria, colunaTotalHoras) => {
        
        if( colunaCargaHorariaETotalHorasACombinar && 
            inputTotalHorasACombinar &&
            inputTotalHoras && 
            inputCargaHoraria && 
            colunaTotalHoras)
        {    
            colunaCargaHorariaETotalHorasACombinar.classList.add("invisible");
        
        
            inputTotalHorasACombinar.classList.remove("is-invalid");
            inputTotalHorasACombinar.classList.remove("is-valid");
            inputTotalHorasACombinar.classList.add("campo-obrigatorio");
            inputTotalHorasACombinar.value = "";

            colunaTotalHoras.classList.add("invisible");
            inputTotalHoras.value = "";
            inputCargaHoraria.value = "00:00";
        }
    };

})(document, window);


