<!-- master nav
====================================-->
<header class="navbar navbar-static-top" id="top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse"
                    data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ url('/') }}" class="navbar-brand"> {{ trans('main2.home') }} </a>
            <a href="{{ route('main.docfinder_home') }}" class="navbar-brand"> {{ trans('main.site_name') }} </a>
        </div>
        <nav id="bs-navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('main.about') }}"> {{ trans('main.about') }} </a>
                </li>
                <li class="active">
                    <a href="{{ route('main.contact') }}"> {{ trans('main.contact') }} </a>
                </li>
                <li>
                    <a href="{{ route('main.links') }}"> {{ trans('main.links') }} </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('user.login') }}"> {{ trans('main.login') }} </a></li>
                <li><a href="{{ route('user.register') }}"> {{ trans('main.register') }} </a></li>
                <?php foreach($langs as $l => $ll): ?>
                    <?php if($l != $lang): ?>
                        <li><a href="<?php echo LangChanger::change($l); ?>"> <?php echo $ll; ?> </a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
    <div id="dr-hp-h-img" style="background-image: url({{ url('img/specialists/' . $specialty . '.jpg') }});">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1>{{ $name }}</h1>
					<h2>{{ $specialty_title }}</h2>
					<p>
						<span class="glyphicon glyphicon-check"></span>
						{{ $about }}
					</p>
				</div>
			</div>
		</div>

    </div>
</header>