@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h2>Show Color</h2>
                <label>Name</label>
                <h3>{{ $color->name }}</h3>
                <a class="btn btn-secondary" href="{{ url('admin/colors') }}">Back</a>
            </div>
        </section>
    @endsection
