@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			<h3 class="text-center">{{ trans('main.doctors') }}</h3>

			@if(isset($action_message) && $action_message != null)
				@if($action_error)
					<div class="alert alert-danger">{{ $action_message }}</div>
				@else
					<div class="alert alert-success">{{ $action_message }}</div>
				@endif
			@endif

			@if(isset($delete_doctor) && $delete_doctor)
				<div class="alert alert-warning">
					<strong>{{ trans('main.are_you_sure_delete_doctor') }}</strong><br />
					{{ trans('main.id') }}: {{ $delete_doctor->id }} <br />
					{{ trans('main.name') }}: {{ $delete_doctor->name . ' ' . $delete_doctor->lname }}<br />
					{{ trans('main.email_address') }}: {{ $delete_doctor->email }} <br />
					{{ trans('main.physician_license_number') }}: {{ $delete_doctor->license }} <br />
					<form action="" method="post">
						<input name="doctor_id" type="hidden" value="{{ $delete_doctor->id }}" />
						{{ csrf_field() }}
						<button type="submit" class="btn btn-danger" name="confirm-deletion" value="1">
							{{ trans('main.delete') }}
						</button>
						<button type="submit" class="btn btn-default" name="cancel-deletion" value="1">
							{{ trans('main.cancel') }}
						</button>
					</form>
				</div>
			@endif


			<form action="" method="get" class="form-horizontal hidden-print">
				<h4>{{ trans('main.filter_results') }}</h4>
				<input type="text" class="form-control inline-form-control" name="ncode"
					   placeholder="{{ trans('main.national_code') }}"
						value="{{ $filter_ncode }}"/>
				<input type="text" class="form-control inline-form-control" name="license"
					   placeholder="{{ trans('main.physician_license_number') }}"
						value="{{ $filter_license }}"/>
				<input type="text" class="form-control inline-form-control" name="email"
					   placeholder="{{ trans('main.email_address') }}"
						value="{{ $filter_email }}"/>
				<select class="form-control inline-form-control" name="status">
					<option value="all">{{ trans('main.all') }}</option>
					<option value="pending" @if($filter_status == 'pending') {{ 'selected' }} @endif>
						{{ trans('main.pending') }}
					</option>
					<option value="active" @if($filter_status == 'active') {{ 'selected' }} @endif>
						{{ trans('main.active') }}
					</option>
					<option value="banned" @if($filter_status == 'banned') {{ 'selected' }} @endif>
						{{ trans('main.banned') }}
					</option>
				</select>
				<button type="submit" class="btn btn-info">
					{{ trans('main.apply') }}
				</button>
				<a href="{{ route('admins.doctors') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr />


			<button class="print-button btn btn-info btn-block">
				<span class="fa fa-print"></span>
				{{ trans('main.print') }}
			</button>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.name') }}</th>
						<th>{{ trans('main.email_address') }}</th>
						<th>{{ trans('main.national_code') }}</th>
						<th>{{ trans('main.physician_license_number') }}</th>
						@if($master_admin)
							<th>{{ trans('main.bank_account_number') }}</th>
						@endif
						<th>{{ trans('main.last_activity') }}</th>
						<th>{{ trans('main.birth_date') }}</th>
						<th>{{ trans('main.registration_date') }}</th>
						@if($master_admin)
							<th class="hidden-print">{{ trans('main.action') }}</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach($doctors as $d)
						@if($d->status == 'pending')
							<tr class="success">
						@elseif($d->status == 'active')
							<tr>
						@elseif($d->status == 'banned')
							<tr class="danger">
						@endif
							<td>{{ $d->id }}</td>
							<td>
								<a href="{{ route('doctors.homepage', ['doctor_id' => $d->id]) }}">
									{{ $d->name . ' ' . $d->lname }}
								</a>
							</td>
							<td>{{ $d->email }}</td>
							<td>{{ $d->ncode }}</td>
							<td>{{ $d->license }}</td>
							@if($master_admin)
								<td>{{ $d->ban }}</td>
							@endif
							<td>{{ jdate('Y/m/d H:i:s', strtotime($d->last_activity)) }}</td>
							<td>{{ $d->bd_year . '/' . $d->bd_month . '/' . $d->bd_date }}</td>
							<td>{{ jdate('Y/m/d H:i:s', strtotime($d->created_at)) }}</td>
							@if($master_admin)
							<td class="hidden-print">
								<div class="dropdown">
									<button id="docaction{{ $d->id }}" type="button"
											data-toggle="dropdown" aria-haspopup="true"
											aria-expanded="false" class="btn btn-default">
										{{ trans('main.action') }}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="docaction{{ $d->id }}">
										<li>
											<form action="" method="post">
												<input type="hidden" name="doctor_id"
													   value="{{ $d->id }}" />
												{{ csrf_field() }}
												<button type="submit" class="btn btn-block btn-default btn-menuitem"
														name="activate" value="1">
													{{ trans('main.activate') }}
												</button>
											</form>
										</li>
										<li>
											<form action="" method="post">
												<input type="hidden" name="doctor_id"
													   value="{{ $d->id }}" />
												{{ csrf_field() }}
												<button type="submit" class="btn btn-block btn-default btn-menuitem"
														name="ban" value="1">
													{{ trans('main.ban') }}
												</button>
											</form>
										</li>
										<li>
											<form action="" method="post">
												<input type="hidden" name="doctor_id"
													   value="{{ $d->id }}" />
												{{ csrf_field() }}
												<button type="submit" class="btn btn-block btn-default btn-menuitem"
														name="delete" value="1">
													{{ trans('main.delete') }}
												</button>
											</form>
										</li>
										<li>
											<a href="javascript:;" class="reg-payment">
												<input type="hidden" name="doctor_id" value="{{ $d->id }}" />
												<?php
												$unpaid_gross = \App\Models\Transaction::where('doctor_id', $d->id)
														->where('status', 'paid')
														->where('settled', 0)
														->sum('amount');
												?>

												<input type="hidden" name="amount" value="{{ number_format($unpaid_gross) }}" />
												{{ trans('main.register_payment') }}
											</a>
										</li>
									</ul>
								</div>
							</td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>

			{!! $doctors->render() !!}
        </div>
    </div>







	<div class="modal fade" id="register-payment-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.register_payment') }}
					</h4>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<div class="form-group">
							<label>{{ trans('main.amount') }}</label>:
							<strong><span class="amount"></span></strong> {{ trans('currencies.irr') }}
						</div>
						<input type="hidden" name="doctor_id" value="" />
						<div class="form-group">
							<input type="text" name="tracking_number"
								   placeholder="{{ trans('main.tracking_number') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="transaction_time"
								   placeholder="{{ trans('main.transaction_time') }}"
								   class="form-control" />
							{{ csrf_field() }}
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{ trans('main.close') }}
						</button>
						<button type="submit" class="btn btn-primary" name="register-payment" value="1">
							<span class="fa fa-floppy-o"></span>
							{{ trans('main.send') }}
						</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection