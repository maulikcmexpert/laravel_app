<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        $googleUser = Socialite::driver('google')->user();


        $user = User::updateOrCreate(['email' => $googleUser->email], [
            'name' => $googleUser->name,
            'google_id' => $googleUser->id,
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
}
