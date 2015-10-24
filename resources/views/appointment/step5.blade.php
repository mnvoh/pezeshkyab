@extends('master')

@section('content')

    @include('appointment.step-viewer')

	<form action="{{ $next_step_link }}" method="post">
		<div class="row">
			<div class="col-sm12 col-md-10 col-lg-8">
				@if(isset($error))
					<p class="text-error">{{ $error }}</p>
				@endif

				<table class="table table-bordered">
					<tr>
						<th>{{ trans('main.firstname') }}</th>
						<td>{{ $filled_info['b_firstname'] }}</td>
					</tr>
					<tr>
						<th>{{ trans('main.lastname') }}</th>
						<td>{{ $filled_info['b_lastname'] }}</td>
					</tr>
					<tr>
						<th>{{ trans('main.nationality') }}</th>
						<td>
							@if($filled_info['b_nationality'] == "ir")
								{{ trans('main.iranian') }}
							@else
								{{ trans('main.non_iranian') }}
							@endif
						</td>
					</tr>
					@if($filled_info['b_nationality'] == 'ir')
						<tr>
							<th>{{ trans('main.national_code') }}</th>
							<td>{{ $filled_info['b_ncode'] }}</td>
						</tr>
					@else
						<tr>
							<th>{{ trans('main.passport_number') }}</th>
							<td>{{ $filled_info['b_ncode'] }}</td>
						</tr>
					@endif
					<tr>
						<th>{{ trans('main.doctor') }}</th>
						<td> {{ $filled_info['b_doctor_label'] }} </td>
					</tr>
					<tr>
						<th>{{ trans('main.reservation_time') }}</th>
						<td>{{ $filled_info['b_rtime'] }}</td>
					</tr>
					<tr>
						<th class="text-error">
							{{ trans('main.select_insurance') }}
						</th>
						<td>
							<select class="form-control" name="insurance">
								<option value="-1">{{ trans('main.no_insurance') }}</option>
								@foreach(\App\Models\Insurance::all() as $i)
									<option value="{{ $i->id }}">{{  $i->title }}</option>
								@endforeach
							</select>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-7">
				@if(!isset($error) || !$error)
					{{ csrf_field() }}
					<button type="submit" class="btn btn-block btn-success" name="form-submitted" value="true">
						{{ trans('main.confirm') }}
					</button>
				@endif
			</div>
			<div class="col-xs-1">
				<a href="{{ $go_back_url }}" class="btn btn-warning">
					{{ trans('main.go_back') }}
				</a>
			</div>
		</div>
	</form>
@endsection

