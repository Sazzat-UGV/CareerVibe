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
                            <li class="breadcrumb-item"><a href="{{ route('account.myJobs') }}">My Jobs</a></li>
                            <li class="breadcrumb-item active">Edit Jobs Details</li>
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
                    <div class="card border-0 shadow mb-4">
                        <form action="" method="post" id="editJobForm" name="editJobForm">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Edit Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            value="{{ $job->title }}" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $job->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Type<span class="req">*</span></label>
                                        <select class="form-select" name="job_type" id="job_type">
                                            <option value="">Select Job Type</option>
                                            @if ($job_types->isNotEmpty())
                                                @foreach ($job_types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ $job->job_type_id == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy"
                                            value="{{ $job->vacancy }}" name="vacancy" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            value="{{ $job->salary }}" class="form-control">
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="location" id="location" name="location"
                                            value="{{ $job->location }}" class="form-control">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <div class="form-check-inline">
                                            <input {{ ($job->status==1)?'checked':'' }} class="form-check-input" type="radio" value="1" id="status-active" name="status">
                                            <label class="form-check-label" for="status">
                                              Active
                                            </label>
                                          </div>

                                        <div class="form-check-inline">
                                            <input  {{ ($job->status==0)?'checked':'' }} class="form-check-input" type="radio" value="0" id="status-block" name="status">
                                            <label class="form-check-label" for="status">
                                              Block
                                            </label>
                                          </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description">{{ $job->description }}</textarea>
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5"
                                        placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="" class="mb-2">Experience<span class="req">*</span></label>
                                    <select class="form-select" name="experience" name="experience">
                                        <option value="1" {{ $job->experience == 1 ? 'selected' : '' }}>1 Year</option>
                                        <option value="2"{{ $job->experience == 2 ? 'selected' : '' }}>2 Years</option>
                                        <option value="3" {{ $job->experience == 3 ? 'selected' : '' }}>3 Years
                                        </option>
                                        <option value="4" {{ $job->experience == 4 ? 'selected' : '' }}>4 Years
                                        </option>
                                        <option value="5" {{ $job->experience == 5 ? 'selected' : '' }}>5 Years
                                        </option>
                                        <option value="6" {{ $job->experience == 6 ? 'selected' : '' }}>6 Years
                                        </option>
                                        <option value="7" {{ $job->experience == 7 ? 'selected' : '' }}>7 Years
                                        </option>
                                        <option value="8" {{ $job->experience == 8 ? 'selected' : '' }}>8 Years
                                        </option>
                                        <option value="9" {{ $job->experience == 9 ? 'selected' : '' }}>9 Years
                                        </option>
                                        <option value="10" {{ $job->experience == 10 ? 'selected' : '' }}>10 Years
                                        </option>
                                        <option value="10_plus" {{ $job->experience == '10_plus' ? 'selected' : '' }}>10+
                                            Years</option>
                                    </select>
                                    <p></p>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords</label>
                                    <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                        value="{{ $job->keywords }}" class="form-control">
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name"
                                            value="{{ $job->company_name }}" name="company_name" class="form-control">
                                        <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location</label>
                                        <input type="text" placeholder="Location" id="company_location"
                                            value="{{ $job->company_location }}" name="company_location"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" id="company_website"
                                        value="{{ $job->company_website }}" name="company_website" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update Job</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $("#editJobForm").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('account.updateJob', $job->id) }}',
                type: 'PUT',
                dataType: 'json',
                data: $("#editJobForm").serializeArray(),
                success: function(response) {
                    if (response.status == true) {
                        $('#title').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#category').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#job_type').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#vacancy').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#location').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#description').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#experience').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#company_name').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        window.location.href = "{{ route('account.myJobs') }}"
                    } else {
                        var errors = response.errors;
                        if (errors.title) {
                            $('#title').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.title)
                        } else {
                            $('#title').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                        if (errors.category) {
                            $('#category').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.category)
                        } else {
                            $('#category').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                        if (errors.job_type) {
                            $('#job_type').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.job_type)
                        } else {
                            $('#job_type').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                        if (errors.vacancy) {
                            $('#vacancy').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.vacancy)
                        } else {
                            $('#vacancy').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }

                        if (errors.location) {
                            $('#location').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.location)
                        } else {
                            $('#location').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                        if (errors.description) {
                            $('#description').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.description)
                        } else {
                            $('#description').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }


                        if (errors.experience) {
                            $('#experience').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.experience)
                        } else {
                            $('#experience').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                        if (errors.company_name) {
                            $('#company_name').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.company_name)
                        } else {
                            $('#company_name').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                    }
                }
            });
        });
    </script>
@endsection
