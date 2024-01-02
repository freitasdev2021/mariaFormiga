<div class="modal otherModal fade " id="cadastroProduto" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Produtos</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCadastroProduto" class="form-controls">
        <input type="hidden" name="categoria_id" value="">
        <input type="hidden" name="categoria_tipo" value="">
        <input type="hidden" name="produto_id" value="">
            <div class="col-sm-12 input">
                  <label for="nomeBase">Produto</label>
                  <input type="text" name="produto" class="form-control" minlength="5" maxlength="250">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-12 input peso_emb">
                  <label for="nomeBase">Peso Suportado</label>
                  <input type="number" name="PSEmb" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" minlength="1" maxlength="2">
                  <div class="error-input text-danger">
                    Preenchimento incorreto!
                  </div>
              </div>
              <div class="col-sm-12 tipo_bolo">
                <label>Tipo do Bolo</label>
                <select name="TPBolo" class="form-control">
                    <option value="0">Acetato</option>
                    <option value="1">Chantilly</option>
                </select>
              </div>
              <div class="col-sm-12 input">
                  <label for="nomeBase">Imagem</label>
                  <input type="file" accept=".jpg,.png,.jpeg" id="imagem-usuario" class="form-control">
              </div>
              <br>
              <div class="col-sm-12 d-flex justify-content-center">
                <img src="" width="500px" height="500px" class='imagemProduto'>
              </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger bt_excluir_produto">Excluir</button>
        <button type="button" class="btn btn-formiga bt_salvar_produto">Salvar</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
