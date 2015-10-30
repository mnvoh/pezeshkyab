<div class="admin-navbar hidden-print">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle collapsed" type="button" data-toggle="collapse"
					data-target="#admin-navbar" aria-controls="admin-navbar" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ route('main.docfinder_home') }}" class="navbar-brand">
				{{ trans('main.home') }}
			</a>
		</div>
		<nav id="admin-navbar" class="collapse navbar-collapse">
			@if(\App\Auth\AdminAuth::check())
				<ul class="nav navbar-nav">
					<li>
						<a href="{{ route('admins.home') }}">
							{{ trans('main.admin_home') }}
						</a>
					</li>
					<li class="shade1">
						<span></span>
						<a href="{{ route('admins.doctors') }}">
							{{ trans('main.doctors') }}
						</a>
					</li>

				@if(\App\Auth\AdminAuth::admin()->type == 'master')
					<li class="shade2">
						<span></span>
						<a href="{{ route('admins.admins') }}">
							{{ trans('main.admins') }}
						</a>
					</li>
				@endif

					<li class="shade3">
						<span></span>
						<a href="{{ route('admins.transactions') }}">
							{{ trans('main.transactions') }}
						</a>
					</li>

					<li class="shade4">
						<span></span>
						<a href="{{ route('admins.reservations') }}">
							{{ trans('main.reservations') }}
						</a>
					</li>

					<li class="shade5">
						<span></span>
						<a href="{{ route('admins.medical_question') }}">
							{{ trans('main.medical_question') }}
						</a>
					</li>
				</ul>
	<!-- ---------------------------------------- -->
				<div class="dropdown shade6">
					<span></span>
					<button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ trans('main.other') }}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
						<li>
							<a href="{{ route('admins.fees') }}">
								{{ trans('main.fees') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.insurances') }}">
								{{ trans('main.insurances') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.specialties') }}">
								{{ trans('main.specialties') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.hospitals') }}">
								{{ trans('main.hospitals') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.medical_news') }}">
								{{ trans('main.mednews') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.chats') }}">
								{{ trans('main.chats') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.links') }}">
								{{ trans('main.links') }}
							</a>
						</li>
					</ul>
				</div>
			@endif

			<ul class="nav navbar-nav navbar-right">
				@if(\App\Auth\AdminAuth::check())
					<li><a href="{{ route('admins.logout') }}"> {{ trans('main.logout') }} </a></li>
				@else
					<li><a href="{{ route('admins.login') }}"> {{ trans('main.login') }} </a></li>
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