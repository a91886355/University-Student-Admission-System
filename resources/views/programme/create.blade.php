@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                Create Programme
                </div>
                <div class="card-body">
                    <form action="{{ route('programmes.store') }}" method="post" id="applyForm">
                        @csrf
                        <div class="form-group required">
                            <label class="control-label" for="category">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="" disable>--Select Your Option--</option>
                                <option value="Arts">Arts</option>
                                <option value="Business">Business</option>
                                <option value="Science">Science</option>
                            </select>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required> 
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="year1RequiredCgpa">Year 1 Required CGPA</label>
                            <input type="number" step="0.01" min="0" class="form-control col-lg-2" id="year1RequiredCgpa" name="year1RequiredCgpa" required>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="year3RequiredCgpa">Year 3 Required CGPA</label>
                            <input type="number" step="0.01" min="0" class="form-control col-lg-2" id="year3RequiredCgpa" name="year3RequiredCgpa" required>
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
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
                Are you confirm to creare this programme?<br>
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


