@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">

			<h4>{{ trans('main.reset_password') }}</h4>

			<form method="POST" action="{{ route('auth.reset_password_post') }}">
				{!! csrf_field() !!}
				<input type="hidden" name="token" value="{{ $token }}">

				@if (count($errors) > 0)
					<ul>
						@foreach ($errors->all() as $error)
							<li class="text-error">{{ $error }}</li>
						@endforeach
					</ul>
				@endif

				<div>
					{{ trans('main.email_address') }}
					<input class="form-control" type="email" name="email" value="{{ old('email') }}">
				</div>

				<div>
					{{ trans('main.password') }}
					<input class="form-control" type="password" name="password">
				</div>

				<div>
					{{ trans('main.repeat_password') }}
					<input class="form-control" type="password" name="password_confirmation">
				</div>

				<div>
					<button class="btn btn-info" type="submit">
						{{ trans('main.reset_password') }}
					</button>
				</div>
			</form>

        </div>
    </div>
@endsection