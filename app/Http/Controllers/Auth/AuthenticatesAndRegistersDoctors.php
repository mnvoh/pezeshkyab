<?php

namespace App\Http\Controllers\Auth;

trait AuthenticatesAndRegistersDoctors
{
    use AuthenticatesDoctors, RegisterDoctors {
        AuthenticatesDoctors::redirectPath insteadof RegisterDoctors;
    }
}