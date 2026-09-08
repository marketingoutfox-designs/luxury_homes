@extends('admin.layout')
@section('title', 'Add Service')
@section('heading', 'Add Service')
@section('subheading', 'Create a new service offering.')
@section('content')
<div class="admin-card">
    @include('admin.services.form', ['service' => null, 'action' => route('admin.services.store'), 'method' => 'post'])
</div>
@endsection
