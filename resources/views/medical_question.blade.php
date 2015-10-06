<div id="medical-question" @if(!isset($standalone) || !$standalone) class="medical-question" @endif>
    <div class="container">
		@if(isset($done) && $done)
			<h2 class="text-success">{{ trans('main4.question_submitted') }}</h2>
		@else
			<div class="row">
				<div class="col-lg-12">
					<h2 class="section-heading text-center">{{ trans('main.medical_question') }}</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<h3 class="section-subheading  text-center text-muted">
						{{ trans('main.medical_question_desc') }}
					</h3>
				</div>
			</div>

			<form action="{{ route('doctors.ask') }}" method="post">
				<div class="row">
					<div class="col-sm-12 col-md-6 col-md-offset-3">
						@if(isset($form_error) && $form_error)
							<ul>
								@foreach($status_message as $sm)
									<li class="text-error">{{ $sm }}</li>
								@endforeach
							</ul>
						@endif

						@include('doctor-picker')

						<div class="form-group">
							<input type="text" class="form-control" id="q_name" name="q_name"
								   placeholder="{{ trans('main2.your_name') }} *" value="{{ old('q_name') }}"/>
						</div>

						<div class="form-group">
							<input type="email" class="form-control" id="q_email" name="q_email"
								   placeholder="{{ trans('main.email_address') }} *" value="{{ old('q_email') }}"/>
						</div>

						<div class="form-group">
							<select name="q_scope" class="form-control">
								<option value="public">{{ trans('main4.public') }}</option>
								<option value="private">{{ trans('main4.private') }}</option>
							</select>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" id="q_title" name="q_title"
								   placeholder="{{ trans('main.title') }} *" value="{{ old('q_title') }}"/>
						</div>

						<textarea class="form-control" rows="8" name="q_question"
								  placeholder="{{ trans('main.your_question') }} *"
								  value="{{ old('q_question') }}"></textarea>

						<br />
						{{ csrf_field() }}
						<button type="submit" class="btn btn-success btn-block" name="question_submitted" value="1">
							{{ trans('main.ask') }}
						</button>
					</div>
				</div>
			</form>
		@endif
    </div>
</div>