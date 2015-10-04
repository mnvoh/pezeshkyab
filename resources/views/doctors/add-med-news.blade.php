@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-offset-1 col-md-10">
			<h1>{{ trans('main4.add_medical_news') }}</h1>
			<form action="{{ $url }}" method="post" enctype="multipart/form-data"
				  onsubmit="return prepareSummernoteSubmission();">

				@if(isset($title_error))
					<p class="text-error">{{ trans('main4.title_too_short') }}</p>
				@endif

				<input class="form-control" type="text" id="title" name="title"
					   placeholder="{{ trans('main.title') }}" value="{{ $title }}" />

				<br />

				<div id="summernote"></div>

				<label for="scope">
					{{ trans('main4.publish_scope') }}
				</label>
				<select name="scope" id="scope" class="form-control">
					<option value="sys">{{ trans('main4.system') }}</option>
					<option value="self">{{ trans('main4.doctors_page') }}</option>
					<option value="both">{{ trans('main4.both') }}</option>
				</select>
				<br />
				<textarea id="summernote-code" name="body" class="hidden"></textarea>
				<pre id="summernote-prev-value" class="hidden">{!! $body !!}</pre>
				{{ csrf_field() }}

				<button class="btn btn-success btn-block" name="form-submitted" value="1">
					{{ trans('main4.save') }}
				</button>
			</form>
        </div>
    </div>
@endsection