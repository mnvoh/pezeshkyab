@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h3>{{ trans('main.medical_questions') }}</h3>
			<hr />
			@foreach($questions as $m)
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
			<br />
			{!! $questions->render() !!}
		</div>
	</div>
@endsection