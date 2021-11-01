( (doc, win) => {
"use strict"



    const arrayCNPJ         = doc.getElementsByName("cnpj")
    const arrayCPF          = doc.getElementsByName("cpf")
    const CPFsContratoCurso = doc.getElementsByName("cpf[]")


    /************************************************************
    **************** FUNÇÃO QUE VALIDA O CPF *******************
    *************************************************************/
    win.validarCPF = (cpf) =>  {


        if(cpf.value !== "" && cpf.value.length == 14){

            const numSemMask = cpf.value.replace(/[.-]/g, "")  // Elimina os (pontos e traços) ficando somente números
            const charArray = numSemMask.substring( 0 , numSemMask.length - 2) // Captura os 9 primeiros digitos
            const digitoRecupUsuario1 = parseInt(numSemMask.substring(9,10)) // Captura o 10° digito digitado pelo usuário
            const digitoRecupUsuario2 = parseInt(numSemMask.substring(10,11)) // Captura o 11° digito digitado pelo usuário
            let   sumDigitoVerificador1 = 0  // Variável que ira guardar soma para encontrar o 1° digito verificador
            let   sumDigitoVerificador2 = 0  // Variável que ira guardar soma para encontrar o 2° digito verificador
            let   digitoVerificador1 = 0  // Variável que ira guardar o 1° digito verificador
            let   digitoVerificador2 = 0  // Variável que ira guardar o 2° digito verificador
            let   j = 1

            //Chama a função que verifica se o usuário digitou todos os números iguais
            if (verificaDigitosRepetidos(numSemMask)){

                /*Loop que ira percorrer os 9 digitos iniciais*/
                for(let i = charArray.length - 1; i >= 0 ; i--, j++){

                    sumDigitoVerificador1 += parseInt(charArray[i]) * (i+1)

                    if( i !== 0){
                        sumDigitoVerificador2 += parseInt(charArray[j]) * j
                    }else{

                        digitoVerificador1 = sumDigitoVerificador1 % 11

                        if(digitoVerificador1 > 9){
                            digitoVerificador1 = 0
                        }
                        sumDigitoVerificador2 += digitoVerificador1 * j
                        digitoVerificador2 = sumDigitoVerificador2 % 11

                        if(digitoVerificador2 > 9){
                            digitoVerificador2 = 0
                        }
                    }
                }

                if(digitoRecupUsuario1 !== digitoVerificador1 ||
                    digitoRecupUsuario2 !== digitoVerificador2 ){

                    cpf.classList.remove("is-valid")
                    cpf.classList.add("is-invalid")

                }else{
                    cpf.classList.remove("is-invalid")
                    cpf.classList.add("is-valid")
                }

            }else{
                cpf.classList.add("is-invalid")
                cpf.classList.remove("is-valid")
            }

        }else if (cpf.value !== "" && cpf.value.length < 14){
            cpf.classList.remove("bg-components-form")
            cpf.classList.remove("is-valid")
            cpf.classList.add("is-invalid")
        }else{
            cpf.classList.remove("is-valid")
            cpf.classList.remove("is-invalid")
            cpf.classList.add("bg-components-form")
        }

        /* Verifica se o usuário digitou todos os dígitos iguais
        * ex: 111-111-111-11 retorna false*/
        function verificaDigitosRepetidos(numDigitadosPelousuario){

            for(let i = 1; i < numDigitadosPelousuario.length; i++){
                if (numDigitadosPelousuario[0] !== numDigitadosPelousuario[i] ){
                    return true;
                }
            }
            return false;
        }
    }


    /************************************************************
     **************** FUNÇÃO QUE VALIDA O CNPJ ******************
     ************************************************************/
    win.validarCNPJ = (cnpj) =>  {

        if(cnpj.value !== "" && cnpj.value.length == 18){

            const numSemMask = cnpj.value.replace(/[.\-\/]/g, "")  // Elimina os (pontos e traços) ficando somente números
            const charArray = numSemMask.substring( 0 , numSemMask.length - 2) // Captura os 9 primeiros digitos
            const digitoRecupUsuario1 = parseInt(numSemMask.substring(12,13)) // Captura o 10° digito digitado pelo usuário
            const digitoRecupUsuario2 = parseInt(numSemMask.substring(13,14)) // Captura o 11° digito digitado pelo usuário
            let sumDigitoVerificador1 = 0  // Variável que ira guardar soma para encontrar o 1° digito verificador
            let sumDigitoVerificador2 = 0  // Variável que ira guardar soma para encontrar o 2° digito verificador
            let digitoVerificador1 = 0  // Variável que ira guardar o 1° digito verificador
            let digitoVerificador2 = 0  // Variável que ira guardar o 2° digito verificador
            const digitosRegra = "6543298765432"
            let j = 0

            //Chama a função que verifica se o usuário digitou todos os números iguais
            if (verificaDigitosRepetidos(numSemMask)){

                /*Loop que ira percorrer os 9 digitos iniciais*/
                for(let i = 0; i <= digitosRegra.length - 1; i++, j++){

                    if( i <= charArray.length - 1){
                        sumDigitoVerificador1 += parseInt(charArray[i]) * parseInt(digitosRegra[j+1])
                    }

                    if( i != digitosRegra.length - 1){
                        sumDigitoVerificador2 += parseInt(charArray[j]) * parseInt(digitosRegra[j])
                    }else{

                        digitoVerificador1 = sumDigitoVerificador1 % 11

                        if(digitoVerificador1 < 2){
                            digitoVerificador1 = 0
                        }else{
                            digitoVerificador1 = 11 - digitoVerificador1
                        }

                        sumDigitoVerificador2 += 2 * digitoVerificador1

                        digitoVerificador2 = sumDigitoVerificador2 % 11

                        if(digitoVerificador2 < 2){
                            digitoVerificador2 = 0
                        }else{
                            digitoVerificador2 = 11 - digitoVerificador2
                        }
                    }
                }

                if(digitoRecupUsuario1 !== digitoVerificador1 ||
                    digitoRecupUsuario2 !== digitoVerificador2 ){

                    cnpj.classList.remove("is-valid")
                    cnpj.classList.add("is-invalid")

                }else{
                    cnpj.classList.remove("is-invalid")
                    cnpj.classList.add("is-valid")
                }

            }else{
                cnpj.classList.add("is-invalid")
                cnpj.classList.remove("is-valid")
            }

        }else if (cnpj.value !== "" && cnpj.value.length < 18){
            cnpj.classList.remove("is-valid")
            cnpj.classList.add("is-invalid")
        }else{
            cnpj.classList.remove("is-valid")
            cnpj.classList.remove("is-invalid")
        }

        /* Verifica se o usuário digitou todos os dígitos iguais
        * ex: 111-111-111-11 retorna false*/
        function verificaDigitosRepetidos(numDigitadosPelousuario){

            for(let i = 1; i < numDigitadosPelousuario.length; i++){
                if (numDigitadosPelousuario[0] !== numDigitadosPelousuario[i] ){
                    return true;
                }
            }
            return false;
        }
    }

    if(arrayCPF.length > 0 ){
        arrayCPF.forEach(cpf => cpf.addEventListener("blur", () => {
            validarCPF(cpf);
        }));
    }
    
    if(CPFsContratoCurso.length > 0 ){
        CPFsContratoCurso.forEach(cpf => cpf.addEventListener("blur", () => {
            validarCPF(cpf);
        }));
    }

    if(arrayCNPJ.length > 0 ){
        arrayCNPJ.forEach(cnpj => cnpj.addEventListener("blur", () => {
            validarCNPJ(cnpj);
        }));
    }




    /************************************************************
     * BUSCANDO OS DADOS ATRAVÉS DO CEP INFORMADO PELO USUÁRIO  *
     ******************* VIA API VIACEP *************************
     ************************************************************/
    const cep = doc.querySelector("#cep");

    if(cep != null){

        const dadosCarregados = (resultado) =>{

            for (const campo in resultado) {
                if(doc.querySelector("#" + campo) && campo != "ddd" ){
                    doc.querySelector("#" + campo).value = resultado[campo]
                    if(resultado[campo] !== ""){
                        doc.getElementById(campo).classList.remove("bg-components-form")
                        doc.getElementById(campo).classList.remove("campo-obrigatorio")
                        doc.getElementById(campo).classList.remove("is-invalid")
                        doc.getElementById(campo).classList.add("is-valid")
                    }else{
                        doc.getElementById(campo).value = ""
                        doc.getElementById(campo).classList.remove("is-valid")
                        doc.getElementById(campo).classList.remove("is-invalid")
                        doc.getElementById(campo).classList.add("bg-components-form")
                    }
                }
            }

            doc.getElementById("num").focus()
        }

        cep.addEventListener("blur", (e)=>{

            let cepSemMask = cep.value.replace(/[.-]/g,"")

            if(cepSemMask.trim() !== "" && cepSemMask.length === 8){

                const OPCOES = {
                    method: 'GET',
                    mode:   'cors',
                    cache:  'default'
                }

                fetch(`https://viacep.com.br/ws/${cepSemMask.trim()}/json/`, OPCOES)
                    .then(response => {response.json()
                        .then(dados => dadosCarregados(dados))
                    })
                    .catch(e => console.log("Ocorreu um erro ao buscar o CEP  " + e.message))
            }else{
                if(cepSemMask.trim() !== "" && cepSemMask.length < 8){
                    cep.classList.remove("bg-components-form")
                    cep.classList.add("is-invalid")
                    cep.placeholder = "CEP inválido"
                }else if (cepSemMask === ""){
                    cep.classList.remove("is-invalid")
                    cep.classList.remove("is-valid")

                        if(doc.getElementById("cnpj") == null){
                            cep.classList.add("bg-components-form")
                        }else{
                            cep.classList.add("campo-obrigatorio")
                        }

                    doc.getElementById("logradouro").value = ""
                    doc.getElementById("logradouro").classList.remove("is-valid")
                    doc.getElementById("logradouro").classList.remove("is-invalid")

                        if(doc.getElementById("cnpj") == null){
                            doc.getElementById("logradouro").classList.add("bg-components-form")
                        }else{
                            doc.getElementById("logradouro").classList.add("campo-obrigatorio")
                        }

                    doc.getElementById("bairro").value = ""
                    doc.getElementById("bairro").classList.remove("is-valid")
                    doc.getElementById("bairro").classList.remove("is-invalid")

                        if(doc.getElementById("cnpj") == null){
                            doc.getElementById("bairro").classList.add("bg-components-form")
                        }else{
                            doc.getElementById("bairro").classList.add("campo-obrigatorio")
                        }

                    doc.getElementById("localidade").value = ""
                    doc.getElementById("localidade").classList.remove("is-valid")
                    doc.getElementById("localidade").classList.remove("is-invalid")

                        if(doc.getElementById("cnpj") == null){
                            doc.getElementById("localidade").classList.add("bg-components-form")
                        }else{
                            doc.getElementById("localidade").classList.add("campo-obrigatorio")
                        }

                    doc.getElementById("uf").value = ""
                    doc.getElementById("uf").classList.remove("is-valid")
                    doc.getElementById("uf").classList.remove("is-invalid")

                        if(doc.getElementById("cnpj") == null){
                            doc.getElementById("uf").classList.add("bg-components-form")
                        }else{
                            doc.getElementById("uf").classList.add("campo-obrigatorio")
                        }
                }
            }
        })

    }

})(document, window)