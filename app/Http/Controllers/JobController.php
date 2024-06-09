<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        $job = Job::where('user_id', Auth::user()->id)->where('id', $request->jobId)->first();

        if ($job == null) {
            session()->flash('error', 'Either job deleted or not found.');
            return response()->json([
                'status' => true,
            ]);
        }
        Job::where('id', $request->jobId)->delete();
        session()->flash('success', 'Job deleted successfully.');
        return response()->json([
            'status' => true,
        ]);
    }
    //This method will show jobs page
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = Job::where('status', 1);

        //search using keyword
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keyword . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }

        //search using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        //search using category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        //search using job type
        $jobTypeArray = [];
        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',', $request->jobType);
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        //search using experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }
        $jobs = $jobs->with('jobType:id,name');
        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }
        $jobs = $jobs->paginate(9);

        return view('frontend.jobs', compact(['categories', 'jobTypes', 'jobs', 'jobTypeArray']));
    }

    //This method will show job detail page
    public function detail($id)
    {
        $job = Job::with('category:id,name', 'jobType:id,name')->where(['id' => $id, 'status' => 1])->first();
        if ($job == null) {
            abort(404);
        }
        $count=0;
        if (Auth::user()) {
            $count = SavedJob::where(['user_id' => Auth::user()->id, 'job_id' => $id])->count();
        }

        return view('frontend.jobDetail', compact(['job', 'count']));
    }

    public function applyJob(Request $request)
    {
        $id = $request->id;
        $job = Job::where('id', $id)->first();
        // if job not found in db
        if ($job == null) {
            session()->flash('error', 'Job does not exist.');
            return response()->json([
                'status' => false,
                'message' => 'Job does not exist.',
            ]);
        }
        // you can not apply on your own job
        $employer_id = $job->user_id;
        if ($employer_id == Auth::user()->id) {
            session()->flash('error', 'You can not apply on your own job.');
            return response()->json([
                'status' => false,
                'message' => 'You can not apply on your own job.',
            ]);
        }

        // you can not apply on a job twise
        $jobApplication = JobApplication::where(['user_id' => Auth::user()->id, 'job_id' => $id])->count();
        if ($jobApplication > 0) {
            session()->flash('error', 'You already applied on this job.');
            return response()->json([
                'status' => false,
                'message' => 'You already applied on this job.',
            ]);
        }

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();


        session()->flash('success', 'You have successfully applied.');
        return response()->json([
            'status' => false,
            'message' => 'You have successfully applied.',
        ]);
    }

    public function myJobApplications()
    {
        $jobApplications = JobApplication::with(['job', 'job.jobType', 'job.applications'])->where('user_id', Auth::user()->id)->latest('id')->paginate(10);

        return view('frontend.job.my-job-application', compact('jobApplications'));
    }

    public function removeJobs(Request $request)
    {
        $jobApplication = JobApplication::where(['id' => $request->id, 'user_id' => Auth::user()->id])->first();
        if ($jobApplication == null) {
            session()->flash('error', 'Job application not found.');
            return response()->json([
                'status' => false,
            ]);
        }

        JobApplication::findOrfail($request->id)->delete();
        session()->flash('success', 'Job application removed successfully.');
        return response()->json([
            'status' => true,
        ]);
    }

    public function savedJob(Request $request)
    {
        $id = $request->id;
        $job = Job::findOrFail($id);

        if ($job == null) {
            session()->flash('error', 'Job not found.');
            return response()->json([
                'status' => false,
            ]);
        }

        //checked if user already saved the job
        $count = SavedJob::where(['user_id' => Auth::user()->id, 'job_id' => $id])->count();
        if ($count > 0) {
            session()->flash('error', 'You already save this job.');
            return response()->json([
                'status' => false,
            ]);
        }
        $savedJob = new SavedJob;
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();
        session()->flash('success', 'You have successfully saved the job.');
        return response()->json([
            'status' => false,
        ]);
    }
    public function mySavedJobs()
    {
        $savedJobs = SavedJob::with(['job', 'job.jobType', 'job.applications'])->where('user_id', Auth::user()->id)->latest('id')->paginate(10);
        return view('frontend.job.saved-jobs', compact('savedJobs'));
    }

    public function removeSavedJobs(Request $request)
    {
        $savedJob = SavedJob::where(['id' => $request->id, 'user_id' => Auth::user()->id])->first();
        if ($savedJob == null) {
            session()->flash('error', 'Job not found.');
            return response()->json([
                'status' => false,
            ]);
        }

        SavedJob::findOrfail($request->id)->delete();
        session()->flash('success', 'Job removed successfully.');
        return response()->json([
            'status' => true,
        ]);
    }
}
