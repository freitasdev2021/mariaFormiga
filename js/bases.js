jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(document).ready(function(){
       montaBotoes();
       $(".modal").on("hide.bs.modal",function(){
        $("input[type=text]",this).val("")
        $("img",this).attr("src","")
       })
       getPedidosCalendario()
    })
    $(".bt_excluir_base").hide()
    $(".bt_excluir_produto").hide()
    $(".partePedido").hide()
    $(".tipo_doce").hide()
    $(".tipo_bolo").hide()
    $(".peso_emb").hide()
    function excluirBase(ID){
        $.ajax({
            method : "POST",
            url : "./Configs/exclusaoDado.php",
            data : {
                IDBase : ID
            }
        }).done(function(){
            window.location.reload()
        })
    }

    $("select[name=statusPedido]").on("change",function(){
        atualizarPedido($(this).val(),$(this).attr("data-id"))
    })

    $(".bt-status-tabela").on("click",function(){
        statusTabela($(this).attr("data-status"),$(this).attr("data-id"))
        if($(this).attr("data-status") == 0){
            $(this).find("i").removeClass("fa-toggle-off").addClass("fa-toggle-on")
            $(this).attr("data-status",1)
        }else{
            $(this).find("i").removeClass("fa-toggle-on").addClass("fa-toggle-off")
            $(this).attr("data-status",0)
        }
    })

    window.jsPDF = window.jspdf.jsPDF;
    var docPDF = new jsPDF();

    function statusTabela(status,id){
        $.ajax({
            method : "POST",
            url    : "./Configs/enviaDados.php",
            data   : {
                IDCategoria : id,
                STCategoria : status
            }
        }).done(function(retStts){
            console.log(retStts)
        })
    }

    function atualizarPedido(status,id){
        $.ajax({
            method : "POST",
            url    : "./Configs/enviaDados.php",
            data   : {
                IDPedido : id,
                STPedido : status
            }
        }).done(function(retPedido){
            window.location.reload()
            //console.log(retPedido)
        })
    }

    function print(cupom){
        // console.log(cupom)
        // return false
        var elementHTML = document.querySelector(cupom);
            docPDF.html(elementHTML, {
            callback: function(docPDF) {
            docPDF.save('PedidoImpresso.pdf');
        },
            x: 2,
            y: 5,
            width: 100,
            windowWidth: 400
        });
    }

    function getPedidosCalendario(){
        $.ajax({
            method : "POST",
            url : "./Configs/enviaDados.php",
            data : {
                getCalendar : true,
            }
        }).done(function(rts){
            var rt = jQuery.parseJSON(rts)
            console.log(rt)
            var diasEntrega = []
            //PEGA A DATA CLICADA
            //DATA EM BRANCO
            // $(".calendar_content").find(".past-date").not(".blank,.bg-success").on("click",function(){
            //     alert("aa")
            // })
            //DATA COM PEDIDOS
            $(".calendar_content").find("div").not(".blank,.past-date").on("click",function(){
                var ServicosJSON = jQuery.parseJSON($(this).find("span").html().trim())
                var modalPedidosCalendario = "#modalCalendario";
                //$(this).unbind("click")
                $(modalPedidosCalendario).modal("show")
                var divPedido = $("<div>",{
                    class: 'impressaoPedidos'
                },"</div>")

                console.log(ServicosJSON)

                $.each(ServicosJSON,function(i,v){
                    var arrPedidos = jQuery.parseJSON(v.PedidoJSON)
                    var dataPed = new Date(v.DTEntrega);
                    if(dataPed.getMinutes() == 0){
                        mins = dataPed.getMinutes()+"0"
                    }else{
                        mins = dataPed.getMinutes();
                    }

                    var horario = dataPed.getHours()+":"+mins
                    divPedido.append("<button class='btn btn-danger btn-sm imprimir impIndividual' data-pdd="+v.IDPedido+">Imprimir</button>")
                    divPedido.append("<div class='cPdd_"+v.IDPedido+"'>\
                    <label> Cliente: <b>"+v.NMCliente+"</b></label>\
                    <br>\
                    <label> Horário: <b>"+horario+"</b></label>\
                    </div>")
                    console.log(arrPedidos)
                    $.each(arrPedidos,function(b,o){
                        var doccs = []
                        if(o.tipo == "DOC"){
                            $.each(o.doces,function(d,c){
                                doccs.push(c.NMBolo)
                            })
                            divPedido.append("<b style='font-size:1.5em;'>Pedido: &nbsp;</b>"+"<p>"+doccs.join(',')+"</p>")
                            divPedido.append("<b>Quantidade: &nbsp;</b>"+"<p>"+o.peso+"</p>")
                        }else{
                            divPedido.append("<b style='font-size:1.5em;'>Pedido: &nbsp;</b>"+"<p>"+o.nome+"</p>")
                            divPedido.append("<b>Quantidade: &nbsp;</b>"+"<p>"+o.peso+"</p>")
                            divPedido.append("<b>Massa: &nbsp;</b>"+"<p>"+o.massa+"</p>")
                            divPedido.append("<b>Recheio: &nbsp;</b>"+"<p>"+o.recheio+"</p>")
                        }
                    })
                    divPedido.append("<hr width='300px'>")

                    $(".modal-body").html(divPedido)
                })
                
                $(document).on("click",".imprimir",function(){
                    if($(this).hasClass("impIndividual")){
                        var idpd = $(this).attr("data-pdd")
                        print(".cpdd_"+idpd)
                    }else{
                        $(".impIndividual").hide()
                        print("#modalCalendario .modal-body")
                    }
                })

            })

            $("#modalCalendario").on("hide.bs.modal",function(){
                //$(".calendar_content").find("div").not(".blank,.past-date").bind("click")
                $(this).find(".modal-body").html("")
            })
            //
            $(".switch-month").hide()
            //CONSULTA AS DATAS
            $(".calendar_content").find("div").not(".blank,.past-date").each(function(){
                
                if($(this).text() < 10){
                    var dayy = "0"+$(this).text()
                }else{
                    var dayy = $(this).text()
                }
                //
                if($(this).parents(".calendar").attr("data-mes") < 10){
                    datames = "0"+$(this).parents(".calendar").attr("data-mes");
                }else{
                    datames = $(this).parents(".calendar").attr("data-mes");
                }
                //console.log($(this).text())
                var dia = $(this).parents(".calendar").attr("data-ano")+"-"+datames+"-"+dayy
                $(this).addClass("dia_"+dia+" dta")
                $.each(rt,function(i,v){
                    if(i == dia){
                        diasEntrega.push(dia)
                        $(".dia_"+i).append("<span style='display:flex;'>"+JSON.stringify(v)+"</span>")
                        $(".dia_"+i).addClass("bg-success text-white")
                    }
                })
            })
            //
        })
    }

    function excluirProduto(IDP,IDC){
        $.ajax({
            method : "POST",
            url : "./Configs/exclusaoDado.php",
            data : {
                IDProduto : IDP
            }
        }).done(function(response){
            //console.log(response)
            getProdutos(IDC)
            //return false
            $("#cadastroProduto").modal("hide")
        })
    }

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalBases = "#cadastroBase";
        var formBases = "#formCadastroBase";
        var modalProdutos = "#cadastroProduto";
        var formProdutos = "#formCadastroProduto";
        $(modalBases,modalProdutos).on("hide.bs.modal",function(){
            $(".bt_excluir_base").hide()
            $(".tipo_doce").hide()
            $(".tipo_bolo").hide()
            $(".peso_emb").hide()
        })

        $(modalBases).on("shown.bs.modal",function(){
            if($("#formCadastroBase input[name=tipo]",modalBases).val() == "DOC"){
                $(".tipo_doce").show()
            }
        })

        $(modalProdutos).on("shown.bs.modal",function(){
            if($("#formCadastroProduto input[name=categoria_tipo]",modalProdutos).val() == "BOL"){
                $(".tipo_bolo").show()
            }else if($("#formCadastroProduto input[name=categoria_tipo]",modalProdutos).val() == "EMB"){
                $(".peso_emb").show()
            }
        })

        $(modalProdutos).on("hide.bs.modal",function(){
            $(".bt_excluir_produto").hide()
        })

        $(".bt_excluir_base").on("click",function(){
            if(confirm("Deseja Excluir essa Categoria? Todos os Itens pertencentes a ela tambem serão Excluidos Permanentemente")){
                excluirBase($("input[name=base_id]",formBases).val())
            }
        })

        $(".bt_excluir_produto").on("click",function(){
            if(confirm("Deseja Excluir esse Produto? Será Excluido Permanentemente")){
                excluirProduto($("input[name=produto_id]",formProdutos).val(),$("input[name=categoria_id]",formProdutos).val())
            }
        })

        $(".bt-editar-base").on("click",function(){
            $(modalBases).modal("show")
            $(modalBases).find("select[name=TPBolo]").val($(this).attr("data-chantilly"))
            $(modalBases).find("input[name=base]").val($(this).attr("data-nome"))
            $(modalBases).find("input[name=base_id]").val($(this).attr("data-id"))
            $(modalBases).find("input[name=valor]").val(trataValor($(this).attr("data-preco"),0))
            $(modalBases).find("select[name=unidade]").val($(this).attr("data-un"))
            $(".bt_excluir_base").show()
        })

        $("#imagem-usuario").on("change",function(){
            // Receber o arquivo do formulario
            var receberArquivo = document.getElementById("imagem-usuario").files;
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
                   $(".imagemProduto").attr("src",imagemBase64)
                   $("#imagem-usuario").val(imagemBase64)
                }  
    
                // O metodo readAsDataURL e usado para ler o conteudo
                lerArquivo.readAsDataURL(carregarImagem);
            }
        })

        //MODAL DE ADICIONAR EMPRESA
        $(".bt_adicionar_base").on("click",function(){
            $(modalBases).modal("show");
            $(modalBases).find("input[name=tipo]").val($(this).attr("data-tipo"))
            $(".bt_excluir_base").hide()
        })
        $(".bt-adicionar-bolo").on("click",function(){
            $(modalProdutos).modal("show");
            $(modalProdutos).find("input[name=categoria_id]").val($(this).attr("data-categoria"))
            $(modalProdutos).find("input[name=categoria_tipo]").val($(this).attr("data-tipocategoria"))
            $(".bt_excluir_base").hide()
        })
        //ENVIAR DADOS DA EMPRESA
        $(".bt_salvar_base").on("click",function(e){
            salvaBase(formBases)
        })
        //
        $("input[name=pesquisaProdutos]").keyup(function(){
            buscaProdutos($(this).val())
        })
        //
        $(".bt_salvar_produto").on("click",function(){
            setProduto(formProdutos)
        })
    //FIM DA FUNÇÃO
    }

    function buscaProdutos(produto){
        $(".card .titleAcordion").each(function(){
            if($(this).text().toLowerCase().indexOf(produto.toLowerCase()) > -1){
                $(this).parents(".card").show(500)
            }else if(produto.toLowerCase() == ""){
                $(this).parents(".card").show(500)
            }else{
                $(this).parents(".card").hide(500)
            }
        })
    }

    function getProdutos(IDCat){
        $.ajax({
            method : "POST",
            url : "./Configs/enviaDados.php",
            data : {
                IDCet : IDCat
            }
        }).done(function(response){
            $(".categoria_"+IDCat).html(response)
            $("input[name=embalagem][type=radio]").hide()
            $(".fotoProduto").on("click",function(){
                $("#cadastroProduto").modal("show")
                $("#cadastroProduto").find("input[name=produto]").val($(this).attr("data-nome"))
                $("#cadastroProduto").find("input[name=produto_id]").val($(this).attr("data-id"))
                $("#cadastroProduto").find("input[name=categoria_id]").val($(this).attr("data-categoria"))
                $("#cadastroProduto").find(".imagemProduto").attr("src",($(this).attr("src")))
                $("#cadastroProduto").find("input[name=imgProduto]").attr("value",($(this).attr("src")))
                if($(this).attr("data-tpbase") == "BOL"){
                    $("#cadastroProduto").find("select[name=TPBolo]").val($(this).attr("data-chantilly"))
                    $(".tipo_bolo").show()
                }else if($(this).attr("data-tpbase") == "DOC"){
                    $("#cadastroProduto").find("select[name=TPDoce]").val($(this).attr("data-tpdoce"))
                    $(".tipo_doce").show()
                }else if($(this).attr("data-tpbase") == "EMB"){
                    $("#cadastroProduto").find("input[name=PSEmb]").val($(this).attr("data-psembalagem"))
                    $(".peso_emb").show()
                }
                $(".bt_excluir_produto").show()
            })
        })
    }

    $("#accordion .card").each(function(){
        getProdutos($(this).attr("data-id"))
    })

    function setProduto(formee){
        // console.log($("input[name=categoria_tipo]").val())
        // return false
        if(!validaCampos(formee))return false;
        ddsProdutos = {
            IDProduto   : $("input[name=produto_id]",formee).val(),
            IDCategoria : $("input[name=categoria_id]",formee).val(),
            NMProduto   : $("input[name=produto]",formee).val(),
            IMGProduto  : $(".imagemProduto",formee).attr("src"),
            TPBase      : $("input[name=categoria_tipo]").val()
        }

        if(ddsProdutos.TPBase == "BOL"){
            ddsProdutos.TPBolo = $("select[name=TPBolo]").val()
        }else if(ddsProdutos.TPBase == "EMB"){
            ddsProdutos.PSEmb = $("input[name=PSEmb]").val()
        }

        $.ajax({
            method : "POST",
            url : "./Configs/enviaDados.php",
            data : ddsProdutos
        }).done(function(response){
            console.log(response)
            getProdutos($("input[name=categoria_id]",formee).val())
            $("#cadastroProduto").modal("hide")
        })
    }

    function salvaBase(form){         
        //INICIA VALIDACAO DOS CAMPOS
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        dadosBase = {
            IDBase  : $("input[name=base_id]",form).val(),
            NMBase  : $("input[name=base]",form).val(),
            VLBase  : trataValor($("input[name=valor]",form).val(),1),
            TPBase  : $("input[name=tipo]",form).val(),
            TPUn    : $("select[name=unidade]",form).val()
        }
        if(dadosBase.TPBase == "DOC"){
            dadosBase.TPDoce = $("select[name=TPDoce]").val()
        }
        // console.log(dadosBase)
        // return false
        $.ajax({
            method : "POST",
            url    : "./Configs/enviaDados.php",
            data   : dadosBase
        }).done(function(resultado){
            console.log(resultado);
            window.location.reload()
        })
    }

    //FIM DA PAGINA
})


