@extends('master')

@section('content')

    @include('appointment.step-viewer')

	<form action="{{ $next_step_link }}" method="post">
		<div class="row">
			<div class="col-sm12 col-md-10 col-lg-8">
				@if(isset($error))
					<p class="text-error">{{ $error }}</p>
				@endif

				<h3>
					{{ trans('main.select_insurance') }}
				</h3>

				<select class="form-control" name="insurance">
					<option value="-1">{{ trans('main.no_insurance') }}</option>
					@foreach(\App\Models\Insurance::all() as $i)
						<option value="{{ $i->id }}"
								@if($i->id == $filled_info['b_insurance_id']) selected @endif>
							{{  $i->title }}
						</option>
					@endforeach
				</select>

				<br />

				<div class="row">
					<div class="col-xs-9">
						@if(!isset($error) || !$error)
							{{ csrf_field() }}
							<button type="submit" class="btn btn-block btn-success" name="form-submitted" value="true">
								{{ trans('main.confirm') }}
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

