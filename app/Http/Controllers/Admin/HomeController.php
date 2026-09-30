<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use App\Models\StudentPayment;
use App\Models\Students;
use App\Models\College;
use App\Models\TrainingProgram;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        $totalAdmins = Admin::count();
        $totalLeads = \Illuminate\Support\Facades\Schema::hasTable('enquiries')
            ? DB::table('enquiries')->count()
            : (\Illuminate\Support\Facades\Schema::hasTable('leads') ? DB::table('leads')->count() : 0);

        return view('admin.index', compact('totalAdmins', 'totalLeads'));
    }

    
    public function profile()
    {
        return view('admin.profile');
    }

    public function update(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
        $data = Admin::find($id);
        $data->fname = $request->fname;
        $data->lname = $request->lname;
        if (isset($request->avatar) && in_array($request->avatar->getClientOriginalExtension(), ['png', 'jpg', 'jpeg'])) {
            $avatar = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('storage/admin/photo'), $avatar);
            $data->photo = 'public/storage/admin/photo/' . $avatar;
        } else {
            return redirect()->back()->with('error', 'Select valid image file! .png, .jpg or .jpeg.');
        }
        if ($data->save()) {
            return redirect()->back()->with('success', 'Profile updated.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, Try again later!');
        }
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (Hash::check($request->confirmemailpassword, $user->password)) {
            $check = Admin::where('email', $request->email)->first();
            if (isset($check)) {
                return redirect()->back()->with('error', 'Email already register, Use diffrent email address');
            } else {
                $user->email = $request->email;
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
        if (Hash::check($request->currentpassword, Auth::guard('admin')->user()->password)) {
            Auth::guard('admin')->user()->update([
                'password' => Hash::make($request->newpassword),
            ]);
            return redirect()->back()->with('success', 'Password updated.');
        }
        return redirect()->back()->with('error', 'Current password incorrect, Try again!');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::guard('admin')->user();
        Auth::guard('admin')->logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }

    public function VerifyUser(Request $request)
    {
        $user = Admin::find($request->id);
        $user->email_verified_at = now();
        if ($user->update()) {
            return json_encode(['status'=>true,'msg'=>'User Verified']);
        }else{
            return json_encode(['status'=>false,'msg'=>'Something went wrong']);
        }

    }
}
