<?php
/**
 * Created by PhpStorm.
 * User: mnVoh
 * Date: 9/10/2015
 * Time: 6:18 PM
 */

namespace App\Providers;


use App\Models\Doctor;
use App\Models\Observers\ElasticsearchDoctorObserver;
use Elasticsearch\Client as ESClient;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Doctor::observe($this->app->make(ElasticsearchDoctorObserver::class));
    }

    public function register()
    {
        $this->app->bindShared(ElasticsearchDoctorObserver::class, function() {
            return new ElasticsearchDoctorObserver(ClientBuilder::create()->build());
        });
    }
}