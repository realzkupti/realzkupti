@extends('layouts.dashboard')

@section('title', 'Dashboard - TailAdmin Template')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
</div>

<div class="card">
    <h2 class="card-title">Welcome to TailAdmin Template</h2>
    <p>This is a modern Laravel admin template with JavaScript-based authentication.</p>

    <div style="margin-top: 20px; padding: 20px; background: #F1F5F9; border-radius: 8px;">
        <h3 style="font-weight: 600; margin-bottom: 12px;">Features:</h3>
        <ul style="list-style: disc; margin-left: 20px; line-height: 2;">
            <li>JavaScript/AJAX-based authentication (no traditional PHP POST)</li>
            <li>Support for all Laravel-compatible databases (MySQL, PostgreSQL, SQLite, SQL Server)</li>
            <li>MVC architecture</li>
            <li>Modern and clean UI with TailAdmin design</li>
            <li>Easy to debug and extend</li>
        </ul>
    </div>
</div>

<div class="card">
    <h2 class="card-title">Quick Stats</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 16px;">
        <div style="padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; color: white;">
            <h3 style="font-size: 14px; opacity: 0.9;">Total Users</h3>
            <p style="font-size: 32px; font-weight: 700; margin-top: 8px;">1</p>
        </div>
        <div style="padding: 20px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 8px; color: white;">
            <h3 style="font-size: 14px; opacity: 0.9;">Active Sessions</h3>
            <p style="font-size: 32px; font-weight: 700; margin-top: 8px;">1</p>
        </div>
        <div style="padding: 20px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 8px; color: white;">
            <h3 style="font-size: 14px; opacity: 0.9;">Database</h3>
            <p style="font-size: 20px; font-weight: 700; margin-top: 8px;">{{ config('database.default') }}</p>
        </div>
    </div>
</div>
@endsection
