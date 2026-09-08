@extends('admin.layout')
@section('title', 'Add Project Category')
@section('heading', 'Add Project Category')
@section('subheading', 'Create a new category for organizing projects.')
@section('content')
<div class="admin-card">
    @include('admin.categories.form', ['category' => null, 'action' => route('admin.categories.store'), 'method' => 'post'])
</div>
@endsection
