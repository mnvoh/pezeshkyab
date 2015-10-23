@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			<h4>{{ trans('main.filter_results') }}</h4>
			<form action="" method="get" class="form-horizontal">
				<input type="text" class="form-control inline-form-control" name="doctor_id"
					   placeholder="{{ trans('main.doctor_id') }}"
						value="{{ $filter_doctor_id }}"/>

				<input type="text" class="form-control inline-form-control" name="ncode"
					   placeholder="{{ trans('main.national_code') }}"
					   value="{{ $filter_ncode }}"/>

				<input type="text" class="form-control inline-form-control" name="tracking_code"
					   placeholder="{{ trans('main.tracking_code') }}"
					   value="{{ $filter_tracking_code }}"/>

				<select class="form-control inline-form-control" name="status">
					<option value="any">{{ trans('main.any') }}</option>
					<option value="active" @if($filter_status == 'active') {{ 'selected' }} @endif>
						{{ trans('main.active_reservations') }}
					</option>
					<option value="free" @if($filter_status == 'free') {{ 'selected' }} @endif>
						{{ trans('main.free_reservations') }}
					</option>
					<option value="done" @if($filter_status == 'done') {{ 'selected' }} @endif>
						{{ trans('main.done_reservations') }}
					</option>
				</select>

				<button type="submit" class="btn btn-info">
					{{ trans('main.apply') }}
				</button>
				<a href="{{ route('admins.reservations') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr />
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.doctor') }}</th>
						<th>{{ trans('main.rtime') }}</th>
						<th>{{ trans('main.fee') }}</th>
						<th>{{ trans('main.patient_name') }}</th>
						<th>{{ trans('main.nationality') }}</th>
						<th>{{ trans('main.national_code') }}</th>
						<th>{{ trans('main.email_address') }}</th>
{{--						<th>{{ trans('main.disease') }}</th>--}}
						<th>{{ trans('main.tracking_code') }}</th>
					</tr>
					</thead>
					<tbody>
					@foreach($reservations as $r)
						<tr>
							<td>
								{{ $r->id }}
							</td>
							<td>
								<a href="{{ route('admins.reservations') }}?doctor_id={{ $r->doctor_id }}"
								   title="{{ trans('main.transactions_only_this_doctor') }}">
									{{ $r->doctor->name . ' ' . $r->doctor->lname }}
								</a>
							</td>
							<td>{{ jdate('Y/m/d H:i:s', strtotime($r->rtime)) }}</td>
							<td>{{ $r->fee->title }}</td>
							<td>{{ $r->pname . ' ' . $r->plname }}</td>
							<td>
								@if($r->nationality == 'ir')
									{{ trans('main.iranian') }}
								@else
									{{ trans('main.non_iranian') }}
								@endif
							</td>
							<td>{{ $r->ncode }}</td>
							<td>{{ $r->pemail }}</td>
{{--							<td>{{ $r->id }}</td>--}}
							<td>{{ $r->tracking_code }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>

			{!! $reservations->render() !!}
        </div>
    </div>
@endsection