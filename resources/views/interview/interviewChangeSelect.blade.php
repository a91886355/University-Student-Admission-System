@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                   Change Time Request (Application No.: U<script>document.write(new Date().getFullYear())</script>-{{ $interview->applicationID }}-{{ $interview->rank }})
                </div>
                <div class="card-body">
                    <form action="{{ route('interviews.update', [$interview->interviewId]) }}" method="post">
                        @csrf
                        @method('put')

                        <input type="hidden" name="changeTime" value="true">
                        <input type="hidden" name="appliedProgrammeId" value="{{ $interview->appliedProgrammeId }}">

                        <div class="form-group">
                            <label class="control-label" for="appliedProgramme">Applied Programme:</label>
                            <input type="text" class="form-control" id="appliedProgramme" name="appliedProgramme" value="{{ $interview->appliedProgramme }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="originalInterviewDate">Orignial Interview Date: (D/M/Y)</label>
                            <input type="date" class="form-control" id="originalInterviewDate" name="originalInterviewDate" value="{{ $interview->interviewDate }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="originalInterviewTime">Orignial Interview Time:</label>
                            <input type="text" class="form-control" id="originalInterviewTime" name="originalInterviewTime" value="{{ $interview->interviewTime }}" disabled>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="newInterviewDate">New Interview Date: (D/M/Y)</label>
                            <select class="form-control" id="newInterviewDate" name="newInterviewDate" required>
                                @if($interviewEmptys != NULL)
                                    <option hidden disabled selected value>--Select--</option>
                                    @foreach($interviewPeriodEmptys as $interviewPeriodEmpty)
                                    <option value="{{ $interviewPeriodEmpty->timePeriodId }}">{{ date('d/m/Y', strtotime($interviewPeriodEmpty->interviewDate)) }}</option>
                                    @endforeach
                                @else
                                    <option value="">No Any Empty Date</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group required">
                            <label class="control-label" for="newInterviewTime">New Interview Time:</label>
                            <select class="form-control" id="newInterviewTime" name="newInterviewTime" required>
                                @if($interviewEmptys != NULL)
                                    <option disabled selected value>--Select--</option>
                                @else
                                    <option value="">No Any Empty of Selected Date</option>
                                @endif
                            </select>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                            @if($interviewEmptys == NULL)
                            <button type="submit" form="noEmptyForm" class="btn btn-danger" style="float:right;">No Any Empty</button>
                            @endif
                        </div>
                    </form>
                    <form action="{{ route('interviews.update', [$interview->interviewId]) }}" id="noEmptyForm" method="post">
                        @csrf
                        @method('put')

                        <input type="hidden" name="changeTime" value="true">
                        <input type="hidden" name="noEmpty" value="true">
                        <input type="hidden" name="appliedProgrammeId" value="{{ $interview->appliedProgrammeId }}">
                    <form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>

    $(document).ready(function(){

        $('#newInterviewDate').change(function(){

            var timePeriodId = $(this).val();

            $('#newInterviewTime').find('option').remove();
            $("#newInterviewTime").append("<option disabled selected value=''>--Select--</option>"); 

            $.ajax({
                url: '/getEmptyTime/'+timePeriodId,
                type: 'get',
                dataType: 'json',
                success: function(response){

                    var len = 0;
                    if(response['data'] != null){
                    len = response['data'].length;
                    }

                    if(len > 0){
                    // Read data and create <option >
                        for(var i=0; i<len; i++){

                            var id = response['data'][i].id;
                            var interviewTime = response['data'][i].interviewTime;

                            if(id == null){
                                $('#newInterviewTime').find('option').remove();
                                var option = "<option value=''>No Any Empty of Selected Date</option>";
                                
                            }else{
                                var option = "<option value='"+id+"'>"+interviewTime+"</option>"; 
                            }

                            $("#newInterviewTime").append(option); 
                        }
                    }

                },
            });
        });

    });

</script>

@endsection
