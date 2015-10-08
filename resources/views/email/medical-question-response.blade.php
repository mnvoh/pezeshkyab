@extends('email.email')

@section('content')
	<h4>{{ trans('email.your_question') }}</h4>
	<p>{!! nl2br(e($question)) !!}</p>

	<h4>{{ trans('email.response') }}</h4>
	<p>{!! nl2br(e($response)) !!}</p>
@endsection