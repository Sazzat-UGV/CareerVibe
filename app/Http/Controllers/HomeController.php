<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;

class HomeController extends Controller
{
    // This method will show home page
    public function index()
    {
        $categories=Category::where('status',1)->orderBy('name','ASC')->take(8)->get();
        $featuredJobs=Job::with('jobType:id,name')->where('status',1)->where('isFeatured',1)->orderBy('created_at','DESC')->take(6)->get();
        $latestJobs=Job::with('jobType:id,name')->where('status',1)->orderBy('created_at','DESC')->take(6)->get();

        $newCategories=Category::where('status',1)->orderBy('name','ASC')->get();
        return view('frontend.home',compact('categories','featuredJobs','latestJobs','newCategories'));
    }
}
