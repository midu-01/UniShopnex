@extends('layouts.dashboard')

@section('title', 'Add Address')

@section('content')
    <x-ui.page-header title="Add Address" description="Capture shipping or billing details with a dedicated form request." />
    @include('customer.addresses.partials.form', ['action' => route('customer.addresses.store'), 'method' => 'POST', 'address' => null])
@endsection
