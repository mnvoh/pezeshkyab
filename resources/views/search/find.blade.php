@extends('master')

@section('content')

	<div class="row">
		<div class="col-sm-12 col-md-10 col-lg-8">
			<h1>{{ trans('main2.find_a_doctor') }}</h1>
			<p class="help-block">{{ trans('main2.find_help') }}</p>
			<form action="" method="get">
				<div class="form-group">
					<label for="firstname" class="control-label">
						{{ trans('main.firstname') }}
					</label>
					<input type="text" name="firstname" id="firstname" class="form-control"
						   placeholder="{{ trans('main.firstname') }}" />
				</div>
				<div class="form-group">
					<label for="lastname" class="control-label">
						{{ trans('main.lastname') }}
					</label>
					<input type="text" name="lastname" id="lastname" class="form-control"
						   placeholder="{{ trans('main.lastname') }}" />
				</div>

				<div class="form-group">
					<label for="specialty" class="control-label">
						{{ trans('main.specialty') }}
					</label>
					@include('specialties_select')
				</div>

				<div class="form-group">
					<label for="city" class="control-label">
						{{ trans('main2.city') }}
					</label>
					@include('cities_select')
				</div>

				<button type="submit" class="btn btn-block btn-success">
					{{ trans('main2.find') }}
				</button>
			</form>
		</div>
	</div>

@endsection