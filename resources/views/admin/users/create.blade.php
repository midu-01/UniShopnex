@extends('layouts.dashboard')

@section('title', 'Create User')

@section('content')
    <x-ui.page-header title="Create User" description="Assign a role and optionally create a vendor store automatically." />
    @include('admin.users.partials.form', ['action' => route('admin.users.store'), 'method' => 'POST', 'user' => $user])
@endsection
