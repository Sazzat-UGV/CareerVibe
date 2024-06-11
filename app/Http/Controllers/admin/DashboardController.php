<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\SavedJob;

class DashboardController extends Controller
{
    public function index(){
        $users=User::count();
        $categories=Category::count();
        $total_job=Job::count();
        $applied_job=JobApplication::count();
        $saved_job=SavedJob::count();
        return view('backend.dashboard',compact([
            'users',
            'categories',
            'saved_job',
            'applied_job',
            'total_job',
        ]));
    }
}
