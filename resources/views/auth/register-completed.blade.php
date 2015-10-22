@extends('master')

@section('content')
    @parent

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 alert-success">
            <h2>{{ trans('main.reg_complete') }}</h2>
            <p>{{ trans('main.reg_complete_desc') }}</p>
        </div>
    </div>
@endsection