@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
    <x-ui.page-header title="Edit User" description="Update role and account metadata." />
    @include('admin.users.partials.form', ['action' => route('admin.users.update', $user), 'method' => 'PATCH', 'user' => $user])
@endsection
