@if(isset($avatar) && $avatar && file_exists($avatar))
	<?php
		list($width, $height) = getimagesize($avatar);
		if($width > $height) {
			$ratio = 200.0 / $height;
			$margin = (200 - ($width * $ratio)) / 2;
			$margin_str = "0 {$margin}px";
			$class = "landscape";
		}
		else {
			$ratio = 200.0 / $width;
			$margin = (200 - ($height * $ratio)) / 2;
			$margin_str = "{$margin}px 0";
			$class = "portrait";
		}
	?>
	<div class="avatar avatar200">
		@if(isset($name))
			@if(isset($avatar_url) && $avatar_url)
				<a href="{{ $avatar_url }}" class="fullsizable">
			@endif
			<img src="{{ url($avatar) }}" alt="{{ $name }}" class="{{ $class }}"
				 style="margin: {{ $margin_str }};" />
			@if(isset($avatar_url) && $avatar_url)
				</a>
			@endif
		@else
			@if(isset($avatar_url) && $avatar_url)
				<a href="{{ $avatar_url }}" class="fullsizable">
			@endif
			<img src="{{ url($avatar) }}" class="{{ $class }}" style="margin: {{ $margin_str }};" />
			@if(isset($avatar_url) && $avatar_url)
				</a>
			@endif
		@endif
		@if(isset($upload_button) && $upload_button)
			<div id="upload-avatar">
				<div class="cprogress"></div>
				<a href="javascript:;">
					<span class="fa fa-upload"></span>
					{{ trans('main.upload') }}
				</a>
				<input
						id="avatar-file"
						type="file"
						name="avatar-file"
						class="hidden"
						accept="image/*"
						data-url="{{ route('doctors.upload_avatar') }}">
				{{ csrf_field() }}
			</div>
		@endif
	</div>
@endif