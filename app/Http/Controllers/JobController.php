<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function createJob()
    {
        $categories = Category::where('status', 1)->select('id', 'name')->get();
        $job_types = JobType::where('status', 1)->select('id', 'name')->get();
        return view('frontend.job.create', compact([
            'categories',
            'job_types',
        ]));
    }

    public function saveJob(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:5|max:200',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'experience' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->job_type;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success', 'Job added successfully.');
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

    public function myJobs()
    {
        $jobs = Job::with(['jobType:id,name'])->where('user_id', Auth::user()->id)->latest('id')->paginate(10);
        return view('frontend.job.my-jobs', compact(['jobs']));
    }

    public function editJob(Request $request, $id)
    {
        $categories = Category::where('status', 1)->select('id', 'name')->get();
        $job_types = JobType::where('status', 1)->select('id', 'name')->get();
        $job = Job::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($job == null) {
            abort(404);
        }

        return view('frontend.job.edit', compact([
            'categories',
            'job_types',
            'job',
        ]));
    }

    public function updateJob(Request $request, $id)
    {
        $rules = [
            'title' => 'required|string|min:5|max:200',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'experience' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $job = Job::findorFail($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->job_type;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success', 'Job updated successfully.');
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

    public function deleteJob(Request $request)
    {
        $job=Job::where('user_id', Auth::user()->id)->where('id', $request->jobId)->first();

        if($job==null){
            session()->flash('error','Either job deleted or not found.');
            return response()->json([
                'status'=>true,
            ]);
        }
        Job::where('id', $request->jobId)->delete();
        session()->flash('success','Job deleted successfully.');
        return response()->json([
            'status'=>true,
        ]);
    }

}
