@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-striped">
					<thead>
						<tr>
							<th>{{ trans('main4.id') }}</th>
							<th>{{ trans('main.name') }}</th>
							<th>{{ trans('main.email_address') }}</th>
						</tr>
					</thead>
				</table>
			</div>
			@foreach($doctors as $d)
				{{ $d->name }}
			@endforeach
			{!! $doctors->render() !!}
        </div>
    </div>
@endsection