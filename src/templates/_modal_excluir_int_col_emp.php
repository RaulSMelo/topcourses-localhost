<!-- Modal excluir interessados - colaboradores - empresas -->
<div class="modal fade" id="modal-excluir-int-col-emp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered  rounded" role="document">
        <div class="modal-content main-body border border-danger border-bottom">
            <div class="modal-header border-bottom border-danger bg-danger">
                <h5 class="modal-title text-light" id="exampleModalLabel">Confirmação de exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input id="id-excluir" name="id-excluir-int-col-emp" type="hidden">
                
                <input id="filtro-nome" name="filtro-nome" type="hidden">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="input-title text-dark" for="nome-modal-excluir">Nome:</label>
                        <input class="form-control text-dark font-weight-bold bg-transparent border border" type="text" id="nome-modal-excluir" disabled >
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="input-title text-dark" for="email-modal-excluir">Email:</label>
                        <input class="form-control text-dark font-weight-bold bg-transparent border" type="text" id="email-modal-excluir" disabled>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="input-title text-dark" for="telefone-modal-excluir">Telefone:</label>
                        <input class="form-control text-dark font-weight-bold bg-transparent border" type="text" id="telefone-modal-excluir" disabled>
                    </div>
                </div>

                <div class="col-md-12">
                    <h5 class="py-3 pl-md-3 bg-danger text-light rounded">Tem certeza que deseja excluir <span id="tipo"></span> ?</h5>
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