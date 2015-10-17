<div class="admin-navbar">
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
				{{ trans('main2.home') }}
			</a>
		</div>
		<nav id="admin-navbar" class="collapse navbar-collapse">
			@if(\App\Auth\AdminAuth::check())
				<ul class="nav navbar-nav">
					<li>
						<a href="{{ route('admins.home') }}">
							{{ trans('main4.admin_home') }}
						</a>
					</li>
					<li class="shade1">
						<span></span>
						<a href="{{ route('admins.doctors') }}">
							{{ trans('main4.doctors') }}
						</a>
					</li>

				@if(\App\Auth\AdminAuth::admin()->type == 'master')
					<li class="shade2">
						<span></span>
						<a href="{{ route('admins.admins') }}">
							{{ trans('main4.admins') }}
						</a>
					</li>
				@endif

					<li class="shade3">
						<span></span>
						<a href="{{ route('admins.transactions') }}">
							{{ trans('main4.transactions') }}
						</a>
					</li>

					<li class="shade4">
						<span></span>
						<a href="{{ route('admins.reservations') }}">
							{{ trans('main4.reservations') }}
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
						{{ trans('main4.other') }}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
						<li>
							<a href="{{ route('admins.medical_question') }}">
								{{ trans('main2.fees') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.medical_question') }}">
								{{ trans('main4.hospitals') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.medical_question') }}">
								{{ trans('main4.mednews') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.medical_question') }}">
								{{ trans('main4.chat_msgs') }}
							</a>
						</li>
						<li>
							<a href="{{ route('admins.medical_question') }}">
								{{ trans('main4.specialties') }}
							</a>
						</li>
					</ul>
				</div>
			@endif

			<ul class="nav navbar-nav navbar-right">
				@if(\App\Auth\AdminAuth::check())
					<li><a href="{{ route('admins.logout') }}"> {{ trans('main3.logout') }} </a></li>
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