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
            <div class="auth-page-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card mt-4">

                                <div class="card-body p-4 bg-info">
                                    <div class="p-2 mt-4">
                                        <form id="submitRegister">
                                             <div class="mb-3">
                                                <label for="username" class="form-label text-white">Name<span class="text-danger text-white">*</span></label>
                                                <input type="text" class="form-control @error('email') is-invalid @enderror"  id="nama" name="nama" placeholder="Enter nama">
                                            </div>
                                            <div class="mb-3">
                                                <label for="username" class="form-label text-white">Username<span class="text-danger text-white">*</span></label>
                                                <input type="text" class="form-control @error('email') is-invalid @enderror"  id="username" name="username" placeholder="Enter username">
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex gap-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input timesRadio" type="radio" name="exampleRadios" id="radio-asia" value="Asia/Jakarta">
                                                        <label class="form-check-label text-white" for="exampleRadios1">
                                                            Asia/Jakarta
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input timesRadio" type="radio" name="exampleRadios" id="radio-auckland"
                                                            value="Pacific/Auckland">
                                                        <label class="form-check-label text-white" for="exampleRadios2">
                                                            Pacific/Auckland
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <a href="{{ route('login') }}" class="text-white">Login</a>
                                            </div>


                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
        </div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $(document).ready(function(){
        $(document).on('submit','#submitRegister',function(e){
            e.preventDefault();
            registerMethod();
        })
    })


    function registerMethod(){
        const urls = `{{ url('api/register_process') }}`;
        let selectTime = $('input[name="exampleRadios"]:checked').val();

        let requestInput = {
            'name' : $('#nama').val(),
            'username' : $('#username').val(),
            'preffered' :selectTime

        }
        $.ajax({
            url       :   urls,
            method    :   "POST",
            dataType  :   "JSON",
            data      : requestInput,
            success   :function(response){
                if(response.status == 200){
                    Swal.fire({
                        icon    : 'success',
                        title   : 'Success',
                        text    : 'Register Success, Silahkan login'
                    })

                    $('#submitRegister')[0].reset();
                    return;
                }

                    $('#submitRegister')[0].reset();
                   Swal.fire({
                        icon    : 'warning',
                        title   : 'Failed',
                        text    : 'Register Failed : ' + response.message
                    })

            },
            error : function(xhr,status,error){
                Swal.fire({
                    icon : 'error',
                    title : 'Error',
                    text : 'Register Error'

                })
            }
        })
    }

</script>




