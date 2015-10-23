@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			<a href="javascript:;" class="open-modal" data-modal="add-link-modal">
				<span class="fa fa-plus-square lg-fa"></span>
			</a>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.link') }}</th>
						<th>{{ trans('main.delete') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($links as $l)
						<tr>
							<td>{{ $l->id }}</td>
							<td>
								<a href="{{ $l->url }}">
									{{ $l->title }}
								</a>
							</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="link_id" value="{{ $l->id }}" />
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
        </div>
    </div>







	<div class="modal fade" id="add-link-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.add_link') }}
					</h4>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<div class="form-group">
							<input type="text" name="title"
								   placeholder="{{ trans('main.title') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="url"
								   placeholder="{{ trans('main.url') }}"
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