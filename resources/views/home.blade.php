@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">


                @if (session('applied'))
                        <div class="alert alert-success">
                            You have already applied our programme(s)!
                            Let's go to the "Application Status" to check!
                        </div>

                        <a href="/status"><p style="text-align:center">>>GO TO APPLICATION STATUS<<<</p></a>
                @elseif (session('noApplication'))
                    <div class="alert alert-danger">
                        Before checking your application status, you need to create a application first!
                    </div>

                    <a href="/applications/create"><p style="text-align:center">>>CREATE APPLICATION<<<</p></a>
                @else

                
                Welcome to University Admission System!!
                @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
