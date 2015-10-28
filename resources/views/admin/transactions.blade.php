@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			<h3 class="text-center">{{ trans('main.transactions') }}</h3>

			@if($gross)
				<div class="text-center">
					<div id="flip-counter-wrapper">
						<h4 class="text-center">
							{{ trans('main.transactions_gross') . '(' . trans('currencies.irr') . ')' }}
						</h4>
						<div id="flip-counter" data-val="{{ (int)$gross }}" dir="ltr">{{ (int)($gross / 2) }}</div>
					</div>
				</div>
			@endif

			<form action="" method="get" class="form-horizontal hidden-print">
				<h4>{{ trans('main.filter_results') }}</h4>
				<input type="text" class="form-control inline-form-control" name="doctor_id"
					   placeholder="{{ trans('main.doctor_id') }}"
						value="{{ $filter_doctor_id }}"/>
				<select class="form-control inline-form-control" name="status">
					<option value="any">{{ trans('main.any') }}</option>
					<option value="pending" @if($filter_status == 'pending') {{ 'selected' }} @endif>
						{{ trans('main.pending') }}
					</option>
					<option value="paid" @if($filter_status == 'paid') {{ 'selected' }} @endif>
						{{ trans('main.paid') }}
					</option>
				</select>
				<input type="text" class="form-control inline-form-control" name="receipt"
					   placeholder="{{ trans('main.receipt') }}"
					   value="{{ $filter_receipt }}"/>
				<select class="form-control inline-form-control" name="settled">
					<option value="any">{{ trans('main.any') }}</option>
					<option value="0" @if(strlen($filter_settled) && !$filter_settled) {{ 'selected' }} @endif>
						{{ trans('main.unsettled_transactions') }}
					</option>
					<option value="1" @if($filter_settled) {{ 'selected' }} @endif>
						{{ trans('main.settled_transactions') }}
					</option>
				</select>
				<button type="submit" class="btn btn-info">
					{{ trans('main.apply') }}
				</button>
				<a href="{{ route('admins.transactions') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr class="hidden-print" />

			<button class="print-button btn btn-info btn-block">
				<span class="fa fa-print"></span>
				{{ trans('main.print') }}
			</button>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.doctor') }}</th>
						<th>{{ trans('main.amount') }}</th>
						<th> {{ trans('main.status') }}</th>
						<th>{{ trans('main.receipt') }}</th>
						<th>{{ trans('main.req_time') }}</th>
						<th>{{ trans('main.comp_time') }}</th>
						<th>{{ trans('main.patient_name') }}</th>
						<th>{{ trans('main.national_code') }}</th>
						<th>{{ trans('main.settlement_tracking_number') }}</th>
						<th>{{ trans('main.settlement_transaction_time') }}</th>
					</tr>
					</thead>
					<tbody>
					@foreach($transactions as $t)
						<tr>
							<td>{{ $t->id }}</td><!-- id -->
							<td>
								<a href="{{ route('admins.transactions') }}?doctor_id={{ $t->doctor_id }}"
										title="{{ trans('main.transactions_only_this_doctor') }}">
									{{ $t->doctor->name . ' ' . $t->doctor->lname }}
								</a>
							</td><!-- doctor -->
							<td>{{ $t->amount . ' ' . trans('currencies.irr') }}</td><!-- amount -->
							<td>
								@if($t->status == 'pending')
									<span class="fa fa-times text-error"></span>
								@else
									<span class="fa fa-check text-success"></span>
								@endif
							</td><!-- status -->
							<td>{{ $t->au }}</td><!-- receipt -->
							<td>{{ jdate('Y/m/d H:i:s', strtotime($t->req_time)) }}</td><!-- req_time -->
							<td>
								@if($t->comp_time)
									{{ jdate('Y/m/d H:i:s', strtotime($t->comp_time)) }}
								@else
									<span class="fa fa-times text-error"></span>
								@endif
							</td><!-- comp_time -->
							<td>
								{{ $t->patient_name . ' ' . $t->patient_name }}
							</td><!-- patient_name -->
							<td>
								{{ $t->patient_nc }}
							</td><!-- patient_ncode -->
							<td>
								@if($t->settled)
									{{ $t->settlement_tracking_number }}
								@else
									<span class="fa fa-times text-error"></span>
								@endif
							</td><!-- settlement_tracking_number -->
							<td>
								@if($t->settled)
									{{ $t->settlement_transaction_time }}
								@else
									<span class="fa fa-times text-error"></span>
								@endif
							</td><!-- settlement_transaction_time -->
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>

			{!! $transactions->render() !!}
        </div>
    </div>
@endsection