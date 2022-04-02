@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success">
                    Congratulations! Your Account is Verified and Active.<br>
                </div>
            <div class="card">
                <div class="card-header">
                <Strong>Applicant Information:</strong>
                </div>
                <div class="card-body">
                Applicant Email: {{ $email }} <br>
                Applicant ID: {{ $user_id }} <br><br>

                Now, you are allowed use the functions.
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
