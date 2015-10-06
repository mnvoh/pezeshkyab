@extends('master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			@if($status_message != null)
				<p class="alert-warning">{{ $status_message }}</p>
			@endif

			<h2>{{ trans('main3.about_doctor') }}</h2>
			<hr />
			<p id="doctor-bio">
				{!! nl2br(htmlentities($about)) !!}
				@if($viewerIsOwner)
					<a href="javascript:;" id="show-new-bio-form">{{ trans('main4.edit') }}</a>
				@endif
			</p>

			@if($viewerIsOwner)
				<form action="{{ $url }}" method="post" id="new-bio-form" style="display:none;">
					<textarea name="bio" class="form-control" style="height: 200px;">{{ $about }}</textarea>
					{{ csrf_field() }}
					<br />
					<button type="submit" name="editBioSubmitted" value="1" class="btn btn-success">
						{{ trans('main4.save') }}
					</button>
				</form>
			@endif
			<br /><br />
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h2>{{ trans('main3.latest_articles') }}</h2>
			<hr />
			<div class="row">
				@if(count($feed))
					@foreach($feed as $f)
						{!! $f !!}
					@endforeach
				@endif
			</div>
		</div>
	</div>

	@if(count($feed))
		<br/>
		<div class="row">
			<div class="col-sm-12 col-md-3">
				<a href="{{ route('doctors.articles', ['doctor_id' => $doctor_id]) }}"
				   class="btn btn-info btn-md btn-block">
					{{ trans('main3.view_all_articles') }}
				</a>
			</div>
		</div>
	@endif
	<br />
@endsection