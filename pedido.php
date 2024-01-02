<?php
include"Configs/configs.php";
include"modais/modalMeidia.php";
if(!isset($_SESSION['step']) || isset($_GET['end']) || isset($_GET['continuar'])){
    $_SESSION['step'] = 1;
}
//unset($_SESSION['dadosPedido']);
if(isset($_GET['step'])){
    $_SESSION['step'] = $_GET['step'];
}

// if(isset($_GET['end'])){
//     echo "<script>window.open('https://wa.me/5531983085313?text=Ola','_blank')</script>";
// }


// unset($_SESSION['dadosPedido']);
// unset($_SESSION['CDPedido']);
// unset($_SESSION['pedido']);
if(isset($_SESSION['pedido'])){
    include"modais/modalEndPedido.php";
    // echo "<pre>";
    // print_r($_SESSION['pedido']);
    // echo "</pre>";
    $boloPreco = 0;
    for($i=0;$i<count($_SESSION['pedido']['bolo']);$i++){
        $boloPreco += $_SESSION['pedido']['bolo'][$i]['preco'];
    }
    if(isset($_SESSION['dadosPedido']['DSMensagem'])){
        $_SESSION['pedido']['bolo'][count($_SESSION['pedido']['bolo'])-1]['DSMensagem'] = $_SESSION['dadosPedido']['DSMensagem'];
    }

    $_SESSION['pedido']['VLTotal'] = $boloPreco;
    echo "<nav class='cabecalhoPedido'>";
    echo "<button class='btn btn-success bt-concluir-pedido'>No Carrinho - ".MRFormiga::trataValor($_SESSION['pedido']['VLTotal'],0)." (Clique para Finalizar)</button>";
    echo "</nav>";
}

// echo "<pre>";
// print_r($_SESSION['dadosPedido']);
// echo "</pre>";
if($_SESSION['step'] == 1){
    if(!isset($_GET['step'])){
        unset($_SESSION['dadosPedido']['bolo']);
        unset($_SESSION['dadosPedido']['embalagem']);
    }
    ob_start();
?>
    <input type="hidden" name="sessionTabela" data-dtentrega="<?=(isset($_SESSION['dadosPedido']['DTEntrega']))? $_SESSION['dadosPedido']['DTEntrega'] : ''?>" value="<?=(isset($_SESSION['dadosPedido']['IDTabela']))? $_SESSION['dadosPedido']['IDTabela'] : ''?>">
    <input type="hidden" name="step" value="<?=$_SESSION['step']?>">
    <?php
    if(!isset($_GET['continuar'])){
    ?>
    <input type="name" name="nome" class="required" placeholder="Nome">
    <input type="text" name="telefone" class="required" placeholder="Telefone">
    <input type="text" name="data"  class="required" placeholder="Data">
    <select name='hora'>
        <option value="">Selecione a Hora</option>
        <option value="08:00">08:00</option>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
        <option value="11:00">11:00</option>
        <option value="12:00">12:00</option>
        <option value="13:00">13:00</option>
        <option value="14:00">14:00</option>
        <option value="15:00">15:00</option>
        <option value="16:00">16:00</option>
        <option value="17:00">17:00</option>
        <option value="18:00">18:00</option>
    </select>
    <?php
    }else{
        // echo MRFormiga::data($_SESSION['dadosPedido']['DTEntrega'],'H:i');
    ?>
    <select name='hora' style="display:none;">
        <?php
        if(isset($_GET['continuar'])){
            echo "<option value='".MRFormiga::data($_SESSION['dadosPedido']['DTEntrega'],'H:i')."' selected></option>";
        }
        ?>
        <option value="">Selecione a Hora</option>
        <option value="08:00">08:00</option>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
        <option value="11:00">11:00</option>
        <option value="12:00">12:00</option>
        <option value="13:00">13:00</option>
        <option value="14:00">14:00</option>
        <option value="15:00">15:00</option>
        <option value="16:00">16:00</option>
        <option value="17:00">17:00</option>
        <option value="18:00">18:00</option>
    </select>
    <input type="hidden" name="nome" placeholder="Nome" value="<?=$_SESSION['dadosPedido']['NMCliente']?>">
    <input type="hidden" name="telefone" placeholder="Telefone" value="<?=$_SESSION['dadosPedido']['DTEntrega']?>">
    <input type="hidden" name="data" value="<?=MRFormiga::data($_SESSION['dadosPedido']['DTEntrega'],'d/m/Y')?>">
    <?php
    }
    ?>
    <select name="qualTabela">
        <option value="">Selecione a Tabela</option>
        <?php
            foreach(Categorias::getBasesSelect() as $bs){
        ?>
            <option value="<?=$bs['IDCategoria']?>"><?=$bs['NMCategoria']?></option>
        <?php
            }
        ?>
        <option value="BOLPER">Bolo Personalizado</option>
    </select>
    <br>
    <div class="pedidos">
        <?php
         if(isset($_GET['continuar'])){
            echo "<h1 align='center'>Escolha a Tabela</h1>";
         }else{
            echo "<h1 align='center'>Escolha a Data do Pedido</h1>";
         }
        ?>
    </div>
<?php
    $retorno = ob_get_clean();
}elseif($_SESSION['step'] == 2){
    unset($_SESSION['dadosPedido']['bolo']['preco']);
    unset($_SESSION['dadosPedido']['bolo']['embalagem']);
    unset($_SESSION['dadosPedido']['bolo']['recheio']);
    unset($_SESSION['dadosPedido']['bolo']['massa']);
    unset($_SESSION['dadosPedido']['bolo']['peso']);
    unset($_SESSION['dadosPedido']['bolo']['preco']);
    if(isset($_SESSION['dadosPedido']['bolo']['recheio'])){
        $rcheio = $_SESSION['dadosPedido']['bolo']['recheio'];
    }else{
        $rcheio = "";
    }
    ob_start();
    if(isset($_SESSION['dadosPedido']['TPBase'])){
?>
    <br>
    <input type="hidden" name="step" value="<?=$_SESSION['step']?>">
    <input type="hidden" name="tpitem" value="<?=$_SESSION['dadosPedido']['TPBase']?>">
    <?php
        if($_SESSION['dadosPedido']['TPBase'] == "BOL" || $_SESSION['dadosPedido']['TPBase'] == "TOR"){
    ?>
    <div class="breadCrumbs">
        <h3 align="center">Escolha a Embalagem e o Peso</h3>
    </div>
    <div class="breadCrumbs">
        <div class="col-sm-12">
            <label>Peso (Obrigatório)</label>
            <select name="pesoProduto" data-un="<?=$_SESSION['dadosPedido']['VLBase']?>">
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
        <div class="col-sm-12">
            <label>massa de chocolate acréscimo de 2,00 reais por kg.</label>
            <select name="massaChocolate" style="border:solid;">
              <option value="nenhum">Selecione a Massa (Acréscimo 2,00/KG)</option>
              <option value="Chocolate">Chocolate</option>
              <option value="Tradicional Massa Branca">Tradicional Massa Branca</option>
            </select>
        </div>
        <br>
        <?php
        if($_SESSION['dadosPedido']['TPBase'] == "BOL"){
        ?>
        <div class="col-sm-12">
            <label>Recheios (+ R$5 - Não Obrigatório)</label>
          <select name="recheios">
              <option <?=($rcheio == "nenhum") ? 'selected' : ''?> value="nenhum">Nenhum</option>
              <option <?=($rcheio == "Ninho com chocolate") ? 'selected' : ''?> value="Ninho com chocolate">Ninho com chocolate</option>
              <option <?=($rcheio == "Ninho com creme suíço com pedaços de morango") ? 'selected' : ''?> value="Ninho com creme suíço com pedaços de morango">Ninho com creme suíço com pedaços de morango ( acréscimo de 5,00 reais no kg)</option>
              <option <?=($rcheio == "Ninho com creme suíço com pedaços de abacaxi") ? 'selected' : ''?> value="Ninho com creme suíço com pedaços de abacaxi">Ninho com creme suíço com pedaços de abacaxi ( acréscimo de 5,00 reais no kg)</option>
              <option <?=($rcheio == "Ninho com doce de leite") ? 'selected' : ''?> value="Ninho com doce de leite">Ninho com doce de leite </option>
              <option <?=($rcheio == "Ninho com bombom") ? 'selected' : ''?> value="Ninho com bombom">Ninho com bombom</option>
              <option <?=($rcheio == "chocolate com bombom") ? 'selected' : ''?> value="chocolate com bombom">chocolate com bombom</option>
              <option <?=($rcheio == "Chocolate com creme suíço com pedaços de abacaxi") ? 'selected' : ''?> value="Chocolate com creme suíço com pedaços de abacaxi">Chocolate com creme suíço com pedaços de abacaxi ( acréscimo de 5,00 reais no kg)</option>
              <option <?=($rcheio == "Chocolate com creme suíço com pedaços de morango") ? 'selected' : ''?> value="Chocolate com creme suíço com pedaços de morango">Chocolate com creme suíço com pedaços de morango ( acréscimo de 5,00 reais no kg)</option>
              <option <?=($rcheio == "Chocolate com doce de leite") ? 'selected' : ''?> value="Chocolate com doce de leite">Chocolate com doce de leite </option>
              <option <?=($rcheio == "Chocolate com maracujá") ? 'selected' : ''?> value="Chocolate com maracujá">Chocolate com maracujá ( acréscimo de 5,00 reais no kg)</option>
              <option <?=($rcheio == "Chocolate com coco") ? 'selected' : ''?> value="Chocolate com coco">Chocolate com coco</option>
              <option <?=($rcheio == "Coco com doce de leite") ? 'selected' : ''?> value="Coco com doce de leite">Coco com doce de leite</option>
              <option <?=($rcheio == "Coco com abacaxi com ninho") ? 'selected' : ''?> value="Coco com abacaxi com ninho">Coco com abacaxi com ninho ( acréscimo de 5,00 no kg )</option>
              <option <?=($rcheio == "Coco com abacaxi e doce de leite") ? 'selected' : ''?> value="Coco com abacaxi e doce de leite">Coco com abacaxi e doce de leite ( acréscimo de 5,00 reais no kg)</option>
            </select>
        </div>
        <?php
        }
        ?>
        <br>
        <div align="center">
        <b>observação: </b>Pode ou não haver uma Margem de erro de 15% no Peso do Bolo/Torta
        </div>
    </div>
    <?php
    }elseif($_SESSION['dadosPedido']['TPBase'] == "DOC"){
    ?>
    <div class="breadCrumbs">
        <div class="col-sm-12">
            <input type="hidden" name="tpdoce" value="<?=$_SESSION['dadosPedido']['bolo']['tpdoce']?>">
            <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" data-un="<?=$_SESSION['dadosPedido']['VLBase']?>" name="gourmet" placeholder="Quantidade">
        </div>
    </div>
    <?php
        }
    ?>
    <br>
    <?php
    if($_SESSION['dadosPedido']['TPBase'] == "BOL" || $_SESSION['dadosPedido']['TPBase'] == "TOR"){
    ?>
    <div class="embalagens">
        <?php
        foreach(Produtos::getEmbalagens() as $e){
        ?>
            <div class="emb">
            <img width="250px" height="250px" src="<?=$e['IMGProduto']?>">
            <strong><?=$e['NMProduto']?></strong>
            <button class="btn-formiga bt-embalagem" data-suportado="<?=$e['PSEmb']?>" data-id='<?=$e['IDProduto']?>' data-emb='<?=$e['VLBase']?>'>Selecionar - <?=MRFormiga::trataValor($e['VLBase'],0)?></button>
            <hr>
            </div>
        <?php
        }
        ?>
    </div>
    <?php
    }elseif($_SESSION['dadosPedido']['TPBase'] == "DOC"){
        unset($_SESSION['dadosPedido']['embalagem']);
    ?>
    <div id="pedidoDoce">
        <img src="<?=$_SESSION['dadosPedido']['bolo']['fotoBolo']?>" width="250px" height="250px" id='imgDoc'>
        <br>
        <textarea name="mensagem" cols="30" rows="5" placeholder="Deixe uma Mensagem (Opcional)"></textarea>
        <br>
        <button class="bt-continuar-doce btn btn-formiga">Continuar</button>
    </div>
    <?php
    }elseif($_SESSION['dadosPedido']['TPBase'] == "BOLPER"){ ////BOLO PERSONALIZADO
    ?>
    <h3 align='center' style='color:white;'>Envie uma Foto do Bolo Personalizado, e se caso não houver topo na foto, envie tambem um Topo</h3>
    <div id="pedidoDoce">
        <input type="file" id="imagemBolper">
        <input type="hidden" name="fotoBolper">
        <img src="img/bolovetor.jpg" width="250px" height="250px" id='imgBolper'>
    </div>
    <br>
    <div id="pedidoDoce">
        <input type="file" id="imagemTopoBolper">
        <input type="hidden" name="fotoTopoBolper">
        <img src="img/semtopo.jpg" width="250px" height="250px" id='imgTopoBolper'>
        <br>
        <textarea name="mensagem" cols="30" rows="5" placeholder="Deixe uma Mensagem (Opcional)"></textarea>
        <br>
    </div>
    <button class="bt-continuar-bolper btn btn-formiga">Continuar</button>
    <br>
    <?php
    }
    }
    if(isset($_SESSION['dadosPedido']) && $_SESSION['dadosPedido']['TPBase'] != "BOLPER"){
    ?>
    <footer class="bg-formiga footer-preco">
        <h3 id='prTotal'>Esse Pedido: <?=(isset($_SESSION['dadosPedido']['vlTotal'])) ? MRFormiga::trataValor($_SESSION['dadosPedido']['vlTotal'],0) : '0,00'?></h3>
    </footer>
<?php
    }
 $retorno = ob_get_clean();
}elseif($_SESSION['step'] == 3){
    unset($_SESSION['dadosPedido']['DSMensagem']);
    //echo $_SESSION['dadosPedido']['bolo']['peso'] * $_SESSION['dadosPedido']['bolo']['precoUn'];
    //unset($_SESSION['dadosPedido']);
    ob_start();
?>
<div class="breadCrumbs" style="display:none;">
<input type="hidden" name="tpitem" value="<?=$_SESSION['dadosPedido']['TPBase']?>">
<input type="hidden" name="step" value="<?=$_SESSION['step']?>">
    <br>
    <?php
        if($_SESSION['dadosPedido']['TPBase'] == "BOL"){
    ?>
    <h3 align="center">Escolha o Topo</h3>
    <?php
        }
    ?>
</div>
<div class="col-sm-12 file-campo">
    <?php
        if($_SESSION['dadosPedido']['TPBase'] == "BOL" || $_SESSION['dadosPedido']['TPBase'] == "TOR"){
    ?>
    <input type="file" id="imagemTopo">
    <img src="img/semtopo.jpg" class="img-topo" width="250px" height="250px">
    <?php
        }
    ?>
    <br>
    <textarea name="mensagem" cols="30" rows="5" placeholder="frase que vai no topo  no topo, (caso tiver topo)"></textarea>
</div>
<div class="col-sm-12">
    
</div>
<footer class="footer-preco">
    <?php
    //ARRAY COM RECHEIOS DE 5 REAIS
    $arrayCinco = array(
        "Ninho com creme suíço com pedaços de morango",
        "Ninho com creme suíço com pedaços de abacaxi",
        "Chocolate com maracujá",
        "Coco com abacaxi com ninho",
        "Coco com abacaxi e doce de leite"
    );
    //CONDIÇOES DE RECHEIOS
    if($_SESSION['dadosPedido']['bolo']['recheio'] == "nenhum"){
        $valorRecheio = 0;
    }elseif(in_Array($_SESSION['dadosPedido']['bolo']['recheio'],$arrayCinco)){
        $valorRecheio = 5;
    }else{
        $valorRecheio = 0;
    }
    ?>
    <button class="btn btn-formiga bt-continuar-pedidos">Continuar - <?=MRFormiga::trataValor($_SESSION['dadosPedido']['vlTotal'],0);?></button>
</footer>
<?php
    $retorno = ob_get_clean();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pedido</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="img/fricon.ico" />
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/libs/styles.css" rel="stylesheet" />
    <link href="css/pedidos.css" rel="stylesheet" />
    <link href="css/libs/scrollable-tabs.css" rel="stylesheet" />
    <link href="css/libs/scrollable-tabs.min.css" rel="stylesheet" />
    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!--LOAD-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/libs/load.css">
    <link rel="stylesheet" href="css/lateralBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--DATATABLES-->
    <link rel="stylesheet" href="css/libs/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="css/libs/Responsive-Table.css">
    <link rel="stylesheet" href="js/libs/tablepagination/paging.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <link href="https://fonts.cdnfonts.com/css/gourmet" rel="stylesheet"> -->
    <link href="https://fonts.cdnfonts.com/css/chocolate-cake" rel="stylesheet">
</head>
<body style="background:#E9B5D2;">
 <!--PEDIDO AQUI-->
<div class="main">
    <?php
    echo $retorno;
    ?>
</div>
 <!--PEDIDO-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="js/pedidos.js"></script>
</body>
</html>