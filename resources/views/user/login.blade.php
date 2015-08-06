@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#doctors" aria-controls="doctors" role="tab" data-toggle="tab">
                        {{ trans('main2.doctor_login') }}
                    </a>
                </li>
                <li role="presentation">
                    <a href="#moderators" aria-controls="moderators" role="tab" data-toggle="tab">
                        {{ trans('main2.mod_login') }}
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active login-form" id="doctors">
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="d_license">{{ trans('main2.physician_license_number') }}</label>
                            <input type="text" class="form-control" id="d_license" name="d_license"
                                   placeholder="{{ trans('main2.physician_license_number') }}" />
                        </div>

                        <div class="form-group">
                            <label for="d_password">{{ trans('main.password') }}</label>
                            <input type="password" class="form-control" id="d_password" name="d_password"
                                   placeholder="{{ trans('main.password') }}" />
                        </div>

                        <div>
                            <label>
                                <input type="checkbox" name="d_remember_me" id="d_remember_me" checked="checked" />
                                {{ trans('main.remember_me') }}
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            {{ trans('main.login') }}
                        </button>

                        <div class="row vertical-spacing"></div>

                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ route('user.forgot_password') }}" title="{{ trans('main.forgot_password') }}"
                                        class="btn btn-block btn-link">
                                    {{ trans('main.forgot_password') }}
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('user.register') }}" title="{{ trans('main.register') }}"
                                        class="btn btn-block btn-link">
                                    {{ trans('main.register') }}
                                </a>
                            </div>
                        </div>
                    </form>

                </div>


                <div role="tabpanel" class="tab-pane login-form" id="moderators">
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="m_email">{{ trans('main.email_address') }}</label>
                            <input type="email" class="form-control" id="m_email" name="m_email"
                                   placeholder="{{ trans('main.email_address') }}" />
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('main.password') }}</label>
                            <input type="password" class="form-control" id="m_password" name="m_password"
                                   placeholder="{{ trans('main.password') }}" />
                        </div>

                        <div>
                            <label>
                                <input type="checkbox" name="m_remember_me" id="m_remember_me" checked="checked" />
                                {{ trans('main.remember_me') }}
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            {{ trans('main.login') }}
                        </button>

                        <div class="row vertical-spacing"></div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection