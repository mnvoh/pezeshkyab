@extends('master')

@section('content')
	<script>
		$(document).ready(function() {
			$('#summernote').summernote();
		});
	</script>
    <div class="row">
        <div class="col-sm-12 col-md-offset-1 col-md-10">
			<div id="summernote"></div>
        </div>
    </div>
@endsection