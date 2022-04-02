@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Programme Table <div style="float: right;"><a href="/programmes/create"><button class="btn btn-success">Create</button></a></div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Create Programme Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('editSuccess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Edit Programme Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('deleteSuccess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Delete Programme Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Category</th>
                                <th scope="col">Name</th>
                                <th scope="col">Year 1 Required CGPA</th>
                                <th scope="col">Year 3 Required CGPA</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programmeList as $programmeList1)
                            <tr>
                                <td>{{ $programmeList1->category }}</td>
                                <td>{{ $programmeList1->name }}</td>
                                <td>{{ $programmeList1->year1RequiredCgpa }}</td>
                                <td>{{ $programmeList1->year3RequiredCgpa }}</td>
                                <td><button class="btn btn-primary" onclick="window.location.href='/programmeEdit?id={{ $programmeList1->id }}'">Edit</button></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection