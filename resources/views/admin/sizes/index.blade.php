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
                        <h1 class="m-0">Sizes</h1>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizes as $size)
                                    <tr>
                                        <td>{{ $size['id'] }}</td>
                                        <td><a href="{{url('admin/sizes/'.$size['id'])}}"><u>{{ $size['name'] }}</u></a></td>
                                        <td scope="col">
                                            <a class="btn btn-success" href="{{url('admin/sizes/'.$size['id'].'/edit')}}">
                                                <h6 class="fa fa-pen text-white"></h6>
                                            </a>
                                        </td>
                                        <td scope="col">
                                            <form action="{{url('admin/sizes/'.$size['id'])}}" method="post">
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
                        {!! $sizes->links() !!}
                        <a class = "btn btn-success" href="{{url('admin/sizes/create')}}">Add Size</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
