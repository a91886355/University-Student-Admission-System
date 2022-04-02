<div class="container">
     <div class="row justify-content-center">
         <div class="col-md-8">
             <div class="card">
                 <div class="card-header"></div>
                   <div class="card-body">
                    @if (session('resent'))
                         <div class="alert alert-success" role="alert">
                            {{ __('A fresh mail has been sent to your email address.') }}
                        </div>
                    @endif
                    {!! $content !!}
                    <br><br>
                    <a href="http://127.0.0.1:8000/status">>>>>Let's Answer the Interview Request<<<<<</a>
                </div>
            </div>
        </div>
    </div>
</div>