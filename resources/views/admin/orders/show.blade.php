@extends('layouts.adminMain')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h2>Show Order</h2>
                <div class="row px-xl-5">
                    <div class="col-lg-4">
                        <div class="bg-light p-30 mb-5">
                            <table >
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
                                    <td><label>{{ $order['status'] }}</label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="margin-left: 10%" class="col-lg-4">
                        <h1 class="m-0">products</h1>
                        <br>
                        <table class="table table-bordered">
                            <th>Id</th>
                            <th>name</th>
                            <th>Image</th>
                            <th>price</th>
                            <th>quantity</th>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product['id'] }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td><img src="{{asset('storage/' . $product['image'])}}" width="100px"></td>
                                <td>{{ $product['price'] -$product['price']*$product['discount']}}</td>
                                <td>{{ $product['quantity'] }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                </div>

                <a class="btn btn-secondary" href="{{ url('admin/orders') }}">Back</a>
            </div>
        </section>
    @endsection
