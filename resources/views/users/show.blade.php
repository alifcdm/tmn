@extends('landingpage.dashboard')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="col-12 d-flex justify-content-between">
                            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}"><i
                                    class="bi bi-pencil-square pe-2"></i>Edit</a>

                            <a class="btn btn-primary" href="{{ url('/home') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <h3 class="card-header text-center">Profile Details</h3>
                        <!-- Account -->
                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" onsubmit="return false">
                                <div class="row">
                                    <div class="mb-4 col-12">
                                        <label for="firstName" class="form-label">Full Name</label>
                                        <h3>{{ $user->fullname }}</h3>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="organization" class="form-label">Status</label>
                                        <h3>{{ $user->role }}</h3>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <h3>{{ $user->telpon }}</h3>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Email</label>
                                        <h3>{{ $user->email }}</h3>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <h3>{{ $user->alamat }}</h3>
                                    </div>
                                    <div class="mb-3 col-md-12 text-center">
                                        <label for="address" class="form-label">Created</label>
                                        <h3>{{ $user->created_at }}</h3>
                                    </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                    <div class="card">
                        <h5 class="card-header">Delete Account</h5>
                        <div class="card-body">
                            <div class="mb-3 col-12">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?
                                    </h6>
                                    <p class="mb-0">Once you delete your account, there is no going back. Please be
                                        certain.</p>
                                </div>
                            </div>
                            {{-- <form id="formAccountDeactivation" onsubmit="return false">
                                <button type="submit" class="btn btn-danger deactivate-account">Delete
                                    Account</button>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
@endsection
