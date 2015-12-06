

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

        error: function(){
           // alert("error petición ajax LIKES");
        },
        success: function(data){
            // alert(data);
            var string= data
            var respons = JSON.parse(string);
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

        }
    });
}


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

function notifySuccess() {
    //console.log('notification submitted');
}

$(notifyInit);

// var numbers;
// Use toastr to show the notification
var callbackLike=function showNotification1(data) {

    var dats= JSON.parse(data);

    if(window.idG==dats.id){
        var numbers= $('#notify').text();
        var numbbb= parseInt(numbers);
        //  toastr.success("liky", null, {"positionClass": "toast-top-right"});
        document.getElementById("notify").innerHTML =numbbb+1;
        $("#likeList").prepend('<li style="background-color:  palegreen"  class="text text-center"> <a href="'+dats.url+'" >'+dats.message+'<br>'+
        "<small>"+dats.date+'</small></a></li>');
        $('#bell').css('color','yellow');


//        $("#likeList").append('<li class="label-primary text-center "><a href="/">Ver todas <i class="fa fa-plus-square"></i></a></li>');
        // TODO: use the text in the notification
    }


}
var callbackWarning=function showNotification2(data) {

    var dats= JSON.parse(data);
    if(window.idG==dats.id){
        var numbers= $('#notify').text();
        var numbbb= parseInt(numbers);
        //  toastr.success("liky", null, {"positionClass": "toast-top-right"});
        document.getElementById("notify").innerHTML =numbbb+1;
         $("#likeList").prepend('<li style="background-color:  palegoldenrod" class="text text-center"> <a href="'+dats.url+' " >'+dats.message+'<br>'+
         "<small>"+dats.date+'</small></a></li>');
        $('#bell').css('color','yellow');

    }


}

var callbackPromote=function showNotification3(data) {

    var dats= JSON.parse(data);

    if(window.idG==dats.id){
        var numbers= $('#notify').text();
        var numbbb= parseInt(numbers);
        //  toastr.success("liky", null, {"positionClass": "toast-top-right"});
        document.getElementById("notify").innerHTML =numbbb+1;
        $("#likeList").prepend('<li style="background-color:  #a6e1ec" class="text text-center"> <a href="'+dats.url+' " >'+dats.message+'<br>'+
        "<small>"+dats.date+'</small></a></li>');
        $('#bell').css('color','yellow');

    }


}

var pusher = new Pusher('57c6339fba339d32f2ca');
//var pusher = new Pusher('{{env("PUSHER_KEY")}}');

var channelLike = pusher.subscribe('likes-channel');
channelLike.bind('likes-event', callbackLike);
var channelWarning = pusher.subscribe('warnings-channel');
channelWarning.bind('warnings-event', callbackWarning);
var channelPromote = pusher.subscribe('promotes-channel');
channelPromote.bind('promotes-event', callbackPromote);
// Added Pusher logging
Pusher.log = function(msg) {
   // console.log(msg);
};
