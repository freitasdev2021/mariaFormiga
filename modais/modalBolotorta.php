<div class="modal fade " id="pedidoBolotorta" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-formiga">
        <h5 class="modal-title">Continuar Pedido</h5>
        <button type="button" class="close bt-fechar-modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPedidos" class="form-controls">
        <input type="hidden" name="valorQuilo" value="">
        <input type="hidden" name="produto_id" value="">
        <div class="col-sm-12">
          <select name="pesoProduto">
              <option value="">Peso</option>
              <option value="1.7">1,7KG (até 10 Pessoas)</option>
              <option value="2.0">2,0KG (até 15 Pessoas)</option>
              <option value="2.5">2,5KG (de 15 a 18 Pessoas)</option>
              <option value="3.0">3,0KG (de 20 a 23 Pessoas)</option>
              <option value="3.5">3,5KG (de 24 a 28 Pessoas)</option>
              <option value="4.0">4,0KG (de 30 a 34 Pessoas)</option>
              <option value="4.5">4,5KG (de 35 a 38 Pessoas)</option>
              <option value="4.0">5,0KG (de 40 a 43 Pessoas)</option>
              <option value="4.0">5,5KG (de 44 a 48 Pessoas)</option>
              <option value="6.0">6,0KG (de 50 a 54 Pessoas)</option>
              <option value="6.5">6,5KG (de 55 a 58 Pessoas)</option>
              <option value="7.0">6,5KG (de 60 a 64 Pessoas)</option>
            </select>
        </div>
        <br>
        <div id="imagemPedido">
          <img src="" width="250px" height="250px" style="border-radius:10px;">
        </div>
        <div class="recheios">
        <br>
        <label>Recheios (+ 5,00)</label>
          <div class="recheios_opcao">
            <input type="radio" name="recheios" value="morango">&nbsp;Morango
            <input type="radio" name="recheios" value="abacaxi">&nbsp;Abacaxi
            <input type="radio" name="recheios" value="maracuja">&nbsp;Maracujá
            <input type="radio" name="recheios" value="nenhum">&nbsp;Nenhum
          </div>
        </div>
        <hr>
          <div class="embalagens">
            <h3 align="center">Escolha uma Embalagem</h3>
              <?php
              echo "<input type='radio' name='embalagem' data-vlbase='0' value='0'>";
              foreach(Categorias::getBases("EMB") as $b){
              ?>
              <div class="itemProduto">
                <strong><?=MRFormiga::trataValor($b['VLBase'],0)?></strong>
                <?php
                echo Produtos::getProdutos($b['IDCategoria'],"0");
                ?>
                <hr>
              </div>
              <?php
              }
              ?>
        </div>
        </form>
        <hr>
        <b id="valorTotal"></b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-formiga bt_finalizar_pedido">Finalizar</button>
        <button type="button" class="btn btn-light bt-fechar-modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
