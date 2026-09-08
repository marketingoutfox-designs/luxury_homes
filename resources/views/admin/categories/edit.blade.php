@extends('admin.layout')
@section('title', 'Edit Project Category')
@section('heading', 'Edit Project Category')
@section('subheading', 'Update category name, slug, visibility, and ordering.')
@section('content')
<div class="admin-card">
    @include('admin.categories.form', ['category' => $category, 'action' => route('admin.categories.update', $category), 'method' => 'put'])
</div>
@endsection
