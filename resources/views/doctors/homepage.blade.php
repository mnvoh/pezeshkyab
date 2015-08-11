@extends('doctors.dr-master')

@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h3>{{ trans('main3.about_doctor') }}</h3>
			<hr />
			<p>
				<span class="glyphicon glyphicon-check p-starter"></span>
				{{ $about }}

				<br /><br />
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h3>{{ trans('main3.latest_articles') }}</h3>
			<hr />
			<?php if(count($feed)): ?>
				<?php
				$first_feed = $feed[0];
				unset($feed[0]);
				?>
				<div class="news-feed">
					<div class="row">
						<div class="col-xs-12">
							<h2><a href="#"><?php echo $first_feed['title'] ?></a></h2>
							<p>
								{{trans('main2.published_by')}}:
								<a href="{{ route('doctors.homepage', ['doctor_id' => $first_feed['publisher_id']]) }}">
									<?php echo $first_feed['publisher'] ?>
								</a>
								{{ trans('main2.on') }}:
								<?php echo $first_feed['published_on'] ?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<a href="#" class="feed-link">
								<span class="feed-thumbnail-lg"
									  style="background-image: url(<?php echo $first_feed['img']; ?>);"></span>
								<span class="feed-link-text">
									<?php echo $first_feed['content']; ?>
								</span>
							</a>
						</div>
					</div>

					<?php
					for($i = 1; $i < sizeof($feed); $i++):
					if(isset($feed[$i])):
					?>
					<div class="vertical-spacing"></div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<h4><a href="#"><?php echo $feed[$i]['title']; ?></a></h4>
							<p>
								{{trans('main2.published_by')}}:
								<a href="{{ route('doctors.homepage', ['doctor_id' => $first_feed['publisher_id']]) }}">
									<?php echo $first_feed['publisher'] ?>
								</a>
								{{ trans('main2.on') }}:
								<?php echo $first_feed['published_on'] ?>
							</p>
							<a href="#" class="feed-link">
													<span class="feed-thumbnail"
														  style="background-image: url(<?php echo $feed[$i]['img']; ?>);">
													</span>
													<span class="feed-link-text">
														<?php echo $feed[$i]['content']; ?>
													</span>
							</a>
						</div>
						<?php
						if(isset($feed[$i + 1])):
						?>
						<div class="col-md-6 col-sm-12">
							<h4><a href="#"><?php echo $feed[$i + 1]['title']; ?></a></h4>
							<p>
								{{trans('main2.published_by')}}:
								<a href="{{ route('doctors.homepage', ['doctor_id' => $first_feed['publisher_id']]) }}">
									<?php echo $first_feed['publisher'] ?>
								</a>
								{{ trans('main2.on') }}:
								<?php echo $first_feed['published_on'] ?>
							</p>
							<a href="#" class="feed-link">
														<span class="feed-thumbnail"
															  style="background-image: url(<?php echo $feed[$i + 1]['img']; ?>);">
														</span>
														<span class="feed-link-text">
															<?php echo $feed[$i + 1]['content']; ?>
														</span>
							</a>
						</div>
						<?php
						endif;
						?>
					</div>
					<?php
					endif;
					endfor;
					?>
				<?php endif; ?>
			</div>
		</div>
	</div>
@endsection