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

			<h3>{{ trans('main.add_schedule') }}</h3>
			<form action="{{ $url }}" method="post">
				<div class="form-control inline-form-control">
					<label class="inline-form-control">{{ trans('main.date') }}</label>

					<span dir="ltr">
						<input type="number" min="{{ $current_year }}" max="{{ $current_year + 1 }}"
							   name="year" class="inline-form-control noborder text-center sm-number-field"
							   value="{{ $current_year }}" width="20" />
						/
						<input type="number" min="1" max="12" name="month"
							   class="inline-form-control noborder text-center sm-number-field"
							   value="{{ $current_month }}" />
						/
						<input type="number" min="1" max="31" name="date"
							   class="inline-form-control noborder text-center sm-number-field"
							   value="{{ ($current_date + 2) % 31 }}" />
					</span>


				</div>
				<div class="form-control inline-form-control">
					<label class="inline-form-control">{{ trans('main.time') }}</label>
					<span dir="ltr">
						<input type="number" min="0" max="23" name="hour"
							   class="inline-form-control noborder text-center sm-number-field" value="7" />
						:
						<input type="number" min="0" max="60" name="minute"
							   class="inline-form-control noborder text-center sm-number-field" value="0" />
					</span>
				</div>
				<div class="form-control inline-form-control">
					<label class="inline-form-control">{{ trans('main.fee') }}</label>
					<select name="fee" class="plain-combo">
						@foreach($fees as $fee)
							<option value="{{ $fee->id }}">
								{{ $fee->title }} - {{ $fee->amount }} {{ trans('currencies.irr') }}
							</option>
						@endforeach
					</select>
				</div>

				{{ csrf_field() }}

				<button type="submit" name="new_reservation" value="1" class="btn btn-success">
					{{ trans('main.save') }}
				</button>
			</form>

			<hr />

			<h3>{{ trans('main.current_schedules') }}</h3>

			<table class="table table-responsive table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.rtime') }}</th>
						<th>{{ trans('main.fee') }}</th>
						<th>{{ trans('main.pname') }}</th>
						<th>{{ trans('main.nationality') }}</th>
						<th>{{ trans('main.national_code') }}</th>
						<th>{{ trans('main.email_address') }}</th>
						<th>{{ trans('main.disease') }}</th>
						<th>{{ trans('main.action') }}</th>
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
										{{ trans('main.delete') }}
									</button>
								</form>
							@else
								<form class="form-inline confirm-form email-patient-form" action="{{ $url }}" method="post">
									<input type="hidden" name="reservation_id" value="{{ $r->id }}" />
									<input type="hidden" name="email" value="{{ $r->pemail }}" />
									<input type="hidden" name="name" value="{{ $r->pname . ' ' . $r->plname }}" />
									{{ csrf_field() }}
									<button type="submit" name="email_patient" value="1" class="btn btn-default">
										{{ trans('main.email') }}
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

	<div class="modal fade" id="email-patient-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.send_email_to') }}:
						<span id="patient-compose-mail-to"></span>
					</h4>
				</div>
				<h3 class="text-success text-center" style="display: none;">{{ trans('email.sent') }}</h3>
				<form action="{{ route('doctors.email_patient_reservation') }}" method="post"
					  id="ajax-form">
					<div class="modal-body">
						<div class="form-group">
							<p class="text-error"></p>
						</div>
						<div class="form-group">
							<input type="text" name="subject" placeholder="{{ trans('main.subject') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<textarea name="message" class="form-control"
									  placeholder="{{ trans('main.email_patient') }}"
									  style="height: 250px;"></textarea>
							<input type="hidden" name="reservation_id" id="mail-to-reservation-id" />
							{{ csrf_field() }}
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{ trans('main.close') }}
						</button>
						<button type="submit" class="btn btn-primary">
							<span class="glyphicon glyphicon-send"></span>
							{{ trans('main.send') }}
						</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection