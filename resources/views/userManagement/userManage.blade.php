@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    User Management <div style="float: right;"><a href="/createOfficer"><button class="btn btn-success">Create Officer Account</button></a></div>
                </div>
                <div class="card-body">
                    @if (session('deleteSuccess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Delete Account Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session('success')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link @if( $count['nav'] =='officer') active @endif" href="/userManage">Officer({{ $count["officer"] }})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if( $count['nav'] =='user') active @endif" href="/userManage?userAccount=user">User({{ $count["user"] }})</a>
                        </li>
                    </ul>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userList as $userList1)
                            <tr>
                                <th scope="row">{{ $userList1->id }}</th>
                                <td>{{ $userList1->name }}</td>
                                <td>{{ $userList1->email }}</td>
                                <td>
                                    <button class="btn btn-danger" style="width:150px"  data-toggle="modal" data-target="#deleteModal{{ $userList1->id }}">Delete</button><br> 
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if($userList != NULL)
    @foreach($userList as $userList1)
        <div class="modal fade" id="deleteModal{{ $userList1->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $userList1->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal{{ $userList1->id }}Label" style="text-align:center">Warning</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you confirm to delete this account?<br><br>

                        Account Details:<br>
                        ID: {{ $userList1->id }}<br>
                        Name: {{ $userList1->name }}<br>
                        Email: {{ $userList1->email }}<br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <form action="{{ route('userManagement.destroy',[$userList1->id]) }}" method="post" >
                            @csrf
                            @method('delete')

                            <input type="hidden"  id="userId" name="userId" value="{{$userList1->id}}">
                            <button type="submit" class="btn btn-danger">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endif

@endsection