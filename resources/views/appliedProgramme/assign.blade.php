@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                   Interview Management
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           Assign Interview Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link @if( $count['nav'] == 'false') active @endif" href="/assign?officerAssigned=false">Assign Interview</a> <!--({{ $count["unassigned"] }}) -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if( $count['nav'] == 'true') active @endif" href="/assign?officerAssigned=true">Interview Status</a> <!--({{ $count["assigned"] }}) -->
                        </li>
                    </ul>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Application No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Applied Programme</th>
                                <th scope="col">Applied Year</th>
                                @if($appliedProgramme != NULL)
                                    @if($appliedProgramme[0]->officerAssigned == "false")
                                    <th scope="col">Action</th>
                                    @else
                                    <th scope="col">Accepted</th>
                                    <th scope="col">Remind</th>
                                    @endif
                                @else
                                    <th scope="col">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if($appliedProgramme != NULL)
                            @foreach($appliedProgramme as $appliedProgramme1)
                            <tr>
                                <th scope="row">U<script>document.write(new Date().getFullYear())</script>-{{ $appliedProgramme1->applicationID }}</th>
                                <td>{{ $appliedProgramme1->englishName }}</td>
                                <td>{{ $appliedProgramme1->appliedProgramme }}</td>
                                <td>Year {{ $appliedProgramme1->appliedYear }}</td>
                                @if($appliedProgramme1->officerAssigned == "false")
                                    <td><button class="btn btn-primary" style="width:100px" data-toggle="modal" data-target="#assignModal{{ $appliedProgramme1->PID }}">Assign</button></td>
                                @else
                                    <td>{{ $appliedProgramme1->userAccepted }}</td>
                                    @if($appliedProgramme1->userAccepted != "Requesting")
                                        <td><button class="btn btn-secondary" style="width:100px" disabled>Remind</button></td>
                                    @else
                                        <td><button class="btn btn-primary" style="width:100px" data-toggle="modal" data-target="#remindModal{{ $appliedProgramme1->PID }}">Remind</button></td>
                                    @endif
                                @endif
                            </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                        @if($appliedProgramme == NULL)
                            <div style="text-align:center;">No Any Approved Application</div>
                        @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assign Modal -->
@if($appliedProgramme != NULL)
    @foreach($appliedProgramme as $appliedProgramme2)
        <div class="modal fade" id="assignModal{{ $appliedProgramme2->PID }}" tabindex="-1" role="dialog" aria-labelledby="assignModal{{ $appliedProgramme2->PID }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignModal{{ $appliedProgramme2->PID }}Label">Assign Interview Time</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Name: {{ $appliedProgramme2->englishName }}<br>
                        Apply Programme: {{ $appliedProgramme2->appliedProgramme }}<br>
                        Apply Year: Year {{ $appliedProgramme2->appliedYear }}<br><br>
                
            
                    
                    
                        <form action="{{ route('interviews.store') }}" method="post" >
                            @csrf

                        <input type="hidden" class="form-control" id="appliedProgrammeId" name="appliedProgrammeId" value="{{ $appliedProgramme2->PID }}">
                        <input type="hidden" class="form-control" id="email" name="email" value="{{ $appliedProgramme2->email }}" required>
                        <input type="hidden" class="form-control" id="subject" name="subject" value="{{ $appliedProgramme2->appliedProgramme }} Interview Request" required>

                        <div class="form-group required">
                            <label class="control-label" for="dateOfInterview">Date of the Interview</label>
                            <input type="date" class="form-control" id="dateOfInterview" name="dateOfInterview" required>
                        </div>

                        <div class="form-group required">
                            <label class="control-label" for="timeOfInterview">Time of the Interview</label>
                            <input type="time" class="form-control" id="timeOfInterview" name="timeOfInterview" required>
                        </div>

                        <div class="form-group required">
                            <label class="control-label" for="venue">Venue</label>
                            <input type="text" class="form-control" id="interviewVenue" name="interviewVenue" required>
                        </div>
                            <div style="text-align: right;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- Remind Modal -->
        <div class="modal fade" id="remindModal{{ $appliedProgramme2->PID }}" tabindex="-1" role="dialog" aria-labelledby="remindModal{{ $appliedProgramme2->PID }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="remindModal{{ $appliedProgramme2->PID }}Label">Send Remind Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('send.email') }}"  method="post">
                                            @csrf

                            <div class="form-group required">
                                <label class="control-label" for="email">To: </label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ $appliedProgramme2->email }}" required>
                            </div>

                            <div class="form-group required">
                                <label class="control-label" for="subject">Subject: </label>
                                <input type="text" class="form-control" id="subject" name="subject" value="Remind: {{ $appliedProgramme2->appliedProgramme }} Interview Request" required>
                            </div>

                            <div class="form-group required">
                            <label class="control-label" for="email">Message: </label>
                            <textarea class="form-control" id="content" name="content" placeholder="Message" rows="15" cols="50">
Dear {{ $appliedProgramme2->englishName }},<br>
<br>
Your {{ $appliedProgramme2->appliedProgramme }} Interview Request is waiting for accept or reject.<br>
<br>
Details of Interview:<br>
Name: {{ $appliedProgramme2->englishName }}<br>
Apply Programme: {{ $appliedProgramme2->appliedProgramme }}<br>
Apply Year: Year {{ $appliedProgramme2->appliedYear }}<br>
Interview Date: {{ $appliedProgramme2->interviewDate }}<br>
Interview Time: {{ $appliedProgramme2->interviewTime }}<br>
Interview Venue: {{ $appliedProgramme2->interviewVenue }}<br>
<br>
Please reply as soon as possible.<br>
<br>
University Officer
                            </textarea>
                            </div>

                            
                            <button type="submit" class="btn btn-primary">Send</button>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

@endsection