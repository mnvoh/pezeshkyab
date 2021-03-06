<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}">
    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ trans('main.site_description') }}">
        <meta name="keywords" content="{{ trans('main.site_keywords') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>

            @if(isset($page_title))
                {{ $page_title }}
                &middot;
            @endif

            {{ trans('main.site_name') }}
            &middot;
            {{ trans('main.site_slogan') }}

        </title>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

		<link rel="stylesheet" href="{{ url('css/jquery-ui.css') }}" />
        <link rel="stylesheet" href="{{ url('css/bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ url('css/style.css') }}" />
		<link rel="stylesheet" href="{{ url('css/summernote.css') }}" />
		<link rel="stylesheet" href="{{ url('css/font-awesome.css') }}" />
		<link rel="stylesheet" href="{{ url('css/jquery.flipcounter.css') }}" />
		<link rel="stylesheet" href="{{ url('css/jquery-fullsizable.css') }}" />
		<link rel="stylesheet" media="print" href="{{ url('css/print.css') }}" />

        @if($dir == 'rtl')
            <link rel="stylesheet" href="{{ url('css/bootstrap-rtl.css') }}" />
            <link rel="stylesheet" href="{{ url('css/style.rtl.css') }}" />
        @endif


        <!-- Favicons -->
        <link rel="apple-touch-icon" href="/apple-touch-icon.png"> <!-- 180 -->
        <link rel="icon" href="/favicon.ico"> <!-- 32 -->
    </head>
    <body>
		@if(isset($use_doctors_navbar) && $use_doctors_navbar)
			@include('doctors.navbar')
		@elseif(isset($user_admin_navbar) && $user_admin_navbar)
			@include('admin.navbar')
		@else
    		@include('navbar')
		@endif

		@if(!isset($hide_content))
			<div class="container content-container">
				@section('content')
				@show
			</div>
		@endif

        <?php if(isset($includeMedicalQuestionForm) && $includeMedicalQuestionForm): ?>
            @include('medical_question')
        <?php endif; ?>

        @include('footer')

    	<script src="{{ url('js/jquery.js') }}"></script>
		<script src="{{ url('js/jquery-ui.js') }}"></script>
		<script src="{{ url('js/jquery-fullsizable.js') }}"></script>
    	<script src="{{ url('js/bootstrap.js') }}"></script>
        <script src="{{ url('js/script.js') }}"></script>
        <script src="{{ url('js/elasticsearch.js') }}"></script>
        <script src="{{ url('js/elasticsearch-jquery.js') }}"></script>
		<script src="{{ url('js/summernote.js') }}"></script>
		<script src="{{ url('js/jquery.flipcounter.js') }}"></script>
		<script src="{{ url('js/jstween-1.1.min.js') }}"></script>

		@if(isset($include_maps) && $include_maps)
			<script src="https://maps.googleapis.com/maps/api/js"></script>
			<script src="{{ url('js/maps.js') }}"></script>
		@endif

		@if(\Illuminate\Support\Facades\Auth::check())
			@include('doctors.floating-chat')
		@endif

		<div class="modal fade" id="cities-list-modal" tabindex="-1" role="modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<p></p>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
    </body>
</html>
<!-- end of master -->