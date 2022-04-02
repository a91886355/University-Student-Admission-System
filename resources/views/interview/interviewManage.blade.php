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
                            <a class="nav-link active" href="/interviewManage">Interview Time Peroid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/waitingAssign">Waiting Arrange</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/interviewChange">Change Time Request</a>
                        </li>
                    </ul>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Programme</th>
                                <th scope="col">Interview Date(D/M/Y)</th>
                                <th scope="col">Interview Time Period</th>
                                <th scope="col">Timeslot</th>
                                <th scope="col">Venue</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if($interview != NULL)
                            @foreach($interview as $interview1)
                            <tr>
                                <td>{{ $interview1->name }}</td>
                                <td>{{ date('d/m/Y', strtotime($interview1->interviewDate)) }}</td>
                                <td>{{ $interview1->timePeriod }}</td>
                                <td>{{ $interview1->timeSlot }} Mins</td>
                                <td>{{ $interview1->interviewVenue }}</td>
                                <td><a href="/interviewPeriodDetails?interviewTimePeriodId={{ $interview1->timePeriodId }}"><button class="btn btn-primary">View</button><a></td>
                            </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                        @if($interview == NULL)
                            <div style="text-align:center;">No Any Interview Period</div>
                        @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection