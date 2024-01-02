<?php
require"./Configs/configs.php";
if(!isset($_SESSION['login'])){
    header("location:login.html");
}

if(isset($_GET['logout'])){
    unset($_SESSION['login']);
    header("location:login.html");
}
include"modais/modalBases.php";
include"modais/modalProdutos.php";
include"modais/modalCalendario.php";
//print_r($_SESSION['login']);
//echo MRFormiga::getFileUrl();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Maria Formiga</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="img/fricon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/libs/styles.css" rel="stylesheet" />
        <link href="css/libs/scrollable-tabs.css" rel="stylesheet" />
        <link href="css/libs/scrollable-tabs.min.css" rel="stylesheet" />
         <!--jQuery-->
         <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
         <!--LOAD-->
         <link rel="stylesheet" href="libs/calendar/css/style.css">
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
         <link rel="stylesheet" href="css/libs/load.css">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
         <!--DATATABLES-->
         <link rel="stylesheet" href="css/libs/responsive.bootstrap4.min.css">
         <link rel="stylesheet" href="css/libs/Responsive-Table.css">
         <link rel="stylesheet" href="css/breadcumbs.css">
         <link rel="stylesheet" href="css/lateralBar.css">
         <link rel="stylesheet" href="js/libs/tablepagination/paging.css">
         <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
         <link href="https://fonts.cdnfonts.com/css/gourmet" rel="stylesheet">
         <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
         <link href="https://fonts.cdnfonts.com/css/courier-prime" rel="stylesheet">
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end" id="sidebar-wrapper" style="background:#b04684;">
                <div class="sidebar-heading text-white" style="background:#b04684;">Painel de controle</div>
                <div class="list-group list-group-flush navegacao">
                    <?php if(Autenticacao::userPerm(1,"PED")):?><a class="list-group-item list-group-item-action list-group-item-light p-3 border-bottom white <?=(MRFormiga::getFileUrl() == "index.php")? 'ativado' : ''?>" href="index.php" style="cursor:pointer; <?=(MRFormiga::getFileUrl() == "index.php")? 'background:white; color:black;' : ''?>"><i class="fa-solid fa-book"></i>&nbsp;Pedidos</a><?php endif?>
                    <?php if($_SESSION['login']['ID'] == 1):?><a class="list-group-item list-group-item-action list-group-item-light p-3 border-bottom white <?=(MRFormiga::getFileUrl() == "usuarios.php")? 'ativado' : ''?>" href="usuarios.php" style="cursor:pointer; <?=(MRFormiga::getFileUrl() == "usuarios.php")? 'background:white; color:black;' : ''?>"><i class="fa-solid fa-users"></i>&nbsp;Usuários</a><?php endif?>
                    <?php if(Autenticacao::userPerm(1,"BOL")):?><a class="list-group-item list-group-item-action list-group-item-light p-3 border-bottom white <?=(MRFormiga::getFileUrl() == "bolos.php")? 'ativado' : ''?>"  href="bolos.php" style="cursor:pointer; <?=(MRFormiga::getFileUrl() == "bolos.php")? 'background:white; color:black;' : ''?>"><i class="fa-solid fa-cake-candles"></i>&nbsp;Bolos</a><?php endif?>
                    <?php if(Autenticacao::userPerm(1,"TOR")):?><a class="list-group-item list-group-item-action list-group-item-light p-3 border-bottom white <?=(MRFormiga::getFileUrl() == "tortas.php")? 'ativado' : ''?>" href="tortas.php" style="cursor:pointer; <?=(MRFormiga::getFileUrl() == "tortas.php")? 'background:white; color:black;' : ''?>"><i class="fa-solid fa-bowl-food"></i>&nbsp;Tortas</a><?php endif?>
                    <?php if(Autenticacao::userPerm(1,"DOC")):?><a class="list-group-item list-group-item-action list-group-item-light p-3 border-bottom white <?=(MRFormiga::getFileUrl() == "doces.php")? 'ativado' : ''?>" href="doces.php" style="cursor:pointer; <?=(MRFormiga::getFileUrl() == "doces.php")? 'background:white; color:black;' : ''?>"><i class="fa-solid fa-cookie"></i>&nbsp;Doces e Brigadeiros</a><?php endif?>
                    <?php if(Autenticacao::userPerm(1,"EMB")):?><a class="list-group-item list-group-item-action list-group-item-light p-3 border-bottom white <?=(MRFormiga::getFileUrl() == "embalagens.php")? 'ativado' : ''?>"  href="embalagens.php" style="cursor:pointer; <?=(MRFormiga::getFileUrl() == "embalagens.php")? 'background:white; color:black;' : ''?>"><i class="fa-solid fa-box"></i>&nbsp;Embalagens</a><?php endif?>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light border-bottom" style="background:#b04684;">
                    <div class="container-fluid" >
                        <button class="btn btn-light" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link text-white" href="index.php?logout">Sair</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <div class="container-fluid conteudo">