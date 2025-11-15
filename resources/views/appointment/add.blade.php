@extends('layouts_global.master')

@section('content')

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span>
                            <h4>Create Appointment</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <form id="submitAppointment">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Judul</label>
                                    <input type="text" id="title-appointment" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <label for="datetimepicker6" class="form-label">Start Date & Time</label>
                                    <input id="datetimepicker6" type="text" class="form-control" placeholder="Select start datetime">
                                </div>

                                <!-- End Datetime -->
                                <div class="col-md-5">
                                    <label for="datetimepicker7" class="form-label">End Date & Time</label>
                                    <input id="datetimepicker7" type="text" class="form-control" placeholder="Select end datetime">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="form-label">Undang user</label>
                                    <input type="text" placeholder="Input username" class="form-control" id="inputInvites" name="invites[]" autocomplete="off" list="invitesOptions" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>


    <script>
        let selectedUsers = [];
        let whiteListVal = null;
        let invitesInput = document.getElementById('inputInvites');
         var tagify = new Tagify(invitesInput, {
                tagTextProp: 'name',
                dropdown: {
                    enabled: 1, // tampilkan dropdown saat user mulai mengetik
                    position: "text", // di bawah text
                    classname: "custom-suggestions-list",
                    closeOnSelect: false
                },
                enforceWhitelist: false
            })

        document.addEventListener("DOMContentLoaded", function () {
            const startPicker = flatpickr("#datetimepicker6", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                 clickOpens: true,  
                onChange: function (selectedDates) {
                    endPicker.set('minDate', selectedDates[0]); 
                }
            });

            const endPicker = flatpickr("#datetimepicker7", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                 clickOpens: true,  
                onChange: function (selectedDates) {
                    startPicker.set('maxDate', selectedDates[0]); 
                }
            });


            tagify.on('change', function (e) {
                const rawValue = e.detail.value;
                if (!rawValue) {
                    selectedUsers = [];
                } else {
                    console.log(rawValue);
                    const jsonValue = JSON.parse(rawValue);
                    selectedUsers = jsonValue.map(item => item.id);
                }

            })

            tagify.on('input',function(e){
                const rawValue = e.detail.value;
                searchProfile(rawValue,selectedUsers).then( res => {

                    if(res.length > 0){
                         whitelistVal = res.map(index => ({
                            value: index.username,
                            id: index.uuid
                        }))

                        tagify.settings.whitelist = whitelistVal;
                        tagify.dropdown.show.call(tagify, e.detail.value);
                    }
                })
            })

            document.getElementById('submitAppointment').addEventListener('submit',function(e){
                e.preventDefault();
                console.log('selected users : ',selectedUsers);
                createAppointment();
            })
        });


        function searchProfile(username,usersSelected){
            let token = localStorage.getItem('token');
            if(!token){
                window.location.href = '/login'
            }

            let requestInput = {
                'username' : username,
                'usersSelected' :usersSelected
            }
            const urls = `{{ url('api/profile/search') }}`;
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: urls,
                    method: "GET",
                    dataType: "JSON",
                    data: requestInput,
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    success: function (response) {
                        let datas =[]
                        if (response.status == 200 && response.data.length > 0) {
                            datas = response.data;
                        }

                        resolve(datas);
                    },
                    error :function(xhr,status,error){

                        if (xhr.status == 401) {
                            localStorage.removeItem('token');
                            window.location.href = '/login';
                        }

                        reject(error);
                    }

                })
            })
        }


        function createAppointment(){
            let token = localStorage.getItem('token');
            if(!token){
                window.location.href = '/login';
            }

            let requestInput = {
                'title' : $('#title-appointment').val(),
                'start' : $('#datetimepicker6').val(),
                'end'   : $('#datetimepicker7').val(),
                'invites' :selectedUsers

            }

            // console.log(requestInput);
            const urls = `{{ url('api/appointment/create') }}`;
            $.ajax({
                url : urls,
                method : "POST",
                dataType : "JSON",
                data     :requestInput,
                headers  : {
                    "Authorization" : "Bearer " + token
                },
                success :function(response){
                   if(response.status == 200){
                        Swal.fire({
                            icon : 'success',
                            title : 'Success',
                            text  : response.message
                        })

                        $('#submitAppointment')[0].reset()
                        selectedUsers = [];
                        return;
                    }

                    if(response.status == 400){
                        Swal.fire({
                            icon : 'Warning',
                            title : 'Failed',
                            text : response.message
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

    </script>

@endsection