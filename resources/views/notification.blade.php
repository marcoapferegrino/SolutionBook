<!DOCTYPE html>
<html>
<head>
    <title>Pusher ejemplo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,200italic,300italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://d3dhju7igb20wy.cloudfront.net/assets/0-4-0/all-the-things.css" />

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="/js/pusherEmbed.js"></script>


    <!-- <script>
         var idG;
         var likesG;

         $(document).ready(function() {
             var id; var likes;
             $.ajax({
                 type: "post",
                 url: "findUserLikes",
                 //data: consulta,
                // data: {'username':$("#username").val()},

                 error: function(){
                     alert("error petición ajax");
                 },
                 success: function(data){
                  //  alert(data);
                     var string= data
                     var respons = JSON.parse(string);
                     //id=response.user_id;
                    // likes=parseInt(response.likes);
                    // alert(lik);
                     id=respons.user_id; likes=respons.likes;

                     window.idG=id;window.likesG=likes;
                     document.getElementById("notify").innerHTML =likesG;

                 }
             });

         });



         // Ensure CSRF token is sent with AJAX requests
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // 'X-CSRF-Token': $('meta[name="csrf-token"]').val()
             }
         });


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

             if(window.idG==data.id){  // es mi like

                 var numbers= $('#notify').text();
                 var numbbb= parseInt(numbers);
                 document.getElementById("notify").innerHTML =numbbb+1;
                 // TODO: use the text in the notification
                 toastr.success(data.message, null, {"positionClass": "toast-top-right"});
             }


         }

         var pusher = new Pusher('{{env("PUSHER_KEY")}}');

         var channel = pusher.subscribe('test-channel');
         channel.bind('test-event', callback);
         // Added Pusher logging
         Pusher.log = function(msg) {
             console.log(msg);
         };

     </script>
     -->


</head>
<body>

<div class="stripe no-padding-bottom numbered-stripe">
    <div class="fixed wrapper">
        <ol class="strong" start="1">
            <li>
                <div class="hexagon"></div>
                <h2>Notificaciones</h2>
            </li>
        </ol>
    </div>
</div>

<section class="blue-gradient-background ">
    <div class="container center-all-container">
        <form id="notify_form" action="/notifications/notify" method="post">
            <input type="text" id="notify_text" name="notify_text"
                   placeholder="Envia algo" minlength="3" maxlength="140" required />
        </form>
    </div>
</section>

<br><br><br>
<div align="middle">
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        <span style="font-size: 125%" id="number" class="label label-success"><i id="notify" class="fa fa-star"></i> </span>
        <span class="caret"></span></a>
    <ul class="dropdown-menu"  id="notificationsj" role="menu">
        <li><a href="">1</a></li>
        <li><a href="">2</a></li>
        <li><a href="">3</a></li>

    </ul>
</li>
</div>
<div id="another" align="middle">0</div>

</body>
</html>
