@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h2>Show Size</h2>
                <label>Name</label>
                <h3>{{ $size->name }}</h3>
                <a class="btn btn-secondary" href="{{ url('admin/sizes') }}">Back</a>
            </div>
        </section>
    @endsection
