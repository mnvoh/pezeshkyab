@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">

			<h4>{{ trans('main.enter_email_to_reset') }}</h4>

			@if(\Illuminate\Support\Facades\Session::has('reset_email_sent'))
				<h4 class="text-success">{{ trans('main.password_reset_mail_sent') }}</h4>
				<?php \Illuminate\Support\Facades\Session::forget('reset_email_sent'); ?>
			@else
				<form method="POST" action="{{ route('auth.reset_password_email') }}">
					{!! csrf_field() !!}

					@if (count($errors) > 0)
						<ul>
							@foreach ($errors->all() as $error)
								<li class="text-error">{{ $error }}</li>
							@endforeach
						</ul>
					@endif

					<div class="form-group">
						{{ trans('main.email_address') }}
						<input class="form-control" type="email" name="email" value="{{ old('email') }}">
					</div>

					<div>
						<button type="submit" class="btn btn-info">
							{{ trans('main.submit') }}
						</button>
					</div>
				</form>
			@endif

        </div>
    </div>
@endsection