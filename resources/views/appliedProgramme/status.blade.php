@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Application Status
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           {{ session('userAccepted') }} Interview Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('change'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           Send Change Time Request Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Rank</th>
                                <th scope="col">Applied Programme</th>
                                <th scope="col">Applied Year</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appliedProgramme as $appliedProgramme1)
                            <tr>
                                <th scope="row">{{ $appliedProgramme1->rank }}</th>
                                <td>{{ $appliedProgramme1->appliedProgramme }}</td>
                                <td>Year {{ $appliedProgramme1->appliedYear }}</td>
                                <td>{{ $appliedProgramme1->status }}</td>
                                
                                @if ($appliedProgramme1->status == "Processing" || $appliedProgramme1->status == "Rejected" )
                                    <td><button class="btn btn-secondary" style="width:160px" disabled>No Action</button>
                                @elseif ($appliedProgramme1->autoAssigned == "false")
                                    <td><button class="btn btn-secondary" style="width:160px" disabled>Arranging Interview</button>
                                @elseif ($appliedProgramme1->status == "Approved")
                                        <td>
                                            @if($appliedProgramme1->userAccepted == "Requesting")
                                                <button class="btn btn-primary" style="width:160px"  data-toggle="modal" data-target="#interviewModal{{ $appliedProgramme1->appliedProgrammeId }}">Interview Detail</button><br>
                                                <button class="btn btn-success" style="width:160px" data-toggle="modal" data-target="#acceptModal{{ $appliedProgramme1->appliedProgrammeId }}">Accept Interview</button><br>
                                                <button class="btn btn-danger" style="width:160px" data-toggle="modal" data-target="#rejectModal{{ $appliedProgramme1->appliedProgrammeId }}">Reject Interview</button>
                                                @if($appliedProgramme1->autoAssigned != "true" OR $appliedProgramme1->changingTime != "true")
                                                <br><button class="btn btn-primary" style="width:160px" data-toggle="modal" data-target="#changeModal{{ $appliedProgramme1->appliedProgrammeId }}">Change Time</button>
                                                @endif
                                            @elseif($appliedProgramme1->userAccepted == "Accepted")
                                                <button class="btn btn-primary" style="width:160px"  data-toggle="modal" data-target="#interviewModal{{ $appliedProgramme1->appliedProgrammeId }}">Interview Detail</button><br>
                                                <br><button class="btn btn-success" style="width:160px" disabled>Accepted Interview</button>
                                            @else
                                                <button class="btn btn-danger" style="width:160px" disabled>Rejected Interview</button>
                                            @endif
                                        </td>
                                @endif
                            </tr>
                            @endforeach           
                        </tbody>
                    </table>

                    @if($appliedProgramme == NULL)
                        <div style="text-align:center;">No Any Programme Application</div>
                    @endif

                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- InterviewDetail Modal -->
@if($appliedProgramme != NULL)
    @foreach($appliedProgramme as $appliedProgramme2)
        @if($appliedProgramme2->autoAssigned == "true" && $appliedProgramme2->interviewId != NULL )
        <div class="modal fade" id="interviewModal{{ $appliedProgramme2->appliedProgrammeId }}" tabindex="-1" role="dialog" aria-labelledby="interviewModal{{ $appliedProgramme2->appliedProgrammeId }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="interviewModal{{ $appliedProgramme2->appliedProgrammeId }}Label" style="text-align:center">The Detail of Interview Assigned</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        Name: {{ $appliedProgramme2->englishName }}<br>
                        Apply Programme: {{ $appliedProgramme2->appliedProgramme }}<br>
                        Apply Year: Year {{ $appliedProgramme2->appliedYear }}<br><br>
                        Interview Date: {{ $appliedProgramme2->interviewDate }}<br>
                        Interview Time: {{ $appliedProgramme2->interviewTime }}<br>
                        Interview Venue: {{ $appliedProgramme2->interviewVenue }}<br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<!-- Accept Modal -->
        <div class="modal fade" id="acceptModal{{ $appliedProgramme2->appliedProgrammeId }}" tabindex="-1" role="dialog" aria-labelledby="acceptModal{{ $appliedProgramme2->appliedProgrammeId }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="acceptModal{{ $appliedProgramme2->appliedProgrammeId }}Label">Precaution</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you confirm to accept this interview?<br>

                        Name: {{ $appliedProgramme2->englishName }}<br>
                        Apply Programme: {{ $appliedProgramme2->appliedProgramme }}<br>
                        Apply Year: Year {{ $appliedProgramme2->appliedYear }}<br><br>
                        Interview Date: {{ $appliedProgramme2->interviewDate }}<br>
                        Interview Time: {{ $appliedProgramme2->interviewTime }}<br>
                        Interview Venue: {{ $appliedProgramme2->interviewVenue }}<br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <form action="{{ route('interviews.update', [$appliedProgramme2->interviewId]) }}" method="post" >
                            @csrf
                            @method('put')

                            <input type="hidden"  id="userAccepted" name="userAccepted" value="Accepted">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- Reject Modal -->
        <div class="modal fade" id="rejectModal{{ $appliedProgramme2->appliedProgrammeId }}" tabindex="-1" role="dialog" aria-labelledby="rejectModal{{ $appliedProgramme2->appliedProgrammeId }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModal{{ $appliedProgramme2->appliedProgrammeId }}Label">Precaution</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you confirm to reject this interview?<br>

                        Name: {{ $appliedProgramme2->englishName }}<br>
                        Apply Programme: {{ $appliedProgramme2->appliedProgramme }}<br>
                        Apply Year: Year {{ $appliedProgramme2->appliedYear }}<br><br>
                        Interview Date: {{ $appliedProgramme2->interviewDate }}<br>
                        Interview Time: {{ $appliedProgramme2->interviewTime }}<br>
                        Interview Venue: {{ $appliedProgramme2->interviewVenue }}<br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <form action="{{ route('interviews.update', [$appliedProgramme2->interviewId]) }}" method="post" >
                            @csrf
                            @method('put')

                            <input type="hidden"  id="userAccepted" name="userAccepted" value="Rejected">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- Change Modal -->
    @if($appliedProgramme2->autoAssigned != "true" OR $appliedProgramme2->changingTime != "true")
<div class="modal fade" id="changeModal{{ $appliedProgramme2->appliedProgrammeId }}" tabindex="-1" role="dialog" aria-labelledby="changeModal{{ $appliedProgramme2->appliedProgrammeId }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeModal{{ $appliedProgramme2->appliedProgrammeId }}Label">Precaution</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you confirm to send a request for changing interview time?<br>
                        <br>
                        <strong>Attendion:<br>
                        1. Every programme application only have ONE chance to send interview time request.<br>
                        2. If interview time period of applied programme is not empty, new interview time may not be assigned.<br>
                        </strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <form action="{{ route('appliedProgrammes.update', [$appliedProgramme2->appliedProgrammeId]) }}" method="post" >
                            @csrf
                            @method('put')

                            <input type="hidden"  id="changingTimeConfirm" name="changingTimeConfirm" value="true">
                            <input type="hidden"  id="changingTime" name="changingTime" value="true">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
        @endif
    @endforeach
@endif

@endsection