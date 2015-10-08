@extends('email.email')

@section('content')

	<p>{!! nl2br(e($content)) !!}</p>

@endsection