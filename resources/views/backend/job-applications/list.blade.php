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
                            <li class="breadcrumb-item active">Job Applications</li>
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
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">Job Applications</h3>
                                </div>

                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Job Title</th>
                                            <th scope="col">Applied User</th>
                                            <th scope="col">Employer</th>
                                            <th scope="col">Applied Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    @if ($applications->isNotEmpty())
                                        @foreach ($applications as $index => $application)
                                            <tbody class="border-0">
                                                <tr class="active">

                                                    <td>
                                                        <p class="job-name fw-500">{{ $application->job->title }}</p>
                                                    </td>
                                                    <td>{{ $application->user->name }}</td>
                                                    <td>{{ $application->employer->name }}</td>
                                                    <td>{{ $application->created_at->format('d M, Y') }}</td>

                        <td>
                            <div class="action-dots ">
                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li><a class="dropdown-item" href="#" onclick="deleteJobApplication({{ $application->id }})"><i
                                                class="fa fa-trash" aria-hidden="true"></i>
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
                        {{ $applications->links() }}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        function deleteJobApplication(id) {
            if (confirm('Are you sure you want to delete?')) {
                $.ajax({
                    url: '{{ route('admin.jobs.destroy') }}',
                    type: 'delete',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = '{{ route('admin.jobs') }}'
                    }
                })
            }
        }
    </script>
@endsection
