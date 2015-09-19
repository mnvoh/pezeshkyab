<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $year = jdate("y", '', '', 'Asia/Tehran', 'en');
        $month = jdate("m", '', '', 'Asia/Tehran', 'en');
        $date = jdate("d", '', '', 'Asia/Tehran', 'en');
        $hour = jdate("H", '', '', 'Asia/Tehran', 'en');
        $min = jdate("i", '', '', 'Asia/Tehran', 'en');

        $year2 = jdate("y", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
        $month2 = jdate("m", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
        $date2 = jdate("d", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
        $hour2 = jdate("H", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
        $min2 = jdate("i", strtotime("+7 days"), '', 'Asia/Tehran', 'en');

        //
        view()->share("today_year", $year);
        view()->share("today_month", $month);
        view()->share("today_date", $date);
        view()->share("today_hour", $hour);
        view()->share("today_minute", $min);

        view()->share("twoday_year", $year2);
        view()->share("twoday_month", $month2);
        view()->share("twoday_date", $date2);
        view()->share("twoday_hour", $hour2);
        view()->share("twoday_minute", $min2);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
