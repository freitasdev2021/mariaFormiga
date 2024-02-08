<?php
include"includes/header.php";
?>
<div class="w-100">
    <div class="scroller scroller-left float-start mt-2"><i class="bi bi-caret-left-fill"></i></div>
    <div class="scroller scroller-right float-end mt-2"><i class="bi bi-caret-right-fill"></i></div>
    <div class="wrapper-nav">
    <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <a class="nav-item nav-link pointer active text-black" data-bs-toggle="tab" data-bs-target="#tab1" role="tab" aria-controls="public" aria-selected="true">Pedidos</a>
            <a class="nav-item nav-link pointer text-black" data-bs-target="#tab3" role="tab" data-bs-toggle="tab">Calendário de Pedidos</a>
            <!-- <a class="nav-item nav-link pointer text-black" data-bs-target="#tab4" role="tab" data-bs-toggle="tab">Crediário</a> -->
        </nav>
    </div>
    <div class="tab-content p-3" id="mytabContent">
        <div role="tabpanel" class="tab-pane fade active show mt-2" id="tab1" aria-labelledby="public-tab" >
            <div class="conteudo">
                <!--EXPULSA EXPULSA-->
                <form action="index.php" method="GET" class='row col-sm-12 d-flex justify-content-center'>
                    <div class='col-sm-2'>
                        <input type="search" name="pesquisa" class='form-control' value="<?=(isset($_GET['pesquisa']))?  $_GET['pesquisa'] : ''?>" placeholder='Pesquisar...'>
                    </div>
                    <div class='col-sm-2'>
                        <input type="date" name="de" class='form-control' value="<?=(isset($_GET['de']))?  $_GET['ate'] : ''?>">
                    </div>
                    <div class='col-auto' style='margin-top:7px;'>
                        Até
                    </div>
                    <div class='col-sm-2'>
                        <input type="date" name="ate" class='form-control' value="<?=(isset($_GET['de']))?  $_GET['ate'] : ''?>">
                    </div>
                    <div class='col-sm-2'>
                        <select name="status" class="form-control">
                            <option value="0" <?=(isset($_GET['status']) && $_GET['status'] == 0)? 'selected' : ''?>>Em Atendimento</option>
                            <option value="1" <?=(isset($_GET['status']) && $_GET['status'] == 1)? 'selected' : ''?>>Massa para Rechear</option>
                            <option value="2" <?=(isset($_GET['status']) && $_GET['status'] == 2)? 'selected' : ''?>>Topo Produção</option>
                            <option value="3" <?=(isset($_GET['status']) && $_GET['status'] == 3)? 'selected' : ''?>>Etiqueta Pronta</option>
                            <option value="4" <?=(isset($_GET['status']) && $_GET['status'] == 4)? 'selected' : ''?>>Recheado</option>
                            <option value="5" <?=(isset($_GET['status']) && $_GET['status'] == 5)? 'selected' : ''?>>Entregue</option>
                        </select>
                    </div>
                    <div class='col-auto'>
                        <button type="submit" class='btn btn-formiga'>Pesquisar</button>
                    </div>
                    <div class='col-auto'>
                        <a href='index.php' class='btn btn-formiga'>Limpar</a>
                    </div>
                </form>
                <!----->
                <div id="accordion" class="acordeoes">
                    <?php
                        foreach(Pedidos::getListaPedidos() as $p){
                            if(isset($p['DSEmbalagem'])){
                                $dadosEmb = json_decode($p['DSEmbalagem'],true);
                                //var_dump($dadosEmb);
                            }else{
                                $dadosEmb = "";
                            }
                            $pedido = json_decode($p['PedidoJSON'],true);
                            // echo "<pre>";
                            // print_r($pedido);
                            // echo "</pre>";
                            switch($p['STPedido']){
                                case 0:
                                    $status = 'bg-atendimento';
                                    $text = 'text-black ';
                                break;
                                case 1:
                                    $status = 'bg-rechear';
                                    $text = '';
                                break;
                                case 2:
                                    $status = 'bg-topoproducao';
                                    $text = 'text-black ';
                                break;
                                case 3:
                                    $status = 'bg-etiquetapronta';
                                    $text = '';
                                break;
                                case 4:
                                    $status = 'bg-recheado';
                                    $text = '';
                                break;
                                case 5:
                                    $status = 'bg-entregue';
                                    $text = '';
                                break;
                            }
                    ?>
                        <div class="card">
                            <div class="card-header <?=$status?>" id="headingOne" style='border:solid; border-color: pink'>
                            <h5 class="mb-0 voltaOlimpica">
                                <button class="btn <?=$text?>" data-toggle="collapse" data-target="#collapseOne_<?=$p['IDPedido']?>" aria-expanded="true" aria-controls="collapseOne">
                                <?=$p['NMCliente']." - ".MRFormiga::data($p['DTEntrega'],'d/m/Y - H:i')?>
                                </button>
                                <div>
                                    <select name='statusPedido' class='stpedido' data-id='<?=$p['IDPedido']?>'>
                                        <option value="0" <?=($p['STPedido'] == 0)? 'selected' : ''?>>Em Atendimento</option>
                                        <option value="1" <?=($p['STPedido'] == 1)? 'selected' : ''?>>Massa para Rechear</option>
                                        <option value="2" <?=($p['STPedido'] == 2)? 'selected' : ''?>>Topo Produção</option>
                                        <option value="3" <?=($p['STPedido'] == 3)? 'selected' : ''?>>Etiqueta Pronta</option>
                                        <option value="4" <?=($p['STPedido'] == 4)? 'selected' : ''?>>Recheado</option>
                                        <option value="5" <?=($p['STPedido'] == 5)? 'selected' : ''?>>Entregue</option>
                                    </select>
                                </div>
                                <div>
                                    <a href="https://api.whatsapp.com/send/?phone=<?=$p['NUTelefoneCliente']?>&text&type=phone_number" class="btn btn-sm text-formiga" style="background:pink; padding:10px;" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                                </div>
                            </h5>
                            </div>
                    
                            <div id="collapseOne_<?=$p['IDPedido']?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body conteudo-principal conteudo-pedido">
                                    <?php
                                    if($pedido){
                                        $dadosPedido = array();
                                    foreach($pedido as $pd){
                                    ?>
                                    <div class="prod-pedido">
                                        <?php
                                        if($pd['tipo'] == 'BOL' || $pd['tipo'] == "TOR"){
                                            $dadosPedido[] = array(
                                                "Nome" => $pd['nome'],
                                                "Quantidade" => $pd['peso'],
                                                "Valor" => str_replace("Esse Pedido: ","",$pd['preco'])
                                            );
                                        ?>
                                        <div class="carrinho">
                                            <img src="<?=$pd['fotoBolo']?>">
                                            <strong><?=$pd['nome']?></strong>
                                            <br>
                                            <?php
                                            if(!empty($pd['recheio'])){
                                                echo "<strong>".$pd['recheio']."</strong>";
                                            }
                                            if(isset($pd['embalagem'])){
                                                echo "<br>";
                                                echo "<strong>".$pd['embalagem']['nome']."</strong>";
                                            }
                                            ?>  
                                        </div>                              
                                        <?php
                                        }elseif($pd['tipo'] == 'DOC'){
                                            $saboresDoces = array();
                                            for($i=0;$i<count($pd['doces']);$i++){
                                                array_push($saboresDoces,$pd['doces'][$i]['NMBolo']);
                                        ?>
                                        <div class="carrinho">
                                            <img src='<?=$pd['doces'][$i]['IMGBolo']?>'>
                                            <strong><?=$pd['doces'][$i]['NMBolo']?></strong>
                                        </div>
                                        <?php
                                            }
                                            $dadosPedido[] = array(
                                                "Nome" => implode(",",$saboresDoces),
                                                "Quantidade" => $pd['peso'],
                                                "Valor" => MRFormiga::trataValor($pd['preco'],0)
                                            );
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if($pd['tipo'] == "BOL" || $pd['tipo'] == "TOR"){
                                        if(!empty($dadosEmb)){
                                    ?>
                                    <div class="prod-pedido">
                                        <h3>Embalagem</h3>
                                        <img src="<?=$dadosEmb['imagemEmbalagem']?>">
                                        <strong><?=$dadosEmb['embalagem']?></strong>
                                    </div>
                                    <?php
                                        }
                                    if(isset($p['fotoTopo'])){
                                    ?>
                                    <div class="prod-pedido">
                                        <h3>Topo</h3>
                                        <img src="<?=$p['IMGTopo']?>">
                                    </div>
                                    <?php
                                            }
                                        }
                                    }
                                    // echo "<pre>";
                                    // print_r($dadosPedido);
                                    // echo "</pre>";
                                }
                                    ?>
                                </div>
                                <br>
                                <hr>
                                <div class="pedidoTotal">
                                    <ul>
                                    <?php
                                    foreach($dadosPedido as $dp){
                                    ?>
                                        <li><?=$dp['Nome']." | Quantidade: ".$dp['Quantidade']." | (R$ ".$dp['Valor'].")";?></li>
                                    <?php
                                    }
                                    ?>
                                    </ul>
                                    <div>
                                        <strong><?="Valor: ".MRFormiga::trataValor($p['VLPedido'],0)?></strong>
                                    </div>
                                    <div>
                                        <strong>Entrega: <?=MRFormiga::data($p['DTEntrega'],'d/m/Y - H:i')?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade mt-2" id="tab3" role="tabpanel" aria-labelledby="group-dropdown2-tab">
            <section class="ftco-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="calendar-section">
                        <div class="row no-gutters">
                        <div class="col-md-6">

                            <div class="calendar calendar-first" id="calendar_first">
                            <div class="calendar_header">
                                <button class="switch-month switch-left">
                                <i class="fa fa-chevron-left"></i>
                                </button>
                                <h2></h2>
                                <button class="switch-month switch-right">
                                <i class="fa fa-chevron-right"></i>
                                </button>
                            </div>
                            <div class="calendar_weekdays"></div>
                            <div class="calendar_content"></div>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="calendar calendar-second" id="calendar_second">
                            <div class="calendar_header">
                                <button class="switch-month switch-left">
                                <i class="fa fa-chevron-left"></i>
                                </button>
                                <h2></h2>
                                <button class="switch-month switch-right">
                                <i class="fa fa-chevron-right"></i>
                                </button>
                            </div>
                            <div class="calendar_weekdays"></div>
                            <div class="calendar_content"></div>
                            </div>            

                        </div>

                        </div> <!-- End Row -->
                            
                    </div> <!-- End Calendar -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php
include"includes/footer.php";
?>