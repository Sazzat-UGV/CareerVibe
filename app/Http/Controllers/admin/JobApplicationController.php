<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Http\Controllers\Controller;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::orderBy('created_at', 'DESC')->with(['job', 'user', 'employer'])->paginate(10);
        return view('backend.job-applications.list', compact('applications'));
    }

    public function destroy(Request $request){
        $id = $request->id;
        $application = JobApplication::findOrFail($id);
        if ($application == null) {
            session()->flash('error', 'Job application not found.');
            return response()->json([
                'status' => false,
            ]);
        }
        $application->delete();
        session()->flash('success', 'Job application delete successfully.');
        return response()->json([
            'status' => true,
        ]);
    }
}
