<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8">
        <div class="step-viewer">
            <ul class="sv-ul list-inline">
                <li class="sv-li <?php echo $step == 1 ?  'active' : ''; ?>
                                <?php echo $step > 1 ?  'success' : ''; ?>">
                    <p class="sv-num">{{ trans('main.1') }}</p>
                    <p class="sv-label hidden-xs">{{ trans('main.terms') }}</p>
                </li>
                <li class="sv-li <?php echo $step == 2 ?  'active' : ''; ?>
                                <?php echo $step > 2 ?  'success' : ''; ?>">
                    <p class="sv-num">{{ trans('main.2') }}</p>
                    <p class="sv-label hidden-xs">{{ trans('main.information') }}</p>
                </li>
                <li class="sv-li <?php echo $step == 3 ?  'active' : ''; ?>
                                <?php echo $step > 3 ?  'success' : ''; ?>">
                    <p class="sv-num">{{ trans('main.3') }}</p>
                    <p class="sv-label hidden-xs">{{ trans('main.doctor') }}</p>
                </li>
                <li class="sv-li <?php echo $step == 4 ?  'active' : ''; ?>
                                <?php echo $step > 4 ?  'success' : ''; ?>">
                    <p class="sv-num">{{ trans('main.4') }}</p>
                    <p class="sv-label hidden-xs">{{ trans('main.schedule') }}</p>
                </li>
                <li class="sv-li <?php echo $step == 5 ?  'active' : ''; ?>
                                <?php echo $step > 5 ?  'success' : ''; ?>">
                    <p class="sv-num">{{ trans('main.5') }}</p>
                    <p class="sv-label hidden-xs">{{ trans('main.insurance') }}</p>
                </li>
                <li class="sv-li <?php echo $step == 6 ?  'active' : ''; ?>
                                <?php echo $step > 6 ?  'success' : ''; ?>">
                    <p class="sv-num">{{ trans('main.6') }}</p>
                    <p class="sv-label hidden-xs">{{ trans('main.confirm_pay') }}</p>
                </li>
                <li class="sv-li <?php echo $step == 7 ?  'active' : ''; ?>
                                <?php echo $step > 7 ?  'success' : ''; ?>">
                    <p class="sv-num">{{ trans('main.7') }}</p>
                    <p class="sv-label hidden-xs">{{ trans('main.result') }}</p>
                </li>
            </ul>
        </div>
    </div>
</div>