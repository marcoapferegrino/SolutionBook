$("#palabras").on('keyup',function(){

    var form = $('#form-titulo');
    var url = form.attr('action');
    var data = form.serialize();
    $.post(url,data,function(result){
        $("#problemas").html(result);
    });

});