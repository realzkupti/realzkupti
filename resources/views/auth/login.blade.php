@extends('tailadmin.layouts.auth')

@section('title', 'Login - TailAdmin Template')

@section('content')
<div class="auth-container">
    <div class="auth-box">
        <div class="auth-logo">
            <h1>TailAdmin</h1>
            <p>Sign in to your account</p>
        </div>

        <form id="loginForm" onsubmit="handleLogin(event)">
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
                    placeholder="Enter your password"
                    required
                >
            </div>

            <div class="form-group flex items-center justify-between">
                <div class="checkbox-wrapper">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="checkbox-input"
                    >
                    <label for="remember" class="checkbox-label">Remember me</label>
                </div>
                <a href="{{ route('forgot-password') }}" class="auth-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary" id="loginBtn">
                Sign In
            </button>
        </form>

        <div class="auth-divider">
            <span>OR</span>
        </div>

        <p class="text-center">
            Don't have an account?
            <a href="{{ route('register') }}" class="auth-link">Sign up</a>
        </p>
    </div>
</div>

@push('scripts')
<script>
async function handleLogin(event) {
    event.preventDefault();

    const button = document.getElementById('loginBtn');
    auth.clearErrors('loginForm');
    auth.setButtonLoading(button, true);

    try {
        const formData = auth.getFormData('loginForm');
        const response = await auth.login(formData);

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
            auth.showErrors(error.errors, 'loginForm');
        }

        auth.showNotification(error.message || 'Login failed', 'error');
    }
}
</script>
@endpush
@endsection
