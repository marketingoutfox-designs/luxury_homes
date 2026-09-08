@extends('admin.layout')
@section('title', 'Edit Service')
@section('heading', 'Edit Service')
@section('subheading', 'Update service details and visibility.')
@section('content')
<div class="admin-card">
    @include('admin.services.form', ['service' => $service, 'action' => route('admin.services.update', $service), 'method' => 'put'])
</div>
@endsection
