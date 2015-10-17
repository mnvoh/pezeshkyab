<!-- master nav
====================================-->
<header class="navbar navbar-static-top" id="top" role="banner">
    <div class="container navbar-container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse"
                    data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{url('/img/logo.png')}}" alt="{{ trans('main.selector_page_title') }}"
                     class="navbar-logo"/>
            </a>
        </div>
        <nav id="bs-navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('main.docfinder_home') }}"> {{ trans('main.site_name') }} </a>
                </li>
                <li>
                    <a href="{{ route('main.about') }}"> {{ trans('main.about') }} </a>
                </li>
                <li class="active">
                    <a href="{{ route('main.contact') }}"> {{ trans('main.contact') }} </a>
                </li>
                <li>
                    <a href="{{ route('main.links') }}"> {{ trans('main.links') }} </a>
                </li>
                <li>
                    <a href="{{ route('search.find') }}" id="show-find-doctor"> {{ trans('main3.find_a_doctor') }} </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(\Illuminate\Support\Facades\Auth::check()): ?>
                <li><a href="{{ route('user.logout') }}"> {{ trans('main3.logout') }} </a></li>
                <?php else: ?>
                <li><a href="{{ route('user.login') }}"> {{ trans('main.login') }} </a></li>
                <li><a href="{{ route('user.register') }}"> {{ trans('main.register') }} </a></li>
                <?php endif; ?>
                <?php foreach($langs as $l => $ll): ?>
                <?php if($l != $lang): ?>
                <li><a href="<?php echo LangChanger::change($l); ?>"> <?php echo $ll; ?> </a></li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>

    <div id="dr-hp-h-img" style="background-image: url({{ url('img/specialists/' . $specialty . '.jpg') }});">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="text-center">{{ trans('main3.dr') }} {{ $name }}</h1>
					<h2 class="text-center">{{ $specialty_title }}</h2>
				</div>
			</div>
		</div>
		@if($viewerIsOwner)
			<?php $upload_button = true; ?>
		@endif
		@include('avatar200')
    </div>

	<div class="doc-navbar">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse"
						data-target="#doc-navbar" aria-controls="doc-navbar" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="{{ route('doctors.homepage', ['doctor_id' => $doctor_id]) }}" class="navbar-brand">
					{{ trans('main3.dr') }} {{ $name }}
				</a>
			</div>
			<nav id="doc-navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li>
						<a href="{{ route('doctors.articles', ['doctor_id' => $doctor_id]) }}">
							{{ trans('main4.mednews') }}
						</a>
					</li>
					@if($viewerIsOwner)
						<li>
							<a href="{{ route('doctors.schedule') }}">
								{{ trans('main4.manage_schedules') }}
							</a>
						</li>
					@else
						<li>
							<a href="{{ route('appointment.book_for_doctor', ['doctor_id' => $doctor_id, 'step' => 1]) }}">
								{{ trans('main.book_appointment') }}
							</a>
						</li>
					@endif
					@if($viewerIsOwner)
						<li>
							<a href="{{ route('doctors.asked_questions') }}">
								{{ trans('main4.asked_questions') }}
							</a>
						</li>
					@else
						<li>
							<a href="{{ route('doctors.ask', ['doctor_id' => $doctor_id]) }}">
								{{ trans('main2.ask_question') }}
							</a>
						</li>
                    @endif
					@if($viewerIsOwner)
						<li>
							<a href="{{ route('doctors.transactions') }}">
								{{ trans('main4.transactions') }}
							</a>
						</li>
					@endif
				</ul>
			</nav>
		</div>
	</div>
</header>


