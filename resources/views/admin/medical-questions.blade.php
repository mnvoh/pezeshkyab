@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
			@if(isset($action_message) && $action_message != null)
				<div class="alert alert-success">{{ $action_message }}</div>
			@endif

			@if(isset($delete_question) && $delete_question)
				<div class="alert alert-warning">
					<strong>{{ trans('main.are_you_sure_delete_mq') }}</strong><br />
					{{ trans('main.id') }}: {{ $delete_question->id }} <br />
					{{ trans('main.title') }}: {{ $delete_question->title }}<br />
					<form action="" method="post">
						<input name="mqid" type="hidden" value="{{ $delete_question->id }}" />
						{{ csrf_field() }}
						<button type="submit" class="btn btn-danger" name="confirm-deletion" value="1">
							{{ trans('main.delete') }}
						</button>
						<button type="submit" class="btn btn-default" name="cancel-deletion" value="1">
							{{ trans('main.cancel') }}
						</button>
					</form>
				</div>
			@endif


			<h4>{{ trans('main.filter_results') }}</h4>
			<form action="" method="get" class="form-horizontal">
				<select name="answered" class="form-control inline-form-control">
					<option value="any">{{ trans('main.any') }}</option>
					<option value="answered" @if($filter_answered == 'answered') {{ 'selected' }} @endif>
						{{ trans('main.answered') }}
					</option>
					<option value="unanswered" @if($filter_answered == 'unanswered') {{ 'selected' }} @endif>
						{{ trans('main.unanswered') }}
					</option>
				</select>

				<button type="submit" class="btn btn-info">
					{{ trans('main.apply') }}
				</button>
				<a href="{{ route('admins.medical_question') }}"
				   class="btn btn-warning" title="{{ trans('main.clear') }}">
					{{ trans('main.clear') }}
				</a>
			</form>

			<hr />
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
					<tr>
						<th>{{ trans('main.id') }}</th>
						<th>{{ trans('main.name') }}</th>
						<th>{{ trans('main.email') }}</th>
						<th>{{ trans('main.doctor') }}</th>
						<th>{{ trans('main.publish_scope') }}</th>
						<th>{{ trans('main.title') }}</th>
						<th>{{ trans('main.date') }}</th>
						<th>{{ trans('main.delete') }}</th>
					</tr>
					</thead>
					<tbody>
					@foreach($questions as $q)
						<tr class="pointer-cursor tr-expand-below">
							<td>{{ $q->id }}</td>
							<td>
								{{ $q->fname }}
							</td>
							<td>
								{{ $q->email }}
							</td>
							<td>
								<a href="{{ route('doctors.homepage', ['doctor_id' => $q->doctor->id]) }}">
									{{ $q->doctor->name . ' ' . $q->doctor->lname }}
								</a>
							</td>
							<td>
								@if($q->scope == 'public')
									{{ trans('main._public') }}
								@else
									{{ trans('main._private') }}
								@endif
							</td>
							<td class="one-row-td">
								@if(mb_strlen($q->title) < 48)
									{{ $q->title }}
								@else
									{{ mb_substr($q->title, 0, 48) }}...
								@endif
							</td>
							<td>
								{{ jdate('Y/m/d H:i:s', strtotime($q->created_at)) }}
							</td>
							<td>
								<form action="" method="post">
									<input type="hidden" name="mqid" value="{{ $q->id }}" />
									{{ csrf_field() }}
									<button type="submit" name="delete" value="1" class="btn btn-danger">
										<span class="fa fa-remove"></span>
									</button>
								</form>
							</td>
						</tr>
						<tr class="expandable-tr">
							<td colspan="8">
								<p><strong>{{ trans('main.title') }}:</strong> {{ $q->title }}</p>
								<hr />
								<p><strong>{{ trans('main.question') }}:</strong> {{ $q->question }}</p>
								<hr />
								<p><strong>{{ trans('main.response') }}:</strong> {{ $q->response }}</p>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>

			{!! $questions->render() !!}
        </div>
    </div>
@endsection