<?php
include"includes/header.php";
include"modais/modalUsuarios.php";
?>
<div class="lista-usuarios">
    <div class="usuario">
        <img src="img/mais.png" width="100%" height="100px" id="bt_usuario">
    </div>
    <?php
    foreach(Usuarios::getUsuarios() as $gs){
    ?>
    <div class="usuario" data-id="<?=$gs['IDUsuario']?>">
        <img src="img/user.png" width="100%" height="100px" class="imgUs">
        <strong class="titleGrid" data-ps="<?=$gs['PSUsuario']?>"><?=$gs['NMUsuario']?></strong>
        <span class="pms" style="display:none;">
            <?=$gs['PMUsuario']?>
        </span>
    </div>
    <?php
    }
    ?>
</div>
<?php
include"includes/footer.php";
?>