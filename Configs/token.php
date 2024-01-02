<?php
require"Configs.php";

if(isset($_POST["user"]) && isset($_POST["senha"])){
    echo Autenticacao::efetuarLogin($_POST["user"],$_POST["senha"]);
}else{
    echo Autenticacao::conferirAcesso($_SESSION['login']['dados']['id']);
}
//echo "aa";


