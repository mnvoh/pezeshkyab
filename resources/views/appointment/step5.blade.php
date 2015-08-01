@extends('master')

@section('content')

    @include('appointment.step-viewer')


    <div class="row">
        <div class="col-sm12 col-md-10 col-lg-8">
            <form action="{{ route('appointment.book', ['step' => 6]) }}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-block btn-success">
                    {{ trans('main.confirm') }}
                </button>
            </form>
        </div>
    </div>
@endsection

