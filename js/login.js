jQuery(function(){
/////////////JQUERY
//Enviar dados para validação
 $("#form_acesso").on("submit",function(e){
    e.preventDefault(); //Evita o disparo do formulario
    //Enviando os dados
    $.ajax({
        url    : "Configs/token.php",
        method : "POST",
        data : {
            user : $("input[name=user]").val(),
            senha : $("input[name=senha]").val()
        }
    }).done(function(resultado){
        // console.log(resultado)
        // return false
        var json = jQuery.parseJSON(resultado)
        if(json['status']){
            window.location.href='index.php';
        }else{
            $(".error").html(json['error'])
        }
    })
    
 })
 ///////CONFERIR O ACESSO DO USUARIO
var confereAcesso = setInterval (function () {
    $.ajax({
        url: '../Configs/token.php'
    }).done(function(r){
        console.log(r)
        if(parseInt(r) == 0){
            window.location.href='../login.html'
        }
    });
}, 5000);

 })




 /////////////////FIM DO JQUERY
