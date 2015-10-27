@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
			{!! nl2br(\App\Helpers\Utils::markdownToHtml(file_get_contents(base_path("fees.{$lang}.md")))) !!}

			<p class="help-block">{{ trans('main.fees_title') }}</p>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th class="min-width-cell">#</th>
						<th>{{ trans('main.title') }}</th>
						<th>{{ trans('main.fee') }}</th>
					</tr>
					</thead>
					<tbody>
					<?php $counter = 1; ?>
					@foreach($fees as $fee)
						<tr>
							<td>{{ $counter }}</td>
							<td>{{ $fee->title }}</td>
							<td>
								{{ $fee->amount }}
								{{ trans('currencies.irr') }}
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