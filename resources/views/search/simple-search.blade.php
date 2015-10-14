<div class="main-search-container simple-search">
	<div class="row">
		<div class="col-xs-12">
			<form method="get" action="{{ route('search.find') }}">
				<div class="form-control main-searchbox-wrapper">
					<a id="btn-adv-search" href="{{ route('search.find') }}">
						<span class="glyphicon glyphicon-cog"></span>
					</a>

					<button type="submit" class="btn-success">
						<span class="glyphicon glyphicon-search"></span>
					</button>

					<div class="input-wrapper">
						<input type="text" class="noborder main-search-input" name="s_q"
							   placeholder="{{trans('main3.search_example')}}" autocomplete="on"
							   @if(isset($showSearchForm))
							   value="{{ filter_input(INPUT_GET, "s_q") }}"
								@endif
								/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>