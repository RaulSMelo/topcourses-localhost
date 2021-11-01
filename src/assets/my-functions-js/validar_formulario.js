((doc, win) => {
  
  
  win.validarFormulario = (evt) => {
    
    let send = true;

    if (evt !== undefined) {
        const form = evt.target.dataset.form;

        if (form == "cadastrar-interessado") {
           send = validarAreaInteresse();
        }
    }
    
    const campoMultSelect = doc.querySelectorAll("span.multiselect-native-select div.btn-group button.multiselect");
    
    if(campoMultSelect.length > 0){
        
        if(campoMultSelect[0] !== null){

            if(campoMultSelect[0].classList.contains("campo-obrigatorio")){

                campoMultSelect[0].classList.remove("campo-obrigatorio");
                campoMultSelect[0].classList.add("is-invalid");
                send = false;
            }
        }
    }
    
    const camposObrigatorios = doc.querySelectorAll(".campo-obrigatorio");
    const camposObrigatoriosVisiveis = [];
    const camposJaVerificadosInvalidos = doc.querySelectorAll(".is-invalid");
    const checkboxDiaSemana = doc.getElementsByName("dia-semana[]");
    const diasSemanaChecado = [];
    
    if(checkboxDiaSemana.length > 0){
        
        const msgAlertaAgendamento = doc.getElementById("msg-alerta-hora-agendamento");
        
        checkboxDiaSemana.forEach(dia => {
            
            if(dia.checked){
                diasSemanaChecado.push(dia.value);
            }
            
        });
        
        if(diasSemanaChecado.length === 0){
            
            msgAlertaAgendamento.innerHTML = "";
            msgAlertaAgendamento.innerHTML = "Selecione pelo menos uma opção do campo agendamento";
            msgAlertaAgendamento.style.display = "block";
            
            send = false;
            
        }else{
            
            msgAlertaAgendamento.innerHTML = "";
            msgAlertaAgendamento.style.display = "none";
        }     
            
    }

    if (camposJaVerificadosInvalidos.length > 0) {
      send = false;
    }

    camposObrigatorios.forEach((campo) => {
      if (campo.offsetParent !== null) {
        camposObrigatoriosVisiveis.push(campo);
      }
    });

    camposObrigatoriosVisiveis.forEach((campo) => {
      if (campo.offsetParent !== null) {
        let msgErro = doc.getElementById("msg-erro-" + campo.id);

        if (campo.value == "") {
          campo.classList.remove("campo-obrigatorio");
          campo.classList.add("is-invalid");
          campo.placeholder = msgErro.innerText;

          //msgErro.classList.remove("invisible")

          send = false;
          
        } else {
          campo.classList.remove("is-invalid");
          campo.classList.add("is-valid");
          msgErro.classList.add("invisible");
        }
      }
    });

    return send;
  };

  win.validarAreaInteresse = () => {
    const opcoesAreaInteresse = doc.getElementsByName("opcao-area-interesse[]");

    if (opcoesAreaInteresse.length != 0) {
      let opcoesChecadas = 0;
      const fieldsetAreaInteresseInteressados = doc.querySelector("fieldset#area-interesse-interessados");
      let msgErro = doc.getElementById("msg-erro-area-interesse-interessados");

      opcoesAreaInteresse.forEach((opcao) => {
        if (!opcao.checked) {
          opcoesChecadas++;
        }
      });

      if (opcoesChecadas == opcoesAreaInteresse.length) {
        msgErro.classList.remove("invisible");
        fieldsetAreaInteresseInteressados.classList.add("border");
        fieldsetAreaInteresseInteressados.classList.add("border-danger");
        return false;
      } else {
        msgErro.classList.add("invisible");
        fieldsetAreaInteresseInteressados.classList.remove("border");
        fieldsetAreaInteresseInteressados.classList.remove("border-danger");
      }

      return true;
    }
  };

  win.validarCamposModal = () => {
     
    
    let send = true;

    const campoModal = doc.querySelectorAll(".campo-obrigatorio-modal");

    campoModal.forEach((campo) => {
        
      if (campo.offsetParent != null) {
          
        let msgErro = doc.getElementById("msg-erro-" + campo.id);

        if (campo.value == "") {
  
          campo.classList.remove("campo-obrigatorio-modal");
          campo.classList.add("is-invalid");
          campo.placeholder = msgErro.innerText;

          send = false;
          
        } else {
          campo.classList.remove("is-invalid");
          campo.classList.add("is-valid");
          msgErro.classList.add("invisible");
        }
      }
    });
    
    return send;
  };
  
})(document, window);
