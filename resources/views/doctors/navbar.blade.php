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
                    <a href="{{ route('search.find') }}" id="show-find-doctor"> {{ trans('main.find_a_doctor') }} </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(\Illuminate\Support\Facades\Auth::check()): ?>
                	<li><a href="{{ route('user.logout') }}"> {{ trans('main.logout') }} </a></li>
				@elseif(\App\Auth\AdminAuth::check())
					<li><a href="{{ route('admins.home') }}"> {{ trans('main.administration') }} </a></li>
					<li><a href="{{ route('admins.logout') }}"> {{ trans('main.logout') }} </a></li>
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

    <div id="dr-hp-h-img" style="background-image: url({{ $specialty_image }});">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="text-center">{{ trans('main.dr') }} {{ $name }}</h1>
					<h2 class="text-center">{{ $specialty_title }}</h2>
					<div class="rating" dir="ltr">
						<?php
						$rating = \App\Models\Doctor::where('id', $doctor_id)->first()->rating();
						$ratingInt = (int)$rating;
						$ratingFloat = $rating - $ratingInt;
						for($j = 1; $j <= $ratingInt; $j++) {
							echo "<span class='fa fa-star fa-2x'></span>";
						}

						if($ratingFloat >= 0.5) {
							$value = $ratingInt + 1;
							echo "<span class='fa fa-star fa-2x'></span>";
						}
						else {
							$value = $ratingInt + 0.5;
							echo "<span class='fa fa-star-half-o fa-2x'></span>";
						}

						for($k = $ratingInt + 2; $k <= 5; $k++) {
							echo "<span class='fa fa-star-o fa-2x'></span>";
						}
						?>
					</div>

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
					{{ trans('main.dr') }} {{ $name }}
				</a>
			</div>
			<nav id="doc-navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li>
						<a href="{{ route('doctors.articles', ['doctor_id' => $doctor_id]) }}">
							{{ trans('main.mednews') }}
						</a>
					</li>
					@if($viewerIsOwner)
						<li>
							<a href="{{ route('doctors.schedule') }}">
								{{ trans('main.manage_schedules') }}
							</a>
						</li>
					@else
						<li>
							<a href="{{ route('appointment.book', ['step' => 1, 'doctor_id' => $doctor_id]) }}">
								{{ trans('main.book_appointment') }}
							</a>
						</li>
					@endif
					@if($viewerIsOwner)
						<li>
							<a href="{{ route('doctors.asked_questions') }}">
								{{ trans('main.asked_questions') }}
							</a>
						</li>
					@else
						<li>
							<a href="{{ route('doctors.ask', ['doctor_id' => $doctor_id]) }}">
								{{ trans('main.ask_question') }}
							</a>
						</li>
                    @endif
					@if($viewerIsOwner)
						<li>
							<a href="{{ route('doctors.transactions') }}">
								{{ trans('main.transactions') }}
							</a>
						</li>
					@endif
				</ul>
			</nav>
		</div>
	</div>
</header>


