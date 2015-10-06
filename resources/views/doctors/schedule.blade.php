@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			@if($status_message)
				@if($form_error)
					<p class="text-error">{{ $status_message }}</p>
				@else
					<p class="text-success">{{ $status_message }}</p>
				@endif
			@endif

			<h3>{{ trans('main4.add_schedule') }}</h3>
			<form action="{{ $url }}" method="post">
				<div class="form-control inline-form-control">
					<label class="inline-form-control">{{ trans('main3.date') }}</label>

					<span dir="ltr">
						<input type="number" min="{{ $current_year }}" max="{{ $current_year + 1 }}"
							   name="year" class="inline-form-control noborder text-center"
							   value="{{ $current_year }}" width="20" />
						/
						<input type="number" min="1" max="12" name="month"
							   class="inline-form-control noborder text-center"
							   value="{{ $current_month }}" />
						/
						<input type="number" min="1" max="31" name="date"
							   class="inline-form-control noborder text-center"
							   value="{{ ($current_date + 2) % 31 }}" />
					</span>


				</div>
				<div class="form-control inline-form-control">
					<label class="inline-form-control">{{ trans('main3.time') }}</label>
					<span dir="ltr">
						<input type="number" min="0" max="23" name="hour" class="inline-form-control noborder text-center"
							   value="7" />
						:
						<input type="number" min="0" max="60" name="minute" class="inline-form-control noborder text-center"
							   value="0" />
					</span>
				</div>
				<div class="form-control inline-form-control">
					<label class="inline-form-control">{{ trans('main2.fee') }}</label>
					<select name="fee">
						@foreach($fees as $fee)
							<option value="{{ $fee->id }}">
								{{ $fee->title }} - {{ $fee->amount }} {{ trans('currencies.irr') }}
							</option>
						@endforeach
					</select>
				</div>

				{{ csrf_field() }}

				<button type="submit" name="new_reservation" value="1" class="btn btn-success">
					{{ trans('main4.save') }}
				</button>
			</form>

			<hr />

			<h3>{{ trans('main4.current_schedules') }}</h3>

			<table class="table table-responsive table-striped">
				<thead>
					<tr>
						<th>{{ trans('main4.id') }}</th>
						<th>{{ trans('main4.rtime') }}</th>
						<th>{{ trans('main2.fee') }}</th>
						<th>{{ trans('main4.pname') }}</th>
						<th>{{ trans('main.nationality') }}</th>
						<th>{{ trans('main.national_code') }}</th>
						<th>{{ trans('main.email_address') }}</th>
						<th>{{ trans('main4.disease') }}</th>
						<th>{{ trans('main4.delete') }}</th>
					</tr>
				</thead>
				<tbody>
				@foreach($reservations as $r)
					<tr>
						<td> {{ $r->id }} </td>
						<td> {{ \App\Helpers\Utils::shamsiDateFromGreg(strtotime($r->rtime)) }} </td>
						<td> {{ $r->fee->title }} {{ $r->fee->amount }} {{ trans('currencies.irr') }} </td>
						<td> {{ ($r->pname != null) ? $r->pname . ' ' . $r->plname : '-' }} </td>
						<td>
							@if($r->nationality == 'ir')
								{{ trans('main.iranian') }}
							@elseif($r->nationality == 'fo')
								{{ trans('main.non_iranian') }}
							@else
								-
							@endif
						</td>
						<td> {{ ($r->ncode != null) ? $r->ncode : '-' }} </td>
						<td> {{ ($r->pemail != null) ? $r->pemail : '-' }} </td>
						<td> {{ ($r->disease_id != null) ? $r->disease->name : '-' }} </td>
						<td>
							@if($r->tracking_code == null)
								<form class="form-inline confirm-form" action="{{ $url }}" method="post">
									<input type="hidden" name="reservation_id" value="{{ $r->id }}" />
									{{ csrf_field() }}
									<button type="submit" name="delete_reservation" value="1" class="btn btn-danger">
										{{ trans('main4.delete') }}
									</button>
								</form>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
        </div>
    </div>
@endsection