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
        var RegExPattern = /^[a-zA-Z0-9Nñ]+$/;
        var letter= consulta.search(RegExPattern);
        var blank = consulta.indexOf(" ");

        if(consulta==''||consulta==null||blank!=-1||letter==-1){
            $("#icon").html("<span style=' font-size: 10pt' class='label label-danger'> No válido<i style='font-size: 150%' class='fa fa-close '></i></span>");

        }else{
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
            url: "/findUsername",
            //data: consulta,
            data: {'username':$("#username").val()},

            error: function(){
                //alert("error petición ajax");
            },
            success: function(data){
              //  alert('-'+data+'-');
                var dats= JSON.parse(data);
                $("#icon").empty();
               // $("#result_table").append(data);
                if(dats.res=="yes"){
                $("#icon").html("<span style=' font-size: 10pt' class='label label-success'> Disponible <i style='font-size: 150%' class='fa fa-check '></i></span>");
                }
                if(dats.res=="no"){

                $("#icon").html("<span style=' font-size: 10pt' class='label label-danger'> No disponible <i style='font-size: 150%' class='fa fa-close '></i></span>");

                }

            }
        });
        }

    });


});