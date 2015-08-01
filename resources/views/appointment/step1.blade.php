@extends('master')

@section('content')

    @include('appointment.step-viewer')


    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <h2 class="section-heading">
                {{ trans('main.terms_of_service') }}
            </h2>
            <p class="lead">
                {{ trans('main.tos_desc') }}
            </p>
            <p class="text-justify">
                {{ file_get_contents(base_path('tos.' . $lang . '.md')) }}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-11 col-md-9 col-lg-7">
            <form action="{{ route('appointment.book', ['step' => 2]) }}" method="post">
                {{ csrf_field() }}
                <button class="btn btn-success btn-block" name="tos" value="accept">
                    {{ trans('main.accept') }}
                </button>
            </form>
        </div>
        <div class="col-sm-1">
            <a href="{{ route('main.docfinder_home') }}" class="btn btn-link">
                {{ trans('main.decline') }}
            </a>
        </div>
    </div>

@endsection

