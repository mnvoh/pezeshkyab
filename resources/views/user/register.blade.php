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

                <div class="form-group">
                    <label for="nationality" class="control-label">
                        {{ trans('main.nationality') }}
                        <span class="text-danger">*</span>
                    </label>

                    <select name="nationality" id="nationality" class="form-control" required>
                        <option disabled selected>{{ trans('main.nationality') }}</option>
                        <option value="ir">{{ trans('main.iranian') }}</option>
                        <option value="fo">{{ trans('main.non_iranian') }}</option>
                    </select>
                </div>

                <div class="form-group" id="signup-national-code">
                    <label for="national_code" class="control-label">
                        {{ trans('main.national_code') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="national_code" id="national_code" class="form-control"
                           placeholder="{{ trans('main.national_code') }}" />
                </div>

                <div class="form-group" id="signup-passport-number" style="display: none;">
                    <label for="passport_number" class="control-label">
                        {{ trans('main.passport_number') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="passport_number" id="passport_number" class="form-control"
                           placeholder="{{ trans('main.passport_number') }}" />
                </div>

                {{ csrf_field() }}

                <button type="submit" class="btn btn-block btn-success">
                    {{ trans('main.signup') }}
                </button>

                <div class="row vertical-spacing"></div>
            </form>
        </div>
    </div>
@endsection