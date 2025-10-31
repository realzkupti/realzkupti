@extends('tailadmin.layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="p-4 md:p-6 2xl:p-10">
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-gray-900 dark:text-white">
            Dashboard
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li class="font-medium text-brand-500">Dashboard</li>
            </ol>
        </nav>
    </div>

    <!-- Summary Cards -->
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="text-sm text-gray-500 dark:text-gray-400">ผู้ใช้งาน (ทั้งหมด / เปิดใช้งาน)</div>
            <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                {{ $stats['users_total'] ?? 0 }}
                <span class="text-base font-semibold text-gray-500 dark:text-gray-400"> / {{ $stats['users_active'] ?? 0 }}</span>
            </div>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="text-sm text-gray-500 dark:text-gray-400">แผนก</div>
            <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['departments'] ?? 0 }}</div>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="text-sm text-gray-500 dark:text-gray-400">เมนู</div>
            <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['menus'] ?? 0 }}</div>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="text-sm text-gray-500 dark:text-gray-400">สถานะระบบ</div>
            <div class="mt-2 text-xl font-bold text-green-600 dark:text-green-400">ทำงานปกติ</div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mb-6">
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">เมนูด่วน</h3>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <a
                    href="{{ route('admin.users') }}"
                    class="flex items-center gap-3 rounded-lg border border-gray-200 p-4 transition-colors hover:border-brand-500 hover:bg-brand-50 dark:border-gray-700 dark:hover:border-brand-500 dark:hover:bg-brand-900/20"
                >
                    <svg class="h-8 w-8 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.3503 17.623 3.8507 18.1676 4.55231C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89317 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z"/>
                    </svg>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">จัดการผู้ใช้</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">จัดการผู้ใช้งานระบบ</div>
                    </div>
                </a>

                <a
                    href="{{ route('admin.departments') }}"
                    class="flex items-center gap-3 rounded-lg border border-gray-200 p-4 transition-colors hover:border-brand-500 hover:bg-brand-50 dark:border-gray-700 dark:hover:border-brand-500 dark:hover:bg-brand-900/20"
                >
                    <svg class="h-8 w-8 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">จัดการแผนก</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">จัดการแผนกงาน</div>
                    </div>
                </a>

                <a
                    href="{{ route('admin.menus') }}"
                    class="flex items-center gap-3 rounded-lg border border-gray-200 p-4 transition-colors hover:border-brand-500 hover:bg-brand-50 dark:border-gray-700 dark:hover:border-brand-500 dark:hover:bg-brand-900/20"
                >
                    <svg class="h-8 w-8 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">จัดการเมนู</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">จัดการเมนูระบบ</div>
                    </div>
                </a>

                <a
                    href="{{ route('admin.permissions.departments') }}"
                    class="flex items-center gap-3 rounded-lg border border-gray-200 p-4 transition-colors hover:border-brand-500 hover:bg-brand-50 dark:border-gray-700 dark:hover:border-brand-500 dark:hover:bg-brand-900/20"
                >
                    <svg class="h-8 w-8 text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">จัดการสิทธิ์</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">จัดการสิทธิ์การใช้งาน</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
        <!-- Card Item -->
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-900">
                <svg class="fill-brand-500 dark:fill-brand-400" width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 15.1156C4.19376 15.1156 0.825012 8.61876 0.687512 8.34376C0.584387 8.13751 0.584387 7.86251 0.687512 7.65626C0.825012 7.38126 4.19376 0.918762 11 0.918762C17.8063 0.918762 21.175 7.38126 21.3125 7.65626C21.4156 7.86251 21.4156 8.13751 21.3125 8.34376C21.175 8.61876 17.8063 15.1156 11 15.1156ZM2.26876 8.00001C3.02501 9.27189 5.98126 13.5688 11 13.5688C16.0188 13.5688 18.975 9.27189 19.7313 8.00001C18.975 6.72814 16.0188 2.43126 11 2.43126C5.98126 2.43126 3.02501 6.72814 2.26876 8.00001Z" fill=""/>
                    <path d="M11 10.9219C9.38438 10.9219 8.07812 9.61562 8.07812 8C8.07812 6.38438 9.38438 5.07812 11 5.07812C12.6156 5.07812 13.9219 6.38438 13.9219 8C13.9219 9.61562 12.6156 10.9219 11 10.9219ZM11 6.625C10.2437 6.625 9.625 7.24375 9.625 8C9.625 8.75625 10.2437 9.375 11 9.375C11.7563 9.375 12.375 8.75625 12.375 8C12.375 7.24375 11.7563 6.625 11 6.625Z" fill=""/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-gray-900 dark:text-white">
                        {{ number_format($stats['views'] ?? 3456, 0) }}
                    </h4>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">จำนวนผู้เข้าชม</span>
                </div>

                <span class="flex items-center gap-1 text-sm font-medium text-green-500">
                    0.43%
                    <svg class="fill-current" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""/>
                    </svg>
                </span>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900">
                <svg class="fill-blue-500 dark:fill-blue-400" width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.7531 16.4312C10.3781 16.4312 9.27808 17.5312 9.27808 18.9062C9.27808 20.2812 10.3781 21.3812 11.7531 21.3812C13.1281 21.3812 14.2281 20.2812 14.2281 18.9062C14.2281 17.5656 13.0937 16.4312 11.7531 16.4312ZM11.7531 19.8687C11.2375 19.8687 10.7906 19.4562 10.7906 18.9062C10.7906 18.3562 11.2031 17.9437 11.7531 17.9437C12.3031 17.9437 12.7156 18.3562 12.7156 18.9062C12.7156 19.4219 12.3031 19.8687 11.7531 19.8687Z" fill=""/>
                    <path d="M5.22183 16.4312C3.84683 16.4312 2.74683 17.5312 2.74683 18.9062C2.74683 20.2812 3.84683 21.3812 5.22183 21.3812C6.59683 21.3812 7.69683 20.2812 7.69683 18.9062C7.69683 17.5656 6.56245 16.4312 5.22183 16.4312ZM5.22183 19.8687C4.7062 19.8687 4.2593 19.4562 4.2593 18.9062C4.2593 18.3562 4.67183 17.9437 5.22183 17.9437C5.77183 17.9437 6.18433 18.3562 6.18433 18.9062C6.18433 19.4219 5.77183 19.8687 5.22183 19.8687Z" fill=""/>
                    <path d="M19.0062 0.618744H17.15C16.325 0.618744 15.6031 1.23749 15.5 2.06249L14.95 6.01562H1.37185C1.0281 6.01562 0.684353 6.18749 0.443728 6.46249C0.237478 6.73749 0.134353 7.11562 0.237478 7.45937C0.237478 7.49374 0.237478 7.49374 0.237478 7.52812L2.36873 13.9562C2.50623 14.4375 2.9531 14.7812 3.46873 14.7812H12.9562C14.2281 14.7812 15.3281 13.8187 15.5 12.5469L16.9437 2.26874C16.9437 2.19999 17.0125 2.16562 17.0812 2.16562H18.9375C19.35 2.16562 19.7281 1.82187 19.7281 1.37499C19.7281 0.928119 19.4187 0.618744 19.0062 0.618744ZM14.0219 12.3062C13.9531 12.8219 13.5062 13.2 12.9906 13.2H3.7781L1.92185 7.56249H14.7094L14.0219 12.3062Z" fill=""/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-gray-900 dark:text-white">
                        ฿{{ number_format($stats['profit'] ?? 45200, 2) }}
                    </h4>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">กำไรรวม</span>
                </div>

                <span class="flex items-center gap-1 text-sm font-medium text-green-500">
                    4.35%
                    <svg class="fill-current" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""/>
                    </svg>
                </span>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-green-50 dark:bg-green-900">
                <svg class="fill-green-500 dark:fill-green-400" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.1063 18.0469L19.3875 3.23126C19.2157 1.71876 17.9438 0.584381 16.3969 0.584381H5.56878C4.05628 0.584381 2.78441 1.71876 2.57816 3.23126L0.859406 18.0469C0.756281 18.9063 1.03128 19.7313 1.61566 20.3844C2.20003 21.0375 3.02816 21.3813 3.92191 21.3813H18.0157C18.8782 21.3813 19.7063 21.0031 20.2907 20.3844C20.875 19.7656 21.15 18.9063 21.1063 18.0469ZM19.2157 19.3531C18.9407 19.6625 18.5625 19.8344 18.0157 19.8344H3.92191C3.40941 19.8344 3.03128 19.6625 2.75628 19.3531C2.48128 19.0438 2.37816 18.6313 2.44691 18.2188L4.13128 3.43751C4.19691 2.71563 4.81253 2.16563 5.56878 2.16563H16.4313C17.1532 2.16563 17.7688 2.71563 17.8344 3.43751L19.5188 18.2531C19.6219 18.6656 19.4907 19.0438 19.2157 19.3531Z" fill=""/>
                    <path d="M14.3345 5.29375C13.922 5.39688 13.647 5.80938 13.7501 6.22188C13.7845 6.42813 13.8189 6.63438 13.8189 6.80625C13.8189 8.35313 12.547 9.625 11.0001 9.625C9.45327 9.625 8.18139 8.35313 8.18139 6.80625C8.18139 6.6 8.21577 6.42813 8.25014 6.22188C8.35327 5.80938 8.07827 5.39688 7.66577 5.29375C7.25327 5.19063 6.84077 5.46563 6.73764 5.87813C6.66889 6.1875 6.63452 6.49688 6.63452 6.80625C6.63452 9.2125 8.5939 11.1719 11.0001 11.1719C13.4064 11.1719 15.3658 9.2125 15.3658 6.80625C15.3658 6.49688 15.3314 6.1875 15.2626 5.87813C15.1595 5.46563 14.747 5.225 14.3345 5.29375Z" fill=""/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-gray-900 dark:text-white">
                        {{ number_format($stats['products'] ?? 2450, 0) }}
                    </h4>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">สินค้าทั้งหมด</span>
                </div>

                <span class="flex items-center gap-1 text-sm font-medium text-green-500">
                    2.59%
                    <svg class="fill-current" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""/>
                    </svg>
                </span>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-purple-50 dark:bg-purple-900">
                <svg class="fill-purple-500 dark:fill-purple-400" width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.18418 8.03751C9.31543 8.03751 11.0686 6.35313 11.0686 4.25626C11.0686 2.15938 9.31543 0.475006 7.18418 0.475006C5.05293 0.475006 3.2998 2.15938 3.2998 4.25626C3.2998 6.35313 5.05293 8.03751 7.18418 8.03751ZM7.18418 2.05626C8.45605 2.05626 9.52168 3.05313 9.52168 4.29063C9.52168 5.52813 8.49043 6.52501 7.18418 6.52501C5.87793 6.52501 4.84668 5.52813 4.84668 4.29063C4.84668 3.05313 5.9123 2.05626 7.18418 2.05626Z" fill=""/>
                    <path d="M15.8124 9.6875C17.6687 9.6875 19.1468 8.24375 19.1468 6.42188C19.1468 4.6 17.6343 3.15625 15.8124 3.15625C13.9905 3.15625 12.478 4.6 12.478 6.42188C12.478 8.24375 13.9905 9.6875 15.8124 9.6875ZM15.8124 4.7375C16.8093 4.7375 17.5999 5.49375 17.5999 6.45625C17.5999 7.41875 16.8093 8.175 15.8124 8.175C14.8155 8.175 14.0249 7.41875 14.0249 6.45625C14.0249 5.49375 14.8155 4.7375 15.8124 4.7375Z" fill=""/>
                    <path d="M15.9843 10.0313H15.6749C14.6437 10.0313 13.6468 10.3406 12.7874 10.8563C11.8593 9.61876 10.3812 8.79376 8.73115 8.79376H5.67178C2.85303 8.82814 0.618652 11.0625 0.618652 13.8469V16.3219C0.618652 16.975 1.13428 17.4906 1.78741 17.4906H20.2468C20.8999 17.4906 21.4499 16.9406 21.4499 16.2875V15.4625C21.4155 12.4719 18.9749 10.0313 15.9843 10.0313ZM2.16553 15.9438V13.8469C2.16553 11.9219 3.74678 10.3406 5.67178 10.3406H8.73115C10.6562 10.3406 12.2374 11.9219 12.2374 13.8469V15.9438H2.16553V15.9438ZM19.8687 15.9438H13.7499V13.8469C13.7499 13.2969 13.6468 12.7469 13.4749 12.2313C14.0937 11.7844 14.8499 11.5781 15.6405 11.5781H15.9499C18.0812 11.5781 19.8343 13.3313 19.8343 15.4625V15.9438H19.8687Z" fill=""/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-gray-900 dark:text-white">
                        {{ number_format($stats['users'] ?? 3456, 0) }}
                    </h4>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">ผู้ใช้ระบบ</span>
                </div>

                <span class="flex items-center gap-1 text-sm font-medium text-red-500">
                    0.95%
                    <svg class="fill-current rotate-180" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.35716 2.47737L0.908974 5.82987L5.0443e-07 4.94612L5 0.0848689L10 4.94612L9.09103 5.82987L5.64284 2.47737L5.64284 10.0849L4.35716 10.0849L4.35716 2.47737Z" fill=""/>
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <!-- Chart and Activity -->
    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">
        <div class="col-span-12 xl:col-span-8">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-4 flex items-center justify-between">
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">
                        ภาพรวมยอดขาย
                    </h4>
                </div>

                <div>
                    <div class="flex h-[350px] items-end justify-center gap-2 p-4">
                        @for ($i = 0; $i < 12; $i++)
                            <div class="flex w-full flex-col items-center gap-1">
                                <div
                                    class="w-full rounded-t bg-brand-500 dark:bg-brand-400"
                                    style="height: {{ rand(20, 100) }}%"
                                ></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">{{ ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'][$i] }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 xl:col-span-4">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h4 class="mb-6 text-xl font-bold text-gray-900 dark:text-white">
                    กิจกรรมล่าสุด
                </h4>

                <div class="space-y-4">
                    @foreach($activities ?? [] as $activity)
                    <div class="flex items-start gap-3 border-b border-gray-200 pb-4 last:border-0 dark:border-gray-800">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-900">
                            <span class="text-xs font-semibold text-brand-500">{{ substr($activity['user'] ?? 'U', 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900 dark:text-white">{{ $activity['action'] ?? 'กิจกรรม' }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $activity['time'] ?? 'เมื่อสักครู่' }}</p>
                        </div>
                    </div>
                    @endforeach

                    @if(empty($activities))
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-600 dark:text-gray-400">ยังไม่มีกิจกรรม</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
