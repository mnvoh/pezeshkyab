<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Client as ESClient;

class Doctor extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    public $redirectTo = "/";

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
//    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'lname', 'ncode', 'license', 'ban', 'mobile', 'avatar'
                            , 'last_activity', 'bio', 'bd_year', 'bd_month', 'bd_date', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function addresses()
    {
        return $this->belongsToMany('App\Models\Address');
    }

    public function avatar()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function diseases()
    {
        return $this->hasMany('App\Models\Disease');
    }

    public function hospitals()
    {
        return $this->belongsToMany('App\Models\Hospital');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function medicalNews()
    {
        return $this->hasMany('App\Models\MedicalNews');
    }

    public function medicalQuestions()
    {
        return $this->hasMany('App\Models\MedicalQuestion');
    }

    public function publicChats()
    {
        return $this->hasMany('App\Models\PublicChat');
    }

    public function rating()
    {
        return $this->ratings()->avg('rating');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }

    public function specialties()
    {
        return $this->belongsToMany('App\Models\Specialty');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function indexInElasticsearch(ESClient $esclient = null)
    {
        if($esclient === null) {
            $esclient = ClientBuilder::create()->build();
        }

        $specialties = array();
        foreach($this->specialties as $s) {
            $specialties[] = $s->title;
        }

        $hospitals = array();
        foreach($this->hospitals as $h) {
            $hospitals[] = $h->name;
        }


        $provinces = array();
        $cities = array();
        $coordinates = array();
        foreach($this->addresses as $a) {
            $city = $a->city;
            $province = $city->province;

            if(!in_array($city->name, $cities))
                $cities[] = $city->name;

            if(!in_array($province->name, $provinces))
                $provinces[] = $province->name;

            //elastic search will have the longitude in the first element.
            $coordinates[] = [(double)$a->lng, (double)$a->lat];
        }

        $schedules = array();
        $open_schedules = $this->reservations;
        foreach($open_schedules as $os) {
            $schedules[] = $os->rtime;
        }

        $params = [
        'index' => 'pezeshkyab',
            'type' => 'doctor',
            'id' => $this->id,
            'body' => [
                'fullname' => $this->name . ' ' . $this->lname,
                'firstname' => $this->name,
                'lastname' =>$this->lname,
                'specialty' => $specialties,
                'hospital' => $hospitals,
                'province' => $provinces,
                'city' => $cities,
                'location' => $coordinates,
                'rating' => $this->rating(),
                'open_schedules' => $schedules,
            ],
        ];

        return $esclient->index($params);
    }

    public function attachTo($to, $id)
    {
        switch($to) {
            case 'App\Models\Address':
                $this->addresses()->attach($id);
                break;
            case 'App\Models\Specialty':
                $this->specialties()->attach($id);
                break;
            case 'App\Models\Hospital':
                $this->hospitals()->attach($id);
                break;
            default:
                return;
        }
        $this->indexInElasticsearch();
    }
}
