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
                {!! \App\Helpers\Utils::markdownToHtml(file_get_contents(base_path('tos.' . $lang . '.md'))) !!}
            </p>


			<div class="row">
				<div class="col-xs-9">
					<form action="{{ $next_step_link }}" method="post">
						{{ csrf_field() }}
						<button class="btn btn-success btn-block" name="form-submitted" value="true">
							{{ trans('main.accept') }}
						</button>
					</form>
				</div>
				<div class="col-xs-3">
					<a href="{{ route('main.docfinder_home') }}" class="btn btn-warning btn-block">
						{{ trans('main.decline') }}
					</a>
				</div>
			</div>

		</div>
    </div>


@endsection

