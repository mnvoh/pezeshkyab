@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8">
			{!! \App\Helpers\Utils::markdownToHtml(file_get_contents(base_path('contact-us.md'))) !!}
		</div>
    </div>
@endsection