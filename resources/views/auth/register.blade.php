@extends('layouts.app')

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
    auth.clearErrors('registerForm');
    auth.setButtonLoading(button, true);

    try {
        const formData = auth.getFormData('registerForm');
        const response = await auth.register(formData);

        if (response.success) {
            auth.showNotification(response.message, 'success');

            // Redirect after short delay
            setTimeout(() => {
                window.location.href = response.redirect;
            }, 500);
        }
    } catch (error) {
        auth.setButtonLoading(button, false);

        if (error.errors) {
            auth.showErrors(error.errors, 'registerForm');
        }

        auth.showNotification(error.message || 'Registration failed', 'error');
    }
}
</script>
@endpush
@endsection
