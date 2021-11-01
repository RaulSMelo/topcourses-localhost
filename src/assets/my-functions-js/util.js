((doc, win) => {
    "use strict";
    (win.verificarCamposObrigatorios = () => {

        const camposObrigatorios = doc.querySelectorAll(".campo-obrigatorio");

        camposObrigatorios.forEach((campo) =>
            campo.addEventListener("change", () => {
                if (campo.offsetParent != null) {
                    let msgErro = doc.getElementById("msg-erro-" + campo.id);

                    if (campo.value != "") {
                        campo.classList.remove("campo-obrigatorio");
                        campo.classList.remove("is-invalid");
                        campo.classList.add("is-valid");
                        msgErro.classList.add("invisible");
                    } else {
                        campo.classList.remove("is-valid");
                        campo.classList.add("campo-obrigatorio");
                    }
                }
            })
        );
    })();

    (win.verificarCamposNaoObrigatorios = () => {

        const camposNaoObrigatorios = doc.querySelectorAll(".bg-components-form");

        camposNaoObrigatorios.forEach((campo) =>
            campo.addEventListener("change", () => {
                if (campo.value != "") {
                    campo.classList.remove("bg-components-form");
                    campo.classList.add("is-valid");
                } else {
                    campo.classList.remove("is-valid");
                    campo.classList.add("bg-components-form");
                }
            })
        );
    })();

    win.calcularCargaHoraria = (camposHoraInicio, camposHoraTermino) => {

        const campoDataInicio    = doc.getElementById("data-inicio");
        const campoDataFinal     = doc.getElementById("data-final");
        const coluna_total_horas = doc.getElementById("col-total-horas");
        const inputTotalHoras    = doc.getElementById("total-horas");
        const campoCargaHoraria  = doc.getElementById("carga-horaria");
        const valorHoraAula      = doc.getElementById("valor-hora-aula");
        const valorTotal         = doc.getElementById("valor-total");
        const valorParcela       = doc.getElementById("valor-parcela");
        const qtdeParcelas        = doc.getElementById("qtde-parcelas");
        const valorEntrada       = doc.getElementById("valor-entrada");
        
        let cargaHoraria = 0;
        let totalDeHorasDoPeriodo = 0;
        let diasChecadosComAsDatasPreenchidas = [];
        
        if(campoDataInicio.value !== "" && campoDataFinal.value !== ""){
            
            const dataInicio = new Date(campoDataInicio.value);
            const dataFinal  = new Date(campoDataFinal.value);

            for (let i = 0; i < camposHoraInicio.length; i++) {

                if (camposHoraInicio[i].value !== "" && camposHoraTermino[i].value !== "") {

                    let hr_ini_min = camposHoraInicio[i].value.toString().split(":");
                    let hr_fim_min = camposHoraTermino[i].value.toString().split(":");

                    if (hr_fim_min.length === 2 && hr_ini_min.length === 2) {

                        let total_min_hrIni = parseInt(hr_ini_min[0] * 60 + parseInt(hr_ini_min[1]));
                        let total_min_hrFim = parseInt(hr_fim_min[0] * 60 + parseInt(hr_fim_min[1]));

                        diasChecadosComAsDatasPreenchidas.push({num_dia_semana: i, minutos: (total_min_hrFim - total_min_hrIni)});

                        if (total_min_hrIni < total_min_hrFim) {

                            cargaHoraria += (total_min_hrFim - total_min_hrIni);

                        }
                    }
                }
            }
                
            
            if(diasChecadosComAsDatasPreenchidas.length > 0){

                for(let i = 1; dataInicio <= dataFinal; i++){

                    for (let diaAgendado of diasChecadosComAsDatasPreenchidas){

                        if(diaAgendado.num_dia_semana === dataInicio.getDay()){

                            totalDeHorasDoPeriodo += parseInt(diaAgendado.minutos);

                        }
                    }

                    dataInicio.setDate(dataInicio.getDate() + 1);

                }
            }
        }
        
        if(totalDeHorasDoPeriodo > 0){
            
            coluna_total_horas.classList.remove("invisible");
            inputTotalHoras.value = (totalDeHorasDoPeriodo / 60).toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});
            
            if(win.dispararCalculoValorTotal(inputTotalHoras.value, valorHoraAula.value)){
                
                let novoValorTotal = parseFloat(win.dispararCalculoValorTotal(inputTotalHoras.value, valorHoraAula.value));
                
                valorTotal.value = novoValorTotal.toLocaleString('pt-br',{style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});
                
                win.calcularValorParcela(valorTotal.value, qtdeParcelas.value, valorParcela, valorEntrada.value);
            }
            
        }else{
            
            coluna_total_horas.classList.add("invisible");
            inputTotalHoras.value = "";
        }
        
        campoCargaHoraria.value = retornaSomaDaCargaHorariaEmFormatoHoras(cargaHoraria);

    };

    const retornaSomaDaCargaHorariaEmFormatoHoras = (cargaHoraria) => {

        let time = "00:00";

        if (cargaHoraria) {

            let horas = Math.trunc(cargaHoraria / 60);
            let minutos = cargaHoraria % 60;

            time = horas.toString().padStart(2, "0") + ":" + minutos.toString().padStart(2, "0");
        }

        return time;
    };

    (win.verificarCheckboxAgendamento = () => {

        const checkboxDiaSemana = doc.getElementsByName("dia-semana[]");
        const campoCargaHoraria = doc.getElementById("carga-horaria");

        if (checkboxDiaSemana !== null) {

            const msgAlertaAgendamento = doc.getElementById("msg-alerta-hora-agendamento");
            const diasSemanaChecado = [];

            checkboxDiaSemana.forEach((dia, i) => dia.addEventListener("change", () => {
                    
                const camposHoraInicio = doc.getElementsByName("hora-inicio[]");
                const camposHoraTermino = doc.getElementsByName("hora-termino[]");

                for (let checkDia of checkboxDiaSemana) {

                    if (checkDia.checked) {

                        diasSemanaChecado.push(checkDia.value);
                        verificarCamposObrigatorios();

                    }

                    if (diasSemanaChecado.length === 1) {

                        camposHoraInicio.forEach(hrIni => hrIni.addEventListener("blur", () => {

                            calcularCargaHoraria(camposHoraInicio, camposHoraTermino);
                            
                        }));

                        camposHoraTermino.forEach(hrTer => hrTer.addEventListener("blur", () => {

                            calcularCargaHoraria(camposHoraInicio, camposHoraTermino);
                            
                        }));

                    }
                }
                 
                calcularCargaHoraria(camposHoraInicio, camposHoraTermino); 

                if (diasSemanaChecado.length === 0) {

                    msgAlertaAgendamento.innerHTML = "";
                    msgAlertaAgendamento.innerHTML = "Selecionar pelo uma opção do campo agendamento";
                    msgAlertaAgendamento.style.display = "block";

                } else {

                    msgAlertaAgendamento.innerHTML = "";
                    msgAlertaAgendamento.style.display = "none";
                }

            }));
        }

    })();


    (win.verificarCamposAlterar = () => {

        const camposAlterar = doc.querySelectorAll(".is-valid");

        camposAlterar.forEach((campo) =>
            campo.addEventListener("change", () => {
                if (campo.offsetParent != null) {
                    if (campo.value == "" && campo.classList.contains("obr")) {
                        campo.classList.remove("is-valid");
                        campo.classList.add("campo-obrigatorio");
                        verificarCamposObrigatorios();
                    } else if (campo.value == "" && campo.classList.contains("nao-obr")) {
                        campo.classList.remove("is-valid");
                        campo.classList.add("bg-components-form");
                        verificarCamposNaoObrigatorios();
                    }
                }
            })
        );
    })();


    (win.verificarCamposObrigatoriosModal = () => {

        const camposObrigatorios = doc.querySelectorAll(".campo-obrigatorio-modal");

        camposObrigatorios.forEach((campo) =>
            campo.addEventListener("change", () => {

                if (campo.offsetParent != null) {

                    let msgErro = doc.getElementById("msg-erro-" + campo.id);

                    if (campo.value != "") {
                        campo.classList.remove("campo-obrigatorio-modal");
                        campo.classList.remove("is-invalid");
                        campo.classList.add("is-valid");
                        msgErro.classList.add("invisible");
                    } else {
                        campo.classList.remove("is-valid");
                        campo.classList.add("campo-obrigatorio-modal");
                    }
                }
            })
        );
    })();



    win.maskTelefone = (tel) => {

        if (tel !== "") {

            return tel.substring(0, 2) + " " + tel.substring(2, 7) + "-" + tel.substring(7, 11);
        }

        return "";
    };

    win.maskCPF = (cpf) => {

        if (cpf !== "") {

            return cpf.substring(0, 3) + "." + cpf.substring(3, 6) + "." + cpf.substring(6, 9) + "-" + cpf.substring(9, 11);
        }

        return "";
    };

})(document, window);
