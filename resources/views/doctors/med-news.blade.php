@extends('master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-xs-12">
						<h2>{{ $title }}</h2>
						<p>
							{{ trans('main2.published_by') }}:
							<a href="{{ route('doctors.homepage', ['doctor_id' => $doctor_id]) }}">
								{{ $doctor_name }}
							</a>
							{{ trans('main2.on') }}:
							{{ $published_on }}
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						{!! $body !!}
					</div>
					<hr />
				</div>
			</div>
		</div>
	</div>

@endsection