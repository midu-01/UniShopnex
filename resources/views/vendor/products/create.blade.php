@extends('layouts.dashboard')

@section('title', 'Create Product')

@section('content')
    <x-ui.page-header title="Create Product" description="Add a product to your vendor catalog." />
    @include('vendor.products._form', ['action' => route('vendor.products.store'), 'method' => 'POST'])
@endsection
