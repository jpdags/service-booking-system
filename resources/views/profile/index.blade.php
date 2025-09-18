@extends('layouts.app')

@section('content')
<div class="profile-container">
    <h1>My Profile</h1>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="profile-image">
            <img src="{{ $user->profile_image ? asset('storage/profiles/'.$user->profile_image) : asset('images/default-profile.png') }}" alt="Profile Image">
        </div>

        <label>Name</label>
        <input type="text" name="name" value="{{ $user->name }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" required>

        <label>New Password (leave blank to keep current)</label>
        <input type="password" name="password">

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">

        <label>Profile Image</label>
        <input type="file" name="profile_image" accept="image/*">

        <button type="submit">Update Profile</button>
    </form>
</div>
@endsection
