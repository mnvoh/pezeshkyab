@extends('master')

@section('content')
	<div class="row">
		<div class="col-sm-12 col-md-8">
			@if($status_message != null)
				<p class="alert-warning">{{ $status_message }}</p>
			@endif

			<h2>{{ trans('main.about_doctor') }}</h2>
			<hr />
			<p id="doctor-bio">
				{!! nl2br(htmlentities($about)) !!}
				@if($viewerIsOwner)
					<a href="javascript:;" id="show-new-bio-form">{{ trans('main.edit') }}</a>
				@endif
			</p>

			@if($viewerIsOwner)
				<form action="{{ $url }}" method="post" id="new-bio-form" style="display:none;">
					<textarea name="bio" class="form-control" style="height: 200px;">{{ $about }}</textarea>
					{{ csrf_field() }}
					<br />
					<button type="submit" name="editBioSubmitted" value="1" class="btn btn-success">
						{{ trans('main.save') }}
					</button>
				</form>
			@endif
			<br /><br />
		</div>

		<div class="col-sm-12 col-md-4">
			<h2>{{ trans('main.rate_doctor') }}</h2>
			<hr />
			<form action="{{ route('doctors.rate') }}" method="post" id="rating-form">
				<p class="text-error"></p>
				<input type="hidden" name="doctor_id" value="{{ $doctor_id }}" />
				<input type="text" class="form-control" name="name" id="name"
					   placeholder="{{ trans('main.firstname') }}" />
				<br />
				<input type="text" class="form-control" name="lname" id="lname"
					   placeholder="{{ trans('main.lastname') }}" />
				<br />
				<div class="input-group">
					<label class="">{{ trans('main.rating') }}</label>:
					@include('fivestar')
				</div>
				<br />
				<textarea class="form-control" name="description" placeholder="{{ trans('main.description') }}" style="height: 150px;"></textarea>
				<br />
				{{ csrf_field() }}
				<button type="submit" class="btn btn-info btn-block">
					<span class="fa fa-send"></span>
					{{ trans('main.submit') }}
				</button>
			</form>
			<p class="text-success hidden" id="rating-submitted-message">{{ trans('main.rating_submitted') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h2>{{ trans('main.latest_articles') }}</h2>
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
					{{ trans('main.view_all_articles') }}
				</a>
			</div>
		</div>
	@endif
	<br />
@endsection