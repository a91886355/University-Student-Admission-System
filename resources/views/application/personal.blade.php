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

                    <!--<ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="/status">Application Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/applications/create">My Application</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="#">My Profile</a>
                        </li>
                    </ul>

                    <nav class="nav flex-column nav-pills">
                        <li class="nav-item bg-light">
                            <a class="nav-link active" href="/personal">1. Personal Particular</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/acade">2. Academic Profile</a>
                        </li>
                        <li class="nav-item bg-light">
                            <a class="nav-link" href="/apply">3. Apply Programme</a>
                        </li>
                    </nav>
                    <br>-->

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="/personal">1. Personal Particular</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/acade">2. Academic Profile</a>
                        </li>
                    </ul>
                    <br>

                    @if (session('notFilledAcade'))
                        <div class="alert alert-danger">
                            Before fill "2. Adademic Profile", you need to fill "1. Personal Particular" form first!
                        </div>
                    @endif

                    @if (session('notFilledAll'))
                        <div class="alert alert-danger">
                            Before apply the programmes, you need to fill "1. Personal Particular" form first!
                        </div>
                    @endif
                
                    <!--if-->
                    <form action="{{ route('applications.update', [$application->id]) }}" method="post">
                        @csrf
                        @method('put')

                        <input type="hidden"  id="personalFilled" name="personalFilled" value="true">

                        <!--Personal Information-->
                        <div class="bg-info text-black text-center">Personal Information</div>

                        <div class="form-group required">
                            <label class="control-label required" for="englishName">English Name</label>
                            <input type="text" class="form-control" id="englishName" name="englishName" value="{{ $application->englishName }}" required>
                        </div>
                        <div class="form-group">
                            <label for="chineseName">Chinese Name</label>
                            <input type="text" class="form-control" id="chineseName" name="chineseName" value="{{ $application->chineseName }}">
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="sex">Sex</label>
                            <select class="form-control" id="sex" name="sex" required>
                                @if( $application->sex == NULL )
                                    <option value="">--Select Your Option--</option>
                                @else
                                    <option value="{{ $application->sex }}">{{ $application->sex }}</option>
                                @endif
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="dateOfBirth">Date of Birth</label>
                            <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="{{ $application->dateOfBirth }}" required>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="nationality">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" value="{{ $application->nationality }}" required> 
                        </div>

                        <!--Contact-->
                        <div class="bg-info text-black text-center">Contact</div>

                        <div class="form-group">
                            <label class="control-label required" for="homephoneNumber">Homephone Number</label>
                            <input type="text" class="form-control" id="homephoneNumber" name="homephoneNumber" value="{{ $application->homephoneNumber }}">
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="mobileNumber">Mobile Number</label>
                            <input type="text" class="form-control" id="mobileNumber" name="mobileNumber" value="{{ $application->mobileNumber }}" required>
                        </div>
                        <div class="form-group required">
                            <label class="control-label required" for="mailingAddress">Mailing Address</label>
                            <input type="text" class="form-control" id="mailingAddress" name="mailingAddress" value="{{ $application->mailingAddress }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Save & Next</button>
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