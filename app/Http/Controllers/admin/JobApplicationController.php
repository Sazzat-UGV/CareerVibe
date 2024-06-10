<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::orderBy('created_at', 'DESC')->with(['job', 'user', 'employer'])->paginate(10);
        return view('backend.job-applications.list', compact('applications'));
    }
}
