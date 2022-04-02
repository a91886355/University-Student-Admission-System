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
                            Change Time Successful!
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
                            <a class="nav-link" href="/waitingAssign">Waiting Arrange</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  active" href="/interviewChange">Change Time Request</a>
                        </li>
                    </ul>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Application No.</th>
                                <th scope="col">Applicant ID</th>
                                <th scope="col">Applied Programme</th>
                                <th scope="col">Applied Year</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if($interviews != NULL)
                            @foreach($interviews as $interview)
                            <tr>
                                <th scope="row">U<script>document.write(new Date().getFullYear())</script>-{{ $interview->applicationID }}-{{ $interview->rank }}</th>
                                <td><a href="/detail?id={{ $interview->applicationID }}">{{ $interview->user_id }}</a></td>
                                <td>{{ $interview->appliedProgramme }}</td>
                                <td>{{ $interview->appliedYear }}</td>
                                <td><a href="/interviewChangeSelect/{{ $interview->appliedProgrammeId }}"><button class="btn btn-primary">Handle</button></a></td>
                            </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                        @if($interviews == NULL)
                            <div style="text-align:center;">No Any Interview Period</div>
                        @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection