@extends('adminlte::page')

@section('title', 'View User')

@section('content_header')
    <h1>View User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Details</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Created At:</strong> {{ $user->created_at }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@stop
