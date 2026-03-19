@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('content')
    <x-ui.page-header title="Edit Category" description="Update category details and hierarchy." />
    @include('admin.categories.partials.form', ['action' => route('admin.categories.update', $category), 'method' => 'PATCH', 'category' => $category, 'parents' => $parents])
@endsection
