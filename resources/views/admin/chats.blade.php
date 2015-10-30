@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">

			@if(isset($action_message) && $action_message != null)
				<div class="alert alert-success">{{ $action_message }}</div>
			@endif

			<h4>{{ trans('main.filter_results') }}</h4>
			<form action="" method="get" class="form-horizontal">
				<input type="text" class="form-control inline-form-control" name="filter"
					   placeholder="{{ trans('main.message') }}" value=""/>

				<button type="submit" class="btn btn-info">
					{{ trans('main.apply') }}
				</button>
				<a href="{{ route('admins.chats') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr />

			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.doctor') }}</th>
						<th>{{ trans('main.sender') }}</th>
						<th>{{ trans('main.sent_at') }}</th>
						<th>{{ trans('main.message') }}</th>
						<th>{{ trans('main.ip') }}</th>
						<th>{{ trans('main.delete') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($msgs as $m)
						<tr>
							<td>{{ $m->id }}</td>
							<td>{{ $m->doctor->name . ' ' . $m->doctor->lname }}</td>
							<td>
								@if($m->sender)
									{{ $m->sender }}
								@else
									{{ trans('main.doctor') }}
								@endif
							</td>
							<td>
								{{ jdate('Y/m/d H:i:s', strtotime($m->sent_at)) }}
							</td>
							<td>
								{{ $m->msg }}
							</td>
							<td>
								{{ $m->ip }}
							</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="msg_id" value="{{ $m->id }}" />
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

			{!! $msgs->render() !!}
        </div>
    </div>
@endsection