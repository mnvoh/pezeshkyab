@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<a href="{{ route('doctors.add_med_news') }}" class="btn btn-default btn-block"
			   title="{{ trans('main4.add_medical_news') }}">
				{{ trans('main4.add_medical_news') }}
			</a>

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
		{!! $med_news->render() !!}
	@endif
	<br />
@endsection