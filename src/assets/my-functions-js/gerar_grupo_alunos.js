((win, doc) => {
"use strict";
    
    const pegarCamposGrupoAlunos = () => {

        const linhas = doc.querySelectorAll("[data-grupo-alunos]");

        return linhas;
        
    };
    
    const normalizarCamposGrupoAluno = (linhaNovoAluno) => {

        const index = pegarCamposGrupoAlunos().length - 1;
        const id    = index + 1;
        
        const inputIdAluno      = doc.getElementsByName("id-aluno[]")[index];
        const inputCPF          = doc.getElementsByName("cpf[]")[index];
        const smallCPF          = doc.querySelectorAll("[data-msg-erro-cpf]")[index];
        const inputNomeCompleto = doc.getElementsByName("nome-completo[]")[index];
        const smallNomeCompleto = doc.querySelectorAll("[data-msg-erro-nome-completo]")[index];
        const btnBuscar         = doc.getElementsByName("btn-buscar[]")[index];
        const btnRemover        = doc.getElementsByName("btn-remover[]")[index];
        const msgAlertaGrupoCPFvazio     = document.getElementById("msg-alerta-grupo-cpf-vazio");

        btnRemover.addEventListener("click", () => {
            
            linhaNovoAluno[index].remove();
            
            if(inputCPF.value === "" && inputNomeCompleto.value === ""){
                
                msgAlertaGrupoCPFvazio.innerHTML     = "";
                msgAlertaGrupoCPFvazio.style.display = "none";
            }
            
        });
        
        btnBuscar.disabled = false;
        btnBuscar.setAttribute("data-index", index);
        
        inputCPF.id          = "cpf-" + id;
        smallCPF.id          = "msg-erro-cpf-" + id;
        
        inputNomeCompleto.id = "nome-completo-" + id;
        smallNomeCompleto.id = "msg-erro-nome-completo-" + id;
        
        inputIdAluno.value      = "";
        inputCPF.value          = "";
        inputNomeCompleto.value = "";
        
        inputCPF.classList.add("campo-obrigatorio");
        smallCPF.classList.add("invisible");
        
        inputNomeCompleto.classList.add("campo-obrigatorio");
        smallNomeCompleto.classList.add("invisible");

        inputCPF.classList.remove("is-invalid");
        inputCPF.classList.remove("is-valid");

        inputNomeCompleto.classList.remove("is-invalid");
        inputNomeCompleto.classList.remove("is-valid");
  

        win.verificarCamposObrigatorios();

    };

        
    const fieldsetGrupoAlunos = doc.getElementById("fieldset-grupo-alunos");
    const btnNovo             = doc.getElementById("btn-novo-aluno");

    btnNovo.addEventListener("click", () => {

        const index = pegarCamposGrupoAlunos().length -1;

        const linhaNovoAluno = pegarCamposGrupoAlunos()[index];

        fieldsetGrupoAlunos.insertAdjacentHTML("beforeend", linhaNovoAluno.outerHTML);

        normalizarCamposGrupoAluno(pegarCamposGrupoAlunos());

    });
    

})(window, document);


