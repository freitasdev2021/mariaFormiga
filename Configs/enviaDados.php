<?php
require"configs.php";
if(isset($_POST['PMUsuario'])){
    echo Usuarios::setUsuario($_POST);
}elseif(isset($_POST['NMBase'])){
    echo Categorias::setBase($_POST);
}elseif(isset($_POST['IDCet'])){
    echo Produtos::getProdutos($_POST['IDCet'],"0");
}elseif(isset($_POST['IMGProduto'])){
    echo Produtos::setProduto($_POST);
}elseif(isset($_POST['dataPedido'])){
    echo Pedidos::getItens($_POST['dataPedido'],$_POST['qualTabela']);
}elseif(isset($_POST['step'])){
    echo Pedidos::setPedido($_POST);
}elseif(isset($_POST['verifDatas'])){
    echo json_encode(Pedidos::getDiasIndisponiveis());
}elseif(isset($_POST['getCalendar'])){
    echo Pedidos::getPedidosCalendario($_POST['getCalendar']);
}elseif(isset($_POST['finalizarPedido'])){
    if(Pedidos::setPedidoBD($_SESSION['pedido'])){
        unset($_SESSION['dadosPedido']);
        unset($_SESSION['CDPedido']);
        unset($_SESSION['pedido']);
    } 
}elseif(isset($_POST['STPedido'])){
    echo Pedidos::atualizarPedido($_POST);
}elseif(isset($_POST['STCategoria'])){
    echo Pedidos::statusCategoria($_POST);
}