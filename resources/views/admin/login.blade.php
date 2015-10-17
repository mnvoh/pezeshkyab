@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3 login-form">
			@if (isset($error) && count($error) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($error as $e)
							<li>{{ $e }} </li>
						@endforeach
					</ul>
				</div>
			@endif
			<form action="{{ route('admins.login') }}" method="post">
				<div class="form-group">
					<label for="email">{{ trans('main.email_address') }}</label>
					<input type="email" class="form-control" id="email" name="email"
						   placeholder="{{ trans('main.email_address') }}" />
				</div>

				<div class="form-group">
					<label for="password">{{ trans('main.password') }}</label>
					<input type="password" class="form-control" id="password" name="password"
						   placeholder="{{ trans('main.password') }}" />
				</div>

				<div>
					<label>
						<input type="checkbox" name="remember_me" id="remember_me" checked="checked" />
						{{ trans('main.remember_me') }}
					</label>
				</div>
				{{ csrf_field() }}
				<button type="submit" class="btn btn-success btn-block">
					{{ trans('main.login') }}
				</button>

				<div class="row vertical-spacing"></div>
			</form>
        </div>
    </div>
@endsection