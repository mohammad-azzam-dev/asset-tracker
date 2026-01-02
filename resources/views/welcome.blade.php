@extends('layouts.auth')

@section('title', 'Welcome - Stock Tracker')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>Stock</b> Tracker
    </div>
    <div class="card">
        <div class="card-body login-card-body text-center">
            <h4 class="mb-4">Track Your Gold & Silver Investments</h4>
            <p class="text-muted">Keep track of your precious metals purchases in one place.</p>

            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block mb-2">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg btn-block">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
