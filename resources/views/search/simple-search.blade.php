<div class="main-search-container simple-search">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-sm-offset-2">
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
					<ul class="nav nav-tabs" role="tablist" style="display: inline-block; margin-bottom: -11px;">
						<li role="presentation" class="active">
							<a href="#tab-specialties" aria-controls="tab-specialties" role="tab" data-toggle="tab">
								<span class="fa fa-2x fa-medkit"></span>
								<br />
								{{ trans('main.specialties') }}
							</a>
						</li>
						<li role="presentation">
							<a href="#tab-provinces" aria-controls="tab-provinces" role="tab" data-toggle="tab">
								<span class="fa fa-2x fa-map"></span>
								<br />
								{{ trans('main.provinces') }}
							</a>
						</li>
						<li role="presentation">
							<a href="#tab-hospitals" aria-controls="tab-hospitals" role="tab" data-toggle="tab">
								<span class="fa fa-2x fa-hospital-o"></span>
								<br />
								{{ trans('main.hospitals') }}
							</a>
						</li>
						<li role="presentation">
							<a href="#tab-labs" aria-controls="tab-labs" role="tab" data-toggle="tab">
								<span class="fa fa-2x fa-heartbeat"></span>
								<br />
								{{ trans('main.labs') }}
							</a>
						</li>
						<li role="presentation">
							<a href="#tab-clinics" aria-controls="tab-clinics" role="tab" data-toggle="tab">
								<span class="fa fa-2x fa-wheelchair"></span>
								<br />
								{{ trans('main.clinics') }}
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
								<div class="col-xs-6 col-sm-4 col-md-3">
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
								<div class="col-xs-6 col-sm-4 col-md-3">
									<a href="javascript:;" class="search-province-link">
										{{ $p->name }}
									</a>
									<span class="hidden cities-list">
										@foreach($cities as $c)
											@if($c->province_id == $p->id)
												<a href="{{route('search.find')}}?s_q={{$c->name}}">
													{{ $c->name }}
												</a>
												&nbsp; &nbsp; &middot; &nbsp; &nbsp;
											@endif
										@endforeach
									</span>
								</div>
							@endforeach
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab-hospitals">
						<br />
						<div class="row">
							@foreach($hospitals as $h)
								<div class="col-xs-6 col-sm-4 col-md-3">
									<a href="{{route('search.find')}}?s_q={{$h->name}}">
										{{ $h->name }}
									</a>
								</div>
							@endforeach
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab-labs">
						<br />
						<div class="row">
							<div class="col-xs-12">
								<h2 class="text-center text-muted">{{ trans('main.under_construction') }}</h2>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab-clinics">
						<br />
						<div class="row">
							<div class="col-xs-12">
								<h2 class="text-center text-muted">{{ trans('main.under_construction') }}</h2>
							</div>
						</div>
					</div>
				</div>
				<br />
			</div>
		</div>
	@endif
</div>

