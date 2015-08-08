@extends('master')

@section('content')
    @parent

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 login-form">
            <h2 class="text-muted">{{ trans('main.register') }}</h2>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="firstname" class="control-label">
                        {{ trans('main.firstname') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="firstname" id="firstname" class="form-control"
                           placeholder="{{ trans('main.firstname') }}" required />
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">
                        {{ trans('main.lastname') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="lastname" id="lastname" class="form-control"
                           placeholder="{{ trans('main.lastname') }}" required />
                </div>

                <div class="form-group">
                    <label for="email" class="control-label">
                        {{ trans('main.email_address') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="{{ trans('main.email_address') }}" required />
                </div>

                <div class="form-group">
                    <label for="password1" class="control-label">
                        {{ trans('main.password') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="password" name="password1" id="password1" class="form-control"
                           placeholder="{{ trans('main.password') }}" required />
                </div>

                <div class="form-group">
                    <label for="password2" class="control-label">
                        {{ trans('main.repeat_password') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="password" name="password2" id="password2" class="form-control"
                           placeholder="{{ trans('main.repeat_password') }}" required />
                </div>

                <div class="form-group" id="specialty_detail">
                    <label for="specialty" class="control-label">
                        {{ trans('main.specialty') }}
                        <span class="text-danger">*</span>
                    </label>
                    @include('specialties_select')
                </div>

                <div class="form-group">
                    <label for="license" class="control-label">
                        {{ trans('main2.physician_license_number') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="license" id="license" class="form-control"
                           placeholder="{{ trans('main2.physician_license_number') }}" required />
                </div>

				<div class="form-group">
					<label for="city" class="control-label">
						{{ trans('main2.city') }}
						<span class="text-danger">*</span>
					</label>
					@include('cities_select')
				</div>

				<div class="form-group">
					<label class="control-label">
						{{ trans('main2.clinic_address') }}
						<span class="text-danger">*</span>
						<p class="help-block">{{ trans('main2.clinic_address_help') }}</p>
					</label>
					<input type="hidden" name="clinicLat" id="clinicLat" value="NaN" />
					<input type="hidden" name="clinicLng" id="clinicLng" value="NaN" />
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