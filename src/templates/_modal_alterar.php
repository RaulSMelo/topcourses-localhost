<div class="modal fade" id="modal-alterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
        <div class="modal-content main-body border border-warning border-bottom">
            <div class="modal-header border-bottom border-warning bg-warning">
                <h5 class="modal-title text-dark" id="exampleModalLabel">Confirmação de alteração</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input id="id-cadastro-basico-alterar" name="id-cadastro-basico-alterar" type="hidden">

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-dark font-weight-bold" for="nome-cadastro-basico-alterar">Nome</label>
                        <input class="obr form-control form-control-sm campo-obrigatorio-modal" type="text" name="nome-cadastro" id="nome-cadastro-basico-alterar">
                        <small id="msg-erro-nome-cadastro-basico-alterar" class="text-danger invisible">Preencha o campo <b>nome</b></small>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-pattern" data-dismiss="modal">Cancelar</button>
                    <button onclick="return validarCamposModal()" name="btn-alterar" type="submit" class="btn btn-success btn-pattern">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>