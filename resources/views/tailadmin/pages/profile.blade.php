@extends('tailadmin.layouts.app')

@section('title', 'Profile - ' . config('app.name'))

@section('content')
<div class="p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-gray-900 dark:text-white">
            โปรไฟล์
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="font-medium text-brand-500 hover:text-brand-600">Dashboard</a>
                </li>
                <li class="font-medium">/</li>
                <li class="font-medium text-brand-500">โปรไฟล์</li>
            </ol>
        </nav>
    </div>

    <!-- Profile Card -->
    <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">ข้อมูลส่วนตัว</h3>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="p-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="form-label">ชื่อ</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    class="form-input"
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="form-label">อีเมล</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', auth()->user()->email) }}"
                    class="form-input"
                    required
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Department -->
            <div class="mb-4">
                <label class="form-label">แผนก</label>
                <input
                    type="text"
                    value="{{ auth()->user()->department?->name ?? 'ไม่ระบุ' }}"
                    class="form-input bg-gray-100 dark:bg-gray-800"
                    disabled
                    readonly
                >
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="form-label">รหัสผ่านใหม่ (เว้นว่างหากไม่ต้องการเปลี่ยน)</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="mb-6">
                <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-input"
                >
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3">
                <button type="submit" class="btn btn-primary">
                    บันทึกการเปลี่ยนแปลง
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    ยกเลิก
                </a>
            </div>
        </form>
    </div>

    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: @json(session('status')),
                    confirmButtonColor: '#2563eb'
                });
            });
        </script>
    @endif
</div>
@endsection
