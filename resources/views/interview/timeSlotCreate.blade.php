@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                   Create Interview Time Period & Slot
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{ route('interviews.store') }}" method="post" >
                        @csrf

                        <div class="form-group required">
                            <label class="control-label" for="programmeId">Programme</label>
                            <select class="form-control" id="programmeId" name="programmeId" required>
                                <option value="" disable>--Select Your Option--</option>
                                @foreach($programme as $programme1)
                                    <option value="{{ $programme1->id }}">{{ $programme1->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group required">
                            <label class="control-label" for="dateOfInterview">Date of the Interview</label>
                            <input type="date" class="form-control" id="dateOfInterview" name="dateOfInterview" required>
                        </div>

                        <div class="form-group required">
                            <label class="control-label" for="startTimeOfInterview">Start Time of the Interview</label>
                            <input type="time" class="form-control" id="startTimeOfInterview" name="startTimeOfInterview" required>
                        </div>

                        <div class="form-group required">
                            <label class="control-label" for="finishTimeOfInterview">Finish Time of the Interview</label>
                            <input type="time" class="form-control" id="finishTimeOfInterview" name="finishTimeOfInterview" required>
                        </div>

                        <div class="form-group required">
                            <label class="control-label" for="timeSlotOfInterview">Time Slot of the Interview</label><br>
                            <input type="number" class="form-control col-md-1" id="timeSlotOfInterview" name="timeSlotOfInterview" style="display:inline" required>Min
                        </div>

                        <div class="form-group required">
                            <label class="control-label" for="venue">Venue</label>
                            <input type="text" class="form-control" id="interviewVenue" name="interviewVenue" required>
                        </div>

                        <div>
                            <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection