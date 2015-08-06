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
    <div id="main-carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#main-carousel" data-slide-to="1"></li>
            <li data-target="#main-carousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{ url('/img/carousel/1.jpg') }}" alt="{{ trans('main2.carousel_title_1') }}" />
                <div class="carousel-caption">
                    <h1>{{ trans('main2.carousel_title_1') }}</h1>
                    <p>{{ trans('main2.carousel_desc_1') }}</p>
                    <a href="{{ route('search.find') }}" title="{{ trans('main2.carousel_title_1') }}"
                            class="btn btn-default btn-lg">
                        {{ trans('main2.carousel_title_1') }}
                    </a>
                </div>
            </div>
            <div class="item">
                <img src="{{ url('/img/carousel/2.jpg') }}" alt="{{ trans('main2.carousel_title_2') }}" />
                <div class="carousel-caption">
                    <h1>{{ trans('main2.carousel_title_2') }}</h1>
                    <p>{{ trans('main2.carousel_desc_2') }}</p>
                    <a href="{{ route('appointment.book', ['step' => 1]) }}" title="{{ trans('main2.carousel_title_2') }}"
                       class="btn btn-default btn-lg">
                        {{ trans('main2.carousel_title_2') }}
                    </a>
                </div>
            </div>
            <div class="item">
                <img src="{{ url('/img/carousel/3.jpg') }}" alt="{{ trans('main2.carousel_title_3') }}" />
                <div class="carousel-caption">
                    <h1>{{ trans('main2.carousel_title_3') }}</h1>
                    <p>{{ trans('main2.carousel_desc_3') }}</p>
                    <a href="{{ route('main.docfinder_home') }}#medical-question" title="{{ trans('main2.carousel_title_3') }}"
                       class="btn btn-default btn-lg">
                        {{ trans('main2.carousel_title_3') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#main-carousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#main-carousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>