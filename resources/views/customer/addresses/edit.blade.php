@extends('layouts.dashboard')

@section('title', 'Edit Address')

@section('content')
    <x-ui.page-header title="Edit Address" description="Update and persist a customer address record." />
    @include('customer.addresses.partials.form', ['action' => route('customer.addresses.update', $address), 'method' => 'PATCH', 'address' => $address])
@endsection
