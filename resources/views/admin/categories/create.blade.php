@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Category</h1>
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ url('admin/categories') }}" enctype ="multipart/form-data">
                    @csrf
                        <div class="col-md-6 form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Image</label>
                            <input type="file" name="image">
                            @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                            <button class="btn btn-success">Add</button>
                    <a class="btn btn-secondary" >Cancel</a>
                </form>
            </div>
        </section>
    </div>
@endsection
