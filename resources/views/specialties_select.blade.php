<select name="specialty" id="specialty" class="form-control" required>
    <option value="-1" disabled selected><?php echo trans('main.specialty') ?></option>
	<option value="0">{{ trans('main2.general_practitioner') }}</option>
	<optgroup label="{{ trans('main2.specialist') }}">
		<option value="1">some specialty 1</option>
		<option value="2">some specialty 2</option>
		<option value="2">some specialty 3</option>
	</optgroup>
</select>