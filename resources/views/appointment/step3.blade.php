@extends('master')

@section('content')

    @include('appointment.step-viewer')

	<form action="{{ $next_step_link }}" method="post">
		<div class="row">
			<div class="col-sm12 col-md-10 col-lg-8">
				<h2>{{ trans('main.doctor_desc') }}</h2>
				@if(isset($error))
					<p class="text-error">{{ $error }}</p>
				@endif

				<?php
					if($filled_info['b_doctor_label'] != '-') {
						$old_doctor_id = $filled_info['b_doctor_id'];
						$old_doctor_description = $filled_info['b_doctor_label'];
					}
				?>
				@include('doctor-picker')

				{{ csrf_field() }}

				<div class="row">
					<div class="col-xs-9">
						<button type="submit" class="btn btn-block btn-success" name="form-submitted" value="true">
							{{ trans('main.next') }}
						</button>
					</div>
					<div class="col-xs-3">
						<a href="{{ $go_back_url }}" class="btn btn-warning btn-block">
							{{ trans('main.go_back') }}
						</a>
					</div>
				</div>
			</div>
		</div> <!-- <div class="row"> -->
	</form>
@endsection

