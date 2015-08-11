@extends('master')

@section('content')

    @include('appointment.step-viewer')


    <div class="row">
        <div class="col-sm12 col-md-10 col-lg-8">
            <h2>{{ trans('main.schedule_information') }}</h2>

            <div class="row">
                <?php foreach($open_appointments as $a): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <?php echo $a; ?>
                    </div>
                <?php endforeach; ?>
            </div>



            <form action="{{ $next_step_link }}" method="post">
                <input type="hidden" name="date" id="date" value="" />

                {{ csrf_field() }}

                <button type="submit" class="btn btn-block btn-success">
                    {{ trans('main.next') }}
                </button>

                <div class="row vertical-spacing"></div>
            </form>
        </div>
    </div>
@endsection

