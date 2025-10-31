@extends('tailadmin.layouts.auth')

@section('title', 'Register - TailAdmin Template')

@section('content')
<div class="auth-container">
    <div class="auth-box">
        <div class="auth-logo">
            <h1>TailAdmin</h1>
            <p>Create your account</p>
        </div>

        <form id="registerForm" onsubmit="handleRegister(event)">
            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-input"
                    placeholder="Enter your full name"
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
                    placeholder="Enter your email"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    placeholder="Enter your password (min 6 characters)"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-input"
                    placeholder="Confirm your password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary" id="registerBtn">
                Create Account
            </button>
        </form>

        <div class="auth-divider">
            <span>OR</span>
        </div>

        <p class="text-center">
            Already have an account?
            <a href="{{ route('login') }}" class="auth-link">Sign in</a>
        </p>
    </div>
</div>

@push('scripts')
<script>
async function handleRegister(event) {
    event.preventDefault();

    const button = document.getElementById('registerBtn');
    const form = document.getElementById('registerForm');
    const formData = new FormData(form);

    // Set button loading state
    button.disabled = true;
    button.textContent = 'Creating account...';

    try {
        const response = await fetch('{{ route('register.post') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message || 'Account created successfully!');
            // Redirect to dashboard
            window.location.href = data.redirect || '{{ route('dashboard') }}';
        } else {
            throw data;
        }
    } catch (error) {
        button.disabled = false;
        button.textContent = 'Create Account';

        const message = error.message || 'Registration failed. Please try again.';
        alert(message);
    }
}
</script>
@endpush
@endsection
