@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h2>{{ trans('main3.about_doctor') }}</h2>
			<hr />
			<p>
				<span class="glyphicon glyphicon-user p-starter"></span>
				{{ $about }}

				<br /><br />
			</p>
		</div>
	</div>

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
				<a href="{{ route('doctors.articles', ['doctor_id' => $doctor_id]) }}"
				   class="btn btn-info btn-md btn-block">
					{{ trans('main3.view_all_articles') }}
				</a>
			</div>
		</div>
	@endif
	<br />
@endsection