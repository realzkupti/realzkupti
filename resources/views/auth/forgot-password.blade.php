@extends('tailadmin.layouts.auth')

@section('title', 'Forgot Password - TailAdmin Template')

@section('content')
<div class="auth-container">
    <div class="auth-box">
        <div class="auth-logo">
            <h1>TailAdmin</h1>
            <p>Reset your password</p>
        </div>

        <form id="forgotPasswordForm" onsubmit="handleForgotPassword(event)">
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
                <p style="font-size: 13px; color: #64748B; margin-top: 8px;">
                    We'll send you a password reset link
                </p>
            </div>

            <button type="submit" class="btn btn-primary" id="forgotPasswordBtn">
                Send Reset Link
            </button>
        </form>

        <div class="auth-divider">
            <span>OR</span>
        </div>

        <p class="text-center">
            Remember your password?
            <a href="{{ route('login') }}" class="auth-link">Sign in</a>
        </p>
    </div>
</div>

@push('scripts')
<script>
async function handleForgotPassword(event) {
    event.preventDefault();

    const button = document.getElementById('forgotPasswordBtn');
    const form = document.getElementById('forgotPasswordForm');
    const formData = new FormData(form);

    // Set button loading state
    button.disabled = true;
    button.textContent = 'Sending...';

    try {
        const response = await fetch('{{ route('forgot-password.post') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message || 'Password reset link sent to your email!');
            // Clear form
            form.reset();
        } else {
            throw data;
        }
    } catch (error) {
        const message = error.message || 'Failed to send reset link. Please try again.';
        alert(message);
    } finally {
        button.disabled = false;
        button.textContent = 'Send Reset Link';
    }
}
</script>
@endpush
@endsection
