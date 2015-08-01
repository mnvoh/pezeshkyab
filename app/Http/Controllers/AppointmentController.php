<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AppointmentController extends Controller
{

    public function book(Request $request, $step) {
        if($step == 4) {
            $times = [
                $this->getCalPage('139404021130'),
                $this->getCalPage('139404021330'),
                $this->getCalPage('139404021730'),
                $this->getCalPage('139404021930')
            ];
            $data = [
                'step' => $step,
                'open_appointments' => $times,
            ];
        }
        else {
            $data = [
                'step' => $step,
            ];
        }
        return view("appointment.step$step", $data);
    }

    private function getCalPage($stimestamp) {
        $year = substr($stimestamp, 0, 4);
        $month = substr($stimestamp, 4, 2);
        $date = substr($stimestamp, 6, 2);
        $hour = substr($stimestamp, 8, 2);
        $minute = substr($stimestamp, 10, 2);

        return view('calpage', array(
            'stimestamp' => $stimestamp,
            'year' => $year,
            'month' => trans('months.' . (int)$month),
            'date' => $date,
            'hour' => $hour,
            'minute' => $minute,
        ));
    }
}
