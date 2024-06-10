<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){
        $jobs=Job::with(['user:id,name','applications'])->orderBy('created_at','DESC')->paginate(10);
        return view('backend.jobs.list',compact('jobs'));
    }
}
