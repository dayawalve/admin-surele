<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{
    public function signInwithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackToGoogle()
    {
        try {
            $password = "123456789";
            $randomNumber = rand(1, 30);
            $user = Socialite::driver('google')->user();
            $name = $user->name;
            $nameParts = explode(' ', $name);
            $finduser = User::where('gauth_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('dashboard');
            } else {
                $checkemail = User::where('email', $user->email)->first();
                if ($checkemail) {
                    return redirect()->route('login')
                        ->with('error', 'Email already exist, Please login using password')
                        ->withInput([
                            'email' => $user->email,
                        ]);
                }
                $newUser = User::create([
                    'fname' => $nameParts[0],
                    'lname' => end($nameParts),
                    'email' => $user->email,
                    'gauth_id' => $user->id,
                    'gauth_type' => 'google',
                    'password' => Hash::make($password),
                    'photo' => 'public/custom-img/avtars/300-' . $randomNumber . '.jpg',
                    'email_verified_at' => now(),
                ]);
                Auth::login($newUser);
                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function gitRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function gitCallback()
    {
        try {
            $password = "123456789";
            $randomNumber = rand(1, 30);
            $user = Socialite::driver('github')->user();
            $name = $user->name;
            $nameParts = explode(' ', $name);
            $searchUser = User::where('github_id', $user->id)->first();
            if ($searchUser) {
                Auth::login($searchUser);
                return redirect()->route('dashboard');
            } else {
                $checkemail = User::where('email', $user->email)->first();
                if ($checkemail) {
                    return redirect()->route('login')
                        ->with('error', 'Email already exist, Please login using password')
                        ->withInput([
                            'email' => $user->email,
                        ]);
                }
                $gitUser = User::create([
                    'fname' => $nameParts[0],
                    'lname' => end($nameParts),
                    'email' => $user->email,
                    'github_id' => $user->id,
                    'gauth_type' => 'github',
                    'password' => Hash::make($password),
                    'photo' => 'public/custom-img/avtars/300-' . $randomNumber . '.jpg',
                    'email_verified_at' => now(),
                ]);
                Auth::login($gitUser);
                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
