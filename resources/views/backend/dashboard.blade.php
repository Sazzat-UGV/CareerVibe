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
                <h2>welcome admin </h2>
            </div>
          </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')

@endsection
