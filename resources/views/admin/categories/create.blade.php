@extends('layouts.dashboard')

@section('title', 'Create Category')

@section('content')
    <x-ui.page-header title="Create Category" description="Add a new storefront category." />
    @include('admin.categories.partials.form', ['action' => route('admin.categories.store'), 'method' => 'POST', 'category' => $category, 'parents' => $parents])
@endsection
