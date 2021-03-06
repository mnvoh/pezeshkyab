<!DOCTYPE html>
<html lang="">
	<head>
    	<title>
    		{{ trans('main.selector_page_title') }}
    	</title>
    	<meta charset="UTF-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link href="{{ url('fonts/IranNastaliq/styles.css') }}" rel="stylesheet" />
    	<style>
			html {
				background: url(../img/front-page-bg.jpg) center center no-repeat;
				background-size: cover;
				height: 100%;
			}

			html, body {
				background-color: transparent;
				height: 100%;
				margin: 0;
				padding: 0;
			}
			.container {
				display: table;
				height: 100%;
				width: 94%;
				margin: 0 3%;
			}
			.container>div {
				display: table-cell;
				vertical-align: middle;
				text-align: center;
			}
			h1 {
				color: #58d;
				text-shadow: 0 0 3px #1B3052, 0 0 3px #1B3052, 0 0 3px #1B3052;
				text-align: center;
				font-family: IranNastaliq, Tahoma, sans-serif;
				font-size: 58px;
				line-height: 98px;
			}
			.btn {
				background: #58d;
				border: 1px solid #47c;
				border-radius: 5px;
				color: #fff;
				display: inline-block;
				text-decoration: none;
				padding: 5px 15px;
				margin: 15px;
				width: 40%;
				text-align: center;
				font-size: 20px;
				line-height: 40px;
			}
			.btn:hover {
				background: #487FDB;
			}
			@media (max-width: 768px) { 
				.btn {
					width: 90%;
					margin: 15px 0;
				}
			}
    	</style>
    	<link rel="shortcut icon" href="/img/favicon.png" />
	</head>
	<body>
		<div class="container">
			<div>
				<h1 class="text-center"> {{ trans('main.selector_page_title') }} </h1>

				<a class="btn" href="{{ route('main.docfinder_home') }}">
					{{ trans('main.doctor_finder_system') }}
				</a>

				<a class="btn" href="#">
					{{ trans('main.medical_clinic_system') }}
				</a>
			</div>
		</div>
	</body>
</html>