@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">

			@if(isset($action_message) && $action_message != null)
				<div class="alert alert-success">{{ $action_message }}</div>
			@endif

			<h4>{{ trans('main.filter_results') }}</h4>
			<form action="" method="get" class="form-horizontal">
				<input type="text" class="form-control inline-form-control" name="title"
					   placeholder="{{ trans('main.title') }}"
						value="{{ $filter_title }}"/>

				<button type="submit" class="btn btn-info">
					{{ trans('main.apply') }}
				</button>
				<a href="{{ route('admins.fees') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr />

			<a href="javascript:;" class="open-modal" data-modal="add-fee-modal">
				<span class="fa fa-plus-square lg-fa"></span>
			</a>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.title') }}</th>
						<th>{{ trans('main.amount') }}</th>
						<th>{{ trans('main.edit') }}</th>
						<th>{{ trans('main.delete') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($fees as $f)
						<tr>
							<td>{{ $f->id }}</td>
							<td>{{ $f->title }}</td>
							<td>{{ $f->amount }}</td>
							<td>
								<a href="javascript:;" class="btn btn-default edit-fee">
									<input type="hidden" name="fee_id" value="{{ $f->id }}" />
									<input type="hidden" name="title" value="{{ $f->title }}" />
									<input type="hidden" name="amount" value="{{ $f->amount }}" />
									<span class="fa fa-edit"></span>
								</a>
							</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="fee_id" value="{{ $f->id }}" />
									{{ csrf_field() }}
									<button type="submit" name="delete" value="1"
											class="btn btn-danger">
										<span class="fa fa-trash"></span>
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			{!! $fees->render() !!}
        </div>
    </div>







	<div class="modal fade" id="add-fee-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.add_edit_fee') }}
					</h4>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<input type="hidden" name="fee_id" value="" />
						<div class="form-group">
							<input type="text" name="title"
								   placeholder="{{ trans('main.title') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="number" name="amount"
								   placeholder="{{ trans('main.amount') }}"
								   class="form-control" />
						</div>
					</div>
					{{ csrf_field() }}
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{ trans('main.close') }}
						</button>
						<button type="submit" class="btn btn-primary" name="save" value="1">
							<span class="fa fa-floppy-o"></span>
							{{ trans('main.save') }}
						</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection