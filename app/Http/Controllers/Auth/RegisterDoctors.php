<?php

namespace App\Http\Controllers\Auth;

use App\Models\Doctor;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;

trait RegisterDoctors
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register', [
			'include_maps' => true
		]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());

        return redirect()->route('user.register_complete');
    }


    public function getRegisterComplete()
    {
        return view('auth.register-completed');
    }
}
