<div class="main-search-container">
		<div class="row">
			<div class="col-xs-12">
				<form method="get" action="{{ route('search.find') }}" id="adv-search-from">
					<div class="form-control main-searchbox-wrapper advanced-search">
						<button type="submit" class="btn-success">
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

					<hr />

					<div class="adv-search">
						<div class="form-group">
							<label>{{ trans('main.search_rating') }}</label>
							@include('fivestar')
						</div>

						<hr />

						<div class="form-group">
							<label>
								<input type="checkbox" name="schedule" id="search_schedule" />
								{{ trans('main.search_schedule') }}
							</label>

							<div class="disabled-form-group">
								<div class="disabled-form-group-overlay"></div>
								<br />
								<label style="width: 50px;">{{ trans('main.from') }}: </label>
								<span class="date-wrapper">
									{{ trans('main.date') }}
									<span dir="ltr">
										<input type="text" name="s_date_from_y" id="s_date_from_y"
											   class="noborder" value="{{ $today_year }}" />
										/
										<input type="text" name="s_date_from_m" id="s_date_from_m"
											   class="noborder" value="{{ $today_month }}" />
										/
										<input type="text" name="s_date_from_d" id="s_date_from_d"
											   class="noborder" value="{{ $today_date }}" />
									</span>


									{{ trans('main.time') }}
									<span dir="ltr">
										<input type="text" name="s_date_from_h" id="s_date_from_h"
											   class="noborder" value="{{ $today_hour }}" />
										:
										<input type="text" name="s_date_from_min" id="s_date_from_min"
											   class="noborder" value="{{ $today_minute }}" />
									</span>
								</span>
								<br />
								<br />
								<label style="width: 50px;">{{ trans('main.to') }}: </label>
								<span class="date-wrapper">
									{{ trans('main.date') }}
									<span dir="ltr">
										<input type="text" name="s_date_to_y" id="s_date_to_y"
											   class="noborder" value="{{ $twoday_year }}" />
										/
										<input type="text" name="s_date_to_m" id="s_date_to_m"
											   class="noborder" value="{{ $twoday_month }}" />
										/
										<input type="text" name="s_date_to_d" id="s_date_to_d"
											   class="noborder" value="{{ $twoday_date }}" />
									</span>

									{{ trans('main.time') }}
									<span dir="ltr">
										<input type="text" name="s_date_to_h" id="s_date_to_h"
											   class="noborder" value="{{ $twoday_hour }}" />
										:
										<input type="text" name="s_date_to_min" id="s_date_to_min"
											   class="noborder" value="{{ $twoday_minute }}" />
									</span>
								</span>
							</div>
						</div>

						<hr />


						<div class="form-group search-radius">
							<label>{{ trans('main.search_radius') }}</label>
							<div class="select2slider-wrapper">
								<select name="s_distance" id="s_distance"
										class="form-control inline-form-control select2slider">
									<option value="0">{{ trans('main.doesnt_matter') }}</option>
									<option value="500">500 {{ trans('main.meters') }}</option>
									<option value="1000">1 {{ trans('main.km') }}</option>
									<option value="2000">2 {{ trans('main.km') }}</option>
									<option value="3000">3 {{ trans('main.km') }}</option>
									<option value="5000">5 {{ trans('main.km') }}</option>
									<option value="10000">10 {{ trans('main.km') }}</option>
									<option value="20000">20 {{ trans('main.km') }}</option>
									<option value="50000">50 {{ trans('main.km') }}</option>
									<option value="100000">100 {{ trans('main.km') }}</option>
									<option value="200000">200 {{ trans('main.km') }}</option>
									<option value="500000">500 {{ trans('main.km') }}</option>
								</select>
							</div>
							<p class="text-error hidden">{{ trans('main.select_radius') }}</p>
						</div>

						<label class="help-block">
							{{ trans('main.s_distance_help') }}
						</label>

						<div id="map-canvas">

						</div>
						<input type="hidden" name="locationLat" />
						<input type="hidden" name="locationLon" />
					</div>

					<br />

					<button type="submit" class="btn btn-success btn-block">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</form>
			</div>
		</div>
</div>