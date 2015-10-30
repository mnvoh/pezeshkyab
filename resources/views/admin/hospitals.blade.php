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
					   placeholder="{{ trans('main.name') }}"
						value="{{ $filter_name }}"/>

				<button type="submit" class="btn btn-info">
					{{ trans('main.apply') }}
				</button>
				<a href="{{ route('admins.hospitals') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr />

			<a href="javascript:;" class="open-modal" data-modal="add-hospital-modal">
				<span class="fa fa-plus-square lg-fa"></span>
			</a>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.name') }}</th>
						<th>{{ trans('main.address') }}</th>
						<th>{{ trans('main.change_address') }}</th>
						<th>{{ trans('main.edit') }}</th>
						<th>{{ trans('main.delete') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($hospitals as $h)
						<tr>
							<td>{{ $h->id }}</td>
							<td>{{ $h->name }}</td>
							<td>
								@if($h->address)
								<a href="https://www.google.com/maps/preview/{{ '@' . $h->address->lat }},{{ $h->address->lng }},17z"
								   target="_blank" title="{{ trans('main.open_in_maps') }}">
									{{ @$h->address->city->province->name }} -
									{{ @$h->address->city->name }} -
									{{ @$h->address->street_addr_1 . ' ' . @$h->address->street_addr_2 }} -
									{{ @$h->address->zip }}
								</a>
								@endif
							</td>
							<td>
								<a href="javascript:;" class="btn btn-default change-address">
									<input type="hidden" name="hospital_id" value="{{ $h->id }}" />
									<span class="fa fa-map-marker"></span>
								</a>
							</td>
							<td>
								<a href="javascript:;" class="btn btn-default edit-hospital">
									<input type="hidden" name="hospital_id" value="{{ $h->id }}" />
									<input type="hidden" name="name" value="{{ $h->name }}" />
									<span class="fa fa-edit"></span>
								</a>
							</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="hospital_id" value="{{ $h->id }}" />
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

			{!! $hospitals->render() !!}
        </div>
    </div>







	<div class="modal fade" id="add-hospital-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.add_edit_hospital') }}
					</h4>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<input type="hidden" name="hospital_id" value="" />
						<div class="form-group">
							<input type="text" name="name"
								   placeholder="{{ trans('main.name') }}"
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


	<div class="modal fade" id="add-hospital-address-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
						{{ trans('main.edit_hospital_address') }}
					</h4>
				</div>
				<form action="" method="post">
					<div class="modal-body">
						<input type="hidden" name="hospital_id" value="" />
						<div class="form-group">
							@include('cities_select')
						</div>
						<div class="form-group">
							<input type="text" name="addr1"
								   placeholder="{{ trans('main.street_addr_1') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="addr2"
								   placeholder="{{ trans('main.street_addr_2') }}"
								   class="form-control" />
						</div>
						<div class="form-group">
							<input type="text" name="postal_code"
								   placeholder="{{ trans('main.postal_code') }}"
								   class="form-control" />
						</div>

						<input type="hidden" name="locationLat" />
						<input type="hidden" name="locationLon" />
						<div id="map-canvas" class="small-map-canvas"></div>
					</div>
					{{ csrf_field() }}
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							{{ trans('main.close') }}
						</button>
						<button type="submit" class="btn btn-primary" name="save-address" value="1">
							<span class="fa fa-floppy-o"></span>
							{{ trans('main.save') }}
						</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection