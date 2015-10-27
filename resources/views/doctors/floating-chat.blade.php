<div class="floating-chat col-xs-12 col-sm-12 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
	<div class="floating-chat-header">
		<h5>
			<a href="javascript:;" class="floating-chat-toggle">
				<span class="fa fa-sort fa-x2"></span>
				&nbsp;&nbsp;
				{{ trans('main.public_chat') }}
				<span class="unread-count zero">0</span>
			</a>
		</h5>
	</div>

	<div class="floating-chat-messages">

	</div>

	<div class="floating-chat-compose">
		<form action="{{ route('chat.send') }}" method="post" id="send-chat-msg-form">
			<input type="text" name="message" class="form-control" >
			{{ csrf_field() }}
			<button type="submit" class="btn btn-default">
				<span class="fa fa-send"></span>
			</button>
		</form>
	</div>
</div>