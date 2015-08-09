@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
			<h1>{{ trans('main2.fees') }}</h1>
			<p class="help-block">{{ trans('main2.fees_title') }}</p>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th class="min-width-cell">#</th>
						<th>{{ trans('main.title') }}</th>
						<th>{{ trans('main2.fee') }}</th>
					</tr>
					</thead>
					<tbody>
					<?php $counter = 1; ?>
					@foreach($fees as $fee)
						<tr>
							<td>{{ $counter }}</td>
							<td>{{ $fee['title'] }}</td>
							<td>
								{{ $fee['fee'] }}
								{{ trans('currencies.' . $fee['currency']) }}
							</td>
						</tr>
						<?php $counter++; ?>
					@endforeach
					</tbody>
				</table>
			</div>
        </div>
    </div>
@endsection