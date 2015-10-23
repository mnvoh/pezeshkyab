<?php $provinces = App\Models\Province::with('cities')->get(); ?>
<select name="city" id="city" class="form-control">
    <option value="-1" disabled selected>{{ trans('main.select_a_city') }}</option>
    <?php foreach($provinces as $p): ?>
        <optgroup label="<?php echo $p->name; ?>">
            <?php foreach($p->cities as $city): ?>
				@if(old('city') == $city->id)
					<option value="<?php echo $city->id; ?>" selected><?php echo $city->name; ?></option>
				@else
					<option value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option>
				@endif
            <?php endforeach; ?>
        </optgroup>
    <?php endforeach; ?>
</select>