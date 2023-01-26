@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h2>Show Product</h2>
                <label>Name</label>
                <h3>{{ $product->name }}</h3>
                <img src="{{ asset('storage/' . $product->image) }}" />
                <a class="btn btn-secondary" href="{{ url('admin/products') }}">Back</a>
            </div>
        </section>
    @endsection
