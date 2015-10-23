<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Doctor;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersDoctors, ThrottlesLogins;

    public $redirectTo = "/docfinder/register";

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $attributes = array(
            'firstname' => trans('main.firstname'),
            'lastname' => trans('main.lastname'),
            'email' => trans('main.email_address'),
            'password' => trans('main.password'),
            'national_code' => trans('main.national_code'),
            'license' => trans('main.physician_license_number'),
            'specialty' => trans('main.specialty'),
            'ban' => trans('main.bank_account_number'),
            'mobile' => trans('main.mobile_number'),
            'bd_year' => trans('main.bd_year'),
            'bd_month' => trans('main.bd_month'),
            'bd_date' => trans('main.bd_date'),
            'city' => trans('main.city'),
            'street_address1' => trans('main.street_addr_1'),
            'street_address2' => trans('main.street_addr_2'),
            'postal_code' => trans('main.postal_code'),
        );

        $messages = array(
            'clinicLat.required' => trans('main.must_specify_location'),
            'clinicLat.numeric' => trans('main.must_specify_location'),
            'clinicLng.required' => trans('main.must_specify_location'),
            'clinicLng.numeric' => trans('main.must_specify_location'),
            'acceptTerms.required' => trans('main.must_accept_terms'),
        );

        $rules = array(
            'firstname' => 'required|max:64',
            'lastname' => 'required|max:64',
            'email' => 'required|email|max:255|unique:doctors',
            'password' => 'required|confirmed|min:6',
            'national_code' => 'required|numeric|digits:10|unique:doctors,ncode',
            'license' => 'required|max:64|unique:doctors,license',
            'specialty' => 'required|exists:specialties,id',
            'ban' => 'required|max:64|unique:doctors',
            'mobile' => 'required|numeric|unique:doctors',
            'bd_year' => 'required|numeric|min:1300|max:1420',
            'bd_month' => 'required|numeric|min:1|max:12',
            'bd_date' => 'required|numeric|min:1|max:31',
            'city' => 'required|exists:cities,id',
            'street_address1' => 'required|max:512',
            'street_address2' => 'max:512',
            'postal_code' => 'required|numeric|digits:10',
            'locationLat' => 'required|numeric',
            'locationLon' => 'required|numeric',
            'acceptTerms' => 'required',
        );

        $validator = Validator::make($data, $rules, $messages);

        $validator->setAttributeNames($attributes);

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $doctor = Doctor::create([
            'name' => $data['firstname'],
            'lname' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'ncode' => $data['national_code'],
            'license' => $data['license'],
            'specialty' => $data['specialty'],
            'ban' => $data['ban'],
            'mobile' => $data['mobile'],
            'bd_year' => $data['bd_year'],
            'bd_month' => $data['bd_month'],
            'bd_date' => $data['bd_date'],
            'status' => 'pending',
        ]);
        $address = Address::create([
            'city_id' => $data['city'],
            'street_addr_1' => $data['street_address1'],
            'street_addr_2' => $data['street_address2'],
            'zip' => $data['postal_code'],
            'lat' => $data['locationLat'],
            'lng' => $data['locationLon'],
        ]);

        $doctor->attachTo('App\Models\Address', $address->id);
        $doctor->attachTo('App\Models\Specialty', $data['specialty']);

        return $doctor;
    }
}
