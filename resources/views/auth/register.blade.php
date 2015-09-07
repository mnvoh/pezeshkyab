@extends('master')

@section('content')
    @parent
    {{ $red }}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 login-form">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{ trans('auth.input_error') }}!</strong>
                    {{ trans('auth.fix_input') }}<br /><br />

                    <ul>
                        <?php
                        $alreadyEchoedMapError = false;
                        foreach ($errors->all() as $error):
                            if($alreadyEchoedMapError)
                                continue;
                            if(strstr($error, trans('main3.must_specify_location')))
                                $alreadyEchoedMapError = true;
                            echo "<li>$error</li>";
                        endforeach;
                        ?>
                    </ul>
                </div>
            @endif

            <h2 class="text-muted">{{ trans('main.register') }}</h2>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="firstname" class="control-label">
                        {{ trans('main.firstname') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="firstname" id="firstname" class="form-control"
                           placeholder="{{ trans('main.firstname') }}" value="{{ old('firstname') }}" />
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">
                        {{ trans('main.lastname') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="lastname" id="lastname" class="form-control"
                           placeholder="{{ trans('main.lastname') }}" value="{{ old('lastname') }}" />
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">
                        {{ trans('main.email_address') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="{{ trans('main.email_address') }}" value="{{ old('email') }}" />
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">
                        {{ trans('main.password') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="{{ trans('main.password') }}" value="{{ old('password') }}" />
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="control-label">
                        {{ trans('main.repeat_password') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                           placeholder="{{ trans('main.repeat_password') }}"  />
                </div>

                <div class="form-group">
                    <label for="license" class="control-label">
                        {{ trans('main.national_code') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="national_code" id="national_code" class="form-control"
                           placeholder="{{ trans('main.national_code') }}" value="{{ old('national_code') }}" />
                </div>

                <div class="form-group">
                    <label for="license" class="control-label">
                        {{ trans('main2.physician_license_number') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="license" id="license" class="form-control"
                           placeholder="{{ trans('main2.physician_license_number') }}" value="{{ old('license') }}" />
                </div>

                <div class="form-group" id="specialty_detail">
                    <label for="specialty" class="control-label">
                        {{ trans('main.specialty') }}
                        <span class="text-danger">*</span>
                    </label>
                    @include('specialties_select')
                </div>

                <div class="form-group">
                    <label for="ban" class="control-label">
                        {{ trans('main3.bank_account_number') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="ban" id="ban" class="form-control"
                           placeholder="{{ trans('main3.bank_account_number') }}" value="{{ old('ban') }}" />
                </div>

                <div class="form-group">
                    <label for="mobile" class="control-label">
                        {{ trans('main3.mobile_number') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="mobile" id="mobile" class="form-control"
                           placeholder="{{ trans('main3.mobile_number') }}" value="{{ old('mobile') }}" />
                </div>

                <div class="form-group">
                    <label class="control-label">
                        {{ trans('main3.birth_date') }}
                        <span class="text-danger">*</span>
                    </label>

                    <div class="form-control">
                        <div class="col-xs-4">
                            <input type="text" name="bd_year" id="bd_year" class="noborder transparent"
                                   placeholder="{{ trans('main3.year') }}" value="{{ old('bd_year') }}" />
                        </div>
                        <div class="col-xs-4">
                            <input type="text" name="bd_month" id="bd_month" class="noborder transparent"
                                   placeholder="{{ trans('main3.month') }}" value="{{ old('bd_month') }}" />
                        </div>
                        <div class="col-xs-4">
                            <input type="text" name="bd_date" id="bd_date" class="noborder transparent"
                                   placeholder="{{ trans('main3.day') }}" value="{{ old('bd_date') }}" />
                        </div>
                    </div>
                </div>

                <hr />
                <label>
                    {{ trans('main2.clinic_address') }}
                </label>

				<div class="form-group">
					<label for="city" class="control-label">
						{{ trans('main2.city') }}
						<span class="text-danger">*</span>
					</label>
					@include('cities_select')
				</div>

                <div class="form-group">
                    <label for="street_address1" class="control-label">
                        {{ trans('main3.street_addr_1') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="street_address1" id="street_address1" class="form-control"
                           placeholder="{{ trans('main3.street_addr_1') }}" value="{{ old('street_address1') }}" />
                </div>

                <div class="form-group">
                    <label for="street_address2" class="control-label">
                        {{ trans('main3.street_addr_2') }}
                    </label>
                    <input type="text" name="street_address2" id="street_address2" class="form-control"
                           placeholder="{{ trans('main3.street_addr_2') }}" value="{{ old('street_address2') }}" />
                </div>

                <div class="form-group">
                    <label for="postal_code" class="control-label">
                        {{ trans('main3.postal_code') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="postal_code" id="postal_code" class="form-control"
                           placeholder="{{ trans('main3.postal_code') }}" value="{{ old('postal_code') }}" />
                </div>

				<div class="form-group">
					<label class="control-label">
						<p class="help-block">
                            {{ trans('main2.clinic_address_help') }}
                            <span class="text-danger">*</span>
                        </p>
					</label>
					<input type="hidden" name="clinicLat" id="clinicLat" value="{{ old('clinicLat') }}" />
					<input type="hidden" name="clinicLng" id="clinicLng" value="{{ old('clinicLng') }}" />
					<div id="map-canvas"></div>
				</div>

                {{ csrf_field() }}

				<div class="row">
					<div class="col-xs-12 col-sm-9">
						<div class="form-group">
							<label for="acceptTerms" class="control-label">
								<input type="checkbox" name="acceptTerms" id="acceptTerms" />
								<?php
									$tosUrl = route('main.tos');
									$privacyUrl = route('main.privacy_policy');
									$tosLink = "<a href='{$tosUrl}'>" . trans('main2.tos') . "</a>";
									$privacyLink = "<a href='{$privacyUrl}'>" . trans('main2.privacy_policy') . "</a>";

									$acceptText = trans('main2.accept_terms');
									$acceptText = str_replace('--tos--', $tosLink, $acceptText);
									$acceptText = str_replace('--privacy--', $privacyLink, $acceptText);
									echo $acceptText;
								?>
								<span class="text-danger">*</span>
							</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-3">
						<button type="submit" class="btn btn-block btn-success">
							{{ trans('main.signup') }}
						</button>
					</div>
				</div>

                <div class="row vertical-spacing"></div>
            </form>
        </div>
    </div>
@endsection