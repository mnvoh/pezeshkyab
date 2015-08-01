<?php $provinces = \DbOps::getProvinces(); ?>
<select name="city" id="city" class="form-control">
    <option value="-1" disabled selected>{{ trans('main.select_a_city') }}</option>
    <?php foreach($provinces as $pid => $p): ?>
        <optgroup label="<?php echo $p; ?>">
            <?php foreach(\DbOps::getCities($pid) as $cid => $city): ?>
                <option value="<?php echo $cid; ?>"><?php echo $city; ?></option>
            <?php endforeach; ?>
        </optgroup>
    <?php endforeach; ?>
</select>