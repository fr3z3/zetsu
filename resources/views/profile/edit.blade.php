@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card mx-auto shadow" style="max-width: 600px;">
        <div class="card-header text-center">
            <h4>Edit Profile</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
    </div>

    <!-- Phone -->
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
    </div>

    <!-- Address -->
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
    </div>

    <!-- Profile Photo -->
<div class="mb-3">
    <label for="profile_photo" class="form-label">Profile Photo</label><br>
    @if ($user->profile_photo)
        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" width="100" class="mb-2">
    @endif
    <input type="file" name="profile_photo" class="form-control">
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('profile.show') }}" class="btn btn-secondary">Back</a>
    <button type="submit" class="btn btn-primary">Update Profile</button>
</div>

        </div>
    </div>
</div>
@endsection
