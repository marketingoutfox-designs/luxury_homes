@extends('admin.layout')
@section('title', 'Edit Project')
@section('heading', 'Edit Project')
@section('subheading', 'Update project content, category, images, and visibility.')
@section('content')
<div class="admin-card">
    @include('admin.projects.form', ['project' => $project, 'action' => route('admin.projects.update', $project), 'method' => 'put'])
</div>
@endsection
