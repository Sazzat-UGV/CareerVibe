<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;

class AccountController extends Controller
{
    // this method will show user registration page
    public function registration()
    {
        return view('frontend.account.registration');
    }

    // this method will save a user
    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'You have register successfully.');
            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    // this method will show user login page
    public function login()
    {
        return view('frontend.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error', 'Either Email/Password incorrect');
            }
        } else {
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }

    public function profile()
    {
        return view('frontend.account.profile');
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'Profile updated successfully.');
            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updateProfilePic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);
        if ($validator->passes()) {
            $user = User::findorFail(Auth::user()->id);
            $this->image_upload($request, $user->id);

            session()->flash('success', 'Profile picture updated successfully.');
            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function image_upload($request, $user_id)
    {
        $user = User::findorFail($user_id);

        if ($request->hasFile('image')) {
            //delete old photo
            if (Auth::user()->image != '') {
                $photo_location = 'public/profile_pic/';
                $old_photo_location = $photo_location . $user->image;
                unlink(base_path($old_photo_location));
            }

            $photo_loation = 'public/profile_pic/';
            $uploaded_photo = $request->file('image');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->resize(600, 600)->save(base_path($new_photo_location));
            $check = $user->update([
                'image' => $new_photo_name,
            ]);
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        if (Hash::check($request->old_password, Auth::user()->password) == false) {
            session()->flash('error', 'Your old password is incorrect.');
            return response()->json([
                'status' => true,
            ]);
        }

        $user = User::findOrFail(Auth::user()->id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        session()->flash('success', 'Password updated successfully.');
        return response()->json([
            'status' => true,
        ]);
    }

    public function forgotPassword()
    {
        return view('frontend.account.forgot-password');
    }

    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.forgotPassword')->withInput()->withErrors($validator);
        }

        $token = Str::random(60);
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);
        // Send email
        $user = User::where('email', $request->email)->first();
        $mailData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'You have requested to change your password.',
        ];
        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));
        return redirect()->route('account.forgotPassword')->with('success', 'Reset password email has been sent to your inbox.');
    }

    public function resetPassword($token)
    {
        $tokenObj = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenObj == null) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid token.');
        }
        return view('frontend.account.reset-password', compact('token'));

    }

    public function processResetPassword(Request $request)
    {
        $tokenObj = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if ($tokenObj == null) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid token.');
        }
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.resetPassword', $request->token)->withInput()->withErrors($validator);
        }
        User::where('email', $tokenObj->email)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('account.login')->with('success', 'You have successfully change your password.');
    }
}
