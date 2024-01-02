$(function () {
  var tableClientes = $("#example1").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaClientes.php",
  });

  tableClientes.on("draw",function(){
    $("#example1 tbody tr td:nth-child(2)").attr("data-content","Email")
    $("#example1 tbody tr td:nth-child(3)").attr("data-content","Telefone")
    $("#example1 tbody tr td:nth-child(4)").attr("data-content","CPF")
    $("#example1 tbody tr td:nth-child(5)").attr("data-content","Marketing")
  })

  var tableContas = $("#example2").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaContas.php",
  });

  var tableContasPagar = $("#example3").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaContasPagar.php",
  });

  tableContasPagar.on("draw",function(){
    $("#example6 tbody tr td:nth-child(2)").attr("data-content","Expedição")
    $("#example6 tbody tr td:nth-child(3)").attr("data-content","Vencimento")
    $("#example6 tbody tr td:nth-child(4)").attr("data-content","Valor")
    $("#example6 tbody tr td:nth-child(5)").attr("data-content","Status")
    $("#example6 tbody tr td:nth-child(6)").attr("data-content","Opções")
  })

  var tableContasReceber = $("#example4").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaContasReceber.php",
  });

  $("#example5").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "bDestroy": true,
  });

  var tableDevedores= $("#example6").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaDevedoresClientes.php",
  });

  tableDevedores.on("draw",function(){
    $("#example6 tbody tr td:nth-child(2)").attr("data-content","Email")
    $("#example6 tbody tr td:nth-child(3)").attr("data-content","Telefone")
    $("#example6 tbody tr td:nth-child(4)").attr("data-content","CPF")
    $("#example6 tbody tr td:nth-child(5)").attr("data-content","Divida Total")
    $("#example6 tbody tr td:nth-child(6)").attr("data-content","Desde")
    $("#example6 tbody tr td:nth-child(7)").attr("data-content","Cobrança")
  })

  var tableCrediarios= $("#example5").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaCrediarioClientes.php",
  });

  tableCrediarios.on("draw",function(){
    $("#example5 tbody tr td:nth-child(2)").attr("data-content","Nome")
    $("#example5 tbody tr td:nth-child(3)").attr("data-content","Email")
    $("#example5 tbody tr td:nth-child(4)").attr("data-content","CPF")
    $("#example5 tbody tr td:nth-child(5)").attr("data-content","Crédito total")
    $("#example5 tbody tr td:nth-child(6)").attr("data-content","Desde")
    $("#example5 tbody tr td:nth-child(7)").attr("data-content","Até")
  })

  var tableFornecedores = $("#example7").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaFornecedores.php",
  });

  var tableServicos = $("#example18").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaServicos.php",
  })

  tableServicos.on("draw",function(){
    $("#example18 tbody tr td:nth-child(2)").attr("data-content","Mão de Obra")
  })

  var tableInsumos = $("#example20").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaInsumos.php",
  })

  var tableOrdens = $("#example19").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaOrdemServico.php",
  })

  tableOrdens.on("draw",function(){
    $("#example19 tbody tr td:nth-child(2)").attr("data-content","Cliente")
    $("#example19 tbody tr td:nth-child(3)").attr("data-content","Atendente")
    $("#example19 tbody tr td:nth-child(4)").attr("data-content","Codigo")
    $("#example19 tbody tr td:nth-child(5)").attr("data-content","Data e Hora")
    $("#example19 tbody tr td:nth-child(6)").attr("data-content","Status")
    $("#example19 tbody tr td:nth-child(7)").attr("data-content","Ordem")
  })

  var tablePagamentos = $("#example9").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaPagamentos.php",
  });

  tablePagamentos.on("draw",function(){
    $("#example9 tbody tr td:nth-child(2)").attr("data-content","Desconto")
    $("#example9 tbody tr td:nth-child(3)").attr("data-content","Método")
    $("#example9 tbody tr td:nth-child(4)").attr("data-content","Parcelas")
  })

  var tableProdutos = $("#example10").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaProdutos.php",
  });

  $("#example11").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true
  });

  var tablePromo = $("#example12").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaPromo.php",
  });

  var tableUsuarios = $("#example13").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaUsuarios.php",
  });

  $("#example14").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true
  });

  var tablePontos = $("#example15").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaPontosVenda.php",
  });

  tableComissoes = $("#example16").DataTable({
    "responsive": true,
    "autoWidth": false,
    "bDestroy": true,
    "serverside": true,
    "ajax" : "./views/listas/tabelaComissoes.php",
  });

  tableComissoes.on("draw",function(){
    $("#example16 tbody tr td:nth-child(2)").attr("data-content","Tipo")
    $("#example16 tbody tr td:nth-child(3)").attr("data-content","Porcentagem")
    $("#example16 tbody tr td:nth-child(4)").attr("data-content","Participantes")
  })

  tableProdutos.on("draw",function(){
    $("#example10 tbody tr td:nth-child(2)").attr("data-content","Valor(R$)")
    $("#example10 tbody tr td:nth-child(3)").attr("data-content","Vendas/Estoque")
    $("#example10 tbody tr td:nth-child(4)").attr("data-content","Entrada/Validade")
    $("#example10 tbody tr td:nth-child(5)").attr("data-content","Vendas/Custos")
  })
  
  tableInsumos.on("draw",function(){
    $("#example20 tbody tr td:nth-child(2)").attr("data-content","Valor(R$)")
    $("#example20 tbody tr td:nth-child(3)").attr("data-content","Vendas/Estoque")
    $("#example20 tbody tr td:nth-child(4)").attr("data-content","Entrada/Validade")
    $("#example20 tbody tr td:nth-child(5)").attr("data-content","Vendas/Custos")
  })

  //
  tableFornecedores.on("draw",function(){
    $("#example7 tbody tr td:nth-child(2)").attr("data-content","Email")
    $("#example7 tbody tr td:nth-child(3)").attr("data-content","Telefone")
    $("#example7 tbody tr td:nth-child(4)").attr("data-content","Endereço")
  })

  tablePromo.on("draw",function(){
    $("#example12 tbody tr td:nth-child(2)").attr("data-content","Desconto")
    $("#example12 tbody tr td:nth-child(3)").attr("data-content","Inicio")
    $("#example12 tbody tr td:nth-child(4)").attr("data-content","Termino")
    $("#example12 tbody tr td:nth-child(5)").attr("data-content","Status")
    $("#example12 tbody tr td:nth-child(6)").attr("data-content","Produtos e Serviços")
  })

});
