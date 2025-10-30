@extends('layouts.app')

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
    auth.clearErrors('forgotPasswordForm');
    auth.setButtonLoading(button, true);

    try {
        const formData = auth.getFormData('forgotPasswordForm');
        const response = await auth.forgotPassword(formData);

        if (response.success) {
            auth.showNotification(response.message, 'success');

            // Clear form
            document.getElementById('forgotPasswordForm').reset();
        }
    } catch (error) {
        if (error.errors) {
            auth.showErrors(error.errors, 'forgotPasswordForm');
        }

        auth.showNotification(error.message || 'Failed to send reset link', 'error');
    } finally {
        auth.setButtonLoading(button, false);
    }
}
</script>
@endpush
@endsection
