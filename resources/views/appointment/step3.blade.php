@extends('master')

@section('content')

    @include('appointment.step-viewer')


    <div class="row">
        <div class="col-sm12 col-md-10 col-lg-8">
            <h2>{{ trans('main.doctor_desc') }}</h2>
            <form action="{{ route('appointment.book', ['step' => 4]) }}" method="post">
                <div class="form-group">
                    <label for="firstname" class="control-label">
                        {{ trans('main.firstname') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="firstname" id="firstname" class="form-control"
                           placeholder="{{ trans('main.firstname') }}" required/>
                </div>

                <div class="form-group">
                    <label for="lastname" class="control-label">
                        {{ trans('main.lastname') }}
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="lastname" id="lastname" class="form-control"
                           placeholder="{{ trans('main.lastname') }}" required/>
                </div>

                <div class="form-group">
                    <label for="specialty" class="control-label">
                        {{ trans('main.specialty') }}
                        <span class="text-danger">*</span>
                    </label>

                    @include('specialties_select')
                </div>


                <div class="form-group">
                    <label for="city" class="control-label">
                        {{ trans('main.city') }}
                        <span class="text-danger">*</span>
                    </label>

                    @include('cities_select')
                </div>


                {{ csrf_field() }}

                <button type="submit" class="btn btn-block btn-success">
                    {{ trans('main.next') }}
                </button>

                <div class="row vertical-spacing"></div>
            </form>
        </div>
    </div> <!-- <div class="row"> -->
@endsection

