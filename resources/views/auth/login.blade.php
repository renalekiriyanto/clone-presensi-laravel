@extends('layouts.main')
@section('title', 'Login')
@section('container')
    <style>
        .card-login {
            width: 300px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: '#bdc3c7';
        }
    </style>
    <div class="card card-login bg-light-subtle">
        <div class="card-body">
            <h5 class="card-title">Login</h5>
            <form method="POST" action="">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label d-flex align-items-center">
                    Username
                    <i class="bi bi-info-circle ms-2"></i>
                    </label>
                    <input type="text" class="form-control" id="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
@endsection
