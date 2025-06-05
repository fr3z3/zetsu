@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card mx-auto shadow" style="max-width: 600px;">
        <div class="card-header text-center">
            <h4>My Profile</h4>
        </div>
        <div class="card-body text-center">
            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-profile.png') }}" alt="Profile Photo" class="rounded-circle mb-3 mx-auto d-block" width="150" height="150">
            <h5>{{ $user->name }}</h5>
            <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Address:</strong> {{ $user->address ?? '-' }}</p>
            <hr>
            <p><strong>Total Bookings:</strong> {{ $totalBooking }}</p>

            <div class="d-flex justify-content-between mt-3">
                @php
                    $previousUrl = url()->previous();
                    $editUrl = route('profile.edit');
                    $dashboardUrl = route('dashboard');
                @endphp
                <a href="{{ in_array($previousUrl, [$editUrl, $dashboardUrl]) ? route('home') : $previousUrl }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection
