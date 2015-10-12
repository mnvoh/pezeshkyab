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
                    <a href="#moderators" aria-controls="moderators" role="tab" data-toggle="tab" id="tab-sel-mod">
                        {{ trans('main2.mod_login') }}
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active login-form" id="doctors">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="d_license">{{ trans('main2.physician_license_number') }}</label>
                            <input type="text" class="form-control" id="license" name="license"
                                   placeholder="{{ trans('main2.physician_license_number') }}"
                                   value="{{ old('license') }}" />
                        </div>

                        <div class="form-group">
                            <label for="d_password">{{ trans('main.password') }}</label>
                            <input type="password" class="form-control" id="d_password" name="password"
                                   placeholder="{{ trans('main.password') }}" value="{{ old('password') }}"/>
                        </div>
                        {{ csrf_field() }}
                        <div>
                            <label>
                                <input type="checkbox" name="remember" id="d_remember_me" checked="checked" />
                                {{ trans('main.remember_me') }}
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            {{ trans('main.login') }}
                        </button>

                        <div class="row vertical-spacing"></div>

                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ url('/password/email') }}" title="{{ trans('main.forgot_password') }}"
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
					@if (isset($errors) && count($errors) > 0)
						<div class="alert alert-danger">
							<ul>

								@foreach ($errors->all() as $error)
									<li>{{ $error }} </li>
								@endforeach
							</ul>
						</div>
					@endif
                    <form action="{{ route('user.admin_login') }}" method="post">
                        <div class="form-group">
                            <label for="m_email">{{ trans('main.email_address') }}</label>
                            <input type="email" class="form-control" id="m_email" name="email"
                                   placeholder="{{ trans('main.email_address') }}" />
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('main.password') }}</label>
                            <input type="password" class="form-control" id="m_password" name="password"
                                   placeholder="{{ trans('main.password') }}" />
                        </div>

                        <div>
                            <label>
                                <input type="checkbox" name="remember_me" id="remember_me" checked="checked" />
                                {{ trans('main.remember_me') }}
                            </label>
                        </div>
						{{ csrf_field() }}
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