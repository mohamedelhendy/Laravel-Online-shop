@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h2>Show Category</h2>
                <label>Name</label>
                <h3>{{ $category->name }}</h3>
                <img src="{{ asset('storage/' . $category->image) }}" />
                <a class="btn btn-secondary" href="{{ url('admin/categories') }}">Back</a>
            </div>
        </section>
    @endsection
