@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h2>Show Order</h2>
                <div class="row px-xl-5">
                    <div class="col-lg-4">
                        <div class="bg-light p-30 mb-5">
                            <table>
                                <tr>
                                    <td><label>Id:</label></td>
                                    <td><label>{{ $order['id'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>Name:</label></td>
                                    <td><label>{{ $order['first_name'] }} {{ $order['last_name'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>order Date:</label></td>
                                    <td><label>{{ $order['created_at'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>country:</label></td>
                                    <td><label>{{ $order['country'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>state:</label></td>
                                    <td><label>{{ $order['state'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>city:</label></td>
                                    <td><label>{{ $order['city'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>address1:</label></td>
                                    <td><label>{{ $order['address1'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>address2:</label></td>
                                    <td><label>{{ $order['address2'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>zip_code:</label></td>
                                    <td><label>{{ $order['zip_code'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>mobile:</label></td>
                                    <td><label>{{ $order['mobile'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>Email:</label></td>
                                    <td><label>{{ $order['email'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>total:</label></td>
                                    <td><label>{{ $order['total'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>payment:</label></td>
                                    <td><label>{{ $order['payment'] }}</label></td>
                                </tr>
                                <tr>
                                    <td><label>status:</label></td>
                                    <td>
                                        <form method="POST" action="{{ url('admin/orders/' . $order['id']) }}">
                                            @method('PUT')
                                            @csrf
                                            <select class="form-control" name="status" value="{{ old('status') }}">
                                                <option selected>{{ $order['status'] }}</option>
                                                <option>not delivered</option>
                                                <option>shipped</option>
                                                <option>delivered</option>
                                            </select>
                                    </td>
                                </tr>
                            </table>
                            <button class="btn btn-success">Apply</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h1 class="m-0">products</h1>
                        <br>
                        <table class="table table-bordered">
                            <th>Id</th>
                            <th>name</th>
                            <th>Image</th>
                            <th>price</th>
                            <th>quantity</th>
                            <th colspan="1">Actions</th>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product['id'] }}</td>
                                    <td>{{ $product['name'] }}</td>
                                    <td><img src="{{ asset('storage/' . $product['image']) }}" width="100px"></td>
                                    <td>{{ $product['price'] - $product['price'] * $product['discount'] }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td scope="col">
                                        <form action="{{ url('admin/orders/deleteProduct/'.$order['id']) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <input type="text" name="product_id" value="{{$product['id']}}" hidden>
                                            <button class="btn btn-danger" onclick="return confirm('Are you sure ?');">
                                                <h6 class="fa fa-trash text-white"></h6>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <form action="{{ url('admin/orders/' . $order['id']) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger btn-block" onclick="return confirm('Are you sure ?');">
                                <h6>Delete order</h6>
                            </button>
                        </form>
                    </div>
                </div>
                <a class="btn btn-secondary" href="{{ url('admin/orders') }}">Back</a>
            </div>
        </section>
    @endsection
