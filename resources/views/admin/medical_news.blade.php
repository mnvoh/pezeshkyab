@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">

			@if(isset($action_message) && $action_message != null)
				<div class="alert alert-success">{{ $action_message }}</div>
			@endif

			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.doctor') }}</th>
						<th>{{ trans('main.title') }}</th>
						<th>{{ trans('main.scope') }}</th>
						<th>{{ trans('main.delete') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($mednews as $m)
						<tr>
							<td>{{ $m->id }}</td>
							<td>
								<a href="{{ route('doctors.homepage', ['doctor_id' => $m->doctor_id]) }}"
										target="_blank">
									{{ $m->doctor->name . ' ' . $m->doctor->lname }}
								</a>
							</td>
							<td>
								<a href="{{ route('doctors.article', [
									'medical_news_id' => $m->id,
									'title' => $m->title,
								]) }}" target="_blank">
									{{ $m->title }}
								</a>
							</td>
							<td>
								@if($m->scope == 'sys')
									{{ trans('main.system') }}
								@elseif($m->scope == 'self')
									{{ trans('main.doctors_page') }}
								@else
									{{ trans('main.both') }}
								@endif
							</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="mnid" value="{{ $m->id }}" />
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

			{!! $mednews->render() !!}
        </div>
    </div>
@endsection