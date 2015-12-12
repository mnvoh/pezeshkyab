@extends('master')

@section('content')
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
				<div class="medical-question-response">
					<p class="text-info">
						{{ $m->question }}
					</p>
					<blockquote>
						<hr />
						<p class="text-success">
							{{ trans('main.doctors_response', ['name' => $m->doctor->name . ' ' . $m->doctor->lname]) }}
						</p>
						{{ $m->response }}
					</blockquote>
				</div>
			@endforeach

			<a href="{{ route('main.med_questions') }}" class="btn btn-block btn-info">
				{{ trans('main.view_all') }}
			</a>
		</div>
	</div>
@endsection