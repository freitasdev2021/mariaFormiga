jQuery(function(){
    //INICIO DA PAGINA
    //DEFINE AS MASCARAS E TRATAM OS CAMPOS
    $(".bt_excluir_usuario").hide()
    $(document).ready(function(){
       montaBotoes();
       montaLista()
       //alert($("input[name=permissao]").val())
    })

    //FUNÇÃO QUE MONTA BOTOES
    function montaBotoes(){
        var modalUsuarios = "#cadastroUsuario";
        var formUsuario = "#formCadastroUsuarios";
        //ENVIAR DADOS DO Pagar
        $(".bt_salvar_usuario").on("click",function(e){
            setRegistro(formUsuario);
        })
        //BREADCUMBS
        $("#bt_usuario").on("click",function(){
           $(modalUsuarios).modal("show")
        })
        //FIM DA FUNÇÃO

        $("#cadastroUsuario").on("hide.bs.modal",function(){
            $(".bt_excluir_usuario").hide()
        })

        $(".bt_excluir_usuario").on("click",function(){
            if(confirm("Deseja mesmo excluir este usuário?")){
                delUsuario("#formCadastroUsuario");
            }
        })

        $(".bt_mudar_usuario").on("click",function(){
            if($("input[name=status]").val() == 1){
                if(confirm("Deseja mesmo desativar este usuário?")){
                    changeStatus()
                }
            }else{
                if(confirm("Deseja mesmo ativar este usuário?")){
                    changeStatus()
                }
            }
        })

        $(".ctrato").hide()
        $("select[name=nivel]").on("change",function(){
            if($(this).val() == "3"){
                $(".ctrato").show()
                $(".permissoes,.permTitle").hide()
            }else{
                $(".ctrato").hide()
                $(".permissoes,.permTitle").show()
            }
        })

        $("input[name=pesquisa]").keyup(function(){
            setTimeout(getRegistros({
                s : $(this).val(),
                Permissao : $("input[name=permissao]").val(),
                IDEmpresa : ($("input[name=permissao]").val() ==3)? $("input[name=IDEmpresa]").val() : ''
            }),3000)
        })

    }

    function delUsuario(){
        var modalUsuarios = "#cadastroUsuario";
        $.ajax({
            method : "POST",
            url : "./Configs/exclusaoDado.php",
            data : {
                ID: $("input[name=usuario_id]",modalUsuarios).val(),
            }
        }).done(function(resultado){
            //console.log(resultado);
            window.location.reload()
        })
    }

    function montaLista(){
        var modalUsuarios = "#cadastroUsuario";
        $(".usuario .imgUs").on("click",function(){
            $(modalUsuarios).modal("show")
            $(modalUsuarios).find("input[name=usuario_id]").val($(this).parents(".usuario").attr("data-id"))
            $(modalUsuarios).find("input[name=usuario]").val($(this).parents(".usuario").find(".titleGrid").text())
            $(modalUsuarios).find("input[name=senha]").val($(this).parents(".usuario").find(".titleGrid").attr("data-ps"))
            $(".bt_excluir_usuario").show()
            $("input[name=USU][value=3]").on("click",function(){
                if($(this).is(":checked")){
                    $("input[name=USU][value=2]").prop("checked",true)
                }else{
                    $("input[name=USU][value=2]").prop("checked",false)
                }
            })

            $("input[name=CON][value=3]").on("click",function(){
                if($(this).is(":checked")){
                    $("input[name=CON][value=2]").prop("checked",true)
                }else{
                    $("input[name=CON][value=2]").prop("checked",false)
                }
            })

            var permissoes = jQuery.parseJSON($(this).parents(".usuario").find(".pms").text().trim())
            //console.log($(this).parents(".usuario").find(".pms").text().trim())
            //return false
            console.log(permissoes)
            $(".permissoes").find("input[type=checkbox]").each(function(){
                for (var [key, value] of Object.entries(permissoes)){
                    if($(this).attr("name") == key){
                            value.forEach((i)=>{
                            if($(this).val() == i){
                                $(this).prop("checked",true)
                            }
                        })
                    }
                }
            })
            // $("#cadastroUsuario").find("input[name=email]").val($(this).parents("tr").find("#permissoes").text())
            if($(this).attr("data-status") == 1){
                $(".bt_mudar_usuario").text("Bloquear")
                $(".bt_mudar_usuario").addClass("btn-warning")
                $(".bt_mudar_usuario").removeClass("btn-success")
            }else{
                $(".bt_mudar_usuario").text("Desbloquear")
                $(".bt_mudar_usuario").removeClass("btn-warning")
                $(".bt_mudar_usuario").addClass("btn-success")
            }
        })
    }

    $("#cadastroUsuario").on("show.bs.modal",function(){
        IDUsuario = $(this).find("input[name=usuario_id]").val()
        //alert(IDUsuario)
    })

    function setRegistro(form){
        //INICIA VALIDACAO DOS CAMPOS
        permissoes = []
        permBolos = [];
        permTortas = [];
        permDoces = [];
        permEmbalagens = [];
        permPedidos = [];
        $("input[name=BOL]:checked").each(function(){
            permBolos.push($(this).val())
        })
        $("input[name=TOR]:checked").each(function(){
            permTortas.push($(this).val())
        })
        $("input[name=DOC]:checked").each(function(){
            permDoces.push($(this).val())
        })
        $("input[name=EMB]:checked").each(function(){
            permEmbalagens.push($(this).val())
        })
        $("input[name=PED]:checked").each(function(){
            permPedidos.push($(this).val())
        })
        if(
            permBolos.length ==0 &&
            permTortas.length ==0 &&
            permDoces.length ==0 &&
            permEmbalagens.length ==0 &&
            permPedidos.length ==0
        ){
            $(".permTitle").addClass("text-danger")
            alert("Marque pelo menos uma permissão")
        }else{
            permissoes = {
                "BOL" : permBolos,
                "TOR" : permTortas,
                "DOC" : permDoces,
                "EMB" : permEmbalagens,
                "PED" : permPedidos
            }
            //
            env = {
                ID    : $("input[name=usuario_id]",form).val(),
                NMUsuario        : $("input[name=usuario]",form).val(),
                PSUsuario         : $("input[name=senha]",form).val(),
                PMUsuario   : JSON.stringify(permissoes)
            }
        }
        if(!validaCampos(form))return false
        //TERMINA A VALIDACAO
        $.ajax({
            method : "POST",
            url    : "./Configs/enviaDados.php",
            data   : env
        }).done(function(resultado){
            console.log(resultado)
            window.location.reload()
        })
    }

    //FIM DA PAGINA
})


