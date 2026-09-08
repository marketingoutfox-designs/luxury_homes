@extends('admin.layout')
@section('title', 'Add Project')
@section('heading', 'Add Project')
@section('subheading', 'Create a new portfolio project and publish it when ready.')
@section('content')
<div class="admin-card">
    @include('admin.projects.form', ['project' => null, 'action' => route('admin.projects.store'), 'method' => 'post'])
</div>
@endsection
