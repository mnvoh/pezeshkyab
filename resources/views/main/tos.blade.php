@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <h1>{{ trans('main.tos') }}</h1>
            {!! \App\Helpers\Utils::markdownToHtml(file_get_contents(base_path('doc-tos.' . $lang . '.md'))) !!}
        </div>
    </div>


@endsection