@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">edit color</h1>
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ url('admin/colors/'.$color->id) }}">
                    @csrf
                    @method('PUT')
                        <div class="col-md-6 form-group">
                        <label>Color Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name',$color->name)}}">
                        </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-success">edit</button>
                    <a class="btn btn-secondary" href="{{ url('admin/colors') }}">Cancel</a>
                </form>
            </div>
        </section>
    </div>
@endsection
