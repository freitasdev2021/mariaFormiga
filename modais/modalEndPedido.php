<div class="modal otherModal fade " id="finalizarPedidoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Finalizar Pedido</h5>
        <button type="button" class="close hidemodal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $dadosPdd = $_SESSION['pedido'];
        // echo "<pre>";
        // unset($_SESSION['dadosPedido']['IMGProduto']);
        // unset($_SESSION['dadosPedido']['embalagem']['foto']);
        // print_r($_SESSION['dadosPedido']);
        // echo "</pre>";
        ?>
        <div class='mrformiga-flex-column'>
        <div>
            <b>Nome do Cliente: </b> <?=$dadosPdd['NMCliente']?>
          </div>
          <div>
            <b>Contato: </b> <?=MRFormiga::formataTelefone($dadosPdd['NUTelefoneCliente'])?>
          </div>
          <div>
            <b>Data: </b> <?=MRFormiga::data($dadosPdd['DTEntrega'],'d/m/Y - H:i')?>
          </div>
          <?php
          for($i=0;$i<count($dadosPdd['bolo']);$i++){
            echo "<hr>";
          if($_SESSION['pedido']['bolo'][$i]['tipo'] == "BOL"){
          ?>
            <div class="pdd">
              <div>
                  <strong style="font-size:1.5em;"><?=$_SESSION['pedido']['bolo'][$i]['nome']?></strong>
              </div>
              <div>
                  <b>Valor:</b> <?=MRFormiga::trataValor($_SESSION['pedido']['bolo'][$i]['preco'],0)?>
              </div>
              <div>
                  <b>Recheio:</b> <?=$_SESSION['pedido']['bolo'][$i]['recheio']?>
              </div>
              <div>
                  <b>Massa:</b> <?=$_SESSION['pedido']['bolo'][$i]['massa']?>
              </div>
            </div>
          <?php
          }elseif($_SESSION['pedido']['bolo'][$i]['tipo'] == "DOC"){
          ?>
          <div class="pdd">
              <div>
                  <strong style="font-size:1.5em;"><?=$_SESSION['pedido']['bolo'][$i]['nome']?></strong>
              </div>
              <div>
                  <b>Valor:</b> <?=MRFormiga::trataValor($_SESSION['pedido']['bolo'][$i]['preco'],0)?>
              </div>
              <div>
                  <b>Tipo:</b> <?=$_SESSION['pedido']['bolo'][$i]['tpdoce']?>
              </div>
          </div>
          <?php
          }elseif($_SESSION['pedido']['bolo'][$i]['tipo'] == "TOR"){
          ?>
          <div class="pdd">
              <div>
                  <strong style="font-size:1.5em;"><?=$_SESSION['pedido']['bolo'][$i]['nome']?></strong>
              </div>
              <div>
                  <b>Valor:</b> <?=MRFormiga::trataValor($_SESSION['pedido']['bolo'][$i]['preco'],0)?>
              </div>
              <div>
                  <b>Recheio:</b> <?=$_SESSION['pedido']['bolo'][$i]['recheio']?>
              </div>
              <div>
                  <b>Massa:</b> <?=$_SESSION['pedido']['bolo'][$i]['massa']?>
              </div>
            </div>
          <?php
          }elseif($_SESSION['pedido']['bolo'][$i]['tipo'] == "BOLPER"){
          ?>
            <div class="pdd">
              <div>
                  <strong style="font-size:1.5em;"><?=$_SESSION['pedido']['bolo'][$i]['nome']?></strong>
              </div>
          </div>
          <?php
          }
          }
          $boloPrecoModal = 0;
          for($i=0;$i<count($_SESSION['pedido']['bolo']);$i++){
              $boloPrecoModal += $_SESSION['pedido']['bolo'][$i]['preco'];
          }
          ?>
          <hr>
          <b style="font-size:1.5em;"><?=MRFormiga::trataValor($boloPrecoModal,0)?></b>
          <div>
          <br>
          <b>Observação:</b> pedido feito com menos de 48horas nao poderá sera cancelado, pois já iniciamos a produção.
          <br>
          <b>Seu pedido só será confirmado após envio da entrada.</b>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-formiga bt-finalizar">Finalizar</button>
        <button type="button" class="btn btn-light hidemodal" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
