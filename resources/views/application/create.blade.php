@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Precaution</div>

                <div class="card-body">
                    
                    <form action="{{ route('applications.store') }}" method="post">
                        @csrf
                        
                        <ul>
                            <li>Each Account only can create ONCE Application.</li>
                            <li>User should input information correctly.</li>
                            <li>User can apply the programme at the last part of application.</li>
                            <li>User can apply 3 programmes in maximum.</li>
                        </ul>

                        <button type="submit" class="btn btn-success">Agree</button>
                        <a href="/" class="btn btn-danger">Disagree</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection