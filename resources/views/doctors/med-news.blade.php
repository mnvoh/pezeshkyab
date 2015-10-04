@extends('master')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
			<h2>{{ trans('main2.articles') }}</h2>
			<hr />
			@if($mednews_added)
				<p class="alert-success">{{ trans('main4.mednews_added') }}</p>
			@endif
			<div class="news-feed">
				<?php foreach($feed as $f): ?>
					<div class="row">
						<div class="col-xs-12">
							<h3><a href="#"><?php echo $f['title'] ?></a></h3>
							<p>
								{{trans('main2.published_by')}}:
								<a href="{{ route('doctors.homepage', ['doctor_id' => $f['publisher_id']]) }}">
									<?php echo $f['publisher'] ?>
								</a>
								{{ trans('main2.on') }}:
								<?php echo $f['published_on'] ?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<a href="#" class="feed-link">
									<span class="feed-thumbnail-lg"
										  style="background-image: url(<?php echo $f['img']; ?>);"></span>
									<span class="feed-link-text">
										<?php echo $f['content']; ?>
									</span>
							</a>
						</div>
					</div>
				<?php endforeach; ?>

				<div class="vertical-spacing"></div>

				<nav>
					{!! $med_news->render() !!}}
				</nav>
			</div>
        </div>
    </div>
@endsection