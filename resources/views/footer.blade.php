<!-- main footer
 ====================================== -->
<footer class="main-footer">
    <div class="container">
        <p class="text-muted">
            &copy; 2015 <a href="<?php echo url('/'); ?>">Pezeshkyab.com</a> all rights reserved.
        </p>
        <ul class="text-muted list-inline">
            <li>v0.1</li>
            <li>&middot;</li>
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
			<li><a href="{{ route('admins.login') }}"> {{ trans('main4.admin_login') }} </a></li>
        </ul>
    </div>
</footer>