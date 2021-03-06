@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">

			<div class="text-center hidden-print">
				<div id="flip-counter-wrapper">
					<h4 class="text-center">{{ trans('main.paid_gross') . '(' . trans('currencies.irr') . ')' }}</h4>
					<div id="flip-counter" data-val="{{ (int)$paid_gross }}" dir="ltr">{{ (int)($paid_gross / 2) }}</div>
				</div>
			</div>

			<br />

			<h3>{{ trans('main.transactions') }}</h3>

			<button class="print-button btn btn-info btn-block">
				<span class="fa fa-print"></span>
				{{ trans('main.print') }}
			</button>

			<br />

			<div class="table-responsive">
				<table class="table table-responsive table-striped">
					<thead>
						<tr>
							<th>{{ trans('main.id') }}</th>
							<th>{{ trans('main.amount') }}</th>
							<th>{{ trans('main.status') }}</th>
							<th>{{ trans('main.gateway_receipt') }}</th>
							<th>{{ trans('main.receipt') }}</th>
							<th>{{ trans('main.req_time') }}</th>
							<th>{{ trans('main.comp_time') }}</th>
							<th>{{ trans('main.name') }}</th>
							<th>{{ trans('main.national_code') }}</th>
						</tr>
					</thead>
					<tbody>
					@foreach($transactions as $t)
						@if($t->status == 'paid')
							<tr class="success">
						@else
							<tr class="danger">
						@endif
							<td class="text-center">{{ $t->id }}</td>
							<td class="text-center">{{ $t->amount . ' ' . trans('currencies.irr') }}</td>
							<td class="text-center">
								@if($t->status == 'paid')
									<span class="glyphicon glyphicon-ok" title="{{ trans('main.paid') }}"></span>
								@else
									<span class="glyphicon glyphicon-remove" title="{{ trans('main.unpaid') }}"></span>
								@endif
							</td>
							<td class="text-center">
								@if($t->status == 'paid')
									{{ $t->au }}
								@else
									<span class="glyphicon glyphicon-remove" title="{{ trans('main.unpaid') }}"></span>
								@endif
							</td>
							<td class="text-center">
								@if($t->status == 'paid')
									{{ $t->receipt }}
								@else
									<span class="glyphicon glyphicon-remove" title="{{ trans('main.unpaid') }}"></span>
								@endif
							</td>
							<td class="text-center">
								{{ jdate('Y/m/d H:i:s', strtotime($t->req_time)) }}
							</td>
							<td class="text-center">
								@if($t->status == 'paid')
									{{ jdate('Y/m/d H:i:s', strtotime($t->comp_time)) }}
								@else
									<span class="glyphicon glyphicon-remove" title="{{ trans('main.unpaid') }}"></span>
								@endif
							</td>
							<td class="text-center">
								{{ $t->patient_name . ' ' . $t->patient_lname }}
							</td>
							<td class="text-center">
								{{ $t->patient_nc }}
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>

			{!! $transactions->render() !!}
        </div>
    </div>
@endsection