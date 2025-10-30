@extends('layouts.dashboard')

@section('title', 'Profile - TailAdmin Template')

@section('content')
<div class="page-header">
    <h1>Profile</h1>
</div>

<div class="card">
    <h2 class="card-title">Update Profile</h2>

    <form id="profileForm" onsubmit="handleUpdateProfile(event)">
        <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-input"
                value="{{ auth()->user()->name }}"
                required
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-input"
                value="{{ auth()->user()->email }}"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary" id="updateProfileBtn" style="width: auto;">
            Update Profile
        </button>
    </form>
</div>

<div class="card">
    <h2 class="card-title">Account Information</h2>

    <div style="line-height: 2;">
        <p><strong>User ID:</strong> {{ auth()->user()->id }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Member Since:</strong> {{ auth()->user()->created_at->format('F d, Y') }}</p>
        <p><strong>Last Updated:</strong> {{ auth()->user()->updated_at->format('F d, Y h:i A') }}</p>
    </div>
</div>

@push('scripts')
<script>
async function handleUpdateProfile(event) {
    event.preventDefault();

    const button = document.getElementById('updateProfileBtn');
    auth.clearErrors('profileForm');
    auth.setButtonLoading(button, true);

    try {
        const formData = auth.getFormData('profileForm');
        const response = await auth.updateProfile(formData);

        if (response.success) {
            auth.showNotification(response.message, 'success');
        }
    } catch (error) {
        if (error.errors) {
            auth.showErrors(error.errors, 'profileForm');
        }

        auth.showNotification(error.message || 'Failed to update profile', 'error');
    } finally {
        auth.setButtonLoading(button, false);
    }
}
</script>
@endpush
@endsection
