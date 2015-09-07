<?php
	$specialties = App\Models\Specialty::all();
?>
<select name="specialty" id="specialty" class="form-control" required>
    <option value="-1" disabled selected><?php echo trans('main.specialty'); ?></option>
	<option value="0">{{ trans('main2.general_practitioner') }}</option>
	<optgroup label="{{ trans('main2.specialist') }}">
		<?php foreach($specialties as $specialty): ?>
			<option value="<?php echo $specialty->id; ?>"><?php echo$specialty->title; ?></option>
		<?php endforeach; ?>
	</optgroup>
</select>