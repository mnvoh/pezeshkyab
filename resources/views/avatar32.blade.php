@if(isset($avatar) && $avatar)
	<?php
		list($width, $height) = getimagesize($avatar);
		if($width > $height) {
			$ratio = 32.0 / $height;
			$margin = (32 - ($width * $ratio)) / 2;
			$margin_str = "0 {$margin}px";
			$class = "landscape";
		}
		else {
			$ratio = 32.0 / $width;
			$margin = (32 - ($height * $ratio)) / 2;
			$margin_str = "{$margin}px 0";
			$class = "portrait";
		}
	?>
	<div class="avatar avatar32">
		@if(isset($name))
			<img src="{{ url($avatar) }}" alt="{{ $name }}" class="{{ $class }}"
				 style="margin: {{ $margin_str }};" />
		@else
			<img src="{{ url($avatar) }}" class="{{ $class }}" style="margin: {{ $margin_str }};" />
		@endif
	</div>
@endif