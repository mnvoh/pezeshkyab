@extends('master')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 login-form">
            <h2 class="text-muted">{{ trans('main.login') }}</h2>
            <form action="#" method="post">
                <div class="form-group">
                    <label for="email">{{ trans('main.email_address') }}</label>
                    <input type="email" class="form-control" id="email" name="email"
                           placeholder="{{ trans('main.email_address') }}" />
                </div>

                <div class="form-group">
                    <label for="password">{{ trans('main.password') }}</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="{{ trans('main.password') }}" />
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="remember_me" id="remember_me" checked="checked" />
                        {{ trans('main.remember_me') }}
                    </label>

                    <label class="pull-right">
                        <a href="{{ route('user.forgot_password') }}" title="{{ trans('main.forgot_password') }}">

                        </a>
                    </label>
                </div>

                <button type="submit" class="btn btn-success btn-block">
                    {{ trans('main.login') }}
                </button>

                <div class="row vertical-spacing"></div>

                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{ route('user.forgot_password') }}" title="{{ trans('main.forgot_password') }}"
                                class="btn btn-block btn-danger">
                            {{ trans('main.forgot_password') }}
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('user.register') }}" title="{{ trans('main.register') }}"
                                class="btn btn-block btn-info">
                            {{ trans('main.register') }}
                        </a>
                    </div>
                </div>

                <div class="row vertical-spacing"></div>
            </form>
        </div>
    </div>
@endsection