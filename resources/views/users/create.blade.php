@extends('landingpage.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center mt-4">
                <div>
                    <h2>Tambah Data User</h2>
                </div>
            </div>
            <div class="col-12">
                <div style="float: right">
                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </div>
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

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row mx-1">
                <div class="col-xs-12 col-sm-12 col-md-12 my-1">
                    <div class="form-group">
                        <label for="fullname" class="form-label"><strong>Fullname: </strong></label>
                        <input type="text" name="fullname" class="form-control" placeholder="Leonardo De Caprio">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-1">
                    <div class="form-group">
                        <label for="nip" class="form-label"><strong>NIP: </strong></label>
                        <input type="text" name="nip" class="form-control" placeholder="10001" maxlength="5">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-1">
                    <div class="form-group">
                        <label for="role" class="form-label">Role: </label>
                        <select class="form-select" id="role" aria-label="Default select example" name="role">
                            <option selected>Select the role</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-1">
                    <div class="form-group">
                        <label for="email" class="form-label"><strong>Email: </strong></label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="example@gmail.com" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-1">
                    <div class="form-group">
                        <label for="phone" class="form-label"><strong>Phone: </strong></label>
                        <input type="text" maxlength="12" name="phone" class="form-control" placeholder="087879192911">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-1">
                    <div class="form-group">
                        <label for="address" class="form-label"><strong>Address: </strong></label>
                        <textarea class="form-control" style="height:150px" name="address" placeholder="Jl Keadilan"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-1">
                    <div class="form-group">
                        <label for="password" class="form-label"><strong>Password: </strong></label>
                        <input type="password" name="password" class="form-control" placeholder="password">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center my-4">
                <button type="submit" class="btn btn-success" name="proses">Create</button>
            </div>
        </div>
        </div>

    </form>
@endsection
