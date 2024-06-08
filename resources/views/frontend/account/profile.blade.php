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
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
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
                        <form action="" method="post" id="userForm" name="userForm">
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">My Profile</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Name<span class="req">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                                        placeholder="Enter Name" class="form-control" value="">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email<span class="req">*</span></label>
                                    <input type="text" name="email" id="email" value="{{ Auth::user()->email }}"
                                        placeholder="Enter Email" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation</label>
                                    <input type="text" name="designation" id="designation"
                                        value="{{ Auth::user()->designation }}" placeholder="Designation"
                                        class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile</label>
                                    <input type="text" name="mobile" id="mobile" value="{{ Auth::user()->mobile }}"
                                        placeholder="Mobile" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                    <form action="" method="post" id="changePasswordForm" name="changePasswordForm">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-body p-4">
                                <h3 class="fs-4 mb-1">Change Password</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Old Password<span class="req">*</span></label>
                                    <input type="password" placeholder="Old Password" id="old_password" name="old_password"
                                        class="form-control">

                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">New Password<span class="req">*</span></label>
                                    <input type="password" placeholder="New Password" id="new_password" name="new_password"
                                        class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Confirm Password<span
                                            class="req">*</span></label>
                                    <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password"
                                        class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $("#userForm").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('account.updateProfile') }}',
                type: 'put',
                dataType: 'json',
                data: $("#userForm").serializeArray(),
                success: function(response) {
                    if (response.status == true) {
                        $('#name').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#email').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        window.location.href = "{{ route('account.profile') }}"
                    } else {
                        var errors = response.errors;
                        if (errors.name) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.name)
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                        if (errors.email) {
                            $('#email').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.email)
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                    }
                }
            });
        });

        $("#changePasswordForm").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route('account.updatePassword') }}',
                type: 'post',
                dataType: 'json',
                data: $("#changePasswordForm").serializeArray(),
                success: function(response) {
                    if (response.status == true) {
                        $('#old_password').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#new_password').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#confirm_password').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        window.location.href = "{{ route('account.profile') }}"
                    } else {
                        var errors = response.errors;
                        if (errors.old_password) {
                            $('#old_password').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.old_password)
                        } else {
                            $('#old_password').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                        if (errors.new_password) {
                            $('#new_password').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.new_password)
                        } else {
                            $('#new_password').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                        if (errors.confirm_password) {
                            $('#confirm_password').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.confirm_password)
                        } else {
                            $('#confirm_password').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('')
                        }
                    }
                }
            });
        });
    </script>
@endsection
