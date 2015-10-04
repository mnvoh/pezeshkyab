<div class="col-xs-12">
	<div class="row">
		<div class="col-xs-12">
			<h4><a href="{{ $url }}">{{ $title }}</a></h4>
			<p>
				{{ trans('main2.published_by') }}:
				<a href="{{ route('doctors.homepage', ['doctor_id' => $doctor_id]) }}">
					{{ $doctor_name }}
				</a>
				{{ trans('main2.on') }}:
				{{ $published_on }}
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<a href="#" class="feed-link">
				@if(isset($cover_image) && $cover_image != null)
					<span class="feed-thumbnail"
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