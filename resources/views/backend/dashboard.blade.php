@extends('frontend.layouts.app')
@section('title')
    CareerVibe | Find Best Jobs
@endsection
@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('backend.include.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('frontend.message')
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-3" >
                                        <div class="card-body" style="background: #A8DF8E">
                                            <h5 class="card-title text-white mb-0">Users</h5>
                                            <h4 class="card-text text-white">{{$users}}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3" >
                                        <div class="card-body" style="background: #A8DF8E">
                                            <h5 class="card-title text-white mb-0">Categories</h5>
                                            <h4 class="card-text text-white">{{ $categories }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3" >
                                        <div class="card-body" style="background: #A8DF8E">
                                            <h5 class="card-title text-white mb-0">Total Jobs</h5>
                                            <h4 class="card-text text-white">{{ $total_job }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3" >
                                        <div class="card-body" style="background: #A8DF8E">
                                            <h5 class="card-title text-white mb-0">Applied Jobs</h5>
                                            <h4 class="card-text text-white">{{ $applied_job }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3" >
                                        <div class="card-body" style="background: #A8DF8E">
                                            <h5 class="card-title text-white mb-0">Saved Jobs</h5>
                                            <h4 class="card-text text-white">{{ $saved_job }}</h4>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')

@endsection
