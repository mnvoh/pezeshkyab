@extends('master')

@section('content')

    @include('appointment.step-viewer')


    <div class="row">
        <div class="col-sm12 col-md-10 col-lg-8">
            <h2>{{ trans('main.doctor_desc') }}</h2>
            @if(isset($error))
                <p class="text-error">{{ $error }}</p>
            @endif
            <form action="{{ $next_step_link }}" method="post">
                @include('doctor-picker')

                {{ csrf_field() }}

                <button type="submit" class="btn btn-block btn-success" name="form-submitted" value="true">
                    {{ trans('main.next') }}
                </button>

                <div class="row vertical-spacing"></div>
            </form>
        </div>
    </div> <!-- <div class="row"> -->
@endsection

