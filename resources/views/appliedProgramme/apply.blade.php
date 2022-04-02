@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Apply Programme (Applicant ID: {{ $application->user_id }})
                </div>
                <div class="card-body">
                    <br>
                
                    <!--if-->
                    <form action="{{ route('appliedProgrammes.store') }}" method="post" id="applyForm">
                        @csrf
                        
                        <input type="hidden" class="form-control" id="applicationID" name="applicationID" value="{{ $application->id }}">

                        <!--Personal Information-->
                        <div class="bg-info text-black text-center">Apply Programme</div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Apply Programme</th>
                                    <th>Apply Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <select class="form-control" id="appliedProgramme1" name="appliedProgramme1" required>
                                            <option value="" disable>--Select Your Option--</option>
                                            @foreach($programme as $programme1)
                                                <option value="{{ $programme1->name }}">{{ $programme1->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" id="appliedYear1" name="appliedYear1" required>
                                            <option value="" disable>--Select Your Option--</option>
                                            <option value="1">Year 1</option>
                                            <option value="3">Year 3</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <select class="form-control" id="appliedProgramme2" name="appliedProgramme2" required>
                                            <option value="" disable>--Select Your Option--</option>
                                            @foreach($programme as $programme2)
                                                <option value="{{ $programme2->name }}">{{ $programme2->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" id="appliedYear2" name="appliedYear2">
                                            <option value="" disable>--Select Your Option--</option>
                                            <option value="1">Year 1</option>
                                            <option value="3">Year 3</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <select class="form-control" id="appliedProgramme3" name="appliedProgramme3" required>
                                            <option value="" disable>--Select Your Option--</option>
                                            @foreach($programme as $programme3)
                                                <option value="{{ $programme3->name }}">{{ $programme3->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" id="appliedYear3" name="appliedYear3">
                                            <option value="" disable>--Select Your Option--</option>
                                            <option value="1">Year 1</option>
                                            <option value="3">Year 3</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <input type="button" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirmModal" class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Precaution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                After submit, you cannot change or create the "3.Apply Programme" any more!<br>
                Are you confirm to submit the programme application?<br>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" form="applyForm">Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
$('#submit').click(function(){
    $('#applyForm').submit();
});
</script>


