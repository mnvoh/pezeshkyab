@extends('master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-xs-12">
						<h2>
							{{ $title }}
							@if(isset($viewerIsOwner) && $viewerIsOwner)
								<a href="{{ route('doctors.delete_mednews', ['mednews_id' => $mednews_id]) }}"
								   class="btn btn-danger">
									<span class="fa fa-trash"></span>
								</a>
							@endif
						</h2>
						<p>
							{{ trans('main.published_by') }}:
							<a href="{{ route('doctors.homepage', ['doctor_id' => $doctor_id]) }}">
								{{ $doctor_name }}
							</a>
							{{ trans('main.on') }}:
							{{ $published_on }}
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						{!! $body !!}
					</div>
					<hr />
				</div>
			</div>
		</div>
	</div>

@endsection