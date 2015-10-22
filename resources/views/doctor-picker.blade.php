<?php
/**
 * Created by PhpStorm.
 * User: mnVoh
 * Date: 9/19/2015
 * Time: 3:36 PM
 */
?>
<div id="doctor-picker">
    <input class="form-control" type="text" placeholder="{{ trans('main.type_to_find_doctor') }}" />
    <input type="hidden" name="doctor_id" @if(isset($old_doctor_id)) value="{{ $old_doctor_id }} @endif" />
    <label class="form-control">
		@if(isset($old_doctor_description))
			{{ $old_doctor_description }}
		@else
			{{ trans('main.type_to_find_doctor') }}
		@endif
	</label>
    <div id="dp-items">
    </div>
</div>
