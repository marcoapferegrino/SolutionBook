<html>
	<head>
		<title>Solution Book</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:200' rel='stylesheet' type='text/css'>

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #cbbaca;
				display: table;
				font-weight: 200;
				font-family: 'Lato';
                background-color: #5e5e5e ;
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
	<body>
		<div class="container">
			<div class="content">
				<div class="title" style="border-color: #ffffff; border-radius: 15px 50px; border-width: 15px;;border-style: solid";><b style="color: #f7f7f7"> Solution Book </b><small style="font-size: 50%">.Alpha <i class="fa fa-qq " style=" ; color: #f7f7f7"></i></small> </div>

				<div class="quote"><b> "{{ Inspiring::quote() }} </b></div>
			</div>
            <br><br><br>
            <a class="btn btn-primary " style="border-radius: 16px" href="{{url('auth/login')}}" role="button" ><i class="fa fa-gamepad fa-5x on fa-circle"></i>
            </a>

		</div>


	</body>
</html>
