@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Apply Requirement (Applicant ID: {{ $user_id }})
                </div>
                <div class="card-body">

                    Before applying the programmes, you need to:<br><br>
                    <ol>
                    @if($notFilled == "acade")
                        <li><a href="/acade">Fill "Academic Profile" Form</a></li>
                    @elseif($notFilled == "all")
                        <li><a href="/personal">Fill "Personal Particular" Form</a></li>
                        <li><a href="/acade">Fill "Academic Profile" Form</a></li>
                    @endif

                    @if($requireDocument == false)
                        <li><a href="/fileView">Upload "Post-Secondary Transcript" Supplement Document</li>
                    @endif
                    </ol>
                
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection