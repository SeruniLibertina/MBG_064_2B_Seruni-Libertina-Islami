@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card login-card">
            <div class="card-header text-center">
                <h2>Login Aplikasi MBG</h2>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-pink">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
