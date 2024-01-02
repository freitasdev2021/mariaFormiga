jQuery(function(){
  getPedido()
  getDatasIndisponiveis()

  //HORAS AGORA
  var horasAgora = new Date().getHours();
  
  function trataValor(valor,tratamento){
    if(tratamento == 0){
        //TRATAENTO PARA EXIBIR NA TELA
        return Intl.NumberFormat('pt-br', {style: 'currency', currency: 'BRL'}).format(valor).replace("R$","").trim()
    }else{
        //TRATAMENTO PARA PROCESSAR NO BACKEND
        var quantidade = 0;
        for (var i = 0; i < valor.length; i++) {
            if (valor[i] == "," || valor[i] == "." ) {
                quantidade++
            }
        }
        //PERGUNTA SE A QUANTIDADE DE VIRGULAS E IGUAL A DOIS
        if(quantidade == 2){
            val = valor.replace(",",".").replace(".","")
        }else{
            val = valor.replace(",",".").trim()
        }
        return val.replace(",",".")
    }
  }

  //ADICIONA DIAS NA DATA
  function addDays(date, months) {
    date.setDate(date.getDate() + months);	
    date.setMonth(date.getMonth() + 1);	
    if(date.getDate() < 10){
      day =  "0"+date.getDate();
    }else{
      day = date.getDate();
    }
    var returnData = date.getFullYear()+"-"+date.getMonth()+"-"+day 
    return returnData;
  }

  $('input[type=name]').bind('input',function(){
    str = $(this).val().replace(/[^A-Za-z\u00C0-\u00FF\-\/\s]+/g,'');
    str = str.replace(/[\s{ \2 }]+/g,' ');
    if(str == " ")str = "";
    $(this).val( str );
  });

  $("input[name=telefone]").keyup(function(){
    $(this).val(formataTelefone($(this).val()))
  })

  function formataTelefone(num){
    var str = "";
    num = num.replace(/[^0-9]+/g,'');
    num = num.substring(0,11);
    for(i=0;i < num.length; i++){
        if(i==0){str = str +'('};
        if(i==2){str = str +') '};
        if(num.length == 10)
            if(i==6){str = str +'-'};
        if(num.length == 11)
            if(i==7){str = str +'-'};
        str = str+ (num[i].toString());
    }
    return str;
  }

  //VERIFICA AS DATAS INDISPONIVEIS
  function getDatasIndisponiveis(){
    $.ajax({
      method : "POST",
      url : "./Configs/enviaDados.php",
      data : {
        verifDatas : true
      }
    }).done(function(responsi){
      // console.log(responsi)
      // return false
      resp = jQuery.parseJSON(responsi)
      //
      console.log(resp)
      function blockDays(date){
        if (date.getDay() === 0) //Domingo
            return [ false, "closed", "Closed on Sunday" ]
        else
          var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
          return [ true, "", "" ] && [ resp.indexOf(string) == -1 ];
      }
      
      ///////
      $("input[name=data]").datepicker({
        minDate : new Date(),
        maxDate : "+1m",
        dateFormat : 'dd/mm/yy',
        beforeShowDay: blockDays,
        locale: 'pt-br',
        closeText:"Fechar",
        prevText:"&#x3C;Anterior",
        nextText:"Próximo&#x3E;",
        currentText:"Hoje",
        monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
        monthNamesShort:["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
        dayNames:["Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sábado"],
        dayNamesShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],
        dayNamesMin:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"]
      })
      //////
    })
  }
  //PEDIR EMBALAGEM
  $(".bt-embalagem").on("click",function(){
    if($("input[name=step]").val() == 2){
      if(confirm("Pode ou não haver uma Margem de erro de 15% no Peso do Bolo/Torta")){
        if($(this).attr("data-suportado") >= $("select[name=pesoProduto]").val()-1 ){
          var ddss = {
            fotoEmbalagem    : $(this).parent().find("img").attr("src"),
            nomeEmbalagem    : $(this).parent().find("strong").text(),
            idEmbalagem      : $(this).attr("data-id"),
            valorEmbalagem   : $(this).attr("data-emb"),
            pesoBolo         : $("select[name=pesoProduto]").val(),
            massaChocolate   : $("select[name=massaChocolate]").val(),
            recheioBolo      : $("select[name=recheios]").val(),
            TPItem           : $("input[name=tpitem]").val()  ,
            VLttl           : trataValor($("#prTotal").text(),1).trim()
          }
          setPedido($("input[name=step]").val(),ddss,"insercao");
        }else{
          alert("Embalagem não Suporta o Peso do Bolo")
        }
      }
    }
  })
  //PEDIDO DO TOPO
  $("#imagemTopo").on("change",function(){
    // Receber o arquivo do formulario
    var receberArquivo = document.getElementById("imagemTopo").files;
    //console.log(receberArquivo);

    // Verificar se existe o arquivo
    if (receberArquivo.length > 0) {

        // Carregar a imagem
        var carregarImagem = receberArquivo[0];
        //console.log(carregarImagem);

        // FileReader - permite ler o conteudo do arquivo do computador do usuario
        var lerArquivo = new FileReader();

        // O evento onload ocorre quando um objeto he carregado
        lerArquivo.onload = function(arquivoCarregado) {
           var imagemBase64 = arquivoCarregado.target.result;  
           $(".img-topo").attr("src",imagemBase64)
           $("#imagemTopo").val(imagemBase64)
        }  

        // O metodo readAsDataURL e usado para ler o conteudo
        lerArquivo.readAsDataURL(carregarImagem);
    }
  })

  $("#finalizarPedidoModal").on("show.bs.modal",function(){
    //alert($("#quantidadePdds",this).find("b").length)
    //$("<p>"+$("input[name=gourmet]").val()+"</p>").insertAfter("#quantidadePdds",this).find("b")
    $("#quantidadePdds",this).append($("input[name=gourmet]").val())
  })

  $(".bt-concluir-pedido").on("click",function(){
    $("#finalizarPedidoModal").modal("show")
  })

  $(".hidemodal").on("click",function(){
    $(".modal").modal("hide")
  })

  ///////FINALIZAÇÃO DO PEDIDO
  $(".bt-finalizar").on("click",function(){
    if(confirm("Deseja Finalizar seu Pedido? em Breve Entraremos em Contato via Whatsapp")){
      finalizarPedido()
    }
  })
  /////CONTINUAÇÃO DO PEDIDO
  $(".bt-continuar-pedidos").on("click",function(){
    if($("input[name=step]").val() == 3){
      var ddss = {
        DSMensagem : $("textarea[name=mensagem]").val(),
        IMGTopo    : $(".img-topo").attr("src"),
        TPItem     : $("input[name=tpitem]").val(),
        MSChocolate : $("select[name=massaChocolate]").val()
      }
      setPedido($("input[name=step]").val(),ddss,"continuacao");
    }
  })
  //BT CONTINUAR DOCE
  $(".bt-continuar-doce").on("click",function(){
    if($("input[name=gourmet]").val() == ""){
      alert("Primeiro Informe a Quantidade!");
    }else{
      var ddss = {
        precoUn    : $(this).attr("data-un"),
        pesoBolo   : $("input[name=gourmet]").val(),
        TPItem     : $("input[name=tpitem]").val(),
        DSMensagem : $("textarea[name=mensagem]").val(),
        VLttl      : trataValor($("#prTotal").text(),1).trim()
      }
      setPedido($("input[name=step]").val(),ddss,"continuacao");
    }
  })
  //BT CONTINUAR BOLO PERSONALIZADO
  $(".bt-continuar-bolper").on("click",function(){
    if($("input[name=fotoBolper]").val() == ""){
      alert("Envie a Foto do Bolo!");
    }else{
      var ddss = {
        DSMensagem  : $("textarea[name=mensagem]").val(),
        IMGTopo     : $("#imgTopoBolper").attr("src"),
        IMGBolper   : $("#imgBolper").attr("src"),
        TPItem      : "BOLPER"
      }
      setPedido($("input[name=step]").val(),ddss,"continuacao");
    }
  })
  //////////////////////////
  $("#personalizadoBolo").hide()
  $("select[name=qualTabela]").on("change",function(){
    // alert($("input[name=data]").val())
    // return false
    if($("input[name=nome]").val() == "" || $("input[name=nome]").val() == "" || $("input[name=data]").val() == "" || $("select[name=hora]").val() == ""){
      alert("Primeiro Preencha Todos os Campos Anteriores");
      $(this).val("")
      return false
    }
    var dataAtual = $("input[name=data]").val().split("/")
    console.log(dataAtual)
    var dataAmericana = dataAtual[2]+"-"+dataAtual[1]+"-"+dataAtual[0]
    // alert(dataAmericana)
    // alert($("select[name=hora],input[name=hora]").val())
    getPedidos(dataAmericana,$(this).val())
  })

  if($("input[name=sessionTabela]").val() != ""){
    getPedidos($("input[name=sessionTabela]").attr('data-dtentrega'),$("input[name=sessionTabela]").val())
  }

    //PEGA O BOLO PERSONALIZADO
    $("#imagemBolper").on("change",function(){
      // Receber o arquivo do formulario
      var receberBolper = document.getElementById("imagemBolper").files;
      //console.log(receberArquivo);
  
      // Verificar se existe o arquivo
      if (receberBolper.length > 0) {
  
          // Carregar a imagem
          var carregarBolper = receberBolper[0];
          //console.log(carregarImagem);
  
          // FileReader - permite ler o conteudo do arquivo do computador do usuario
          var lerBolper = new FileReader();
  
          // O evento onload ocorre quando um objeto he carregado
          lerBolper.onload = function(bolperCarregado){
              $("input[name=fotoBolper]").val(bolperCarregado.target.result)
              $("#imgBolper").attr("src",bolperCarregado.target.result)
          }  
  
          // O metodo readAsDataURL e usado para ler o conteudo
          lerBolper.readAsDataURL(carregarBolper);
      }
  })

  //FOTO DO TOPO DO BOLO PERSONALIZADO
  $("#imagemTopoBolper").on("change",function(){
    // Receber o arquivo do formulario
    var receberTopoBolper = document.getElementById("imagemTopoBolper").files;
    //console.log(receberArquivo);

    // Verificar se existe o arquivo
    if (receberTopoBolper.length > 0) {

        // Carregar a imagem
        var carregarTopoBolper = receberTopoBolper[0];
        //console.log(carregarImagem);

        // FileReader - permite ler o conteudo do arquivo do computador do usuario
        var lerTopoBolper = new FileReader();

        // O evento onload ocorre quando um objeto he carregado
        lerTopoBolper.onload = function(bolperTopoCarregado){
            $("input[name=fotoTopoBolper]").val(bolperTopoCarregado.target.result)
            $("#imgTopoBolper").attr("src",bolperTopoCarregado.target.result)
        }  

        // O metodo readAsDataURL e usado para ler o conteudo
        lerTopoBolper.readAsDataURL(carregarTopoBolper);
    }
  })

  function finalizarPedido(){
    $.ajax({
      method : "POST",
      url    : "./Configs/enviaDados.php",
      data   : {
        finalizarPedido : true
      },
      success : function(r){
        // console.log(r)
        // alert("rr")
        window.location.href='pedido.php?end'
      }
    })
  }

  function getPedidos(data,tabela){
    $.ajax({
      method : "POST",
      url : "./Configs/enviaDados.php",
      data : {
        dataPedido : data,
        qualTabela : tabela
      }
    }).done(function(retorno){
      // console.log(retorno)
      // alert(tabela)
      // return false;
      ret = jQuery.parseJSON(retorno)
      if(horasAgora > 12){
          var date1 = new Date();
          var date2 = new Date(data);
          var diffTime = Math.abs(date2 - date1);
          var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
          if(diffDays < 2){
            $("#modalMeidia").modal("show")
          }else{
            if(tabela != "BOLPER"){
              $(".pedidos").html(ret.itens)
            }else{
              var dataPedido = $("input[name=data]").val().split("/")
              var dataNova = dataPedido[2]+"-"+dataPedido[1]+"-"+dataPedido[0]+" "+$("select[name=hora]").val()
              if($("select[name=hora]").val() == "" || $("input[name=data]").val() == ""){
                alert("Preencha os Campos Corretamente!")
                return false
              }
              if($("input[name=step]").val() == 1){
                var ddss = {
                  NMCliente : $("input[name=nome]").val(),
                  TLCliente : $("input[name=telefone]").val().replace(/[^0-9]+/g,''),
                  DTEntrega : dataNova,
                  TPItem    : "BOLPER"
                }
                setPedido($("input[name=step]").val(),ddss,"insercao");
              }
            }
          }
      }else{
        if(tabela != "BOLPER"){
          $(".pedidos").html(ret.itens)
        }else{
          var dataPedido = $("input[name=data]").val().split("/")
          var dataNova = dataPedido[2]+"-"+dataPedido[1]+"-"+dataPedido[0]+" "+$("select[name=hora]").val()
          if($("select[name=hora]").val() == "" || $("input[name=data]").val() == ""){
            alert("Preencha os Campos Corretamente!")
            return false
          }
          if($("input[name=step]").val() == 1){
            var ddss = {
              NMCliente : $("input[name=nome]").val(),
              TLCliente : $("input[name=telefone]").val().replace(/[^0-9]+/g,''),
              DTEntrega : dataNova,
              TPItem    : "BOLPER"
            }
            setPedido($("input[name=step]").val(),ddss,"insercao");
          }
        }
      }
      //
      $(".card").find("select[name=hora]").each(function(){
        if($("option",this).length == 0){
          $(this).parents(".card").find(".bt-pedir").hide()
          $(this).hide()
          $(this).parents(".card").find(".partePedido").append("<h3>Pedidos Esgotados para Essa Data</h3>")
        }
      })
      //PEDIR BOLO
      $(".bt-pedir").on("click",function(){
        var dataPedido = $("input[name=data]").val().split("/")
        var dataNova = dataPedido[2]+"-"+dataPedido[1]+"-"+dataPedido[0]+" "+$("select[name=hora]").val()
        if($("select[name=hora]").val() == "" || $("input[name=data]").val() == ""){
          alert("Preencha os Campos Corretamente!")
          return false
        }
        if($("input[name=step]").val() == 1){
          // alert(dataNova)
          // return false;
          var ddss = {
            IMGBolo   : $(this).parents(".bolTorDoc").find("img").attr("src"),
            NMCliente : $("input[name=nome]").val(),
            TLCliente : $("input[name=telefone]").val().replace(/[^0-9]+/g,''),
            DTEntrega : dataNova,
            IDTabela  : $("select[name=qualTabela]").val(),
            IDBolo    : $(this).parents(".bolTorDoc").find("img").attr("data-id"),
            NMBolo    : $(this).parents(".bolTorDoc").find("img").attr("data-nome"),
            VLItem    : $(this).parents(".bolTorDoc").find("img").attr("data-valor"),
            TPItem    : $(this).parents(".bolTorDoc").find("img").attr("data-tpbase")
          }
          if(ddss.TPItem == "DOC"){
            ddss.TPDoce = $(this).parents(".bolTorDoc").find("img").attr("data-tpdoce")
          }
          // alert($("input[name=step]").val())
          // return false
          setPedido($("input[name=step]").val(),ddss,"insercao");
        }
        //alert(dataNova)
      })
      //PEDIR DOCE
      //PEDIR BOLO PERSONALIZADO
      
      //
    })
  }

  function setPedido(step,dados,operacao){
    if($(".required").val() == ""){
      alert("Preencha os campos vazios!")
      return false
    }
    // console.log(dados)
    // return false
    $.ajax({
      method : "POST",
      url    : "./Configs/enviaDados.php",
      data : {
        dados : dados,
        step : step
      }
    }).done(function(retorno){
      // console.log(retorno)
      // return false;
      // alert(dados.TPItem)
      // return false
      if(dados.TPItem == "BOL" || dados.TPItem == "TOR" ){
        if(step == 1){
          window.location.href="pedido.php?step=2";
        }else if(step == 2){
          window.location.href="pedido.php?step=3";
        }else if(step == 3){
          if(operacao == "continuacao"){
            window.location.href="pedido.php?continuar";
          }else{
            window.location.href="pedido.php?end";
          }
        }
      }else if(dados.TPItem == "DOC"){
        if(step == 1){
          window.location.href="pedido.php?step=2";
        }else if(step == 2){
          if(operacao == "continuacao"){
            window.location.href="pedido.php?continuar";
          }else{
            window.location.href="pedido.php?end";
          }
        }
      }else if(dados.TPItem == "BOLPER"){
        if(step == 1){
          window.location.href="pedido.php?step=2";
        }else if(step == 2){
          if(operacao == "continuacao"){
            window.location.href="pedido.php?continuar";
          }else{
            window.location.href="pedido.php?end";
          }
        }
      }
    })
  }

  function getPedido(){
    $("select[name=pesoProduto]").on("change",function(){
      var valorCliente = $(this).val()
      var valorUn = $(this).attr("data-un")
      var valorTotal = valorUn * valorCliente
      $("#prTotal").text(trataValor(valorTotal,0))
    })
    //BOTÃO PARA DOCE TRADICIONAL
    if($("input[name=tpdoce]").val() == "Doces Gourmet"){
      $("input[name=gourmet]").on("keyup",function(){
        var valorCliente = $(this).val()
        var valorUn = $(this).attr("data-un")/100
        var valorTotal = valorUn * valorCliente
        $("#prTotal").text(trataValor(valorTotal,0))
      })
    }else if($("input[name=tpdoce]").val() == "Doces Tradicionais"){
      $("input[name=gourmet]").on("keyup",function(){
        var valorCliente = $(this).val();
        if(valorCliente % 100 == 0 ) {
          var valorUn = $(this).attr("data-un")/100
          valorTotal = valorCliente * valorUn
        }else if(valorCliente % 50 == 0){
          var valorUn = 45/50
          valorTotal = valorCliente * valorUn
        }else{
          valorTotal = valorCliente * 1
        }
        $("#prTotal").text(trataValor(valorTotal,0))
      })
    }else if($("input[name=tpdoce]").val() == "Bombons Tradicionais"){
      $("input[name=gourmet]").on("keyup",function(){
        var valorCliente = $(this).val();
        if(valorCliente % 100 == 0 ) {
          var valorUn = $(this).attr("data-un")/100
          valorTotal = valorCliente * valorUn
        }else{
          valorTotal = valorCliente * 2
        }
        $("#prTotal").text(trataValor(valorTotal,0))
      })
    }
  }

})