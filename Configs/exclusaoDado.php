<?php
require"Configs.php";
if(isset($_POST['ID'])){
    echo Usuarios::delUsuario($_POST);
}elseif(isset($_POST['IDBase'])){
    echo Categorias::delBase($_POST['IDBase']);
}elseif(isset($_POST['IDProduto'])){
    echo Produtos::delProduto($_POST['IDProduto']);
}