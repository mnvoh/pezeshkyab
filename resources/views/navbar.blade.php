<!-- master nav
====================================-->
<header class="navbar navbar-static-top" id="top" role="banner">
	<div class="container-fluid" id='main-navbar-wrapper'>
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
						<a class="dropdown-toggle" id="linksDropDown" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="true">
							{{ trans('main.links') }}
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" aria-labelledby="linksDropDown">
							@foreach(\App\Models\Link::all() as $link)
								<li>
									<a href="{{ $link->url }}">{{ $link->title }}</a>
								</li>
							@endforeach
						</ul>
					</li>
					<li>
						<a href="{{ route('search.find') }}" id="show-find-doctor"> {{ trans('main.find_a_doctor') }} </a>
					</li>
					<li>
						<a class="mobile-nav-item" href="#">
							{{ trans('main.download_app') }}
						</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(\Illuminate\Support\Facades\Auth::check())
						<li><a href="{{ route('user.logout') }}"> {{ trans('main.logout') }} </a></li>
					@elseif(\App\Auth\AdminAuth::check())
						<li><a href="{{ route('admins.home') }}"> {{ trans('main.administration') }} </a></li>
						<li><a href="{{ route('admins.logout') }}"> {{ trans('main.logout') }} </a></li>
					@else
						<li><a href="{{ route('user.login') }}"> {{ trans('main.login') }} </a></li>
						<li><a href="{{ route('user.register') }}"> {{ trans('main.register') }} </a></li>
					@endif

					@foreach($langs as $l => $ll)
						@if($l != $lang)
							<li><a href="<?php echo LangChanger::change($l); ?>"> <?php echo $ll; ?> </a></li>
						@endif
					@endforeach
				</ul>
			</nav>
		</div>
	</div>


    <?php if(isset($includeMainCarousel) && $includeMainCarousel): ?>
		<div class="container">
			<div id="home-page-banner" class="row">
				<div class="col-xs-12">
					<br />
					<br />
					<h2 class="text-center help-block">
						{{ trans('main.find_and_book') }}
					</h2>
					<br />
					<br />
					@include('search.simple-search')
				</div>
			</div>
		</div>
		<hr />
    <?php endif; ?>
</header>