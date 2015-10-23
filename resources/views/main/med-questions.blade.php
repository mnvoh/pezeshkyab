@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h3>{{ trans('main.medical_questions') }}</h3>
			<hr />
			@foreach($questions as $m)
				<blockquote>
					{{ $m->question }}
					<blockquote>
						{{ trans('main.doctors_response', ['name' => $m->doctor->name . ' ' . $m->doctor->lname]) }}
						<br /> <hr />
						{{ $m->response }}
					</blockquote>
				</blockquote>
			@endforeach
			<br />
			{!! $questions->render() !!}
		</div>
	</div>
@endsection