@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Product</h1>
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="{{ url('admin/products/'.$product->id) }}"enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="container-fluid">
                        <div class="row px-xl-5">
                            <div class="bg-light p-30 mb-5">
                                <div class="row">
                                    @csrf
                                    <div class="col-md-6 form-group">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $product->name) }}">
                                    </div>
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-md-6 form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Price</label>
                                        <input class="form-control" name="price" type="number"
                                            value="{{ old('price', $product->price) }}" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Discount</label>
                                        <input class="form-control" name="discount" type="number"
                                            value="{{ old('discout', $product->discount) }}" step="0.01" />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Is Recent <input name="is_recent" type="checkbox"
                                                {{ old('is_recent', $product->is_recent) ? 'checked' : '' }} /></label>
                                        <br />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Is Featured <input name="is_featured" type="checkbox"
                                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} /></label>
                                        <br />
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Image</label>
                                        <input type="file" name="image"value="{{ old('image') }}">
                                        @error('image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category_id">
                                            <option>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category['id'] ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Color</label>
                                        <select class="form-control" name="color_id">
                                            <option>Select Color</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}"
                                                    {{ old('color_id', $product->color_id) == $color['id'] ? 'selected' : '' }}>
                                                    {{ $color->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Size</label>
                                        <select class="form-control" name="size_id">
                                            <option>Select Size</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}"
                                                    {{ old('size_id', $product->size_id) == $size['id'] ? 'selected' : '' }}>
                                                    {{ $size->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-success">Edit</button>
                                    <a class="btn btn-secondary" href="{{ url('admin/products') }}">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
