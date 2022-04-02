@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                My Application (Applicant ID: {{ $application->user_id }})
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="/personal">1. Personal Particular</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/acade">2. Academic Profile</a>
                        </li>
                    </ul>
                    <br>

                    @if (session('acadeSuccess'))
                        <div class="alert alert-success">
                            "2. Academic Profile" Update Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            "1. Personal Particular" Update Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('notFilledAll'))
                        <div class="alert alert-danger">
                            Before apply the programmes, you need to fill "2. Academic Profile" form first!
                        </div>
                    @endif
                
                    <!--if-->
                    <form action="{{ route('applications.update', [$application->id]) }}" method="post">
                        @csrf
                        @method('put')
                        
                        <input type="hidden"  id="acadeFilled" name="acadeFilled" value="true">

                        <!--Secondary School-->
                        <div class="bg-info text-black text-center">Secondary School</div>

                        <div class="form-group required">
                            <label class="control-label required" for="secondaryCountry">Country/Region</label>
                            <input type="text" class="form-control" id="secondaryCountry" name="secondaryCountry" value="{{ $application->secondaryCountry }}" required>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="secondarySchool">Name of School</label>
                            <input type="text" class="form-control" id="secondarySchool" name="secondarySchool" value="{{ $application->secondarySchool }}" required>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="secondaryAdmission">Date of Admission</label>
                            <input type="date" class="form-control" id="secondaryAdmission" name="secondaryAdmission" value="{{ $application->secondaryAdmission }}" required>
                        </div>
                        <div class="form-group required required">
                            <label class="control-label required" for="secondaryCompletion">Date/Expected Date of Completion</label>
                            <input type="date" class="form-control" id="secondaryCompletion" name="secondaryCompletion" value="{{ $application->secondaryCompletion }}" required> 
                        </div><br>

                        <!--Post-Secondary School-->
                        <div class="bg-info text-black text-center">Post-Secondary School</div>

                        <div class="form-group required">
                            <label class="control-label required" for="postCountry">Country/Region</label>
                            <input type="text" class="form-control" id="postCountry" name="postCountry" value="{{ $application->postCountry }}" required>
                        </div>
                        <div class="form-group required ">
                            <label class="control-label required" for="postSchool">Name of School</label>
                            <input type="text" class="form-control" id="postSchool" name="postSchool" value="{{ $application->postSchool }}" required>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="postProgramme">Studying Programme</label>
                            <input type="text" class="form-control" id="postProgramme" name="postProgramme" value="{{ $application->postProgramme }}" required>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="postQualification">Qualidication of Programme</label>
                            <select class="form-control" id="postQualification" name="postQualification" required>
                                @if( $application->sex == NULL )
                                    <option value="">--Select Your Option--</option>
                                @else
                                    <option value="{{ $application->postQualification }}">{{ $application->postQualification }}</option>
                                @endif
                                <option value="hd">HD</option>
                                <option value="asso">Asso</option>
                                <option value="degree">Degree</option>
                            </select>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="postMode">Studying Mode of Programme</label>
                            <select class="form-control" id="postMode" name="postMode" required>
                                @if( $application->sex == NULL )
                                    <option value="">--Select Your Option--</option>
                                @else
                                    <option value="{{ $application->postMode }}">{{ $application->postMode }}</option>
                                @endif
                                <option value="fullTime">Full-time</option>
                                <option value="partTime">Part-time</option>
                            </select>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="postCgpa">Latest Cumulative CGPA</label>
                            
                            <div class="input-group">
                            <input type="number" step="0.01" min="0" class="form-control col-lg-2" id="postCgpa" name="postCgpa" value="{{ $application->postCgpa }}" required>
                            &nbsp out of maximum CGPA &nbsp
                            <span class="input-group-btn" style="width:0px;"></span>
                            <input type="number" step="0.01" min="0" class="form-control col-lg-2" id="postMaxCgpa" name="postMaxCgpa" value="{{ $application->postMaxCgpa }}" required>
                            </div>

                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="postAdmission">Date of Admission</label>
                            <input type="date" class="form-control" id="postAdmissionn" name="postAdmission" value="{{ $application->postAdmission }}" required>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="postCompletion">Date/Expected Date of Completion</label>
                            <input type="date" class="form-control" id="postCompletion" name="postCompletion" value="{{ $application->postCompletion }}" required> 
                        </div>


                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <!--endif-->
                </div>
            </div>
        </div>
    </div>
</div>
<style>
  label.required:after {
    content:" *";
    color: red;
  }
</style>
@endsection