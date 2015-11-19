/**
 * Created by vale on 17/11/2015.
 */
$("#password2").on('keyup',function(){
    var password=$("#password").val();
    var password2=$(this).val();
    if(password!=password2){
        $("#messagePassword").html("La contraseña no coincide");
    }
    else{
        $("#messagePassword").append("La contraseña es correcta");
    }
});