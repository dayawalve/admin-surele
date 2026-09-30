<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;

class SiteController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function profile()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        if (isset($request->avatar) && in_array($request->avatar->getClientOriginalExtension(), ['png', 'jpg', 'jpeg'])) {
            $avatar = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('storage/user/photo'), $avatar);
            $data->photo = 'public/storage/user/photo/' . $avatar;
        } else {
            return redirect()->back()->with('error', 'Select valid image file! .png, .jpg or .jpeg.');
            // Handle the case where the file is not a valid PNG, JPG, or JPEG here.
        }
        if ($data->save()) {
            return redirect()->back()->with('success', 'Profile updated.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, Try again later!');
        }
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        if (Hash::check($request->confirmemailpassword, $user->password)) {
            $check = User::where('email', $request->email)->first();
            if (isset($check)) {
                return redirect()->back()->with('error', 'Email already register, Use diffrent email address');
            } else {
                $user->email = $request->email;
                $user->email_verified_at = null;
                $user->save();
                return redirect()->back()->with('success', 'Email updated.');
            }
        } else {
            return redirect()->back()->with('error', 'Password incorrect, Try again!');
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'newpassword' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if (Hash::check($request->currentpassword, Auth::user()->password)) {
            Auth::user()->update([
                'password' => Hash::make($request->newpassword),
            ]);
            return redirect()->back()->with('success', 'Password updated.');
        }
        return redirect()->back()->with('error', 'Current password incorrect, Try again!');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
