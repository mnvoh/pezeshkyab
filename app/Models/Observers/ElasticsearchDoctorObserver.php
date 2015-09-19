<?php
/**
 * Created by PhpStorm.
 * User: mnVoh
 * Date: 9/10/2015
 * Time: 3:45 PM
 */

namespace App\Models\Observers;

use App\Models\Doctor;
use Elasticsearch\Client as ESClient;

class ElasticsearchDoctorObserver
{
    private $elasticsearch;

    public function __construct(ESClient $client)
    {
        $this->elasticsearch = $client;
    }

    public function created(Doctor $doctor)
    {
        $response = $doctor->indexInElasticsearch($this->elasticsearch);
    }

    public function updated(Doctor $doctor)
    {
        $response = $doctor->indexInElasticsearch($this->elasticsearch);
    }
}