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
                        <h1 class="m-0">users</h1>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>email</th>
                                    <th>e-mail verified</th>
                                    <th>created</th>
                                    <th>Admin</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user['id'] }}</td>
                                        <td>{{ $user['name'] }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>{{ ($user['email_verified_at'])?"yes":"no" }}</td>
                                        <td>{{ $user['created_at'] }}</td>
                                        <td>{{ ($user['is_admin'])?"yes":"no" }}</td>
                                        
                                        <td scope="col">
                                            <a class="btn btn-success" href="{{url('admin/users/setAdmin/'.$user['id'])}}">
                                                <h6>Set Admin</h6>
                                            </a>
                                        </td>
                                        <td scope="col">
                                            <form action="{{url('admin/users/'.$user['id'])}}" method="post">
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
                        {!! $users->links() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
