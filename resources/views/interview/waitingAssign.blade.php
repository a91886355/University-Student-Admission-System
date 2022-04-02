@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                   Interview Management <div style="float: right;"><a href="/timeSlotCreate"><button class="btn btn-success">Create</button></a></div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           Add Interview Time Period Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="/interviewManage">Interview Time Peroid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/waitingAssign">Waiting Arrange</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/interviewChange">Change Time Request</a>
                        </li>
                    </ul>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Programme</th>
                                <th scope="col">Require intervews</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if($waitingList != NULL)
                            @foreach($waitingList as $waitingList1)
                            <tr>
                                <td>{{ $waitingList1->appliedProgramme }}</td>
                                <td>{{ $waitingList1->number }}</td>
                            </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                        @if($waitingList == NULL)
                            <div style="text-align:center;">No Any Application Waiting Assign Interview</div>
                        @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection