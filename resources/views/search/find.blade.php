@extends('master')

@section('content')

	@if($no_query)
		@include('search.advanced-search')
	@else
		<div class="row">
			<div class="col-sm-12">
				<?php if($error): ?>
					<h3 class="text-error">{{ trans('main.no_search_server') }}</h3>
				<?php else: ?>
					<h3>{{ trans('main.search_results') }}</h3>
					<p class="help-block">
						{{ trans('main.sr_stats', ['count' => $count, 'time' => $time_took]) }}
					</p>

					@if($suggestion != null)
						<h3>
							{{ trans('main.suggestion') }}
							<form method="get" action="{{ route('search.find') }}" class="inline-form-control">
								<?php
								foreach($_GET as $name => $value) {
									$name = htmlspecialchars($name);
									$value = htmlspecialchars($value);
									if($name == 'page')
										continue;
									if($name == 's_q')
										$value = $suggestion;
									echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
								}
								?>
								<button type="submit" class="btn btn-link" style="font-size: 20px; font-weight: bold;">
									{{ $suggestion }}
								</button>
							</form>
						</h3>
					@endif

					<hr />

					<div class="search-results">
						@foreach($results as $result)
							<div class="search-result">

								<a href="{{ route('doctors.homepage', ['doctor_id' => $result['_id']]) }}">
									<?php
										$avatar = $result['avatar'];
										$name = $result['_source']['fullname'];
									?>
									@include('avatar200')
									<br />
									<span>
										{{ $result['_source']['fullname'] }}
									</span>
								</a>
								<br />
								&middot;
								@foreach($result['_source']['specialty'] as $specialty)
									{{ $specialty }}
								@endforeach
								&middot;
								@foreach($result['_source']['city'] as $city)
									{{ $city }}
								@endforeach
							</div>
						@endforeach

						<nav>
							<ul class="pagination">
								@if($currentPage > 1)
								<li>
									<a href="{{ $pagelessUrl . "page=" . ($currentPage - 1) }}" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
								@else
									<li class="disabled">
										<a href="#" aria-label="Previous">
											<span aria-hidden="true">&laquo;</span>
										</a>
									</li>
								@endif

								@for($i = 1; $i <= $pageCount; $i++)
									@if($i == $currentPage)
										<li class="active">
											<a href="{{ $pagelessUrl . "page=" . $i }}">{{ $i }}</a>
										</li>
									@else
										<li><a href="{{ $pagelessUrl . "page=" . $i }}">{{ $i }}</a></li>
									@endif
								@endfor

								@if($currentPage < $pageCount)
									<li>
										<a href="{{ $pagelessUrl . "page=" . ($currentPage + 1) }}" aria-label="Next">
											<span aria-hidden="true">&raquo;</span>
										</a>
									</li>
								@else
									<li class="disabled">
										<a href="#" aria-label="Next">
											<span aria-hidden="true">&raquo;</span>
										</a>
									</li>
								@endif
							</ul>
						</nav>
					</div>
				<?php endif; ?>
			</div>
		</div>
	@endif
@endsection