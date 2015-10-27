<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Insurance;
use App\Models\Reservation;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    public function book(Request $request, $step, $doctor_id = null)
    {
		view()->share('go_back_url', route('appointment.book', [
			'step' => $step - 1,
		]));

        if($request->has('form-submitted') && $step < 6) {
            $validation = $this->validateData($request, $step, $error);

            if ($validation == false) {
                $request->session()->put('book_error', $error);
            }
            else {
                return redirect(route('appointment.book', ['step' => $step + 1, 'doctor_id' => $doctor_id]));
            }
        }
		else if($step == 6) {
			$request->session()->put('booking_insurance_id', $request->get('insurance'));
		}

        if($step == 4) {
            $r = Reservation::where("doctor_id", $request->session()->get("booking_doctor_id"))
                ->where('tracking_code', null)
                ->get();
            $reservations = array();
            foreach($r as $res) {
                $reservations[] = $this->getCalPage($res->id, $res->rtime);
            }

            $data = [
                'step' => $step,
                'open_appointments' => $reservations,
                'next_step_link' => route('appointment.book', [
                    'step' => $step,
                ]),
            ];
        }
        else if($step == 5) {
            if(!$request->session()->has('booking_firstname') ||
                !$request->session()->has('booking_lastname') ||
                !$request->session()->has('booking_nationality') ||
                !$request->session()->has('booking_ncode'))
            {
                $data = [
                    'step' => $step,
                    'error' => trans('main.incomplete_information'),
                    'next_step_link' => route('appointment.book', [
                        'step' => 2,
                    ]),
                ];
            }
            else if(!$request->session()->has('booking_doctor_id'))
            {
                $data = [
                    'step' => $step,
                    'error' => trans('main.incomplete_information'),
                    'next_step_link' => route('appointment.book', [
                        'step' => 3,
                    ]),
                ];
            }
            else if(!$request->session()->has('booking_reservation_id'))
            {
                $data = [
                    'step' => $step,
                    'error' => trans('main.incomplete_information'),
                    'next_step_link' => route('appointment.book', [
                        'step' => 4,
                    ]),
                ];
            }
            else
            {
                $data = [
                    'step' => $step,
                    'next_step_link' => route('appointment.book', [
                        'step' => 6,
                    ]),
                ];
            }
        }
        else if($step == 6) {
            $data = [
                'step' => $step,
                'next_step_link' => route('appointment.book', [
                    'step' => $step + 1,
                ]),
            ];
        }
        else {
            $data = [
                'step' => $step,
				'next_step_link' => route('appointment.book', [
					'step' => $step,
				]),
            ];
        }

        if($request->session()->has('book_error')) {
            $data['error'] = $request->session()->get('book_error');
            $request->session()->forget('book_error');
        }


		if($request->session()->get('booking_doctor_id', null) == null && $doctor_id != null) {
			if(Doctor::where('id', $doctor_id)->first()) {
				$request->session()->set('booking_doctor_id', $doctor_id);
			}
		}

        if($request->session()->get('booking_doctor_id') != null) {
            $doctor = Doctor::where('id', $request->session()->get('booking_doctor_id'))->first();

			if($doctor) {
				$docstr = $doctor->name . " " . $doctor->lname . " &middot; ";

				foreach ($doctor->specialties as $s) {
					$docstr .= " " . $s->title . " ";
				}


				$docstr .= " &middot; ";

				foreach ($doctor->addresses as $c) {
					$docstr .= " " . $c->city->name . " ";
				}
			}
			else {
				$docstr = "-";
			}
        }
        else {
            $docstr = "-";
        }


        if($request->session()->get('booking_reservation_id') != null) {
            $reservation = Reservation::where('id', $request->session()->get('booking_reservation_id'))->first();
            $rtime = jdate('Y/m/d H:i:s', strtotime($reservation->rtime));
            $fee_title = $reservation->fee->title;
            $fee_amount = $reservation->fee->amount;
        }
        else {
            $rtime = "-";
            $fee_title = '';
            $fee_amount = '';
        }

		$insurance = Insurance::where('id', $request->session()->get('booking_insurance_id', -1))
			->first();
		$insurance_id = ($insurance) ? $insurance->id : null;
		$insurance_title = ($insurance) ? $insurance->title : null;
		$insurance_rate = ($insurance) ? 1 - $insurance->rate : 1;

        $data['filled_info'] = [
            'b_firstname' => $request->session()->get('booking_firstname', ""),
            'b_lastname' => $request->session()->get('booking_lastname', ""),
            'b_nationality' => $request->session()->get('booking_nationality', null),
            'b_ncode' => $request->session()->get('booking_ncode', ""),
            'b_doctor_id' => $request->session()->get('booking_doctor_id', ""),
            'b_doctor_label' => $docstr,
            'b_reservation_id' => $request->session()->get('booking_reservation_id', ""),
            'b_rtime' => $rtime,
            'b_fee_title' => $fee_title,
            'b_fee_amount' => $fee_amount,
			'b_insurance_id' => $insurance_id,
			'b_insurance_rate' => $insurance_rate,
			'b_insurance_title' => $insurance_title,
        ];

        return view("appointment.step$step", $data);
    }

    private function getCalPage($id, $stimestamp) {
        $year = jdate("Y", strtotime($stimestamp), '', 'Asia/Tehran', 'en');
        $month = jdate("n", strtotime($stimestamp), '', 'Asia/Tehran', 'en');
        $date = jdate("j", strtotime($stimestamp), '', 'Asia/Tehran', 'en');
        $hour = jdate("H", strtotime($stimestamp), '', 'Asia/Tehran', 'en');
        $minute = jdate("i", strtotime($stimestamp), '', 'Asia/Tehran', 'en');

        return view('calpage', array(
            'id' => $id,
            'stimestamp' => $stimestamp,
            'year' => $year,
            'month' => $month,
            'date' => $date,
            'hour' => $hour,
            'minute' => $minute,
        ));
    }

    /**
     * Validates the input data and stores them in session if valid.
     * @param Request $request The request containing the input data
     * @param $step The step of the form.
     * @param $error Error messages will be stored int this variable.
     *
     * @return true|false True if the input are valid
     */
    private function validateData(Request $request, $step, &$error)
    {
        switch($step) {
            case 2:
                //store the data for step 2 which are:
                //firstname
                //lastname
                //nationality
                //based on nationality: national_code | passport_number
                if(strlen($request->get('firstname')) < 2) {
                    $error = trans('main.invalid_firstname');
                    return false;
                }
                if(strlen($request->get('lastname')) < 2) {
                    $error = trans('main.invalid_lastname');
                    return false;
                }
                if(!preg_match('/^[0-9]{10}$/', $request->get('national_code'))) {
                    $error = trans('main.invalid_national_code');
                    return false;
                }

                $request->session()->put("booking_firstname", $request->get('firstname'));
                $request->session()->put("booking_lastname", $request->get('lastname'));
                $request->session()->put("booking_nationality", $request->get('nationality'));
                if($request->get('nationality') == "ir") {
                    $request->session()->put("booking_ncode", $request->get('national_code'));
                }
                else {
                    $request->session()->put("booking_ncode", $request->get('passport_number'));
                }
                break;
            case 3:
                //store the datum for step 3 which is:
                //doctor_id
                if(!$request->has('doctor_id')) {
                    $error = trans('main.select_doctor');
                    return false;
                }

                $doc = Doctor::where('id', $request->get('doctor_id'))->first();

                if($doc == null) {
                    $error = trans('main.select_doctor');
                    return false;
                }
                $request->session()->put("booking_doctor_id", $request->get('doctor_id'));
                break;
            case 4:
                //store the data for step 4 which are:
                //date which in turn must broken down into date pieces and
                //be converted to gregorian: ex is: 139404021130 => 1394/04/02 11:30
                if(!$request->has('reservation_id')) {
                    $error = trans('main.select_reservation_time');
                    return false;
                }

                $res = Reservation::where('id', $request->get('reservation_id'))->first();

                if(!$res || $res->tracking_code != null) {
                    $error = trans('main.invalid_reservation');
                    return false;
                }

                $request->session()->put("booking_reservation_id", $request->get('reservation_id'));

                break;
        }
        return true;
    }
}
