<?php
require"BD/bd.php";
session_start();
class Autenticacao {
    /** EFETUA O LOGIN
	 * 
	 * Retorna um array contendo o status do login e abastecendo as sessoes
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */
    public static function efetuarLogin($user,$senha){
        $SQL = mysqli_query(MRFormiga::DB(),"SELECT * FROM usuarios WHERE NMUsuario = '$user' AND PSUsuario = '$senha' "); //CONSULTA - REALIZA A CONSULTA NO BANCO DE DADOS
        $login = mysqli_fetch_assoc($SQL);
        if($login){
            $PMUsuario = json_decode($login['PMUsuario']); //Permissões do usuário
            $STUsuario = $login['STUsuario']; //Situação do Usuario
            $IDUsuario = $login['IDUsuario'];
            //Pergunta se o contrato do usuário está ativo
            if($STUsuario == 1){
                $_SESSION['login'] = array(
                    "ID" => $IDUsuario,
                    "PMUsuario" => $PMUsuario
                );
                $retorno['status'] = true;
            }else{
                $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Suporte</strong></h5>";
                $retorno['status'] = false;
            }
        }else{
            $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Credenciais incorretas</strong></h5>";
            $retorno['status'] = false;
        }
        return json_encode($retorno);
    }

    public static function userPerm($numero,$modulo){
        if($_SESSION['login']['ID'] > 1){
            $p1 = json_encode($_SESSION['login']['PMUsuario']);
            $permissoes = json_decode($p1,true);
            if(is_int(array_search($numero,$permissoes[$modulo]))){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    /** CONFERE SE O USUARIO ESTA LOGADO
	 * 
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */
    public static function conferirLogin(){
        if(empty($_SESSION["login"])){
            $v_return = 0;
        }else{
            $v_return = 1;
        }

        return $v_return;
    }

    /** RETORNA A PERMISSÃO DO USUARIO
	 * 
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */
    public function conferirArea($Nivel){
        if(self::conferirLogin() == 1){
            return $Nivel;
        }
    }

    /** RETORNA O ACESSO DO CLIENTE
	 * 
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */
    public static function conferirAcesso($ID){
        $SQL = mysqli_query(MRFormiga::DB(),"SELECT col.STAcesso,us.STUsuario,con.STContrato FROM usuarios as us 
        LEFT JOIN colaboradores as col USING(IDColaborador) 
        LEFT JOIN contratos con USING(IDContrato) 
        WHERE IDUsuario = $ID  ");
        $v_acesso = mysqli_fetch_assoc($SQL);
        if($_SESSION['login']['nivel'] > 1){
            if($v_acesso['STContrato'] == 0){
                if($_SESSION['login']['nivel'] == 1.5){
                    if($v_acesso['STUsuario'] == 0){
                        $v_access = 0;
                    }else{
                        $v_access = 1;
                    }
                }else{
                    $v_access = 0;
                }
            }else{
                if($_SESSION['login']['nivel'] == 3.5){
                    if($v_acesso['STAcesso'] == 0){
                        $v_access = 0;
                    }else{
                        $v_access = 1;
                    }
                }elseif($_SESSION['login']['nivel'] == 3){
                    if($v_acesso['STContrato'] == 0){
                        $v_access = 0;
                    }else{
                        $v_access = 1;
                    }
                }
            }
        }else{
            $v_access = 1;
        }
        return $v_access;
    }
    //

}

class Usuarios{
    public static function getUsuarios(){
        $SQL = mysqli_query(MRFormiga::DB(),"SELECT * FROM usuarios WHERE IDUsuario != 1");
        return $SQL;
    }

    public static function delUsuario($dados){
        extract($dados);
        return mysqli_query(MRFormiga::DB(),"DELETE FROM usuarios WHERE IDUsuario = $ID");
    }

    public static function setUsuario($dados){
        extract($dados);
        if($ID){
            $SQL = "UPDATE usuarios SET NMUsuario = '$NMUsuario', PSUsuario = '$PSUsuario', PMUsuario = '$PMUsuario' WHERE IDUsuario = $ID";
        }else{
            $SQL = "INSERT INTO usuarios (NMUsuario,PSUsuario,PMUsuario) VALUES('$NMUsuario','$PSUsuario','$PMUsuario')";
        }
        return mysqli_query(MRFormiga::DB(),$SQL);
    }
}

class Categorias{
    public static function setBase($dados){
        extract($dados);
        if(isset($TPDoce)){
            $tipoDoce = $TPDoce; 
        }else{
            $tipoDoce = "";
        }
        if($IDBase){
            $SQL = "UPDATE categorias SET NMCategoria = '$NMBase', VLBase = '$VLBase',TPUn = '$TPUn',TPDoce = '$tipoDoce' WHERE IDCategoria = $IDBase ";
        }else{
            $SQL = "INSERT INTO categorias (NMCategoria,VLBase,TPBase,TPUn,TPDoce) VALUES ('$NMBase','$VLBase','$TPBase','$TPUn','$tipoDoce')";
        }
        return mysqli_query(MRFormiga::DB(),$SQL);
    }

    public static function getBases($base){
        if(!empty($base)){
            $SQL = "SELECT * FROM categorias WHERE categorias.TPBase = '$base' ORDER BY categorias.IDCategoria ASC";
        }else{
            $SQL = "SELECT * FROM categorias LEFT JOIN produtos USING(IDCategoria) WHERE categorias.TPBase IN('BOL','TOR','DOC') GROUP BY NMProduto ORDER BY categorias.IDCategoria ASC";
        }
        
        return mysqli_query(MRFormiga::DB(),$SQL);
    }

    public static function getBasesSelect(){
        $SQL = "SELECT IDCategoria,NMCategoria FROM categorias WHERE TPBase !='EMB' AND STTabela = 1";
        return mysqli_query(MRFormiga::DB(),$SQL);
    }

    public static function delBase($ID){
        mysqli_query(MRFormiga::DB(),"DELETE FROM categorias WHERE IDCategoria = $ID");
        mysqli_query(MRFormiga::DB(),"DELETE FROM produtos WHERE IDCategoria = $ID");
    }

}

class Produtos{
    public static function getItensPedido($base){
        if(!empty($base)){
            $SQL = mysqli_query(MRFormiga::DB(),"SELECT 
                produtos.TPBase,
                produtos.STChantilly,
                produtos.IMGProduto,
                categorias.VLBase,
                categorias.TPDoce,
                categorias.TPUn,
                produtos.PSEmb,
                produtos.IDProduto,
                categorias.IDCategoria,
                produtos.NMProduto 
            FROM categorias LEFT JOIN produtos USING(IDCategoria) WHERE produtos.IDCategoria = '$base' GROUP BY NMProduto ORDER BY produtos.IDCategoria ASC");
        }else{
            $SQL = mysqli_query(MRFormiga::DB(),"SELECT 
                produtos.TPBase,
                produtos.STChantilly,
                produtos.IMGProduto,
                categorias.VLBase,
                categorias.TPDoce,
                categorias.TPUn,
                produtos.PSEmb,
                produtos.IDProduto,
                categorias.IDCategoria,
                produtos.NMProduto 
            FROM categorias LEFT JOIN produtos USING(IDCategoria) WHERE categorias.TPBase IN('TOR','DOC','BOL') GROUP BY NMProduto ORDER BY produtos.IDCategoria ASC");
        }
        
        return $SQL;
    }
    public static function setProduto($dados){
        extract($dados);
        if(isset($PSEmb)){
            if($IDProduto){
                $SQL = "UPDATE produtos SET NMProduto = '$NMProduto', IMGProduto = '$IMGProduto', PSEmb = '$PSEmb' WHERE IDProduto = '$IDProduto' ";
            }else{
                $SQL = "INSERT INTO produtos (NMProduto,IMGProduto,IDCategoria,PSEmb) VALUES ('$NMProduto','$IMGProduto','$IDCategoria','$PSEmb')";
            }
        }elseif(isset($TPBolo)){
            if($IDProduto){
                $SQL = "UPDATE produtos SET NMProduto = '$NMProduto', IMGProduto = '$IMGProduto', STChantilly = '$TPBolo' WHERE IDProduto = '$IDProduto' ";
            }else{
                $SQL = "INSERT INTO produtos (NMProduto,IMGProduto,IDCategoria,STChantilly,TPBase) VALUES ('$NMProduto','$IMGProduto','$IDCategoria',$TPBolo,'$TPBase')";
            }
        }else{
            if($IDProduto){
                $SQL = "UPDATE produtos SET NMProduto = '$NMProduto', IMGProduto = '$IMGProduto' WHERE IDProduto = '$IDProduto' ";
            }else{
                $SQL = "INSERT INTO produtos (NMProduto,IMGProduto,IDCategoria) VALUES ('$NMProduto','$IMGProduto','$IDCategoria')";
            }
        }
        return mysqli_query(MRFormiga::DB(),$SQL);
    }

    public static function getEmbalagens(){
        $SQL = "SELECT * FROM produtos LEFT JOIN categorias USING(IDCategoria) WHERE categorias.TPBase = 'EMB'";
        return mysqli_query(MRFormiga::DB(),$SQL);
    }

    public static function getProdutos($ID,$horarios){
        $SQL = mysqli_query(MRFormiga::DB(),"SELECT * FROM produtos LEFT JOIN categorias USING(IDCategoria) WHERE IDCategoria = $ID");
        ob_start();
        foreach($SQL as $s){
        ?>
        <div class="item">
            <?php
            if(is_array($horarios)){
            ?>
            <div class="partePedido">
                <button class="btn btn-formiga bt-pedir">Pedir</button>
                <?php
                echo "<select name='hora'>";
                foreach($horarios as $key => $val){
                    echo "<option value='$key'>$key</option>";
                }
                echo "</select>";
                ?>
            </div>
            <?php
            }
            ?>
            <img src="<?=$s['IMGProduto']?>" 
            data-chantilly='<?=$s['STChantilly']?>' 
            data-tpbase="<?=$s['TPBase']?>"
            data-tpdoce="<?=$s['TPDoce']?>"
            data-psembalagem="<?=$s['PSEmb']?>"
            width="100%" height="250px" style="cursor:pointer;" class="fotoProduto" data-id='<?=$s['IDProduto']?>' data-categoria='<?=$s['IDCategoria']?>' data-nome='<?=$s['NMProduto']?>'>
            <?php
            if($s['TPBase'] == "EMB"){
            ?>
            <input type="radio" name="embalagem" data-vlbase='<?=$s['VLBase']?>' value="<?=$s['IDProduto']?>">&nbsp;
            <?php
            }
            ?>
            <strong class="titleGrid"><?=$s['NMProduto']?></strong>
        </div>
        <?php
        }
        return ob_get_clean();
    }

    public static function delProduto($ID){
        mysqli_query(MRFormiga::DB(),"DELETE FROM produtos WHERE IDProduto = $ID");
    }
}

class Pedidos{
    // public static function getHorarioPedido($data,$hora,$beis){
    //     if(!empty($beis)){
    //         $bs = " AND TPBase= '$beis'";
    //     }else{
    //         $bs = "";
    //     }
    //     if($hora != "Dia"){
    //         $SQL = mysqli_query(MRFormiga::DB(),"SELECT CASE WHEN IDCategoria IS NOT NULL THEN COUNT(IDCategoria) ELSE 0 END as Pedidos, SUM(QTProduto) as PedidosQT FROM pedidos LEFT JOIN produtos USING(IDProduto) WHERE DTEntrega LIKE '%$data%' AND DTEntrega LIKE '%$hora%' $bs");
    //     }else{
    //         $SQL = mysqli_query(MRFormiga::DB(),"SELECT 
    //             SUM(QTProduto) as PedidosQT,
    //             (SELECT 
    //                 CASE WHEN IDCategoria IS NOT NULL THEN COUNT(IDCategoria) ELSE 0 END 
    //                 FROM pedidos LEFT JOIN produtos USING(IDProduto) 
    //                 LEFT JOIN categorias USING(IDCategoria) 
    //                 WHERE DATE_FORMAT(DTEntrega,'%Y-%m-%d') = DATE_FORMAT('$data','%Y-%m-%d') AND categorias.TPBase IN('TOR','BOL','DOC')
    //             ) as Pedidos
    //         FROM pedidos 
    //         LEFT JOIN produtos USING(IDProduto) 
    //         LEFT JOIN categorias 
    //         USING(IDCategoria) 
    //         WHERE DATE_FORMAT(DTEntrega,'%Y-%m-%d') = DATE_FORMAT('$data','%Y-%m-%d') AND categorias.TPBase IN('TOR','BOL','DOC')");
    //     }
        
    //     return mysqli_fetch_assoc($SQL);
    //     //return "SELECT CASE WHEN IDCategoria IS NOT NULL THEN COUNT(IDCategoria) ELSE 0 END as Pedidos FROM pedidos INNER JOIN produtos USING(IDProduto) INNER JOIN categorias USING(IDCategoria) WHERE DTEntrega LIKE '%$data%' AND DTEntrega LIKE '%$hora%' GROUP BY TPBase"
    // }

    public static function getPedidosCalendario(){
        
        $SQL = "SELECT * FROM pedidos";
        //GERA OS PROXIMOS 30 DIAS
        $NewDate=Date('Y-m-d', strtotime('+32 days'));
        $period = new DatePeriod(
            new DateTime(),
            new DateInterval('P1D'),
            new DateTime($NewDate)
        );
        $dates = array();
        foreach ($period as $key => $value) {
            array_push($dates,$value->format('Y-m-d'));     
        }
        //PEGA OS PEDIDOS
        $getPedido = mysqli_query(MRFormiga::DB(),$SQL);
        $pedidos = array();
        foreach($getPedido as $gp){
            $pedidos[] = $gp;
        }
        //COMPARA AS DATAS
        $pdds = array();
        foreach($dates as $d){
            foreach($pedidos as $p){
                if(MRFormiga::data($p['DTEntrega'],"Y-m-d") == MRFormiga::data($d,"Y-m-d")){
                    $pdds[$d][] = $p;
                }
            }
        }
        //RETORNA A FUNÇÃO
        return json_encode($pdds);
    }

    public static function atualizarPedido($dados){
        $SQL = "UPDATE pedidos SET STPedido = '".$dados['STPedido']."' WHERE IDPedido ='".$dados['IDPedido']."' ";
        return mysqli_query(MRFormiga::DB(),$SQL);
    }

    public static function statusCategoria($dados){
        if($dados['STCategoria'] == 0){
            $SQL = "UPDATE categorias SET STTabela = 1 WHERE IDCategoria ='".$dados['IDCategoria']."' ";
        }else{
            $SQL = "UPDATE categorias SET STTabela = 0 WHERE IDCategoria ='".$dados['IDCategoria']."' ";
        }
        
        return mysqli_query(MRFormiga::DB(),$SQL);
    }

    //GET LISTA PEDIDOSS
    public static function getListaPedidos(){
        $where = "";
        if(isset($_GET['pesquisa'])){
            if(!empty($_GET['pesquisa'])){
                if(!empty($where)){
                    $where .= " AND NMCliente LIKE '%".$_GET['pesquisa']."%' || NUTelefoneCliente LIKE '%".$_GET['pesquisa']."%' ";
                }else{
                    $where .= "WHERE NMCliente LIKE '%".$_GET['pesquisa']."%' || NUTelefoneCliente LIKE '%".$_GET['pesquisa']."%' ";
                }
            }

            if(!empty($_GET['status'])){
                if(!empty($where)){
                    $where .= " AND STPedido = '".$_GET['status']."' ";
                }else{
                    $where .= "WHERE STPedido = '".$_GET['status']."' ";
                }
            }

            if(!empty($_GET['de']) && !empty($_GET['ate'])){
                if(!empty($where)){
                    $where .= " AND DATE_FORMAT(DTEntrega,'%Y-%m-%d') BETWEEN '".$_GET['de']."' AND '".$_GET['ate']."' ";
                }else{
                    $where .= "WHERE DATE_FORMAT(DTEntrega,'%Y-%m-%d') BETWEEN '".$_GET['de']."' AND '".$_GET['ate']."' ";
                }
            }else{
                if(!empty($_GET['de'])){
                    if(!empty($where)){
                        $where .= " AND DATE_FORMAT(DTEntrega,'%Y-%m-%d') = '".$_GET['de']."' ";
                    }else{
                        $where .= "WHERE DATE_FORMAT(DTEntrega,'%Y-%m-%d') = '".$_GET['de']."' ";
                    }
                }
    
                if(!empty($_GET['ate'])){
                    if(!empty($where)){
                        $where .= " AND DATE_FORMAT(DTEntrega,'%Y-%m-%d') = '".$_GET['ate']."' ";
                    }else{
                        $where .= "WHERE DATE_FORMAT(DTEntrega,'%Y-%m-%d') = '".$_GET['ate']."' ";
                    }
                }
            }

        }
        $SQL = "SELECT * FROM pedidos $where ORDER BY IDPedido DESC";
        return mysqli_query(MRFormiga::DB(),$SQL);
    }
    //HORARIOS DISPONIVEIS PARA OS PEDIDOS
    public static $horarios = array(
        "chantilly" => array(
            "10:00:00"=>2,
            "11:00:00"=>3,
            "11:30:00"=>3,
            "12:00:00"=>3,
            "12:30:00"=>3,
            "13:00:00"=>3,
            "13:30:00"=>3,
            "14:00:00"=>4,
            "15:00:00"=>6,
            "16:00:00"=>7,
            "17:00:00"=>10,
            "18:00:00"=>15
        ),
        "acetato" => array(
            "09:00:00"=>2,
            "10:00:00"=>4,
            "11:00:00"=>6,
            "11:30:00"=>5,
            "12:00:00"=>5,
            "12:30:00"=>5,
            "13:00:00"=>5,
            "13:30:00"=>5,
            "14:00:00"=>5,
            "15:00:00"=>10,
            "16:00:00"=>15,
            "17:00:00"=>20,
            "18:00:00"=>30
        ),
        "doces" => array(
            "09:00:00" => 100,
            "10:00:00" => 200,
            "11:00:00" => 300,
            "12:00:00" => 100,
            "13:00:00" => 200,
            "14:00:00" => 300,
            "15:00:00" => 300,
            "16:00:00" => 300,
            "17:00:00" => 300,
            "18:00:00" => 500
        ),
        "torta" => array(
            "09:00:00" => 1,
            "10:00:00" => 2,
            "11:00:00" => 2
        )
    );
    //FUNÇÃO QUE OLHA OS DIAS DISPONIVEIS PARA PEDIDOS
    public static function getDiasIndisponiveis(){
        $sumPedidos = 0;
        foreach(Produtos::getItensPedido("") as $b){
            //ACHA A AREA DE CADA PEDIDO
            switch($b['TPBase']){
                case "BOL":
                    if($b['STChantilly'] == 1){
                        $chave = "chantilly";
                    }else{
                        $chave = "acetato";
                    }
                break;
                case "DOC":
                    $chave = "doces";
                break;
                case "TOR":
                    $chave = "torta";
                break;
            }
            //VERIFICA SOMA OS PEDIDOS DIARIOS
            foreach(SELF::$horarios[$chave] as $key => $val){
                $sumPedidos = $sumPedidos + $val;
            }
        }
        //GERA OS PROXIMOS 30 DIAS
        $NewDate=Date('Y-m-d', strtotime('+32 days'));
        $period = new DatePeriod(
            new DateTime(),
            new DateInterval('P1D'),
            new DateTime($NewDate)
        );
        $dates = array();
        foreach ($period as $key => $value) {
            array_push($dates,$value->format('Y-m-d'));     
        }
        //PESQUISA AS DATAS
        $diasCheios = array();
        $feriadosJSON = json_decode(file_get_contents("https://api.invertexto.com/v1/holidays/".date('Y')."?token=5815|xWJG6z48VfDqdgg6OD7YQ8KIKRRrRbk2"),true);
        foreach($feriadosJSON as $fj){
            array_push($diasCheios,$fj['date']);
        }
        array_push($diasCheios,date("Y-04-29"));
        // foreach($dates as $d){
        //     $quantidadePedidos = Pedidos::getHorarioPedido($d,"Dia","");
        //     if(isset($quantidadePedidos)){
        //         $qtPedidosDia = $quantidadePedidos['Pedidos'];
        //         $qtPedidosDiaQT = $quantidadePedidos['PedidosQT'];
        //     }else{
        //         $qtPedidosDiaQT = 0;
        //         $qtPedidosDia = 0;
        //     }
        //     $resQT = $qtPedidosDia + $qtPedidosDiaQT;
        //     if($resQT >= $sumPedidos){
        //         array_push($diasCheios,$d);
        //     }
        //     //array_push($diasCheios,$sumPedidos);
        // }
        return $diasCheios ;
    }
    ////////////////FUNÇÃO QUE GERA OS ITENS PARA OS PEDIDOS
    public static function getItens($data,$base){
            ob_start();
            $accordions = 0;
            // echo "<h2 align='center'>Clique no Item Escolhido para Continuar o Pedido</h2>";
            
            $oquetemarray = array();
            foreach(Produtos::getItensPedido($base) as $b){
                // array_push($oquetemarray,$b);
                // $accordions = $accordions+1;
                // switch($b['TPBase']){
                //     case "BOL":
                //         if($b['STChantilly'] == 1){
                //             $chave = "chantilly";
                //         }else{
                //             $chave = "acetato";
                //         }
                //     break;
                //     case "DOC":
                //         $chave = "doces";
                //     break;
                //     case "TOR":
                //         $chave = "torta";
                //     break;
                // }
            //CONFERE OS HORAROS
            //echo $chave;
            // foreach(SELF::$horarios[$chave] as $key => $val){
            //     //CONFERE A QUANTIDADE DE PEDIDOS NAQUELE DIA E NAQUELA HORA
            //     $quantidadePedidos = Pedidos::getHorarioPedido($data,$data." ".$key,$b['TPBase']);
            //     if(isset($quantidadePedidos)){
            //         if(in_array($b['TPBase'],array('BOL','TOR'))){
            //             $qt = $quantidadePedidos['Pedidos'];
            //         }else{
            //             $qt = $quantidadePedidos['PedidosQT'];
            //         }
            //         // print_r($quantidadePedidos);
            //     }else{
            //         $qt = 0;
            //     }
            //     //echo $qt;
            //     if($qt >= $val ){
            //         unset(SELF::$horarios[$chave][$key]);
            //     }
            //     //print_r($quantidadePedidos);
            // }
            // echo "<pre>";
            // print_r(SELF::$horarios[$chave]);
            // echo "</pre>";
            //print_r($diasCheios);
            //AQUI VAI OP HTML
            if($b['TPUn'] == "UN"){
                $tp = "CEN";
            }else{
                $tp = $b['TPUn'];
            }
            if(in_array($b['TPBase'],array("BOL","TOR"))){
            ?>
                <div class="bolTorDoc">
                    <img src="<?=$b['IMGProduto']?>" 
                    data-chantilly='<?=$b['STChantilly']?>' 
                    data-valor="<?=$b['VLBase']?>"
                    data-tpdoce="<?=$b['TPDoce']?>"
                    data-psembalagem="<?=$b['PSEmb']?>"
                    style="cursor:pointer;" class="fotoProduto" data-id='<?=$b['IDProduto']?>' data-categoria='<?=$b['IDCategoria']?>' data-nome='<?=$b['NMProduto']?>'>
                    <button class="btn btn-formiga bt-pedir" data-tpbase="<?=$b['TPBase']?>">Pedir (<?=MRFormiga::trataValor($b['VLBase'],0)?>/<?=$tp?>) </button>
                </div>
            <?php
                }elseif($b['TPBase'] == 'DOC'){
            ?>
                <div class="bolTorDoc">
                    <div class='checkboxDoces'>
                        <input type="checkbox" name="doce">
                    </div>
                    <img src="<?=$b['IMGProduto']?>" 
                    data-chantilly='<?=$b['STChantilly']?>' 
                    data-tpbase="<?=$b['TPBase']?>"
                    data-psembalagem="<?=$b['PSEmb']?>"
                    style="cursor:pointer;" class="fotoProduto" data-id='<?=$b['IDProduto']?>' data-categoria='<?=$b['IDCategoria']?>' data-nome='<?=$b['NMProduto']?>'>
                    <div class='checkboxDocesTxt'>
                        <?=$b['NMProduto']?>
                    </div>
                </div>
            <?php
            }
            // echo "<pre>";
            // print_r($oquetemarray);
            // echo "</pre>";
        }
        if($b['TPBase'] == "DOC"){
            echo "<div class='pedidoDoceFooter'><button class='btn btn-formiga bt-pedir' data-tpbase=".$b['TPBase']."  data-tpdoce='".$b['TPDoce']."' data-valor=".$b['VLBase'].">Pedir</button></div>";
        }
        $retorno['itens'] = ob_get_clean();
        return json_encode($retorno,JSON_UNESCAPED_UNICODE);
    }
    //GERADOR DE STRING OBRIGATORIOS
    public static function getCodigoPedido($size){
        $keys = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    
        $key = '';
        for ($i = 0; $i < ($size+10); $i++) 
        {
            $key .= $keys[array_rand($keys)];
        }

        return substr($key, 0, $size);
    }
    //SET PEDIDO
    public static function setPedido($dados){
        extract($dados);
        //$cdPedido = $_SESSION['CDPedido'];
        if(!isset($_SESSION['CDPedido'])){
            $_SESSION['CDPedido'] = SELF::getCodigoPedido(50);
        }

        if($step == 1){
            if($dados['TPItem'] != "BOLPER"){
                if($dados['TPItem'] == "DOC"){
                    $_SESSION['dadosPedido'] = array(
                        "VLBase" => $dados['VLItem'],
                        "TPBase" => $dados['TPItem'],
                        "IDTabela" => $dados['IDTabela'],
                        "IDProduto" => $dados['IDBolo'],
                        "DTEntrega" => $dados['DTEntrega'],
                        "NMCliente" => $dados['NMCliente'],
                        "NUTelefoneCliente" => $dados['TLCliente'] ,
                        "TPDoce" => $dados['TPDoce'],
                        "tipo" => "DOC"
                    );
                    $_SESSION['dadosPedido']['bolo']['doces'] = json_decode($dados['doces'],true);
                    $_SESSION['dadosPedido']['bolo']['tipo'] = "DOC";
                }else{
                    $_SESSION['dadosPedido'] = array(
                        "VLBase" => $dados['VLItem'],
                        "TPBase" => $dados['TPItem'],
                        "IDTabela" => $dados['IDTabela'],
                        "IDProduto" => $dados['IDBolo'],
                        "DTEntrega" => $dados['DTEntrega'],
                        "NMCliente" => $dados['NMCliente'],
                        "NUTelefoneCliente" => $dados['TLCliente'] ,
                        'bolo' => array(
                            'nome' => $dados['NMBolo'] ,
                            'id' => $dados['IDBolo'],
                            "fotoBolo" => $dados['IMGBolo'],
                            'precoUn' => $dados['VLItem'],
                            'tipo' => $dados['TPItem']
                        )
                    );
                }
                if(isset($dados['TPDoce'])){
                    $_SESSION['dadosPedido']['bolo']['tpdoce'] = $dados['TPDoce'];
                }
                $_SESSION['dadosPedido']['vlTotal'] = $dados['VLItem'];
                $_SESSION['dadosPedido']['bolo']['preco'] = $dados['VLItem'];
            }else{
                $_SESSION['dadosPedido'] = array(
                    "VLBase" => 0,
                    "TPBase" => "BOLPER",
                    "IDTabela" => 0,
                    "IDProduto" => 0,
                    "DTEntrega" => $dados['DTEntrega'],
                    "NMCliente" => $dados['NMCliente'],
                    "NUTelefoneCliente" => $dados['TLCliente'] ,
                    'bolo' => array(
                        'nome' => "Bolo Personalizado",
                        'id' => 0,
                        'precoUn' => 0,
                        'tipo' => "BOLPER"
                    )
                );
                $_SESSION['dadosPedido']['vlTotal'] = 0;
                $_SESSION['dadosPedido']['bolo']['preco'] = 0;
            }
        }elseif($step == 2){
            $_SESSION['dadosPedido']['bolo']['preco'] = $dados['VLttl'];
            if($_SESSION['dadosPedido']['TPBase'] == "TOR" || $_SESSION['dadosPedido']['TPBase'] == "BOL"){
                $_SESSION['dadosPedido']['bolo']['embalagem'] = array(
                    "foto" => $dados['fotoEmbalagem'],
                    'nome' => $dados['nomeEmbalagem'] ,
                    'id' => $dados['idEmbalagem'],
                    'valor' => $dados['valorEmbalagem']
                );
                $_SESSION['dadosPedido']['bolo']['recheio'] = $dados['recheioBolo'];
                $_SESSION['dadosPedido']['bolo']['massa'] = $dados['massaChocolate'];
                $_SESSION['dadosPedido']['bolo']['peso'] = $dados['pesoBolo'];
                if($dados['massaChocolate'] != "nenhum"){
                    $massaChoco = 2;
                }else{
                    $massaChoco = 0;
                }
                if($dados['recheioBolo'] != "nenhum"){
                    $recheioBolo = 5;
                }else{
                    $recheioBolo = 0;
                }
                $pcBolo = $_SESSION['dadosPedido']['bolo']['preco'] + $massaChoco + $recheioBolo;
                $_SESSION['dadosPedido']['bolo']['preco'] = $pcBolo;
                $_SESSION['dadosPedido']['vlTotal'] = $_SESSION['dadosPedido']['bolo']['preco'];
            }elseif($_SESSION['dadosPedido']['TPBase'] == "DOC"){
                $_SESSION['dadosPedido']['bolo']['peso'] = $dados['pesoBolo'];
                $_SESSION['dadosPedido']['bolo']['DSMensagem'] = $dados['DSMensagem'];
                //CASO O USUÁRIO QUISER CONTINUAR O PEDIDO
                $_SESSION['pedido']['NMCliente'] = $_SESSION['dadosPedido']['NMCliente'];
                $_SESSION['pedido']['NUTelefoneCliente'] = $_SESSION['dadosPedido']['NUTelefoneCliente'];
                $_SESSION['pedido']['DTEntrega'] = $_SESSION['dadosPedido']['DTEntrega'];
                $_SESSION['dadosPedido']['DSMensagem'] = $dados['DSMensagem'];
                $_SESSION['pedido']['bolo'][] = $_SESSION['dadosPedido']['bolo'];
            }elseif($_SESSION['dadosPedido']['TPBase'] == "BOLPER"){
                $_SESSION['dadosPedido']['bolo']['peso'] = 0;
                $_SESSION['dadosPedido']['bolo']['DSMensagem'] = $dados['DSMensagem'];
                $_SESSION['dadosPedido']['bolo']['fotoTopo'] = $dados['IMGTopo'];
                $_SESSION['dadosPedido']['bolo']['preco'] = 0;
                $_SESSION['dadosPedido']['bolo']['fotoBolo'] = $dados['IMGBolper'];
                //CASO O USUÁRIO QUISER CONTINUAR O PEDIDO
                $_SESSION['pedido']['NMCliente'] = $_SESSION['dadosPedido']['NMCliente'];
                $_SESSION['pedido']['NUTelefoneCliente'] = $_SESSION['dadosPedido']['NUTelefoneCliente'];
                $_SESSION['pedido']['DTEntrega'] = $_SESSION['dadosPedido']['DTEntrega'];
                $_SESSION['dadosPedido']['DSMensagem'] = $dados['DSMensagem'];
                $_SESSION['pedido']['bolo'][] = $_SESSION['dadosPedido']['bolo'];
            }

        }elseif($step == 3){
            $_SESSION['dadosPedido']['bolo']['fotoTopo'] = $dados['IMGTopo']; 
            $_SESSION['pedido']['bolo'][] = $_SESSION['dadosPedido']['bolo'];
            //CASO O USUÁRIO QUISER CONTINUAR O PEDIDO
            $_SESSION['pedido']['NMCliente'] = $_SESSION['dadosPedido']['NMCliente'];
            $_SESSION['pedido']['NUTelefoneCliente'] = $_SESSION['dadosPedido']['NUTelefoneCliente'];
            $_SESSION['pedido']['DTEntrega'] = $_SESSION['dadosPedido']['DTEntrega'];
            $_SESSION['dadosPedido']['DSMensagem'] = $dados['DSMensagem'];
        }
        //return $step;
        return true;
    }
    //MÉTODO QUE SALVA O PEDIDO
    public static function setPedidoBD($dados){
        $pedidosJson = json_encode($dados['bolo'],JSON_UNESCAPED_UNICODE);
        $SQL = "INSERT INTO pedidos (NMCliente,NUTelefoneCliente,DTEntrega,PedidoJSON,VLPedido) VALUES ('".$dados['NMCliente']."','".$dados['NUTelefoneCliente']."','".$dados['DTEntrega']."','".$pedidosJson."','".$dados['VLTotal']."')";
        return mysqli_query(MRFormiga::DB(),$SQL);
    }
}

?>