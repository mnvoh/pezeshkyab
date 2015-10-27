@extends('master')

@section('content')

    @include('appointment.step-viewer')

	<form action="{{ $next_step_link }}" method="post">
		<div class="row">
			<div class="col-sm12 col-md-10 col-lg-8">
				<h2>{{ trans('main.schedule_information') }}</h2>
				@if(isset($error))
					<p class="text-error">{{ $error }}</p>
				@endif

				@if(count($open_appointments))
					<div class="row">
						<?php foreach($open_appointments as $a): ?>
							<div class="col-sm-6 col-md-4 col-lg-3">
								<?php echo $a; ?>
							</div>
						<?php endforeach; ?>
					</div>
				@else
					<h3 class="text-center text-error">{{ trans('main.no_open_schedules') }}</h3>
				@endif


				<input type="hidden" name="reservation_id" id="reservation_id" value="" />

				{{ csrf_field() }}



				<div class="row">
					<div class="col-xs-9">
						@if((!isset($error) || !$error) && count($open_appointments))
							<button type="submit" class="btn btn-block btn-success" name="form-submitted" value="true">
								{{ trans('main.next') }}
							</button>
						@endif
					</div>
					<div class="col-xs-3">
						<a href="{{ $go_back_url }}" class="btn btn-warning btn-block">
							{{ trans('main.go_back') }}
						</a>
					</div>
				</div>

			</div>
		</div>
	</form>
@endsection

