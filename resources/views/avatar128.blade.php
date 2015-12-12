@if(isset($avatar) && $avatar && file_exists($avatar))
	<?php
		list($width, $height) = getimagesize($avatar);
		if($width > $height) {
			$ratio = 128.0 / $height;
			$margin = (128 - ($width * $ratio)) / 2;
			$margin_str = "0 {$margin}px";
			$class = "landscape";
		}
		else {
			$ratio = 128.0 / $width;
			$margin = (128 - ($height * $ratio)) / 2;
			$margin_str = "{$margin}px 0";
			$class = "portrait";
		}
	?>
	<div class="avatar avatar128">
		@if(isset($name))
			<img src="{{ url($avatar) }}" alt="{{ $name }}" class="{{ $class }}"
				 style="margin: {{ $margin_str }};" />
		@else
			<img src="{{ url($avatar) }}" class="{{ $class }}" style="margin: {{ $margin_str }};" />
		@endif
	</div>
@endif