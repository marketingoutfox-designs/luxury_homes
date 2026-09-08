@extends('admin.layout')
@section('title', 'Add Content Block')
@section('heading', 'Add Content Block')
@section('subheading', 'Create a new editable text block or setting.')
@section('content')
<div class="admin-card">
    @include('admin.contents.form', ['content' => null, 'action' => route('admin.contents.store'), 'method' => 'post'])
</div>
@endsection
