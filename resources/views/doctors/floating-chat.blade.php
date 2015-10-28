<div class="chat-box floating-chat hidden-floating-chat hidden-print col-xs-12 col-sm-12 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
	<div class="floating-chat-header">
		<h5>
			<a href="javascript:;" class="floating-chat-toggle">
				<span class="fa fa-sort fa-x2"></span>
				&nbsp;&nbsp;
				{{ trans('main.public_chat') }}
			</a>
		</h5>
	</div>

	<div class="chat-messages">

	</div>

	<div class="chat-compose">
		<form action="{{ route('chat.send') }}" method="post" id="send-chat-msg-form">
			<input type="text" name="message" class="form-control">
			{{ csrf_field() }}
			<button type="submit" class="btn btn-default">
				<span class="fa fa-send"></span>
			</button>
		</form>
		<form action="{{ route('chat.get') }}" method="post" class="hidden" id="get-messages-form">
			{{ csrf_field() }}
		</form>
	</div>
</div>