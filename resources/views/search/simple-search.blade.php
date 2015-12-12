<div class="main-search-container simple-search">
	<div class="row">
		<div class="col-xs-12">
			<form method="get" action="{{ route('search.find') }}">
				<div class="form-control main-searchbox-wrapper">
					<button type="submit" class="btn-primary">
						<span class="glyphicon glyphicon-search"></span>
					</button>

					<div class="input-wrapper">
						<input type="text" class="noborder main-search-input" name="s_q"
							   placeholder="{{trans('main.search_example')}}" autocomplete="on"
							   @if(isset($showSearchForm))
							   value="{{ filter_input(INPUT_GET, "s_q") }}"
								@endif
								/>
					</div>
				</div>
			</form>
			<div style="height: 10px;"></div>
			<a id="btn-adv-search" href="{{ route('search.find') }}">
				<span class="glyphicon glyphicon-cog"></span>
				{{ trans('main.advanced_search') }}
			</a>
		</div>
	</div>
	<br />
	@if(isset($specialties) && $specialties)
		<div class="row">
			<div class="col-xs-12 text-center">
				<!-- Nav tabs -->
				<div style="border-bottom: 1px solid #ddd;">
					<ul class="nav nav-tabs" role="tablist" style="display: inline-block; margin-bottom: -6px;">
						<li role="presentation" class="active">
							<a href="#tab-specialties" aria-controls="tab-specialties" role="tab" data-toggle="tab">
								{{ trans('main.specialties') }}
							</a>
						</li>
						<li role="presentation">
							<a href="#tab-provinces" aria-controls="tab-provinces" role="tab" data-toggle="tab">
								{{ trans('main.provinces') }}
							</a>
						</li>
						<li role="presentation">
							<a href="#tab-cities" aria-controls="tab-cities" role="tab" data-toggle="tab">
								{{ trans('main.cities') }}
							</a>
						</li>
					</ul>
				</div>


				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="tab-specialties">
						<br />
						<div class="row">
							@foreach($specialties as $s)
								<div class="col-xs-12 col-sm-4 col-md-2">
									<a href="{{route('search.find')}}?s_q={{$s->title}}">
										<span class="fa-3x fa fa-user-md"></span><br />
										{{ $s->title }}
									</a>
								</div>
							@endforeach
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab-provinces">
						<br />
						<div class="row">
							@foreach($provinces as $p)
								<div class="col-xs-12 col-sm-4 col-md-2">
									<a href="{{route('search.find')}}?s_q={{$p->name}}">
										{{ $p->name }}
									</a>
								</div>
							@endforeach
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab-cities">
						<br />
						<div class="row">
							@foreach($cities as $c)
								<div class="col-xs-12 col-sm-4 col-md-2">
									<a href="{{route('search.find')}}?s_q={{$c->name}}">
										{{ $c->name }}
									</a>
								</div>
							@endforeach
						</div>
					</div>
				</div>
				<br />
			</div>
		</div>
	@endif

</div>