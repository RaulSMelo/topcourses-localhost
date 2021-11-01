

function mascaraGenerica(evt, campo, padrao) {
    //testa a tecla pressionada pelo usuario
    let charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 8) return true; //tecla backspace permitida
    if (charCode == 9) return true; //tecla tab permitida
    if (charCode != 46 && (charCode < 48 || charCode > 57)) return false; //apenas numeros
    campo.maxLength = padrao.length; //Define dinamicamente o tamanho maximo do campo de acordo com o padrao fornecido
    //aplica a mascara de acordo com o padrao fornecido
    let entrada = campo.value;
    if (padrao.length > entrada.length && padrao.charAt(entrada.length) != '#') {
        campo.value = entrada + padrao.charAt(entrada.length);
    }
    return true;
}


    function maskMoeda(value) {

        return value
            .replace(/\D/g,"")
            .replace(/(\d{1,3})(\d{2})/g,"$1,$2")
            .replace(/(\d{3}),(\d)(\d{2})/g,"$1.$2,$3")
            .replace(/(\d)(\d{2})\.(\d),(\d{2})/g,"$1.$2$3,$4")
            .replace(/(\d)\.(\d)(\d{2}),(\d)(\d{2})/g,"$1$2.$3$4,$5")
            .replace(/(\d)\.(\d{2})(\d),(\d)(\d),(\d{2})/g,"$1$2.$3$4$5,$6")
            .replace(/(\d)(\d{3})\.(\d{3}),(\d{2})/g,"$1.$2.$3,$4")
            .replace(/(\d{2})\.(\d{3}),(\d{3}),(\d{2})/g,"$1.$2.$3,$4")
            .replace(/(\d{2})\.(\d)(\d{2})\.(\d)(\d{2}),(\d)(\d{2})/g,"$1$2.$3$4.$5$6,$7")
            .replace(/(,\d{2})\d+?$/g,"$1")

    }

    document.querySelectorAll("[data-moeda]").forEach(input => {
        input.addEventListener("input", (evt) => {
            evt.target.value = maskMoeda(evt.target.value);
        });
    });
    
    function maskHoras(value) {

     return value
         .replace(/\D/g,"")
         .replace(/(\d{1,3})(\d{2})/g,"$1:$2")
         .replace(/(:\d{2})\d+?$/g,"$1")

    }

    document.querySelectorAll("[data-hora]").forEach(input => {
        input.addEventListener("input", (evt) => {
            evt.target.value = maskHoras(evt.target.value);
        });
    });
    