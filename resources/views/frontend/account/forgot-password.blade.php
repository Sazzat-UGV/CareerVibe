@extends('frontend.layouts.app')
@section('title')
    CareerVibe | Find Best Jobs
@endsection
@section('content')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                @include('frontend.message')
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Forgot Password</h1>
                        <form action="{{ route('account.processForgotPassword') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email"
                                    class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                    placeholder="Enter email" value="{{ old('email') }}">
                                @error('email')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="justify-content-between d-flex">
                                <button class="btn btn-primary mt-2" type="submit">Sumbit</button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p><a href="{{ route('account.login') }}">Back to login</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
@endsection

@section('customJs')
@endsection
