$("#title").on('keyup',function(){

    /*$(this).popover({
        title: 'Ver Problemas similares:',
        placement: 'bottom'
    });*/
    var x = $(this).val();
    if (x=='') {x='a'};
    var form = $('#form-titulo');
    var url = form.attr('action').replace(':TEXT',x);
    var data = form.serialize();
//            alert(data);
    $.post(url,data,function(result){
        $("#similarTitle").html(result);
    });
    //$(this).popover('show');

});
/*
$("#title").change(function(){

    $(this).popover('hide');
});*/
