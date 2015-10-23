<?php
	$specialties = App\Models\Specialty::all();
?>
<select name="specialty" id="specialty" class="form-control" required>
    <option value="-1" disabled selected><?php echo trans('main.specialty'); ?></option>
	<option value="0">{{ trans('main.general_practitioner') }}</option>
	<optgroup label="{{ trans('main.specialist') }}">
		<?php foreach($specialties as $specialty): ?>
			@if(old('specialty') == $specialty->id)
				<option value="<?php echo $specialty->id; ?>" selected><?php echo$specialty->title; ?></option>
			@else
				<option value="<?php echo $specialty->id; ?>"><?php echo$specialty->title; ?></option>
			@endif
		<?php endforeach; ?>
	</optgroup>
</select>