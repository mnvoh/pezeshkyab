@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			<h3 class="text-center">{{ trans('main.insurances') }}</h3>
			<br />
			<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('main.insurance_name') }}</th>
						<th>{{ trans('main.description') }}</th>
						<th>{{ trans('main.rate') }}</th>
					</tr>
				</thead>
				<tbody>
				@foreach($insurances as $i)
					<tr>
						<td>{{ $i->title }}</td>
						<td>{{ $i->description }}</td>
						<td>{{ $i->rate * 100 }}%</td>
					</tr>
				@endforeach
				</tbody>
			</table>
        </div>
    </div>
@endsection