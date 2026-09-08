@extends('admin.layout')
@section('title', 'Edit Content Block')
@section('heading', 'Edit Content Block')
@section('subheading', 'Update this content block safely.')
@section('content')
<div class="admin-card">
    @include('admin.contents.form', ['content' => $content, 'action' => route('admin.contents.update', $content), 'method' => 'put'])
</div>
@endsection
