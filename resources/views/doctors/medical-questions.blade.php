@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			<h2>{{ trans('main4.asked_questions') }}</h2>

			@foreach($medical_questions as $mq)
				<div class="med-q">
					<a name="medq{{ $mq->id }}"></a>
					<p>{{ trans('main4.sender') }}: {{ $mq->fname }}</p>
					<p>{{ trans('main.email_address') }}: {{ $mq->email }}</p>
					<p>{{ trans('main.title') }}: {{ $mq->title }}</p>
					<blockquote>
						<p>{{ $mq->question }}</p>
					</blockquote>

					<hr />

					<h5>{{ trans('main4.response') }}</h5>

					<form action="#medq{{ $mq->id }}" method="post">
						<div class="form-group">
							<textarea name="response" class="form-control" style="height: 200px;">@if($mq->response) {{ $mq->response }} @endif</textarea>
						</div>
						<input type="hidden" name="qid" value="{{ $mq->id }}" />
						{{ csrf_field() }}
						<button type="submit" class="btn btn-success" name="reply_sent" value="1">
							{{ trans('main4.save') }}
						</button>
					</form>

				</div>
			@endforeach

			{!! $medical_questions->render() !!}
        </div>
    </div>
@endsection