@extends('layouts_global.master')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span><h4>Edit Profil</h4></span>
                </div>
                <div class="card-body">
                    <form id="submitProfile">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Nama
                                </label>
                                <input type="text" id="nama_user" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Username
                                </label>
                                <input type="text" id="username" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-9">
                                <label class="form-label">
                                    Timezone
                                </label>
                                <div class="d-flex gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="radio-asia" value="Asia/Jakarta">
                                        <label class="form-check-label" for="exampleRadios1">
                                            Asia/Jakarta
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="radio-auckland"
                                            value="Pacific/Auckland">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Pacific/Auckland
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-success mt-2">
                                Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('script')
      <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>

        document.addEventListener('DOMContentLoaded',function(){
            getProfile();

            document.getElementById('submitProfile').addEventListener('submit',function(e){
                e.preventDefault();
                editProfile();
            })
        })


        function editProfile(){
            let token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '/login'
            }

            const urls = `{{ url('api/profile/edit') }}`
            let requestInput = {
                'username' : $('#username').val(),
                'name'     : $('#nama_user').val(),
                'preffered' : $('input[name="exampleRadios"]:checked').val()
            };

            $.ajax({
                url         : urls,
                method      : "PUT",
                dataType    : "JSON",
                data        :  requestInput,
                headers     : {
                    'Authorization' : 'Bearer ' + token,

                },
                success : function(response){
                    if(response.status == 200){
                        Swal.fire({
                            icon : 'success',
                            title : 'Success',
                            text  : 'Success update profile'
                        })


                        return;
                    }

                    if(response.status == 400){
                        Swal.fire({
                            icon : 'Warning',
                            title : 'Failed',
                            text : 'Failed update profile'
                        })

                        return
                    }

                    if(response.status == 422){
                        Swal.fire({
                            icon : 'warning',
                            title : 'Failed',
                            text : response.message
                        })

                        return
                    }

                },
                error: function (xhr) {
                    if (xhr.status == 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    }
                }
            })

        }

        function getProfile(){

            let token = localStorage.getItem('token');
            if(!token){
                window.location.href = '/login'
            }

            const urls = `{{ url('api/profile/get') }}`;
            $.ajax({
                url :urls,
                method : "GET",
                dataType : "JSON",
                headers : {
                    "Authorization" : "Bearer " + token
                },
                success :function(response){
                    if(response.status == 200){
                        $('#nama_user').val(response.data.name);
                        $('#username').val(response.data.username);

                        if(response.data.preffered_timezone == 'Asia/Jakarta'){
                            $('input[id="radio-asia"]').prop('checked',true)
                            $('input[id="radio-auckland"]').prop('checked',false)
                        }else{
                            $('input[id="radio-auckland"]').prop('checked',true)
                            $('input[id="radio-asia"]').prop('checked',false)
                        }
                    }
                },
                error :function(xhr){
                     if (xhr.status == 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    }
                    console.error('Error fetch data')
                }
            })
        }

    </script>

@endsection