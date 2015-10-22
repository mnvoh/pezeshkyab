<div class="col-xs-12">
	<div class="row">
		<div class="col-xs-12">
			<h2><a href="{{ $url }}">{{ $title }}</a></h2>
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
			<a href="{{ $url }}" class="feed-link">
				@if(isset($cover_image) && $cover_image != null)
					<span class="feed-thumbnail-lg"
						style="background-image: url({{ $cover_image }});"></span>
				@endif
				<span class="feed-link-text">
				   {!! $content !!}
				</span>
			</a>
		</div>
	</div>
	<hr />
</div>