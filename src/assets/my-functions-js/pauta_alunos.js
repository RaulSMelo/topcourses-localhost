((win, doc) => {
"use strict";

    const Tds = $(".celula-anotacao");
    const btnLinks = $(".link");
    const opcoesAnotacoes = $(".opcao a");
    const menuOpcoes = $(".opcao");
    let   links = [];
    const classesCores = [];
    const textoAnotacoes = [];

    $.each(btnLinks, (index, linkDropdown) => {

        linkDropdown.addEventListener("click", () => {

            const divResponsiveTabelaMes  = linkDropdown.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
            const tabelaMes               = linkDropdown.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
            const linhaClicadaTabela      = linkDropdown.parentNode.parentNode.parentNode.parentNode;
            const alturaLinhaTabela       = linhaClicadaTabela.offsetHeight;
            const alturaTabelaMes         = tabelaMes.offsetHeight;
            const alturarMenuDropdown     = 230;
            const itensMenuDropdown       = linkDropdown.parentNode.children[1].children;
            const coordenadasLinhaTabela  = linhaClicadaTabela.offsetTop;;
            const diferencaTopo           = alturaTabelaMes - (coordenadasLinhaTabela  + alturaLinhaTabela);

            if(!$(itensMenuDropdown).is(":visible") || itensMenuDropdown.length !== 0){

                if(!(alturarMenuDropdown - diferencaTopo) <= 50){
                    
                    divResponsiveTabelaMes.style.height = alturaTabelaMes + (alturarMenuDropdown - diferencaTopo) + "px";
                }

            }else{
                
                divResponsiveTabelaMes.removeAttribute("style");
            }

        });

    });

    const body = document.querySelector("body");

    body.addEventListener("click", (evt) => {

        const classe = evt.target;

        if( !(classe.classList.contains("link"))){

            const divTabela = document.querySelectorAll("[data-meses]");

            divTabela.forEach(div => {
                div.removeAttribute("style");
            });
        }

    },true);


    /**
     * Itera o total de td(celula) da tabela pauta de alunos
     * Adiciona classe uma classe (link- i) adcional para controlar o elemento
     * Adiciona um id diferente para cada menu de opções
     */
    for(let i = 0; i < Tds.length; i++){
        //btnLinks[i].classList.add("link-" + i); //foi alterar 09/05/2021
        $(menuOpcoes[i]).attr("id" , i);
    }

    /**
     * Atribui para o array(links) os elementos link(a) do primeiro elemento (div) de opções
     */
    $(".celula-anotacao ul li div").each(function (){
        links = $(this).children();
    });

    /**
     * Armazena o total de opções de anotações (links)
     * @type {number}
     */
    const totalOpcoes = links.length;

    /**
     * Atribui a variavel array(classesCores) as classes dos link respectivos
     * Atribui a variavel array(textoAnotações) os textos(value) links respectivo
     */
    for(let i = 0; i < links.length; i++){
        classesCores.push(links[i].className.toString().replaceAll(/dropdown-item /g, ""));
        textoAnotacoes.push(links[i].innerHTML);
    }

    /**
     * Iterando a variável array(opcoesAnotaçoes) e colocando o evento "click" para cada opção de anotação
     */
    $.each(opcoesAnotacoes, (index, opcao) => {

        opcao.addEventListener("click", (e) => {
            e.preventDefault();

            let idOpcao = $(opcao).attr("data-id");
            
            anotar(index, idOpcao);

            const divMes = opcao.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;

            divMes.removeAttribute("style");

        });
    });

    function anotar(index, idOpcao) {

        let totalCelulas = opcoesAnotacoes.length / links.length;
        let exit = false;
        
        for(let i = 1; i <= totalCelulas; i++){
            
            for(let j = 0; j < i * totalCelulas; j++){
                
                if(index >= (i * links.length - links.length) && index < (i * links.length))
                {
                    if(btnLinks[i-1].className.toString().indexOf("bg-") > -1){
                        
                        let cores = btnLinks[i-1].className.toString().split(" ");
                        $(btnLinks[i-1]).removeClass(cores[2]);
                        
                    }

                    if(parseInt(idOpcao) === (totalOpcoes -1)){
                        
                        $(btnLinks[i-1]).html(`<i class="fas fa-chevron-down"></i>`);
                        $(btnLinks[i-1]).addClass("bg-dark");
                        
                        
                    }else{
                        
                        $(btnLinks[i-1]).html(textoAnotacoes[idOpcao]);
                        $(btnLinks[i-1]).addClass(classesCores[idOpcao]);
                        
                    }

                    exit = true;
                    
                    break;
                }
            }

            if(exit) break;
            
        }
    }
    
    (win.gravarAnotacoesDoprofessor = () => {
        
        const dropdownItem = doc.querySelectorAll(".dropdown-item");
        
        dropdownItem.forEach(item => { 
            
            item.addEventListener("click", () => {
            
                const idAluno           = item.parentNode.parentNode.parentNode.parentNode.parentNode.children[0].children[0];
                const idContrato        = doc.getElementById("id-contrato");
                const anotacaoProfessor = item.dataset.id;
                const idAgendamento     = doc.getElementsByName("id-agendamento");
                const idPautaAluno      = item.parentNode.parentNode.children[0];
                const dropdownMenu      = item.parentNode.parentNode.children[1];
                const msgAlerta         = doc.getElementById("msg-alerta-pauta-aluno");
                
                
                $.ajax({
                    
                    url: "../../ajax/inserir_anotacao_professor.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_aluno:           idAluno.value,
                        id_contrato:        idContrato.value,
                        anotacao_professor: anotacaoProfessor,
                        id_pauta_aluno:     idPautaAluno.value,
                        id_agendamento:     idAgendamento[item.parentNode.id].value
                    },
                    
                    success: (response) => {
                        
                        if(response.msg_error){
                            
                            msgAlerta.classList.remove("invisible");
                            msgAlerta.innerHTML = response.msg_error;
                            
                        }else if(response.ret){
                             
                            const inputIdPautaAluno = document.createElement("input");
                            const li = item.parentNode.parentNode;
                            const tag_a_dropdown = item.parentNode.parentNode.children[0];

                            inputIdPautaAluno.setAttribute("type", "hidden");
                            inputIdPautaAluno.setAttribute("name", "id-pauta-aluno");
                            inputIdPautaAluno.setAttribute("value", response.ret);

                            li.insertBefore(inputIdPautaAluno, tag_a_dropdown);
                        }
                            
                        msgAlerta.classList.add("invisible");
                        msgAlerta.innerHTML = "";
                        
                    },
                    
                    error: (XMLHttpRequest) => {

                        console.log(XMLHttpRequest.responseText);
                    }
                
                });
            });
        });
        
    })();
    
    (win.salvarEalterarAnotacoesDasAula = () => {

        const btnAnotacoesAulas = doc.querySelectorAll("[data-acao]");
        
        btnAnotacoesAulas.forEach(btn => btn.addEventListener("click", () => {

            const idAnotacaoAula  = btn.parentNode.parentNode.children[1].children[0];
            const idAgendamento   = btn.parentNode.parentNode.children[1].children[1];
            const anotacaoAula    = btn.parentNode.parentNode.children[1].children[2];
            const msgAlerta       = btn.parentNode.parentNode.children[1].children[3];
            const links = linkifyHtml(anotacaoAula.innerHTML.trim(), {
                defaultProtocol: "https"
            });

            anotacaoAula.innerHTML = links;

            doc.querySelectorAll(".linkified").forEach(link => link.setAttribute("contenteditable", false));

            if(btn.dataset.acao === "alterar"){

                $.ajax({

                    url: "../../ajax/inserir_anotacoes_da_aula.php",
                    method: "POST",
                    dataType: "json",
                    data: {

                        id_anotacao_aula: idAnotacaoAula.value,
                        id_agendamento:   idAgendamento.value,
                        anotacao_aula:    anotacaoAula.innerHTML
                    },

                    success: (response) => {

                        if(response.ret === -1){
                            
                            msgAlerta.classList.remove("invisible");
                            msgAlerta.innerHTML = response.msg_error;

                        }else{
                                
                            btn.classList.remove("btn-success");
                            btn.classList.add("btn-warning");
                            btn.innerHTML = "<i class='fas fa-pencil-alt mr-1'></i> Alterar";

                            msgAlerta.classList.add("invisible");
                            msgAlerta.innerHTML = "";
                        }
                    },

                    error: (XMLHttpRequest) => {

                        console.log(XMLHttpRequest.responseText);

                    }
                });
                
                
            }else if(btn.dataset.acao === "salvar"){
                
                $.ajax({

                    url: "../../ajax/inserir_anotacoes_da_aula.php",
                    method: "POST",
                    dataType: "json",
                    data: {

                        id_anotacao_aula : idAnotacaoAula.value,
                        id_agendamento:    idAgendamento.value,
                        anotacao_aula:     anotacaoAula.innerHTML
                    },

                    success: (response) => {

                        if(response.ret === -1){
                            
                            msgAlerta.classList.remove("invisible");
                            msgAlerta.innerHTML = response.msg_error;

                        }else{
                            
                            idAnotacaoAula.value = response.ret;
                            
                            btn.classList.remove("btn-success");
                            btn.classList.add("btn-warning");
                            btn.innerHTML = "<i class='fas fa-pencil-alt mr-1'></i> Alterar";
                            btn.setAttribute("data-acao","alterar");
                            
                            const anotacaoAterior = anotacaoAula.value;
                            
                            anotacaoAula.addEventListener("change", () => {
                                    
                                btn.classList.remove("btn-warning");
                                btn.classList.add("btn-success");
                                btn.innerHTML = "<i class='fas fa-save mr-1'></i> Salvar";
                                btn.setAttribute("data-acao","alterar");
                                      
                            });
                            
                            msgAlerta.classList.add("invisible");
                            msgAlerta.innerHTML = "";
                        }
                    },

                    error: (XMLHttpRequest) => {

                        console.log(XMLHttpRequest.responseText);

                    }
                });
            }
            
        }));

    })();
    
    (win.pegarTextareasAnotacoesAulaPreenchidos = () => {
        
        const divAnotacoesAulas   = doc.querySelectorAll(".area-anotacoes-aula");
        
        divAnotacoesAulas.forEach(anotacao => {
            
            if(anotacao.innerHTML !== ""){

                anotacao.addEventListener("focusout", () => {
                    
                    const btn = anotacao.parentNode.parentNode.children[2].children[0];
                    
                    if(btn.dataset.acao === "alterar"){
                        
                        btn.classList.remove("btn-warning");
                        btn.classList.add("btn-success");
                        btn.innerHTML = "<i class='fas fa-save mr-1'></i> Salvar";
                    }
                    
                });
            }
            
        });
        
    })();

    (win.capturarLinksDasAnotacoesAulas = () => {

        const divAnotacoesAulas = doc.querySelectorAll(".area-anotacoes-aula");

        divAnotacoesAulas.forEach(anotacao => {

            if(anotacao.innerHTML.trim() !== ""){

                const links = linkifyHtml(anotacao.innerHTML.trim(), {
                    defaultProtocol: "https"
                });

                anotacao.innerHTML = links;
            }
        })

        doc.querySelectorAll(".linkified").forEach(link => link.setAttribute("contenteditable", false));

    })();

    win.buscarDadosDoAlunoPauta = (evt) => {
        
        let id = evt.target.dataset.id;
        
        if(id){
            
            $.ajax({
                
                url: "../../ajax/buscar_dados_aluno_pauta.php",
                method: "POST",
                dataType: "json",
                data: {
                    id_aluno_pauta: id
                },

                success: function (response) {
                    
                    const msgAlertaModalDadosAluno = doc.getElementById("msg-alerta-modal-dados-aluno-pauta");
                    const inputNomeCompleto        = doc.getElementById("nome-modal");
                    const inputEmail               = doc.getElementById("email-modal");
                    const inputTelefone            = doc.getElementById("telefone-modal");
                    const inputDataNascimento      = doc.getElementById("data-nascimento-modal");
                    const inputProfissao           = doc.getElementById("profissao-modal");
                    
                    if(response.ret === -1){
                        
                        msgAlertaModalDadosAluno.innerHTML = "Não foi possivel carregar os dados do aluno";
                        msgAlertaModalDadosAluno.classList.remove("invisible");
                        
                    }else{
                        
                        msgAlertaModalDadosAluno.classList.add("invisible");
                        msgAlertaModalDadosAluno.innerHTML = "";
                        
                        inputNomeCompleto.value   = response.nome + " " + response.sobrenome;
                        inputEmail.value          = response.email;
                        inputTelefone.value       = win.maskTelefone(response.telefone);
                        inputDataNascimento.value = response.data_nascimento;
                        inputProfissao.value      = response.profissao;
                    }
                        
                    
                },

                error: function (XMLHttpRequest) {

                    console.log(XMLHttpRequest.responseText);
                }
                
            });
        }   
    };

})(window, document);