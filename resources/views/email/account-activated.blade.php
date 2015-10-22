@extends('email.email')

@section('content')

	<p>
		{{ $content }}
		<a href="{{ route('user.login') }}">{{ trans('main.login') }}</a>
	</p>

@endsection