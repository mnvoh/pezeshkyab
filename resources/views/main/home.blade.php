@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h2>{{ trans('main3.find_a_doctor') }}</h2>
			<hr />
			<div class="row">
				@include('search.simple-search')
			</div>
		</div>
	</div>

	<br /><br />

	<div class="row">
		<div class="col-lg-12">
			<h2>{{ trans('main3.latest_articles') }}</h2>
			<hr />
			<div class="row">
				@if(count($feed))
					@foreach($feed as $f)
						{!! $f !!}
					@endforeach
				@endif
			</div>
		</div>
	</div>

	@if(count($feed))
		<br/>
		<div class="row">
			<div class="col-sm-12 col-md-3">
				<a href="{{ route('main.med_news') }}"
				   class="btn btn-info btn-md btn-block">
					{{ trans('main3.view_all_articles') }}
				</a>
			</div>
		</div>
	@endif
	<br />
@endsection