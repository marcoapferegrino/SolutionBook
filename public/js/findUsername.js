$(document).ready(function() {


    var consulta;

    //hacemos focus al campo de búsqueda
    $("#username").focus();

    //comprobamos si se pulsa una tecla
   // $("#username").keyup(function(e){

    $("#username").keyup(function(e){

        $("#icon").empty();

    });
    $("#getdata").click(function(e){

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#username").val();
        //hace la búsqueda
        $.ajaxSetup(
            {
                headers:
                {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });

        $.ajax({
            type: "post",
            url: "findUsername",
            //data: consulta,
            data: {'username':$("#username").val()},

            error: function(){
                alert("error petición ajax");
            },
            success: function(data){
                $("#icon").empty();
               // $("#result_table").append(data);
                if(data=="yes"){
                $("#icon").html("<br><br><span style=' font-size: 10pt' class='label label-success'> Disponible <i style='font-size: 150%' class='fa fa-check '></i></span>");
                }
                else{

                $("#icon").html("<br><br><span style=' font-size: 10pt' class='label label-danger'> No disponible <i style='font-size: 150%' class='fa fa-close '></i></span>");

                }

            }
        });


    });


});