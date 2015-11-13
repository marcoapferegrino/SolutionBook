<html>
	<head>

        <title>Solution Book</title>
        <link rel="icon" href="{{url("oie_transparent.png")}}">
		<link href='//fonts.googleapis.com/css?family=Lato:200' rel='stylesheet' type='text/css'>

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="http://d3dhju7igb20wy.cloudfront.net/assets/0-4-0/all-the-things.css" />


        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="{{asset('/js/wall.js')}}"></script>
		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #cbbaca;
				display: table;
				font-weight: 200;
                background-color:rgba(0, 0, 0, 0.9);
				font-family: Lato;
                /*background-color: #5e5e5e ;*/
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body id="body">
		<div class="container">
			<div class="content" >
				<div  class="title  blue-gradient-background" style="margin-left:0% ;border-color: #ffffff; border-radius: 15px 50px; border-width: 15px;border-style: solid";><b style="color: #f7f7f7">
                        &nbsp; <img  src="{{url("icon.png")}}">
                        Solution Book &nbsp;</b><small style="font-size: 50%">.Beta<i class="fa fa-qq " style=" ; color: #f7f7f7"></i></small> </div>

				<div class="quote"><b style="color: ffffff"> "{{ Inspiring::quote() }} </b></div>
			</div>
            <br><br><br>
            <a class="btn btn-primary " style="border-radius: 16px" href="{{url('auth/login')}}" role="button" ><i class="fa fa-gamepad fa-5x on fa-circle"></i>
            </a>
		</div>


	</body>


</html>
