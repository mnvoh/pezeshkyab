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
				'next_step_link' => route('appointment.book', [
					'step' => $step + 1,
				]),
            ];
        }
        else {
            $data = [
                'step' => $step,
				'next_step_link' => route('appointment.book', [
					'step' => $step + 1,
				]),
            ];
        }
        return view("appointment.step$step", $data);
    }

	public function bookForDoctor(Request $request, $doctor_id, $step) {
		if($step == 3) {
			return redirect()->route('appointment.book_for_doctor', [
				'doctor_id' => $doctor_id,
				'step' => 4,
			]);
		}

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
				'next_step_link' => route('appointment.book_for_doctor', [
					'doctor_id' => $doctor_id,
					'step' => $step + 1,
				]),
			];
		}
		else {
			$data = [
				'step' => $step,
				'next_step_link' => route('appointment.book_for_doctor', [
					'doctor_id' => $doctor_id,
					'step' => $step + 1,
				]),
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
