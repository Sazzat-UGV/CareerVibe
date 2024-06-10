<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(10);
        return view('backend.users.list', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
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

            session()->flash('success', 'User information updated successfully.');
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

    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        if ($user == null) {
            session()->flash('error', 'User not found.');
            return response()->json([
                'status' => false,
            ]);
        }
        $user->delete();
        session()->flash('success', 'User delete successfully.');
        return response()->json([
            'status' => true,
        ]);
    }
}
