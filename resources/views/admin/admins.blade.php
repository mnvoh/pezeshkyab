@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">

			@if(isset($action_message) && $action_message != null)
				@if($action_error)
					<div class="alert alert-danger">{{ $action_message }}</div>
				@else
					<div class="alert alert-success">{{ $action_message }}</div>
				@endif
			@endif

			@if(isset($delete_admin) && $delete_admin)
				<div class="alert alert-warning">
					<strong>{{ trans('main.are_you_sure_delete_admin') }}</strong><br />
					{{ trans('main.id') }}: {{ $delete_admin->id }} <br />
					{{ trans('main.name') }}: {{ $delete_admin->name . ' ' . $delete_admin->lname }}<br />
					{{ trans('main.email_address') }}: {{ $delete_admin->email }} <br />
					<form action="" method="post">
						<input name="admin_id" type="hidden" value="{{ $delete_admin->id }}" />
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

			<h4>{{ trans('main.filter_results') }}</h4>
			<form action="" method="get" class="form-horizontal">
				<input type="text" class="form-control inline-form-control" name="email"
					   placeholder="{{ trans('main.email_address') }}"
						value="{{ $filter_email }}"/>
				<select class="form-control inline-form-control" name="type">
					<option value="any">{{ trans('main.any') }}</option>
					<option value="master" @if($filter_type == 'master') {{ 'selected' }} @endif>
						{{ trans('main.master') }}
					</option>
					<option value="minor" @if($filter_type == 'minor') {{ 'selected' }} @endif>
						{{ trans('main.minor') }}
					</option>
				</select>
				<button type="submit" class="btn btn-info">
					{{ trans('main.apply') }}
				</button>
				<a href="{{ route('admins.admins') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr />

			<a href="javascript:;" class="open-modal" data-modal="add-admin-modal">
				<span class="fa fa-user-plus lg-fa"></span>
			</a>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.name') }}</th>
						<th>{{ trans('main.email_address') }}</th>
						<th> {{ trans('main.type') }}</th>
						<th>{{ trans('main.last_activity') }}</th>
						<th>{{ trans('main.action') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($admins as $a)
						<tr>
							<td>{{ $a->id }}</td>
							<td>{{ $a->name . ' ' . $a->lname }}</td>
							<td>{{ $a->email }}</td>
							<td>
								@if($a->type == 'master')
									{{ trans('main.master') }}
								@else
									{{ trans('main.minor') }}
								@endif
							</td>
							<td>{{ jdate('Y/m/d H:i:s', strtotime($a->last_activity)) }}</td>
							<td>
								<div class="dropdown">
									<button id="adminaction{{ $a->id }}" type="button"
											data-toggle="dropdown" aria-haspopup="true"
											aria-expanded="false" class="btn btn-default">
										{{ trans('main.action') }}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" aria-labelledby="adminaction{{ $a->id }}">
										<li>
											<form action="" method="post">
												<input type="hidden" name="admin_id"
													   value="{{ $a->id }}" />
												{{ csrf_field() }}
												<button type="submit" class="btn btn-block btn-default btn-menuitem"
														name="delete" value="1">
													{{ trans('main.delete') }}
												</button>
											</form>
										</li>
										<li>
											<a href="javascript:;" class="change-admin-pass">
												<input type="hidden" name="admin_id" value="{{ $a->id }}" />
												{{ trans('main.change_password') }}
											</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			{!! $admins->render() !!}
        </div>
    </div>







	<div class="modal fade" id="change-password-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.change_password') }}
					</h4>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<input type="hidden" name="admin_id" value="" />
						<div class="form-group">
							<input type="password" name="new_password"
								   placeholder="{{ trans('main.password') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="password" name="new_password_r"
								   placeholder="{{ trans('main.repeat_password') }}"
								   class="form-control" />
							{{ csrf_field() }}
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{ trans('main.close') }}
						</button>
						<button type="submit" class="btn btn-primary" name="change-password" value="1">
							<span class="fa fa-floppy-o"></span>
							{{ trans('main.save') }}
						</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->



	<div class="modal fade" id="add-admin-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.add_new_admin') }}
					</h4>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<div class="form-group">
							<input type="email" name="email"
								   placeholder="{{ trans('main.email_address') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="name"
								   placeholder="{{ trans('main.firstname') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="lname"
								   placeholder="{{ trans('main.lastname') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="password" name="password"
								   placeholder="{{ trans('main.password') }}"
								   class="form-control" />
						</div>

						{{ csrf_field() }}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{ trans('main.close') }}
						</button>
						<button type="submit" class="btn btn-primary" name="add-admin" value="1">
							<span class="fa fa-floppy-o"></span>
							{{ trans('main.save') }}
						</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection