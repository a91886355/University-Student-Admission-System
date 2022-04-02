@extends('layouts.app')

@section('content')
<div style="text-align:center"><button class="btn btn-primary" onclick="history.back()">Back to Last Page</button></div> 
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Uploaded File of Applicant (ID: {{ $user_id }})
                </div>
                <br>
                <div class="card-body">   
                    <div class="accordion" id="applicationDetail">
                        @if($files!=NULL)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Files</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    @if($file->fileName=="dseResult")
                                        <td>DSE Result</td>
                                    @elseif($file->fileName=="postSecondaryTranscript")
                                        <td>Post-Secondary Transcript</td>
                                    @else
                                        <td>{{ $file->fileName }}</td>
                                    @endif
                                    <td><a href="{{ route('files.getfile', substr($file->filePath,13)) }}"><button class="btn btn-primary">View</button></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <div style="text-align:center">No any Uploaded File</div>
                        @endif
                    </div>
                    <br>
                </div>                                                         
            </div>
        </div>
    </div>
</div>

@endsection
