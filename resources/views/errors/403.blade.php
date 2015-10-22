<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>
		<link rel="stylesheet" href="{{ url('css/style.css') }}" />
        <style>
            html, body {
				background: #eee;
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: Ubuntu, "Helvetica Neue", Helvetica, Arial, sans-serif;
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
                font-size: 72px;
                margin-bottom: 40px;
            }

			.content div a { margin: 20px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">{{ trans('main.access_denied') }}</div>
				<div>
					<a href="{{ route('user.login') }}"> {{ trans('main.doctors_login') }} </a>
					<a href="{{ route('admins.login') }}"> {{ trans('main.admins_login') }} </a>
				</div>
            </div>
        </div>
    </body>
</html>
