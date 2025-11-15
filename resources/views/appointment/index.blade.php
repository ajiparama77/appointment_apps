@extends('layouts_global.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span><h4>My Appointment</h4></span>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-primary" type="button" href="{{ route('add-appointment') }}">
                            Create Appointment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped mt-2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Host</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="content-data">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade modal-lg modal-center" id="modal-appointment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detail Appointment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Appointment</th>
                                        <th>Timezone</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                    </tr>
                                </thead>
                                <tbody id="content-detail"></tbody> 
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closeDetail" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        let uuidSelected = null;
        let itemsDetail = [];
        $(document).ready(function(){
            getNyAppointment();

            $(document).on('click','.detailButton',function(){
                uuidSelected = $(this).data('detailId');
                let modalsTag = document.getElementById('modal-appointment');
                let modals = new bootstrap.Modal(modalsTag);

                getDetail(uuidSelected);

                modals.show();


            })

            $(document).on('click', '.closeDetail', function () {
                const modalsTag = document.getElementById('modal-appointment');
                const modal = new bootstrap.Modal(modalsTag);
                modal.hide();
            });


        })

        function getNyAppointment(){
            let token = localStorage.getItem('token');
            if(!token){
                window.location.href = '/login';
                return;
            }

            const urls = `{{ url('api/appointment/my') }}`;
            $.ajax({
                url : urls,
                dataType : "JSON",
                method : "GET",
                headers : {
                    'Authorization' : 'Bearer ' + token
                },
                success : function(response){
                    let content = ``;
                    if(response.status == 200){
                          let datas = response.data;
                          datas.forEach( (value,index) => {
                            content += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${value.creator}</td>
                                    <td>${value.title}</td>
                                    <td>${value.status}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary detailButton" data-detail-id="${value.uuid}">Detail</button>
                                    </td>
                                </tr>
                            `;
                          } )

                        $('#content-data').html(content);
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


        function getDetail(uuid){
            let token = localStorage.getItem('token');
            if(!token){
                window.location.href = '/login';
                return;
            }

            const urls = `{{ url('api/appointment/detail/REPLACE_ID')  }}`.replace('REPLACE_ID',uuid);

            if(itemsDetail.length > 0){
                itemsDetail = [];
            }

            $.ajax({
                url :urls,
                method : "GET",
                dataType : "JSON",
                headers  : {
                    "Authorization" : "Bearer " + token
                },
                success :function(response){
                    if(response.status == 200 && response.data.length > 0){
                        let content = ``;

                        itemsDetail = response.data;
                        itemsDetail.forEach( (value,index) => {
                            content += `
                                <tr>
                                    <td>${value.name}</td>
                                    <td>${value.timezone}</td>
                                    <td>${value.start}</td>
                                    <td>${value.end}</td>
                                </tr>
                            `;
                        })

                        $('#content-detail').html(content);
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