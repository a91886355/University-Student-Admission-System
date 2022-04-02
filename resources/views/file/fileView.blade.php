@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    File Upload
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Upload Successful!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Files</th>
                                <th scope="col">Uploaded</th>
                                <th scope="col">Last Modified</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>DSE Result</td>
                                @if(!isset($dseResult) OR $dseResult == NULL)
                                    <td>No</td>
                                    <td>N.A.</td>
                                    <td><button class="btn btn-primary" data-toggle="modal" data-target="#dseUploadModal" style="width:80px">Upload</button></td>
                                @else
                                    <td>Yes</td>
                                    <td>{{ $dseResult[0]->updated_at }}</td>
                                    <td><button class="btn btn-primary" data-toggle="modal" data-target="#dseUploadModal" style="width:80px">Edit</button></td>
                                @endif
                            </tr>
                            <tr>
                                <td class="required">Post-Secondary Transcript</td>
                                @if(!isset($postSecondaryTranscript) OR $postSecondaryTranscript == NULL)
                                    <td>No</td>
                                    <td>N.A.</td>
                                    <td><button class="btn btn-primary" data-toggle="modal" data-target="#postSecondaryUploadModal" style="width:80px">Upload</button></td>
                                @else
                                    <td>Yes</td>
                                    <td>{{ $postSecondaryTranscript[0]->updated_at }}</td>
                                    <td><button class="btn btn-primary" data-toggle="modal" data-target="#postSecondaryUploadModal" style="width:80px">Edit</button></td>
                                @endif
                            </tr>
                            @if(isset($userFiles) and $userFiles != NULL)
                                @foreach($userFiles as $userFile)
                                    <tr>
                                        <td>{{ $userFile->fileName }}</td>
                                        <td>Yes</td>
                                        <td>{{ $userFile->updated_at }}</td>
                                        <td>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#editOtherModal{{ $userFile->id }}" style="width:80px">Edit</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="4"><div style="text-align:center"><button class="btn btn-success" data-toggle="modal" data-target="#uploadOtherModal">Upload Other Supplementary Document</button></div></td>
                            </tr>       
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($userFiles) and $userFiles != NULL)
    @foreach($userFiles as $userFile)
        <div class="modal fade" id="editOtherModal{{ $userFile->id }}" tabindex="-1" role="dialog" aria-labelledby="editOtherModal{{ $userFile->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOtherModal{{ $userFile->id }}Label">{{ $userFile->fileName }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="deleteOtherform" method="post" action="{{ route('files.destroy', [$userFile->id]) }}">
                            @csrf @method('DELETE')
                        </form>
                        <form action="{{ route('files.update', [$userFile->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="form-group">
                            <div class="form-group">
                                <strong class="required">File Name:</strong>
                                    <input type="text" class="form-control" id="fileName" name="fileName" value="{{ $userFile->fileName }}" required>
                                </div>

                                <strong>Uploaded File: <a href="{{ route('files.getfile', substr($userFile->filePath,13)) }}">{{ $userFile->fileOriginalName }}</a></strong><br><br>
                                <strong>Upload New File:</strong>
                                <input type="file" name="file" class="form-control" placeholder="file" id="file" required>
                            </div>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="submit" form="deleteOtherform" class="btn btn-danger" style="float:right;">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


        <div class="modal fade" id="dseUploadModal" tabindex="-1" role="dialog" aria-labelledby="dseUploadModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dseUploadModalLabel">DSE Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if(!isset($dseResult) OR $dseResult == NULL)
                            <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <strong>Upload File:</strong>
                                    <input type="file" name="file" class="form-control" placeholder="file" id="file">
                                </div>

                                <input type="hidden" name="fileName" value="dseResult">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>   
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        @else
                            <form action="{{ route('files.update', [$dseResult[0]->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="form-group">
                                        <strong>Uploaded File: <a href="{{ route('files.getfile', substr($dseResult[0]->filePath,13)) }}">{{ $dseResult[0]->fileOriginalName }}</a></strong><br><br>
                                    <strong>Upload New File:</strong>
                                    <input type="file" name="file" class="form-control" placeholder="file" id="file" required>
                                </div>

                                <input type="hidden" name="fileName" value="dseResult">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>   
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="postSecondaryUploadModal" tabindex="-1" role="dialog" aria-labelledby="postSecondaryUploadModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title required" id="postSecondaryUploadModalLabel">Post-Secondary Transcript</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if(!isset($postSecondaryTranscript) OR $postSecondaryTranscript == NULL)
                            <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <strong>Upload File:</strong>
                                    <input type="file" name="file" class="form-control" placeholder="file"  id="file" required>
                                </div>

                                <input type="hidden" name="fileName" value="postSecondaryTranscript">
                        
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>   
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        @else
                            <form action="{{ route('files.update', [$postSecondaryTranscript[0]->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="form-group">
                                    <strong>Uploaded File: <a href="{{ route('files.getfile', substr($postSecondaryTranscript[0]->filePath,13)) }}">{{ $postSecondaryTranscript[0]->fileOriginalName }}</a></strong><br><br>
                                    <strong>Upload New File:</strong>
                                    <input type="file" name="file" class="form-control" placeholder="file"  id="file">
                                </div>

                                <input type="hidden" name="fileName" value="postSecondaryTranscript">
                        
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>   
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="uploadOtherModal" tabindex="-1" role="dialog" aria-labelledby="uploadOtherModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadOtherModalLabel">Upload Other Supplementart Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                <strong class="required">File Name:</strong>
                                    <input type="text" class="form-control" id="fileName" name="fileName" required>
                                </div>

                                <div class="form-group">
                                    <strong class="required">Upload New File:</strong>
                                    <input type="file" name="file" class="form-control" placeholder="file" id="file" required>
                                </div>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>   
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
<style>
  .required:after {
    content:" *";
    color: red;
  }
</style>
@endsection