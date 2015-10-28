@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			<h2 class="text-center">{{ trans('main.public_chat') }}</h2>

			@if($from)
				@include('doctors.pinned-chat')
			@else
				<h4>{{ trans('main.enter_name_to_chat') }}</h4>
				<form action="" method="post">
					<input type="text" name="chat_name" class="form-control inline-form-control" />
					{{ csrf_field() }}
					<button type="submit" class="btn btn-default">
						<span class="fa fa-comment"></span>
					</button>
				</form>
			@endif

        </div>
    </div>
@endsection