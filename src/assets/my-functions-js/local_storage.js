( (win, doc) => {
"use strict";

    const capturarCamposConsultaInteressado = () => {
        
        const dataInicio = doc.getElementById("data-inicio");
        const dataFinal  = doc.getElementById("data-final");
        const nome       = doc.getElementById("nome");
        const idCurso    = doc.getElementById("curso");
        const idRevisao  = doc.getElementById("revisao");
        const idTraducao = doc.getElementById("traducao");
        const btnBuscar  = doc.getElementById("btn-buscar");
        
        return {
                dataInicio: dataInicio, 
                dataFinal:  dataFinal, 
                nome:       nome, 
                idCurso:    idCurso, 
                idTraducao: idTraducao, 
                idRevisao:  idRevisao,
                btnBuscar:  btnBuscar
            };
    };
    
    
    const colocarClasseEmCampoPreenchidos = (campos) => {
        
        if(campos.dataInicio.value != ""){
            
            campos.dataInicio.classList.remove("campo-obrigatorio");
            campos.dataInicio.classList.add("is-valid");
        }
        
        if(campos.dataFinal.value != ""){
            
            campos.dataFinal.classList.remove("campo-obrigatorio");
            campos.dataFinal.classList.add("is-valid");
        }
        
        if(campos.nome.value != ""){
            
            campos.nome.classList.remove("bg-components-form");
            campos.nome.classList.add("is-valid");
        }
        
        if(campos.idCurso.value != ""){
            
            campos.idCurso.classList.remove("bg-components-form");
            campos.idCurso.classList.add("is-valid");
        }
        
        if(campos.idTraducao.value != ""){
            
            campos.idTraducao.classList.remove("bg-components-form");
            campos.idTraducao.classList.add("is-valid");
        }
        
        if(campos.idRevisao.value != ""){
            
            campos.idRevisao.classList.remove("bg-components-form");
            campos.idRevisao.classList.add("is-valid");
        }
        
    };

    
    

    win.capturarFiltrosConsultaInteressado = (id, pagina) => {
        
        const campos = capturarCamposConsultaInteressado();
       
        localStorage.data_inicio = campos.dataInicio.value;
        localStorage.data_final  = campos.dataFinal.value;
        localStorage.nome        = campos.nome.value;
        localStorage.id_curso    = campos.idCurso.value;
        localStorage.id_traducao = campos.idTraducao.value;
        localStorage.id_revisao  = campos.idRevisao.value;

        if(pagina == "alterar"){
            
            win.location.href = `alterar_aluno_interessado.php?cod=${id}`;
            
        }else if(pagina == "ver_mais"){
            
            win.location.href = `ver_mais_interessados.php?cod=${id}`;
        }
        
       
    };
    
    (win.manterFiltroAnteriorConsultaInteressado = () => {
        
        const filtros = capturarCamposConsultaInteressado();
        
        const dtIni  = localStorage.getItem("data_inicio");
        const dtFim  = localStorage.getItem("data_final");
        const nome   = localStorage.getItem("nome");
        const idCur  = localStorage.getItem("id_curso");
        const idTrad = localStorage.getItem("id_traducao");
        const idRev  = localStorage.getItem("id_traducao");
        
        if(dtIni !== null && dtFim !== null){
           
            filtros.dataInicio.value = dtIni;
            filtros.dataFinal.value  = dtFim;
            filtros.nome.value       = nome;
            filtros.idCurso.value    = idCur;
            filtros.idTraducao.value = idRev;
            filtros.idRevisao.value  = idTrad;
            
            colocarClasseEmCampoPreenchidos(filtros);
        
            localStorage.clear();

            filtros.btnBuscar.click();
     
        }
               
    })();
    
    
})(window, document);
