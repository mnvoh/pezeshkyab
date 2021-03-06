@extends('master')

@section('content')

    @include('appointment.step-viewer')


    <div class="row">
        <div class="col-sm12 col-md-10 col-lg-8">
            <h2>{{ trans('main.information_desc') }}</h2>
            @if(isset($error))
                <p class="text-error">{{ $error }}</p>
            @endif
            <form action="{{ $next_step_link }}" method="post">
                <div class="form-group">
                    <label for="firstname" class="control-label">
                        {{ trans('main.firstname') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="firstname" id="firstname" class="form-control"
                           placeholder="{{ trans('main.firstname') }}" value="{{ $filled_info['b_firstname'] }}"/>
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">
                        {{ trans('main.lastname') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="lastname" id="lastname" class="form-control"
                           placeholder="{{ trans('main.lastname') }}" value="{{ $filled_info['b_lastname'] }}" />
                </div>

                <div class="form-group">
                    <label for="nationality" class="control-label">
                        {{ trans('main.nationality') }}
                        <span class="text-danger">*</span>
                    </label>

                    <select name="nationality" id="nationality" class="form-control" required>
                        <option disabled selected>{{ trans('main.nationality') }}</option>
                        <option value="ir" <?php if($filled_info['b_nationality'] == 'ir') echo "selected"; ?>>
                            {{ trans('main.iranian') }}
                        </option>
                        <option value="fo" <?php if($filled_info['b_nationality'] == 'fo') echo "selected"; ?>>
                            {{ trans('main.non_iranian') }}
                        </option>
                    </select>
                </div>

                <div class="form-group" id="signup-national-code">
                    <label for="national_code" class="control-label">
                        {{ trans('main.national_code') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="national_code" id="national_code" class="form-control"
                           placeholder="{{ trans('main.national_code') }}" value="{{ $filled_info['b_ncode'] }}" />
                </div>

                <div class="form-group" id="signup-passport-number" style="display: none;">
                    <label for="passport_number" class="control-label">
                        {{ trans('main.passport_number') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="passport_number" id="passport_number" class="form-control"
                           placeholder="{{ trans('main.passport_number') }}"/>
                </div>

                {{ csrf_field() }}

                <button type="submit" class="btn btn-block btn-success" name="form-submitted" value="true">
                    {{ trans('main.next') }}
                </button>

                <div class="row vertical-spacing"></div>
            </form>
        </div>
    </div>
@endsection

