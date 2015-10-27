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
						<th>{{ trans('main.amount') }}</th>
						<td>
							{{ $filled_info['b_fee_title'] }}
							-
							{{ (int)$filled_info['b_fee_amount'] }} {{ trans('currencies.irr') }}
						</td>
					</tr>
					<tr>
						<th>{{ trans('main.selected_insurance') }}</th>
						<td>{{ $filled_info['b_insurance_title'] ? $filled_info['b_insurance_title'] : '-' }}</td>
					</tr>
					<tr>
						<th>{{ trans('main.final_amount') }}</th>
						<td>
							{{ $filled_info['b_fee_amount'] * $filled_info['b_insurance_rate'] }}
							{{ trans('currencies.irr') }}
						</td>
					</tr>
				</table>


				<div class="row">
					<div class="col-xs-9">
						@if(is_numeric($filled_info['b_fee_amount']) && $filled_info['b_fee_amount'] > 0)
							{{ csrf_field() }}
							<button type="submit" class="btn btn-block btn-success"  name="form-submitted" value="true">
								<span class="fa fa-credit-card"></span>
								{{ trans('main.pay') }}
							</button>
						@else
							{{ 'error' }}
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

