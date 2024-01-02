<?php
require"BD/bd.php";
//SET PEDIDO
public static function setPedido($dados){
    extract($dados);
    //$cdPedido = $_SESSION['CDPedido'];
    if($step == 1){
        $nome = $dados['NMCliente'];
        $telefone = $dados['TLCliente'];
        $imagem = $dados['IMGBolo'];
        $entrega = $dados['DTEntrega'];
        $idbolo = $dados['IDBolo'];
        //
        // if(isset($_SESSION['CDPedido'])){
        //     $SQL = "UPDATE pedidos SET NMCliente = '$nome', NUTelefoneCliente='$telefone',IMGBolo = '$imagem',DTEntrega = '$entrega',IDProduto = '$idbolo' WHERE IDPedido = ''";
        // }else{
            
        // }
        $SQL = "INSERT INTO pedidos (NMCliente,NUTelefoneCliente,IMGBolo,DTEntrega,IDProduto) VALUES('$nome','$telefone','$imagem','$entrega','$idbolo')";
        mysqli_query(MRFormiga::DB(),$SQL);
        $_SESSION['CDPedido'] = mysqli_insert_id(MRFormiga::DB());
        //
        //
        
        // $sqlPedido = mysqli_query(MRFormiga::DB(),"SELECT VLBase,TPBase,IDPedido FROM pedidos LEFT JOIN produtos USING (IDProduto) LEFT JOIN categorias USING(IDCategoria) WHERE CDPedido = '$cdPedido'");
        // $pedido = mysqli_fetch_assoc($sqlPedido);
        // $_SESSION['dadosPedido'] = array(
        //     "VLBase" => $pedido['VLBase'],
        //     "TPBase" => $pedido['TPBase']
        // );
    }
    //return $step;
    return true;
}