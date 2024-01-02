<div class="modal otherModal fade " id="cadastroBase" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Categorias</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroBase" class="form-controls">
        <input type="hidden" name="base_id" value="">
        <input type="hidden" name="tipo" value="">
            <div class="col-sm-12 input">
                  <label for="nomeBase">Base</label>
                  <input type="text" name="base" class="form-control" minlength="3" maxlength="250">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-12 money">
                  <label for="emailUsuario">Valor</label>
                  <input type="text" name="valor" class="form-control norequire" minlength="1" maxlength="6">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-12">
                <label>Tipo</label>
                <select name="unidade" class="form-control">
                    <option>Selecione</option>
                    <option value="KG">KG</option>
                    <option value="UN">UN</option>
                </select>
              </div>
              <div class="col-sm-12 tipo_doce">
                <label>Tipo dos Doces</label>
                <select name="TPDoce" class="form-control">
                    <option value="Doces Tradicionais">Doces Tradicionais</option>
                    <option value="Doces Gourmet">Doces Gorumet</option>
                    <option value="Bombons Tradicionais">Bombons Tradicionais</option>
                </select>
              </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger bt_excluir_base">Excluir</button>
        <button type="button" class="btn btn-formiga bt_salvar_base">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
