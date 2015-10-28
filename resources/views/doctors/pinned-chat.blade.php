<div class="chat-box pinned-chat col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
	<div class="chat-messages">

	</div>

	<div class="chat-compose">
		<form action="{{ route('chat.send') }}" method="post" id="send-chat-msg-form">
			<input type="text" name="message" class="form-control" >
			<input type="hidden" name="doctor_id" value="{{ $doctor_id }}" />
			<input type="hidden" name="sender" value="{{ $from }}" />
			{{ csrf_field() }}
			<button type="submit" class="btn btn-info">
				<span class="fa fa-send"></span>
			</button>
		</form>
		<form action="{{ route('chat.get') }}" method="post" class="hidden" id="get-messages-form">
			<input type="hidden" name="doctor_id" value="{{ $doctor_id }}" />
			{{ csrf_field() }}
		</form>
	</div>
</div>