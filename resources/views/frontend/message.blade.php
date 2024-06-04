@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <p class="mb-0 pb-0">{{ Session::get('error') }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
