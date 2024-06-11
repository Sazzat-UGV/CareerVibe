@extends('frontend.layouts.app')
@section('title')
    CareerVibe | Find Best Jobs
@endsection
@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('account.profile') }}">Home</a></li>
                            <li class="breadcrumb-item active">Saved Jobs</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.account.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('frontend.message')
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">Saved Jobs</h3>
                                </div>

                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    @if ($savedJobs->isNotEmpty())
                                        @foreach ($savedJobs as $savedJob)
                                            <tbody class="border-0">
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{ $savedJob->job->title }}</div>
                                                        <div class="info1">{{ $savedJob->job->jobType->name }} . {{ $savedJob->job->location }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $savedJob->job->applications->count() }} Applications</td>
                                                    <td>
                                                        @if ($savedJob->job->status == 1)
                                                            <div class="job-status text-capitalize">
                                                                <span class="badge bg-success">Active</span>
                                                            @else
                                                                <span class="badge bg-danger">Close</span>
                                                        @endif
                            </div>
                            </td>
                            <td>
                                <div class="action-dots">
                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('job.detail', $savedJob->job_id) }}"> <i class="fa fa-eye"
                                                    aria-hidden="true"></i>
                                                View</a></li>

                                        <li><a class="dropdown-item" href="#"
                                                onclick="removeJob({{ $savedJob->id }})"><i class="fa fa-trash"
                                                    aria-hidden="true"></i>
                                                Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                            </tr>
                            </tbody>
                            @endforeach
                            @endif
                            </table>
                        </div>
                        <div>
                            {{ $savedJobs->links() }}
                        </div>
                    </div>
                </div>
            @endsection

            @section('customJs')
                <script>
                    function removeJob(id) {
                        if (confirm('Are you sure you want to delete?')) {
                            $.ajax({
                                url: '{{ route("account.removeSavedJobs") }}',
                                type: 'post',
                                data: {
                                    id: id
                                },
                                dataType: 'json',
                                success: function(response) {
                                    window.location.href='{{ route("account.mySavedJobs") }}'
                                }
                            })
                        }
                    }
                </script>
            @endsection
