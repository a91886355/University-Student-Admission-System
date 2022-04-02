@extends('layouts.app')

@section('content')
<div style="text-align:center"><button class="btn btn-primary" onclick="history.back()">Back to Last Page</button></div> 
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Detial of Applicant (ID: {{ $application->user_id }})
                </div>
                <br>
                <div class="col-md-12">
                <div class="card-body">   
                    <div class="accordion" id="applicationDetail">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                1. Personal Particular 
                                </button>
                            </h2>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#applicationDetail">
                                <div class="card-body">
                                    <ul class="list-group list-group-hover">
                                        <div class="bg-info text-black text-center">Personal Information</div>
                                        <li class="list-group-item">English Name: {{ $application->englishName }}</li>
                                        <li class="list-group-item">Chinese Name: {{ $application->chineseName }}</li>
                                        <li class="list-group-item">Sex: {{ $application->sex }}</li>
                                        <li class="list-group-item">Date of Birth: {{ $application->dateOfBirth }}</li>
                                        <li class="list-group-item">Nationality: {{ $application->nationality }}</li>
                                    </ul>
                                    <br>
                                    <ul class="list-group list-group-hover">
                                        <div class="bg-info text-black text-center">Contact</div>
                                        <li class="list-group-item">Homephone Number: {{ $application->homephoneNumber }}</li>
                                        <li class="list-group-item">Mobile Number: {{ $application->mobileNumber }}</li>
                                        <li class="list-group-item">Mailing Address: {{ $application->mailingAddress }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                2. Academic Profile
                                </button>
                            </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#applicationDetail">
                                <div class="card-body">
                                    <ul class="list-group list-group-hover">
                                        <div class="bg-info text-black text-center">Seconday School</div>
                                        <li class="list-group-item">Country/Region: {{ $application->secondaryCountry }}</li>
                                        <li class="list-group-item">Name of School: {{ $application->secondarySchool }}</li>
                                        <li class="list-group-item">Date of Admission: {{ $application->secondaryAdmission }}</li>
                                        <li class="list-group-item">Date/Expected Date of Completion: {{ $application->secondaryCompletion }}</li>
                                    </ul>
                                    <br>
                                    <ul class="list-group list-group-hover">
                                        <div class="bg-info text-black text-center">Post-Seconday School</div>
                                        <li class="list-group-item">Country/Region: {{ $application->postCountry }}</li>
                                        <li class="list-group-item">Name of School: {{ $application->postSchool }}</li>
                                        <li class="list-group-item">Studying Programme: {{ $application->postProgramme }}</li>
                                        <li class="list-group-item">Qualidication of Programme: {{ $application->postQualification }}</li>
                                        <li class="list-group-item">Studying Mode of Programme: {{ $application->postMode }}</li>
                                        <li class="list-group-item">Latest Cumulative CGPA {{ $application->postCgpa }} out of maximum CGPA {{ $application->postMaxCgpa }}</li>
                                        <li class="list-group-item">Date of Admission: {{ $application-> postAdmission}}</li>
                                        <li class="list-group-item">Date/Expected Date of Completion: {{ $application-> postCompletion}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                </div>
                </div>                                                         
            </div>
        </div>
    </div>
</div>

@endsection
