@extends('layouts.app')

@section('content')
<div style="text-align:center"><button class="btn btn-primary" onclick="history.back()">Go Back to Inteview Management</button></div><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                   Details of Interviews Period
                </div>
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Interview Date</th>
                                <th scope="col">Interview Time</th>
                                <th scope="col">User Accepted</th>
                                <th scope="col">Applicant</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if($interviewDetail != NULL)
                            @foreach($interviewDetail as $interviewDetail1)
                            <tr>
                                <td>{{ $interviewDetail1->interviewDate }}</td>
                                <td>{{ $interviewDetail1->interviewTime }}</td>
                                @if($interviewDetail1->userAccepted == NULL)
                                    <td>N.A.</td>
                                @elseif($interviewDetail1->userAccepted == "Requesting")
                                    <td>Requesting</td>
                                @else
                                    <td>Accepted</td>
                                @endif()

                                @if($interviewDetail1->appliedProgrammeId != NULL)
                                    <td><a href="/detail?id={{ $interviewDetail1->applicationID }}">{{ $interviewDetail1->user_id }}</a></td>
                                @else
                                    <td>Empty</td>
                                @endif
                            </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                        @if($interviewDetail == NULL)
                            <div style="text-align:center;">No Any Interview Period</div>
                        @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection