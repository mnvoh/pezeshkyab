<!-- main footer
 ====================================== -->
<footer class="main-footer">
    <div class="container">
        <ul class="text-muted list-inline">
            <li><a href="{{ route('main.about') }}"> {{ trans('main.about') }} </a></li>
            <li>&middot;</li>
            <li class="active"><a href="{{ route('main.contact') }}"> {{ trans('main.contact') }} </a></li>
            <li>&middot;</li>
            <li><a href="{{ route('main.links') }}"> {{ trans('main.links') }} </a></li>
            <li>&middot;</li>
            <li><a href="{{ route('user.login') }}"> {{ trans('main.login') }} </a></li>
            <li>&middot;</li>
            <li><a href="{{ route('user.register') }}"> {{ trans('main.register') }} </a></li>
			<li>&middot;</li>
			<li><a href="{{ route('admins.login') }}"> {{ trans('main.admin_login') }} </a></li>
        </ul>
		<p class="text-muted" style="font-size: 11px;">
			&copy; 2015 تمامی حقوق محفوظ می باشد
		</p>
    </div>
</footer>