

// Ensure CSRF token is sent with AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // 'X-CSRF-Token': $('meta[name="csrf-token"]').val()
    }
});

var idG;
var likesG;

$(document).ready(function() {
    var id; var likes;
    $.ajax({
        type: "post",
        url: "/findUserLikes",
        //data: consulta,
        // data: {'username':$("#username").val()},

        error: function(){
            alert("error petición ajax LIKES");
        },
        success: function(data){
            //  alert(data);
            var string= data
            var respons = JSON.parse(string);
            //id=response.user_id;
            // likes=parseInt(response.likes);
            // alert(lik);
          //  alert(data);
            id=respons.user_id; likes=respons.likes;

            window.idG=id;window.likesG=likes;
            document.getElementById("notify").innerHTML =' '+likesG;

            document.getElementById("wait").style.display = 'none';

        }
    });



});

function deView(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // 'X-CSRF-Token': $('meta[name="csrf-token"]').val()
        }
    });
    var idLike=id;
    $.ajax({
        type: "post",
        url: "/deView",
        data: "id="+idLike,
        // data: {'username':$("#username").val()},

        error: function(){
           // alert("error petición ajax VIEW");
        },
        success: function(data){
            //alert(data);
            /*alert(data);
            var string= data
            var respons = JSON.parse(string);
            //id=response.user_id;
            // likes=parseInt(response.likes);
            // alert(lik);
            //  alert(data);
            id=respons.user_id; likes=respons.likes;

            window.idG=id;window.likesG=likes;
            document.getElementById("notify").innerHTML =' '+likesG;*/

        }
    });
}




/*var pusher = new Pusher('{{env("PUSHER_KEY")}}');

 var channel = pusher.subscribe('test-channel');
 channel.bind('test-event', callback);*/

function notifyInit() {
    // set up form submission handling
    $('#notify_form').submit(notifySubmit);
}

// Handle the form submission
function notifySubmit() {
    var notifyText = $('#notify_text').val();
    if(notifyText.length < 3) {
        return;
    }

    // Build POST data and make AJAX request
    var data = {notify_text: notifyText};
    $.post('/notifications/notify', data).success(notifySuccess);

    // Ensure the normal browser event doesn't take place
    return false;
}

// Handle the success callback
function notifySuccess() {
    console.log('notification submitted');
}

$(notifyInit); // Existing functionality

// var numbers;
// Use toastr to show the notification
var callback=function showNotification(data) {

    var dats= JSON.parse(data);

    if(window.idG==dats.id){  // es mi like
       // alert('es mi like');
        var numbers= $('#notify').text();
        var numbbb= parseInt(numbers);
        //alert(dats.solution);

        toastr.success("liky", null, {"positionClass": "toast-top-right"});
        document.getElementById("notify").innerHTML =numbbb+1;
        //document.getElementById("likeList").innerHTML =numbbb+1;
        document.getElementById("lastLike").style.display = 'none';
        $("#likeList").append('<li class="text text-center"> <a href="'+dats.url+'" >'+dats.message+'<br>'+
                        "<small>Fecha:"+dats.date+'</small></a></li>').on('click','dropdown-menu sidebar-offcanvas ', deView(dats.solution));

        $("#likeList").append('<li class="label-primary text-center "><a href="/">Ver todas <i class="fa fa-plus-square"></i></a></li>');
        // TODO: use the text in the notification
    }


}

var pusher = new Pusher('57c6339fba339d32f2ca');
//var pusher = new Pusher('{{env("PUSHER_KEY")}}');

var channel = pusher.subscribe('test-channel');
channel.bind('test-event', callback);
// Added Pusher logging
Pusher.log = function(msg) {
    console.log(msg);
};
