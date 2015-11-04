$("#tags").on('keyup',function(){

    var x = $(this).val();

    if (x=='') {x='a#'};
    var form = $('#form-tag');
    var url = form.attr('action').replace(':TEXT',x);
    var data = form.serialize();
   /* $(this).popover({
        title: 'Ver Problemas similares:',
        width:'300px',
        placement: 'bottom'
    });*/
    $.post(url,data,function(result){
        //$(".popover-content").html(result);
        $("#similarTags").html(result);
    });

    //$(this).popover('show');

});
/*
$("#tags").change(function(){

    $(this).popover('hide');
});*/
