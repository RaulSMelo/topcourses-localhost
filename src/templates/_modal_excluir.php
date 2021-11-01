<div class="modal fade" id="modal-excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
        <div class="modal-content main-body border border-danger border-bottom">
            <div class="modal-header border-bottom border-danger bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Confirmação de exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="id-cadastro-basico-excluir" name="id-cadastro-basico-excluir">

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-dark font-weight-bold" for="nome-cadastro-basico-excluir">Você deseja excluir esse item ?</label>
                        <input id="nome-cadastro-basico-excluir" class="form-control form-control-sm bg-transparent border text-white" readonly>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-pattern" data-dismiss="modal">Cancelar</button>
                    <button name="btn-excluir" type="submit" class="btn btn-danger btn-pattern">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</div>