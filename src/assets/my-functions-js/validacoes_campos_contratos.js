((win, doc) => {
    "use strict";
    (win.validarCampoNumericoEmonetario = () => {

        const idTipoContrato = doc.getElementById("id-tipo-contrato");
        const totalHoras = doc.getElementById("total-horas");
        const valorTotal = doc.getElementById("valor-total");
        const qtdeParcelas = doc.getElementById("qtde-parcelas");
        const valorParcela = doc.getElementById("valor-parcela");
        const valorEntrada = doc.getElementById("valor-entrada");
        const cargaHoraria = doc.getElementById("carga-horaria");

        if (totalHoras !== null) {

            if (parseInt(idTipoContrato.value) >= 3 && parseInt(idTipoContrato.value) <= 13) {

                totalHoras.addEventListener("change", () => {

                    const msgAlertaTotalHoras = doc.getElementById("msg-alerta-total-horas");
                    const arrayTotalHoras = totalHoras.value.toString().split(":");

                    if (totalHoras.value.trim() !== "") {

                        if (parseInt(arrayTotalHoras[0]) <= 0) {

                            totalHoras.classList.remove("campo-obrigatorio");
                            totalHoras.classList.remove("is-valid");
                            totalHoras.classList.add("is-invalid");

                            msgAlertaTotalHoras.innerHTML = "Por favor, digite uma valor maior que 0";
                            msgAlertaTotalHoras.style.display = "block";

                            totalHoras.focus();

                        }

                        if (parseInt(idTipoContrato.value) === 7 || parseInt(idTipoContrato.value) === 8 || parseInt(idTipoContrato.value) === 13) {

                            const valorMaxPadrao = 20 * 60;
                            const valorTotalHorasDigitado = (arrayTotalHoras.length === 2) ? parseInt(arrayTotalHoras[0]) * 60 + parseInt(arrayTotalHoras[1]) : parseInt(arrayTotalHoras[0]) * 60;

                            let contrato = "";

                            if (parseInt(idTipoContrato.value) === 7) {
                                contrato = "PF individual termo de compromisso até 20 horas";
                            } else if (parseInt(idTipoContrato.value) === 8) {
                                contrato = "PF grupo termo de compromisso até 20 horas";
                            } else if (parseInt(idTipoContrato.value) === 13) {
                                contrato = "PJ termo de compromisso até 20 horas";
                            }

                            if (valorTotalHorasDigitado > valorMaxPadrao) {

                                totalHoras.classList.remove("campo-obrigatorio");
                                totalHoras.classList.remove("is-valid");
                                totalHoras.classList.add("is-invalid");

                                msgAlertaTotalHoras.innerHTML = `Valor digitado <strong><em>${totalHoras.value}</em></strong> é inválido. O contrato <strong><em>${contrato}</em></strong> precisa ter um valor mínimo de <strong><em>1(uma)</em></strong> hora, e no máximo de <strong><em>20(vinte) horas</em></strong>`;
                                msgAlertaTotalHoras.style.display = "block";

                                totalHoras.value = "";
                                totalHoras.focus();

                            } else {

                                msgAlertaTotalHoras.innerHTML = "";
                                msgAlertaTotalHoras.style.display = "none";

                            }

                        } else {

                            msgAlertaTotalHoras.innerHTML = "";
                            msgAlertaTotalHoras.style.display = "none";

                        }
                    } else {

                        totalHoras.classList.remove("is-invalid");
                        totalHoras.classList.add("campo-obrigatorio");
                        msgAlertaTotalHoras.innerHTML = "";
                        msgAlertaTotalHoras.style.display = "none";

                    }

                });

            }

        }

        if (valorTotal !== null) {

            valorTotal.addEventListener("change", () => {

                const msgAlertaValorTotal = doc.getElementById("msg-alerta-valor-total");

                if (valorTotal.value.trim() !== "") {

                    if (parseFloat(numeroFormatoAmericano(valorTotal.value)) <= 0) {

                        valorTotal.classList.remove("campo-obrigatorio");
                        valorTotal.classList.remove("is-valid");
                        valorTotal.classList.add("is-invalid");

                        msgAlertaValorTotal.innerHTML = "Por favor, digite uma valor maior que R$ 0,00";
                        msgAlertaValorTotal.style.display = "block";

                        valorTotal.focus();

                    } else {

                        msgAlertaValorTotal.innerHTML = "";
                        msgAlertaValorTotal.style.display = "none";

                    }
                } else {

                    valorTotal.classList.remove("is-invalid");
                    valorTotal.classList.add("campo-obrigatorio");
                    msgAlertaValorTotal.innerHTML = "";
                    msgAlertaValorTotal.style.display = "none";

                }

            });

        }


        if (qtdeParcelas !== null) {

            const msgAlertaQtdeParcelas = doc.getElementById("msg-alerta-qtde-parcelas");

            qtdeParcelas.addEventListener("change", () => {

                if (qtdeParcelas.value.trim() !== "") {

                    if (parseInt(qtdeParcelas.value) <= 0) {

                        qtdeParcelas.classList.remove("campo-obrigatorio");
                        qtdeParcelas.classList.remove("is-valid");
                        qtdeParcelas.classList.add("is-invalid");

                        msgAlertaQtdeParcelas.innerHTML = `Por favor, digite uma valor maior que 0`;
                        msgAlertaQtdeParcelas.style.display = "block";

                        qtdeParcelas.focus();

                    } else {

                        msgAlertaQtdeParcelas.innerHTML = "";
                        msgAlertaQtdeParcelas.style.display = "none";
                    }
                } else {

                    qtdeParcelas.classList.remove("is-invalid");
                    qtdeParcelas.classList.add("campo-obrigatorio");
                    msgAlertaQtdeParcelas.innerHTML = "";
                    msgAlertaQtdeParcelas.style.display = "none";
                }

            });
        }



        if (valorTotal !== null && qtdeParcelas !== null) {

            qtdeParcelas.addEventListener("change", () => {

                if (valorTotal.value.trim() !== "" && parseFloat(numeroFormatoAmericano(valorTotal.value)) > 0) {

                    calcularValorParcela(valorTotal.value, qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);

                } else {

                    valorParcela.classList.remove("is-valid");
                    valorParcela.classList.remove("font-weight-bold");
                    valorParcela.classList.remove("is-invalid");
                    valorParcela.classList.add("campo-obrigatorio");

                }

            });

            valorTotal.addEventListener("change", () => {

                if (qtdeParcelas.value.trim() !== "" && parseInt(qtdeParcelas.value) > 0) {

                    calcularValorParcela(valorTotal.value, qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);

                } else {

                    valorParcela.classList.remove("is-valid");
                    valorParcela.classList.remove("font-weight-bold");
                    valorParcela.classList.remove("is-invalid");
                    valorParcela.classList.add("campo-obrigatorio");
                }

            });
        }


        if (valorParcela !== null) {

            valorParcela.addEventListener("change", () => {

                const msgAlertaValorParcela = doc.getElementById("msg-alerta-valor-parcela");

                if (valorParcela.value.trim() !== "") {

                    if (parseFloat(numeroFormatoAmericano(valorParcela.value)) <= 0) {

                        valorParcela.classList.remove("campo-obrigatorio");
                        valorParcela.classList.remove("is-valid");
                        valorParcela.classList.remove("font-weight-bold");
                        valorParcela.classList.add("is-invalid");

                        msgAlertaValorParcela.innerHTML = "Por favor, digite uma valor maior que 0";
                        msgAlertaValorParcela.style.display = "block";

                        valorParcela.focus();

                    } else {

                        msgAlertaValorParcela.innerHTML = "";
                        msgAlertaValorParcela.style.display = "none";

                    }

                } else {

                    valorParcela.classList.remove("is-invalid");
                    valorParcela.classList.add("campo-obrigatorio");
                    msgAlertaValorParcela.innerHTML = "";
                    msgAlertaValorParcela.style.display = "none";
                }

            });
        }

        if (valorEntrada !== null) {

            valorEntrada.addEventListener("change", () => {

                const msgAlertaValorEntrada = doc.getElementById("msg-alerta-valor-entrada");

                if (valorEntrada.value.trim() !== "") {

                    const valorTotal = doc.getElementById("valor-total");

                    if (parseFloat(numeroFormatoAmericano(valorEntrada.value)) <= 0) {

                        valorEntrada.classList.remove("campo-obrigatorio");
                        valorEntrada.classList.remove("is-valid");
                        valorEntrada.classList.remove("font-weight-bold");
                        valorEntrada.classList.add("is-invalid");

                        msgAlertaValorEntrada.innerHTML = "Por favor, digite uma valor maior que 0";
                        msgAlertaValorEntrada.style.display = "block";

                        valorEntrada.focus();

                    } else if (parseFloat(numeroFormatoAmericano(valorEntrada.value)) >= parseFloat(numeroFormatoAmericano(valorTotal.value))) {

                        valorEntrada.classList.remove("campo-obrigatorio");
                        valorEntrada.classList.remove("is-valid");
                        valorEntrada.classList.remove("font-weight-bold");
                        valorEntrada.classList.add("is-invalid");

                        msgAlertaValorEntrada.innerHTML = `O valo de entrada (<strong>R$ ${valorEntrada.value}</strong>) não pode ser igual ou maior que o valor total (<strong>R$ ${valorTotal.value}</strong>)`;
                        msgAlertaValorEntrada.style.display = "block";

                        valorEntrada.value = "";
                        valorEntrada.focus();

                    } else {

                        msgAlertaValorEntrada.innerHTML = "";
                        msgAlertaValorEntrada.style.display = "none";

                        if (qtdeParcelas.value.trim() !== "" && parseInt(qtdeParcelas.value) > 0 &&
                                valorTotal.value.trim() !== "" && parseFloat(valorTotal.value) > 0) {

                            calcularValorParcela(valorTotal.value, qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);
                        }


                    }
                } else {

                    valorEntrada.classList.remove("is-invalid");
                    valorEntrada.classList.add("campo-obrigatorio");

                    msgAlertaValorEntrada.innerHTML = "";
                    msgAlertaValorEntrada.style.display = "none";
                }

            });
        }

        if (cargaHoraria !== null) {

            const msgAlertaCargaHoraria = doc.getElementById("msg-alerta-carga-horaria");

            cargaHoraria.addEventListener("change", () => {

                if (cargaHoraria.value !== "") {

                    const arrayCargaHoraria = cargaHoraria.value.toString().split(":");

                    if (parseInt(arrayCargaHoraria[0]) <= 0) {

                        cargaHoraria.classList.remove("campo-obrigatorio");
                        cargaHoraria.classList.remove("is-valid");
                        cargaHoraria.classList.add("is-invalid");

                        msgAlertaCargaHoraria.innerHTML = "Por favor, digite uma valor maior que 0";
                        msgAlertaCargaHoraria.style.display = "block";

                        cargaHoraria.focus();

                    } else {

                        cargaHoraria.classList.remove("campo-obrigatorio");
                        cargaHoraria.classList.remove("is-invalid");
                        cargaHoraria.classList.add("is-valid");

                        msgAlertaCargaHoraria.innerHTML = "";
                        msgAlertaCargaHoraria.style.display = "none";
                    }

                } else {

                    cargaHoraria.classList.remove("is-invalid");

                    msgAlertaCargaHoraria.innerHTML = "";
                    msgAlertaCargaHoraria.style.display = "none";

                }
            });

        }


    })();

    const numeroFormatoAmericano = (numero) => {

        return numero.trim().replace("\.", "").replace(",", ".");
    };

    win.calcularValorParcela = (valorTotal, qtdeParcelas, valorParcela, valorEntrada) => {

        const valorTotalFormatado = numeroFormatoAmericano(valorTotal);
        const valorEntradaFormatado = valorEntrada !== "" && valorEntrada !== undefined ? numeroFormatoAmericano(valorEntrada) : undefined;
        const valor = valorEntradaFormatado != undefined ? parseFloat(valorTotalFormatado) - parseFloat(valorEntradaFormatado) : parseFloat(valorTotalFormatado);

        if (qtdeParcelas.trim() !== "" && parseInt(qtdeParcelas.trim()) > 0) {

            const resultado = parseFloat(valor) / parseInt(qtdeParcelas);

            valorParcela.value = resultado.toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});


            valorParcela.classList.remove("campo-obrigatorio");
            valorParcela.classList.remove("is-invalid");
            valorParcela.classList.add("is-valid");
            valorParcela.classList.add("font-weight-bold");
        }
    };

    (win.verificarLocalDasAulasMinistradas = () => {

        const selectLocalDasAulas = doc.getElementById("local-das-aulas-ministradas");

        if (selectLocalDasAulas !== null) {

            const divOutroEndereco = doc.getElementById("div-outro-endereco");

            selectLocalDasAulas.addEventListener("change", () => {

                if (selectLocalDasAulas.value === "outro-endereco") {

                    divOutroEndereco.style.display = "block";

                } else {

                    divOutroEndereco.style.display = "none";
                }

            });
        }

    })();

    win.habilitarInputsRadiosFormaDePagamento = () => {

        const formasDePagamentos = doc.getElementsByName("forma-de-pagamento");
        const idioma = doc.getElementById("id-idioma").value.trim();
        const valorHoraAula = doc.getElementById("valor-hora-aula").value.trim();
        const totalHoras = doc.getElementById("total-horas").value.trim();
        const valorTotal = doc.getElementById("valor-total").value.trim();
        const arrayTotalHoras = totalHoras.toString().split(":");

        if (idioma !== "" && valorHoraAula !== "" && totalHoras !== "" && valorTotal !== "") {

            if (parseFloat(numeroFormatoAmericano(valorHoraAula)) > 0) {

                if (arrayTotalHoras[0] > 0) {

                    if (parseFloat(numeroFormatoAmericano(valorTotal)) > 0) {

                        formasDePagamentos.forEach(item => {

                            item.removeAttribute("disabled");

                        });
                    }
                }

            }

        }

    };

    (win.verificarFormaDePagamento = () => {

        const formasDePagamentos = doc.getElementsByName("forma-de-pagamento");
        const divValorEntrada = doc.getElementById("div-valor-entrada");
        const valorEntrada = doc.getElementById("valor-entrada");
        const qtdeParcelas = doc.getElementById("qtde-parcelas");
        const valorParcela = doc.getElementById("valor-parcela");
        const diaVencimentoParcela = doc.getElementById("dia-vencimento-parcela");
        const desconto = doc.getElementById("desconto");
        const msgAlertaDesconto = doc.getElementById("msg-alerta-desconto");
        const msgAlertaDiaVencimentoParcelas = doc.getElementById("msg-alerta-dia-vencimento-parcelas");
        const msgAlertaQtdeParcelas = doc.getElementById("msg-alerta-qtde-parcelas");
        const idTipoContrato = doc.getElementById("id-tipo-contrato");

        const contratoRevTrad = (idTipoContrato.value === "1" || idTipoContrato.value === "2");

        if (formasDePagamentos.length > 0) {

            formasDePagamentos.forEach(forma => forma.addEventListener("change", () => {

                    if (forma.checked) {

                        if (forma.value === "sem-entrada") {

                            if (!contratoRevTrad) {

                                msgAlertaDesconto.style.display = "none";
                                msgAlertaDesconto.innerHTML = "";
                                msgAlertaDiaVencimentoParcelas.style.display = "none";
                                msgAlertaDiaVencimentoParcelas.innerHTML = "";
                                msgAlertaQtdeParcelas.style.display = "none";
                                msgAlertaQtdeParcelas.innerHTML = "";
                            }

                            divValorEntrada.classList.add("invisible");
                            valorEntrada.value = "";
                            valorEntrada.classList.remove("is-valid");
                            valorEntrada.classList.add("campo-obrigatorio");

                            qtdeParcelas.value = "";
                            qtdeParcelas.classList.remove("is-valid");
                            qtdeParcelas.classList.add("campo-obrigatorio");
                            qtdeParcelas.removeAttribute("readonly");

                            valorParcela.value = "";
                            valorParcela.classList.remove("is-valid");
                            valorParcela.classList.remove("font-weight-bold");
                            valorParcela.classList.add("campo-obrigatorio");

                            diaVencimentoParcela.value = "";
                            diaVencimentoParcela.classList.remove("is-valid");
                            diaVencimentoParcela.classList.add("campo-obrigatorio");
                            diaVencimentoParcela.removeAttribute("readonly");


                        } else if (forma.value === "com-entrada") {

                            if (!contratoRevTrad) {

                                msgAlertaDesconto.style.display = "none";
                                msgAlertaDesconto.innerHTML = "";
                                msgAlertaDiaVencimentoParcelas.style.display = "none";
                                msgAlertaDiaVencimentoParcelas.innerHTML = "";
                                msgAlertaQtdeParcelas.style.display = "none";
                                msgAlertaQtdeParcelas.innerHTML = "";
                            }

                            divValorEntrada.classList.remove("invisible");

                            qtdeParcelas.value = "";
                            qtdeParcelas.classList.remove("is-valid");
                            qtdeParcelas.classList.add("campo-obrigatorio");
                            qtdeParcelas.removeAttribute("readonly");

                            valorParcela.value = "";
                            valorParcela.classList.remove("is-valid");
                            valorParcela.classList.remove("font-weight-bold");
                            valorParcela.classList.add("campo-obrigatorio");

                            diaVencimentoParcela.value = "";
                            diaVencimentoParcela.classList.remove("is-valid");
                            diaVencimentoParcela.classList.add("campo-obrigatorio");
                            diaVencimentoParcela.removeAttribute("readonly");


                        } else if (forma.value === "avista") {

                            if (!contratoRevTrad) {

                                msgAlertaDesconto.style.display = "none";
                                msgAlertaDesconto.innerHTML = "";
                                msgAlertaDiaVencimentoParcelas.style.display = "none";
                                msgAlertaDiaVencimentoParcelas.innerHTML = "";
                                msgAlertaQtdeParcelas.style.display = "none";
                                msgAlertaQtdeParcelas.innerHTML = "";
                            }

                            divValorEntrada.classList.add("invisible");
                            valorEntrada.value = "";
                            valorEntrada.classList.remove("is-valid");
                            valorEntrada.classList.add("campo-obrigatorio");

                            const valorTotal = doc.getElementById("valor-total");

                            if (valorTotal.value !== "" && parseFloat(valorTotal.value) > 0) {

                                qtdeParcelas.value = 1;
                                qtdeParcelas.classList.remove("campo-obrigatorio");
                                qtdeParcelas.classList.add("is-valid");
                                qtdeParcelas.setAttribute("readonly", true);

                                valorParcela.value = valorTotal.value;
                                valorParcela.classList.remove("campo-obrigatorio");
                                valorParcela.classList.add("is-valid");
                                valorParcela.classList.add("font-weight-bold");

                                const dataAtual = new Date();

                                diaVencimentoParcela.value = dataAtual.getFullYear() + "-" + (dataAtual.getMonth() + 1).toString().padStart(2, '0') + "-" + dataAtual.getDate().toString().padStart(2, '0');
                                diaVencimentoParcela.classList.remove("campo-obrigatorio");
                                diaVencimentoParcela.classList.add("is-valid");
                                diaVencimentoParcela.setAttribute("readonly", true);

                                desconto.focus();
                            }
                        }

                    }

                }));

        }

    })();

    (win.calcularValorTotal = () => {

        const idiomas = doc.getElementById("id-idioma");
        const valorHoraAula = doc.getElementById("valor-hora-aula");
        const colunaTotalHoras = doc.getElementById("col-total-horas");
        const totalHorasACombinar = doc.getElementById("total-horas-a-combinar");
        const totalHoras = doc.getElementById("total-horas");
        const valorTotal = doc.getElementById("valor-total");
        const qtdeParcelas = doc.getElementById("qtde-parcelas");
        const valorParcela = doc.getElementById("valor-parcela");
        const valorEntrada = doc.getElementById("valor-entrada");
        const inputRadioSemEntrada = doc.getElementById("sem-entrada");
        let   resultado = "";

        if (valorHoraAula !== null && totalHoras !== null) {


            totalHoras.addEventListener("change", () => {

                resultado = dispararCalculoValorTotal(valorHoraAula.value, totalHoras.value);

                if (resultado) {

                    valorTotal.value = "";
                    valorTotal.value = parseFloat(resultado).toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});
                    valorTotal.classList.remove("campo-obrigatorio");
                    valorTotal.classList.remove("is-invalid");
                    valorTotal.classList.add("is-valid");
                    valorTotal.classList.add("font-weight-bold");
                    doc.getElementById("sem-entrada").focus();

                    calcularValorParcela(valorTotal.value, qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);

                    habilitarInputsRadiosFormaDePagamento();

                    inputRadioSemEntrada.focus();

                } else {

                    valorTotal.value = "";
                    valorTotal.classList.remove("is-valid");
                    valorTotal.classList.remove("font-weight-bold");
                    valorTotal.classList.add("campo-obrigatorio");
                }

            });

        } 
        
        if (valorHoraAula !== null && totalHorasACombinar !== null) {

            totalHorasACombinar.addEventListener("change", () => {

                if (totalHorasACombinar.value !== "") {

                    totalHorasACombinar.classList.remove("campo-obrigatorio");
                    totalHorasACombinar.classList.add("is-valid");

                    colunaTotalHoras.classList.remove("invisible");
                    totalHoras.value = totalHorasACombinar.value;

                    resultado = dispararCalculoValorTotal(valorHoraAula.value, totalHoras.value);

                    if (resultado) {

                        valorTotal.value = "";
                        valorTotal.value = parseFloat(resultado).toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});
                        valorTotal.classList.remove("campo-obrigatorio");
                        valorTotal.classList.remove("is-invalid");
                        valorTotal.classList.add("is-valid");
                        valorTotal.classList.add("font-weight-bold");
                        doc.getElementById("sem-entrada").focus();

                        calcularValorParcela(valorTotal.value, qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);

                        habilitarInputsRadiosFormaDePagamento();

                        inputRadioSemEntrada.focus();

                    } else {

                        valorTotal.value = "";
                        valorTotal.classList.remove("is-valid");
                        valorTotal.classList.remove("font-weight-bold");
                        valorTotal.classList.add("campo-obrigatorio");
                    }
                }

            });
        }

    })();

    win.dispararCalculoValorTotal = (valorHoraAula, totalHoras) => {

        if (valorHoraAula !== "" && totalHoras !== "") {

            if (parseFloat(numeroFormatoAmericano(valorHoraAula)) > 0) {

                return bigDecimal.multiply(numeroFormatoAmericano(totalHoras), numeroFormatoAmericano(valorHoraAula));

            }

        }

        return false;
    };


    (win.vericarDesconto = () => {

        const desconto = doc.getElementById("desconto");
        const msgAlertaDesconto = doc.getElementById("msg-alerta-desconto");
        const valorHoraAula = doc.getElementById("valor-hora-aula");
        const totalHoras = doc.getElementById("total-horas");
        const valorTotal = doc.getElementById("valor-total");
        const qtdeParcelas = doc.getElementById("qtde-parcelas");
        const valorParcela = doc.getElementById("valor-parcela");
        const valorEntrada = doc.getElementById("valor-entrada");

        if (desconto) {

            desconto.addEventListener("change", () => {

                let   arrayTotalHoras = [];
                let   resultado = "";
                let   valorTotalEntrada = 0;
                let   valorEntradaEmPorcentagem = "0";
                let   valorMaxDesconto = "1";
                let   descontoDigitado = 0;

                if (valorHoraAula.value.trim() !== "" && parseFloat(numeroFormatoAmericano(valorHoraAula.value)) > 0) {

                    if (totalHoras.value.trim() !== "") {

                        arrayTotalHoras = totalHoras.value.toString().split(":");

                        if (parseInt(arrayTotalHoras[0]) > 0) {

                            if (valorTotal.value.trim() !== "" && parseFloat(numeroFormatoAmericano(valorTotal.value)) > 0) {

                                if (qtdeParcelas.value.trim() !== "" && parseInt(qtdeParcelas.value) > 0) {

                                    if (valorParcela.value.trim() !== "" && parseFloat(numeroFormatoAmericano(valorParcela.value)) > 0) {

                                        if (desconto.value.trim() !== "" && parseFloat(numeroFormatoAmericano(desconto.value)) > 0) {

                                            if (valorEntrada.value.trim() !== "" && parseFloat(numeroFormatoAmericano(valorEntrada.value)) > 0) {

                                                valorEntradaEmPorcentagem = bigDecimal.divide(numeroFormatoAmericano(valorEntrada.value), numeroFormatoAmericano(localStorage.getItem("valorTotal")), 3);

                                            }

                                            valorMaxDesconto = bigDecimal.subtract("1", valorEntradaEmPorcentagem);

                                            descontoDigitado = bigDecimal.divide(numeroFormatoAmericano(desconto.value), "100", 3);

                                            if (parseFloat(descontoDigitado) < parseFloat(valorMaxDesconto)) {

                                                const valorDesconto = (parseFloat(numeroFormatoAmericano(desconto.value)) / 100) * parseFloat(numeroFormatoAmericano(localStorage.getItem("valorHoraAula")));

                                                const valorHoraAulaComDesconto = (parseFloat(localStorage.getItem("valorHoraAula")) - valorDesconto).toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});

                                                resultado = dispararCalculoValorTotal(valorHoraAulaComDesconto, totalHoras.value.trim());

                                                if (resultado) {

                                                    if (resultado > valorTotalEntrada) {

                                                        valorTotal.value = "";
                                                        valorTotal.value = parseFloat(resultado).toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});

                                                        calcularValorParcela(valorTotal.value.toString(), qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);

                                                        msgAlertaDesconto.innerHTML = "";
                                                        msgAlertaDesconto.style.display = "none";

                                                        desconto.classList.remove("is-invalid");

                                                        desconto.focus();
                                                    }
                                                }
                                            } else {

                                                valorHoraAula.value = localStorage.getItem("valorHoraAula");

                                                valorTotal.value = "";
                                                valorTotal.value = localStorage.getItem("valorTotal").toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});

                                                calcularValorParcela(valorTotal.value.toString(), qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);

                                                desconto.value = "";
                                                desconto.classList.remove("is-valid");
                                                desconto.classList.remove("is-invalid");
                                                desconto.classList.add("bg-components-form");

                                                desconto.focus();

                                                msgAlertaDesconto.innerHTML = "";
                                                msgAlertaDesconto.style.display = "block";
                                                msgAlertaDesconto.innerHTML = `O limite máximo permitido para desconto é  <strong><em>${parseFloat(bigDecimal.multiply(valorMaxDesconto, '100')).toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'})}%</em></strong>`;

                                            }

                                        } else {
                                            
                                            valorHoraAula.value = localStorage.getItem("valorHoraAula");

                                            resultado = dispararCalculoValorTotal(valorHoraAula.value, totalHoras.value.trim());
                                            
                                            if (resultado) {

                                                valorTotal.value = parseFloat(resultado).toLocaleString('pt-br', {style: 'decimal', minimumFractionDigits: '2', maximumFractionDigits: '2'});


                                                calcularValorParcela(valorTotal.value, qtdeParcelas.value.trim(), valorParcela, valorEntrada.value);

                                                desconto.focus();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }

    })();


    const verifica_se_horaInicio_e_maior_que_horaFinal = (horaInicio, horaTermino, msgAlertaAgendamento) => {

        const arrHrIni = horaInicio.value.toString().split(":");
        const arrHrFim = horaTermino.value.toString().split(":");

        if (arrHrIni.length === 2 && arrHrFim.length === 2) {

            const totalMinHoraInicio = parseInt(arrHrIni[0]) * 60 + parseInt(arrHrIni[1]);
            const totalMinHoraTermino = parseInt(arrHrFim[0]) * 60 + parseInt(arrHrFim[1]);

            if (totalMinHoraInicio >= totalMinHoraTermino) {

                horaInicio.classList.remove("campo-obrigatorio");
                horaInicio.classList.remove("is-valid");
                horaInicio.classList.add("is-invalid");

                horaTermino.classList.remove("campo-obrigatorio");
                horaTermino.classList.remove("is-valid");
                horaTermino.classList.add("is-invalid");

                msgAlertaAgendamento.innerHTML = `Valor da hora início informada <strong><em>${horaInicio.value}</em></strong> não pode ser maior ou igual que a hora de término informada <strong><em>${horaTermino.value}</em></strong>`;
                msgAlertaAgendamento.style.display = "block";


                horaInicio.value = "";
                horaTermino.value = "";

                horaInicio.focus();

            } else {

                horaInicio.classList.remove("is-invalid");
                horaTermino.classList.remove("is-invalid");
                msgAlertaAgendamento.innerHTML = "";
                msgAlertaAgendamento.style.display = "none";
            }
        }

    };

    (win.validarCamposHorasDoAgendamento = () => {

        const horasInicio = doc.getElementsByName("hora-inicio[]");
        const horasFinal = doc.getElementsByName("hora-termino[]");
        const msgAlertaAgendamento = doc.querySelectorAll("[data-msg-alerta-hora-agendamento]");

        horasInicio.forEach((hrIni, i) => {

            hrIni.addEventListener("change", () => {

                if (hrIni.value.trim() !== "" && horasFinal[i].value.trim() !== "") {

                    verifica_se_horaInicio_e_maior_que_horaFinal(hrIni, horasFinal[i], msgAlertaAgendamento[i]);
                }
            });
        });

        horasFinal.forEach((hrFim, i) => {

            hrFim.addEventListener("change", () => {

                if (hrFim.value.trim() !== "" && horasInicio[i].value.trim() !== "") {

                    verifica_se_horaInicio_e_maior_que_horaFinal(horasInicio[i], hrFim, msgAlertaAgendamento[i]);
                }
            });
        });

    })();


    /*CONTRATO GRUPO*/

    (win.buscarCPFinteressados_contratoGrupo = () => {

        const nomeInteressado = doc.getElementById("nome-buscar-interessado");
        const btnBuscar = doc.getElementById("btn-buscar");
        const tabelaDadosInteressado = doc.getElementById("tabela-dados-interessados");
        const msgAlertaBuscarInteressados = doc.getElementById("msg-alerta-buscar-interessados");

        if (btnBuscar !== null) {

            btnBuscar.addEventListener("click", () => {

                if (nomeInteressado.value.trim() !== "") {

                    const nome = nomeInteressado.value.trim();

                    $.ajax({

                        url: "../../ajax/buscarCPFContratoGrupo.php",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            nome_interessado: nome
                        },

                        success: (response) => {

                            if (response !== 0) {

                                msgAlertaBuscarInteressados.classList.add("invisible");

                                for (let res of response) {

                                    tabelaDadosInteressado.insertAdjacentHTML("beforeend", `<tr>
                                                                                                <td class="line-nowrap">${res.nome + " " + res.sobrenome}</td>
                                                                                                <td class="line-nowrap">${win.maskCPF(res.cpf)}</td>
                                                                                                <td class="line-nowrap">
                                                                                                    <a onclick="preencherDadosInteressadoContratoGrupo('${res.id_interessado}', '${win.maskCPF(res.cpf)}', '${res.nome + " " + res.sobrenome}')" class="btn btn-success btn-sm">
                                                                                                        <i class="far fa-paper-plane"></i>
                                                                                                        Confirmar
                                                                                                    </a>
                                                                                                </td>
                                                                                            </tr>`);
                                }

                            } else {

                                msgAlertaBuscarInteressados.classList.remove("invisible");
                            }

                        },

                        error: (XMLHttpRequest) => {

                            console.log(XMLHttpRequest.responseText);
                        }


                    });
                }
            });
        }

    })();

})(window, document);


