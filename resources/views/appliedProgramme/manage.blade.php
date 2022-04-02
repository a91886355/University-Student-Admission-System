@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    Application Management
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           {{ session('status') }} Application Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link @if( $count['nav'] =='Processing') active @endif" href="/manage?filterStatus=Processing">Processing({{ $count["processing"] }})</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link @if( $count['nav'] =='Approved') active @endif" href="/manage?filterStatus=Approved">Approved({{ $count["approved"] }})</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link @if( $count['nav'] =='Rejected') active @endif" href="/manage?filterStatus=Rejected">Rejected({{ $count["rejected"] }})</a>
                        </li>
                    </ul>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Application No.</th>
                                <th scope="col">Applicant ID</th>
                                <th scope="col">Applied Programme</th>
                                <th scope="col">Applied Year</th>
                                <th scope="col">Status</th>
                                @if($appliedProgramme != NULL)
                                    @if ($appliedProgramme[0]->status == "Processing")
                                    <th scope="col">Requirement</th>
                                    @else
                                    <th scope="col">Document</th>
                                    @endif
                                @endif
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($appliedProgramme != NULL)
                                @foreach($appliedProgramme as $appliedProgramme1)
                                <tr>
                                    <th scope="row">U<script>document.write(new Date().getFullYear())</script>-{{ $appliedProgramme1->applicationID }}-{{ $appliedProgramme1->rank }}</th>
                                    <td><a href="/detail?id={{ $appliedProgramme1->applicationID }}">{{ $appliedProgramme1->user_id }}</a></td>
                                    <td>{{ $appliedProgramme1->appliedProgramme }}</td>
                                    <td>Year {{ $appliedProgramme1->appliedYear }}</td>
                                    <td>{{ $appliedProgramme1->status }}</td>
                                    @if ($appliedProgramme1->status == "Processing")
                                    <td><button class="btn btn-primary" style="width:100px;" data-toggle="modal" data-target="#checkModal{{ $appliedProgramme1->id }}">Check</button></td>
                                    <td><button class="btn btn-success" style="width:100px;" data-toggle="modal" data-target="#approveModal{{ $appliedProgramme1->id }}">Approve</button><br>
                                    <button class="btn btn-danger" style="width:100px" data-toggle="modal" data-target="#rejectModal{{ $appliedProgramme1->id }}">Reject</button></td>
                                    @else
                                    <td><a href="viewFile/{{ $appliedProgramme1->user_id }}"><button class="btn btn-primary">View</button></a></td>
                                    <td><button class="btn btn-secondary" style="width:100px;" disabled>No Action</button></td>
                                    @endif
                                </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                        @if($appliedProgramme == NULL)
                            <div style="text-align:center;">No Any Application</div>
                        @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Check Modal -->
@if($appliedProgramme != NULL)
    @foreach($appliedProgramme as $appliedProgramme2)
        <div class="modal fade" id="checkModal{{ $appliedProgramme2->id }}" tabindex="-1" role="dialog" aria-labelledby="checkModal{{ $appliedProgramme2->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="checkModal{{ $appliedProgramme2->id }}Label">Check Requirement (Application No.: U<script>document.write(new Date().getFullYear())</script>-{{ $appliedProgramme2->applicationID }}-{{ $appliedProgramme2->rank }})</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--
                        Applicant ID: {{ $appliedProgramme2->user_id }}<br>
                        Applicant latest CGPA: {{ $appliedProgramme2->postCgpa }}<br>
                        <br>
                        Uploaded Document: <a href="viewFile/{{ $appliedProgramme2->user_id }}">View</a><br>
                        -->
                        <!--
                            Post-Sencondary School Transcript: 
                        @if(isset($appliedProgramme2->postSecondaryTranscript))
                            <a href="{{ route('files.getfile', substr($appliedProgramme2->postSecondaryTranscript,13)) }}">{{ $appliedProgramme2->postSecondaryTranscriptName }}</a><br>
                        @else
                            N.A <br>
                        @endif
                        -->
                        <!--
                        <br>
                        Application No.: U<script>document.write(new Date().getFullYear())</script>-{{ $appliedProgramme2->applicationID }}-{{ $appliedProgramme2->rank }}<br>
                        Applied Programme: {{ $appliedProgramme2->appliedProgramme }}<br>
                        Applied Year: {{ $appliedProgramme2->appliedYear }}<br>
                        Required CGPA: 
                        @if($appliedProgramme2->appliedYear == 1) 
                            {{ number_format($appliedProgramme2->year1RequiredCgpa,2, '.', '') }}<br>
                        @else
                            {{ number_format($appliedProgramme2->year3RequiredCgpa,2, '.', '') }}<br>
                        @endif
                        -->

                        Uploaded Document: <br>
                        Post-Secondary Transcript: <a href="{{ route('files.getfile', substr($appliedProgramme2->filePath,13)) }}">View</a> <br>
                                
                        Other Document: <a href="viewFile/{{ $appliedProgramme2->user_id }}">View More..</a><br><br>

                        Comparision:
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Applicant Lastet CGPA</th>
                                    <th scope="col">Required CGPA of Applied Programme</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>{{ $appliedProgramme2->postCgpa }}</td>
                                @if($appliedProgramme2->appliedYear == 1) 
                                   <td>{{ number_format($appliedProgramme2->year1RequiredCgpa,2, '.', '') }}</td>
                                @else
                                    <td>{{ number_format($appliedProgramme2->year3RequiredCgpa,2, '.', '') }}</td>
                                @endif
                            </tbody>
                        </table>

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<!-- Approve Modal -->
@if($appliedProgramme != NULL)
    @foreach($appliedProgramme as $appliedProgramme2)
        <div class="modal fade" id="approveModal{{ $appliedProgramme2->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModal{{ $appliedProgramme2->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModal{{ $appliedProgramme2->id }}Label">Precaution</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you confirm to approve this application?<br>
                        Application No.: U<script>document.write(new Date().getFullYear())</script>-{{ $appliedProgramme2->applicationID }}<br>
                        Name.: {{ $appliedProgramme2->englishName }}<br>
                        Apply Programme: {{ $appliedProgramme2->appliedProgramme }}<br>
                        Apply Year: Year {{ $appliedProgramme2->appliedYear }}<br>
                        Latest Cumulative CGPA: {{ $appliedProgramme2->postCgpa }} out of maximum CGPA {{ $appliedProgramme2->postMaxCgpa }}<br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="{{ route('appliedProgrammes.update', [$appliedProgramme2->id]) }}" method="post">
                            @csrf
                            @method('put')

                            <input type="hidden"  id="programme" name="programme" value="{{ $appliedProgramme2->appliedProgramme }}">
                            <input type="hidden"  id="appliedProgrammeId" name="appliedProgrammeId" value="{{ $appliedProgramme2->id }}">
                            <input type="hidden"  id="userAccepted" name="userAccepted" value="Requesting">
                            <input type="hidden"  id="status" name="status" value="Approved">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>

                        <!--
                        <form action="{{ route('appliedProgrammes.update', [$appliedProgramme2->id]) }}" method="post">
                            @csrf
                            @method('put')

                            <input type="hidden"  id="status" name="status" value="Approved">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                        -->
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<!-- Reject Modal -->
@if($appliedProgramme != NULL)
    @foreach($appliedProgramme as $appliedProgramme2)
        <div class="modal fade" id="rejectModal{{ $appliedProgramme2->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModal{{ $appliedProgramme2->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModal{{ $appliedProgramme2->id }}Label">Precaution</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you confirm to reject this application?<br>
                        Application No.: U<script>document.write(new Date().getFullYear())</script>-{{ $appliedProgramme2->applicationID }}<br>
                        Name.: {{ $appliedProgramme2->englishName }}<br>
                        Apply Programme: {{ $appliedProgramme2->appliedProgramme }}<br>
                        Apply Year: Year {{ $appliedProgramme2->appliedYear }}<br>
                        Latest Cumulative CGPA: {{ $appliedProgramme2->postCgpa }} out of maximum CGPA {{ $appliedProgramme2->postMaxCgpa }}<br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <form action="{{ route('appliedProgrammes.update', [$appliedProgramme2->id]) }}" method="post" >
                            @csrf
                            @method('put')

                            <input type="hidden"  id="status" name="status" value="Rejected">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

@endsection




