@extends('layouts_global.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="bg-blacek">
        <div class="bg-overlay"></div>

      
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                    </div>
                </div>
            </div>
      

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4 bg-info">

                        <div class="card-body p-4">
                            <div class="p-2 mt-4">
                                <form id="login_process">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label text-white">Username<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" value="" id="username" name="username" placeholder="Enter username">
                                      
                                    </div>

                                    <div class="mb-3">
                                        <a href="{{ route('register') }}" class="text-white">Register</a>
                                    </div>

                            
                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                    </div>


                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
@endsection
@section('script')



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function(){

    $(document).on('submit','#login_process',function(e){
        e.preventDefault();
        loginProcess();
    })

})

function loginProcess(){
    const urls = `{{ url('api/login_process') }}`;
    let requestInput = {
        'username' : $('#username').val()
    }
    $.ajax({
        url : urls,
        method : "POST",
        dataType : "JSON",
        data     :requestInput,
        success : function(response){
            if(response.meta.status == 200){
                localStorage.setItem('token',response.data.access_token)
                location.replace(`{{ route('dashboard') }}`)
            }
        }

    })
}

</script>

@endsection