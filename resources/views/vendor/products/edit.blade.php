@extends('layouts.dashboard')

@section('title', 'Edit Product')

@section('content')
    <x-ui.page-header title="Edit Product" description="Update pricing, stock, publishing, and media." />
    @include('vendor.products._form', ['action' => route('vendor.products.update', $product), 'method' => 'PATCH'])
@endsection
