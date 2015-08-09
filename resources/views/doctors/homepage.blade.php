@extends('doctors.dr-master')

@section('content')
	<div class="row">
		<div class="visible-md visible-lg col-md-4 col-lg-4">
			<ul class="nav nav-pills nav-stacked">
				<li role="presentation" class="active">
					<a href="#">{{ trans('main2.home') }}</a>
				</li>
				<li role="presentation">
					<a href="#">{{ trans('main2.articles') }}</a>
				</li>
				<li role="presentation">
					<a href="#">{{ trans('main.book_appointment') }}</a>
				</li>
				<li role="presentation">
					<a href="#">{{ trans('main2.ask_question') }}</a>
				</li>
			</ul>
		</div>
		<div class="col-sm-12 col-md-8">
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