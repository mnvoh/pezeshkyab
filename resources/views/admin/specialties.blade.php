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
				<a href="{{ route('admins.specialties') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr />

			<a href="javascript:;" class="open-modal" data-modal="add-specialty-modal">
				<span class="fa fa-plus-square lg-fa"></span>
			</a>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.title') }}</th>
						<th>{{ trans('main.description') }}</th>
						<th>{{ trans('main.image') }}</th>
						<th>{{ trans('main.upload') . ' ' . trans('main.image') }}</th>
						<th>{{ trans('main.edit') }}</th>
						<th>{{ trans('main.delete') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($specialties as $s)
						<tr>
							<td>{{ $s->id }}</td>
							<td>{{ $s->title }}</td>
							<td>{{ $s->desc }}</td>
							<td>
								@if($s->image)
									<?php $avatar = url($s->image->path); ?>
									<a href="{{ $avatar }}" class="fullsizable">
										@include('avatar32')
									</a>
								@endif
							</td>
							<td>
								<a href="javascript:;" class="btn btn-default upload-specialty-image">
									<input type="hidden" name="specialty_id" value="{{ $s->id }}" />
									<input id="image-upload-{{ $s->id }}"
										   type="file"
										   name="image-file"
										   class="hidden upload-file"
										   accept="image/*"
										   data-url="{{ route('admins.upload_specialty_image') }}">
									<span class="fa fa-upload"></span>
								</a>
							</td>
							<td>
								<a href="javascript:;" class="btn btn-default edit-specialty">
									<input type="hidden" name="specialty_id" value="{{ $s->id }}" />
									<input type="hidden" name="title" value="{{ $s->title }}" />
									<input type="hidden" name="description" value="{{ $s->desc }}" />
									<span class="fa fa-edit"></span>
								</a>
							</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="specialty_id" value="{{ $s->id }}" />
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

			{!! $specialties->render() !!}
        </div>
    </div>







	<div class="modal fade" id="add-specialty-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.add_edit_specialty') }}
					</h4>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<input type="hidden" name="specialty_id" value="" />
						<div class="form-group">
							<input type="text" name="title"
								   placeholder="{{ trans('main.title') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="description"
								   placeholder="{{ trans('main.description') }}"
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


	<div class="modal fade" id="specialty-image-upload-progress-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.uploading') }}
					</h4>
				</div>
				<div class="modal-body">
					<div class="progress">
						<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0"
							 aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
						</div>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection