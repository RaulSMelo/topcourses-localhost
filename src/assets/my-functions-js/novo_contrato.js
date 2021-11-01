( (doc, win) => {
"use strict";

 
    const tipoContrato    = doc.getElementsByName("tipo-contrato");
    const contratoCurso   = doc.getElementById("contrato-curso");
    const exibirContrato  = doc.getElementById("exibir-contrato");
    const idAluno         = doc.getElementById("id-aluno").value;
    const dataAgendamento = doc.getElementById("data-agendamento").value;
    const cpf             = doc.getElementById("cpf-aluno").value;
    const nomeCompleto    = doc.getElementById("nome-completo").value;

    tipoContrato.forEach(opcaoContrato => {
        
        opcaoContrato.addEventListener("change", () => {

            if(opcaoContrato.checked){
                
                if(opcaoContrato.value === "contrato-curso"){
                    
                    doc.getElementById("select-contrato-pf").value = "";
                    doc.getElementById("select-contrato-pj").value = "";
                    doc.getElementById("select-contrato-pf").classList.remove("is-valid");
                    doc.getElementById("select-contrato-pf").classList.add("campo-obrigatorio");
                    doc.getElementById("select-contrato-pj").classList.remove("is-valid");
                    doc.getElementById("select-contrato-pj").classList.add("campo-obrigatorio");
                    contratoCurso.style.display = "block";
                    
                    exibirContrato.innerHTML = "";
                    
                    rolarParaTopo(contratoCurso.id);
                    
                }else{
                    
                    contratoCurso.style.display = "none";
                    
                    retornarTipoContratoViaAjax(opcaoContrato.value, idAluno, cpf, nomeCompleto);
                    
                    rolarParaTopo(exibirContrato.id);
                    
                }
            }else{
                
                retornarTipoContratoViaAjax(opcaoContrato.value, idAluno, cpf, nomeCompleto);
                
            }
            
        });
    });
    
    
    const retornarTipoContratoViaAjax = (idTipoContrato, idAluno, cpf, nomeCompleto) => {
        
         
        if(idTipoContrato !== "" && !isNaN(idTipoContrato)){
            
            const contrato_grupo = (
                    
                    idTipoContrato === "3" || 
                    idTipoContrato === "4" ||
                    idTipoContrato === "8" ||
                    idTipoContrato === "9" ||
                    idTipoContrato === "10"
                );
            
            $.ajax({
                
                url: "tipo_contrato.php",
                method: "POST",
                data: {
                    tipo_contrato:    idTipoContrato,
                    id_aluno:         idAluno,
                    data_agendamento: dataAgendamento,
                    cpf_aluno:        cpf,
                    nome_completo:    nomeCompleto
                },
                
                success: (response) => {
                    
                    exibirContrato.innerHTML = "";
                    exibirContrato.innerHTML = response;
                    rolarParaTopo(exibirContrato.id);
                    $.getScript("../../assets/my-functions-js/agendamento.js");
                    $.getScript("../../assets/my-functions-js/util.js");
                    $.getScript("../../assets/my-functions-js/mascaras.js");
                    $.getScript("../../assets/my-functions-js/ajax.js");
                    $.getScript("../../assets/my-functions-js/validacoes_campos_contratos.js");
                    $.getScript("../../assets/my-functions-js/validar_cpf_cnpj_cep.js");
                    $.getScript("../../assets/vendor/big-decimal/js-big-decimal.min.js");

                    if(contrato_grupo){
                        
                        $.getScript("../../assets/my-functions-js/gerar_grupo_alunos.js");
                        
                    }
                },
                
                error: (XMLHttpRequest) => {
                    
                    console.log(XMLHttpRequest.responseText);
                }
            });
               
        }
            
    };
   

    const tiposClientes     = doc.getElementsByName("tipo-cliente[]");
    const divSelectOpcoesPF = doc.getElementById("select-pf");
    const divSelectOpcoesPJ = doc.getElementById("select-pj");
    const selectPF          = doc.getElementById("select-contrato-pf");
    const selectPJ          = doc.getElementById("select-contrato-pj");

    tiposClientes.forEach(tipo => {
        
        tipo.addEventListener("change", () => {
            
            if(tipo.checked){

                if(tipo.value === "pf"){

                    divSelectOpcoesPF.style.display = "block";
                    divSelectOpcoesPJ.style.display = "none";
                    selectPJ.value = "";
                    selectPJ.classList.remove("is-valid");
                    selectPJ.classList.add("campo-obrigatorio");

                }else if(tipo.value === "pj"){

                    divSelectOpcoesPJ.style.display = "block";
                    divSelectOpcoesPF.style.display = "none";
                    selectPF.value = "";
                    selectPF.classList.remove("is-valid");
                    selectPF.classList.add("campo-obrigatorio");
                       
                }
            }
        });
    });


    
    const rolarParaTopo = (id) => {
        
        const element = doc.getElementById(id);
        
        let rolarPara = "";

        rolarPara = element.offsetTop - 100;
 
        win.scroll({
            top: rolarPara,
            behavior: "smooth"

        });   
    };
   

})(document, window);