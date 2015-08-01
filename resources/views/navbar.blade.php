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
    <div class="navbar-title-search">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <h1>
                        <img src="" width="96" height="96" />
                        {{ trans('main.site_name') }}
                    </h1>

                    <h3>
                        {{ trans('main.site_slogan') }}
                    </h3>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>{{ trans('main.find_a_doctor_now') }}</h4>

                            <form action="#" method="get">
                                <div class="form-group">
                                    <input type="text" name="query" id="query"
                                           placeholder="{{ trans('main.doctor_name') }}"
                                           class="form-control"/>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">
                                    {{ trans('main.find') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center vertical-spacing-bi">{{ trans('main.or') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="{{ route('appointment.book', ['step' => 1]) }}" class="btn btn-block btn-success">
                                {{ trans('main.book_appointment') }}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</header>