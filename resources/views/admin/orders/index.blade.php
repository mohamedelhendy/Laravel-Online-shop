@extends('layouts.adminMain')
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
                @if ($message=Session::get('success'))
                    <div class="alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <strong>{{$message}}</strong>
                    </div>
                    
                @endif
                <div class="row">
                    <div class="col-12">
                        <h1 class="m-0">Orders</h1>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>country</th>
                                    <th>address</th>
                                    <th>mobile</th>
                                    <th>total</th>
                                    <th>payment</th>
                                    <th>ordered at</th>
                                    <th>status</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order['id'] }}</td>
                                        <td><a href="{{url('admin/orders/'.$order['id'])}}"><u>{{ $order['first_name'] }} {{ $order['last_name'] }}</u></a></td>
                                        <td>{{ $order['country'] }}</td>
                                        <td>{{ $order['address1'] }}</td>
                                        <td>{{ $order['mobile'] }}</td>
                                        <td>{{ $order['total'] }}</td>
                                        <td>{{ $order['payment'] }}</td>
                                        <td>{{ $order['created_at'] }}</td>
                                        <td>{{ $order['status'] }}</td>
                                        <td scope="col">
                                            <a class="btn btn-success" href="{{url('admin/orders/'.$order['id'].'/edit')}}">
                                                <h6>Edit status/products</h6></a>
                                        </td>
                                        <td scope="col">
                                            <form action="{{url('admin/orders/'.$order['id'])}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" onclick="return confirm('Are you sure ?');">
                                                    <h6 class="fa fa-trash text-white"></h6>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $orders->links() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
