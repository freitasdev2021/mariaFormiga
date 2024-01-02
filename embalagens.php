<?php
include"includes/header.php";
?>
<div class="conteudo">
    <div class="breadCrumbs">
        <button class="btn btn-formiga text-formiga breadItem bt_adicionar_base" data-tipo="EMB">Adicionar Tipo</button>
        <input type="search" class="form-control breadItem" placeholder="Pesquisar.." name="pesquisaProdutos">
    </div>
    <div id="accordion">
    <?php
    foreach(Categorias::getBases("EMB") as $b){
    ?>
        <div class="card" data-id='<?=$b['IDCategoria']?>'>
            <div class="card-header bg-formiga" id="headingOne">
            <h5 class="mb-0 voltaOlimpica">
                <button class="btn btn-formiga titleAcordion" data-tipocategoria="EMB" data-toggle="collapse" data-target="#collapseOne_<?=$b['IDCategoria']?>" aria-expanded="true" aria-controls="collapseOne">
                <?=$b['NMCategoria']?>
                -
                <?=MRFormiga::trataValor($b['VLBase'],0)."/".$b['TPUn']?>
                </button>
                <div>
                    <button class="btn btn-sm text-formiga bt-adicionar-bolo" data-categoria='<?=$b['IDCategoria']?>' data-tipocategoria="EMB" style="background:pink">Adicionar Embalagem</button>
                    <button class="btn btn-xl text-formiga bt-editar-base" data-nome='<?=$b['NMCategoria']?>' data-preco='<?=$b['VLBase']?>' data-un='<?=$b['TPUn']?>' data-id='<?=$b['IDCategoria']?>' style="background:pink"><i class='fas fa-pen'></i></button>
                </div>
            </h5>
            </div>
            <div id="collapseOne_<?=$b['IDCategoria']?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body conteudo-principal categoria_<?=$b['IDCategoria']?>">
                    
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<?php
include"includes/footer.php";
?>