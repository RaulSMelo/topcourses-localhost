((doc, win) => {
    "use strict"


    /**
     *
     * Captura as opcões da área de interesse(opcoes => CURSO, TRADUÇÃO, REVISÃO)
     * e para deixar visível os select se as opções for checada se não deixa invisível
     *
     * @type {NodeListOf<Element>} opcoes
     */
    const opcoes = doc.getElementsByName("opcao-area-interesse[]")

    opcoes.forEach(opcao => opcao.addEventListener("change", () => {

        const areaCurso = doc.getElementById("campo-curso")
        const areaTraducao = doc.getElementById("campo-traducao")
        const areaRevisao = doc.getElementById("campo-revisao")

        const idCurso = areaCurso.id.toString().replaceAll("campo-", "")
        const idTraducao = areaTraducao.id.toString().replaceAll("campo-", "")
        const idRevisao = areaRevisao.id.toString().replaceAll("campo-", "")

        const checkboxID = opcao.id.toString().replaceAll("opcao-", "")

        const fieldsetAreaInteresseInteressados = doc.querySelector("fieldset#area-interesse-interessados")
        const msgErroAreaInteresseCadastro = doc.getElementById("msg-erro-area-interesse-interessados")

        if(opcao.checked) {
            if(checkboxID === idCurso){

                areaCurso.classList.remove("invisible")

                if (fieldsetAreaInteresseInteressados.classList.contains("border") &&
                    fieldsetAreaInteresseInteressados.classList.contains("border-danger"))
                {
                    fieldsetAreaInteresseInteressados.classList.remove("border")
                    fieldsetAreaInteresseInteressados.classList.remove("border-danger")
                    msgErroAreaInteresseCadastro.classList.add("invisible")
                }

            }else if(checkboxID === idTraducao){

                areaTraducao.classList.remove("invisible")

                if (fieldsetAreaInteresseInteressados.classList.contains("border") &&
                    fieldsetAreaInteresseInteressados.classList.contains("border-danger"))
                {
                    fieldsetAreaInteresseInteressados.classList.remove("border")
                    fieldsetAreaInteresseInteressados.classList.remove("border-danger")
                    msgErroAreaInteresseCadastro.classList.add("invisible")
                }

            }else if(checkboxID === idRevisao){
                areaRevisao.classList.remove("invisible")

                if (fieldsetAreaInteresseInteressados.classList.contains("border") &&
                    fieldsetAreaInteresseInteressados.classList.contains("border-danger"))
                {
                    fieldsetAreaInteresseInteressados.classList.remove("border")
                    fieldsetAreaInteresseInteressados.classList.remove("border-danger")
                    msgErroAreaInteresseCadastro.classList.add("invisible")
                }
            }

        }else{

            if (checkboxID === idCurso) {

                areaCurso.classList.add("invisible")
                const selectCurso = doc.getElementById(idCurso)
                const msgSelectAreaInteresse = doc.getElementById("msg-erro-" + idCurso)

                selectCurso.value = ""
                selectCurso.classList.add("campo-obrigatorio")
                msgSelectAreaInteresse.classList.add("invisible")

                if(selectCurso.classList.contains("is-valid")) {
                    selectCurso.classList.remove("is-valid")
                }

                if (selectCurso.classList.contains("is-invalid")){
                    selectCurso.classList.remove("is-invalid")
                }

            } else if (checkboxID === idTraducao) {

                areaTraducao.classList.add("invisible")
                const selectTraducao = doc.getElementById(idTraducao)
                const msgSelectAreaInteresse = doc.getElementById("msg-erro-" + idTraducao)

                selectTraducao.value = ""
                selectTraducao.classList.add("campo-obrigatorio")
                msgSelectAreaInteresse.classList.add("invisible")

                if(selectTraducao.classList.contains("is-valid")) {
                    selectTraducao.classList.remove("is-valid")
                }

                if (selectTraducao.classList.contains("is-invalid")){
                    selectTraducao.classList.remove("is-invalid")
                }
            } else if (checkboxID === idRevisao) {

                areaRevisao.classList.add("invisible")
                const selectRevisao = doc.getElementById(idRevisao)
                const msgSelectAreaInteresse = doc.getElementById("msg-erro-" + idRevisao)

                selectRevisao.value = ""
                selectRevisao.classList.add("campo-obrigatorio")
                msgSelectAreaInteresse.classList.add("invisible")

                if(selectRevisao.classList.contains("is-valid")) {
                    selectRevisao.classList.remove("is-valid")
                }

                if (selectRevisao.classList.contains("is-invalid")){
                    selectRevisao.classList.remove("is-invalid")
                }
            }
        }

    }))

    /**
     * Captura as opções (SIM ou NÃO) do campo aula experimental
     * para habilitar a campo para digitar a data da aula.
     * @type {HTMLElement}
     */
    const dataAgengendamento = doc.getElementById("div-data-agendamento")
    const inputDataAgendamento = doc.getElementById("data-agendamento")
    const aulaAgendada = doc.getElementsByName("aula-agendada[]")
    let msgErro = doc.getElementById("msg-erro-data-agendamento")

    aulaAgendada.forEach(opcaoAulaAgendada => opcaoAulaAgendada.addEventListener("click", () => {

        if(opcaoAulaAgendada.checked){
            if(opcaoAulaAgendada.value == "0"){
                msgErro.classList.add("invisible")
                inputDataAgendamento.classList.remove("is-invalid")
                inputDataAgendamento.classList.remove("is-valid")
                inputDataAgendamento.classList.add("campo-obrigatorio")
                inputDataAgendamento.value = ""
                dataAgengendamento.style.display = "none"

            }else if(opcaoAulaAgendada.value == "1"){
                dataAgengendamento.style.display = "inline-block"
            }
        }
    }))

})(document, window)