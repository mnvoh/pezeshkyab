@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h2>{{ trans('main.find_a_doctor') }}</h2>
			<hr />
			<div class="row">
				@include('search.simple-search')
			</div>
		</div>
	</div>

	<br /><br />

	<div class="row">
		<div class="col-lg-12">
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
					{{ trans('main.view_all_articles') }}
				</a>
			</div>
		</div>
	@endif
	<br />
	<hr />

	<div class="row">
		<div class="col-lg-12">
			<h3>{{ trans('main.latest_medical_questions') }}</h3>
			@foreach($medical_questions as $m)
				<blockquote>
					{{ $m->question }}
					<blockquote>
						{{ trans('main.doctors_response', ['name' => $m->doctor->name . ' ' . $m->doctor->lname]) }}
						<br /> <hr />
						{{ $m->response }}
					</blockquote>
				</blockquote>
			@endforeach

			<a href="{{ route('main.med_questions') }}">
				{{ trans('main.view_all') }}
			</a>
		</div>
	</div>
@endsection