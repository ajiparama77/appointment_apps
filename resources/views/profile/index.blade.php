@extends('layouts_global.master')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span><h4>Daftar Profil</h4></span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody id="content-data">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>

    $(document).ready(function(){
        getUsers();
    })

    function getUsers(){
        let token = localStorage.getItem('token');
        if(!token){
            window.location.href = '/login'
        }

        const urls = `{{ url('api/profile/list') }}`;
        $.ajax({
            url :urls,
            method : "GET",
            dataType : "JSON",
            headers : {
                'Authorization' : 'Bearer ' + token
            },
            success :function(response){
                if(response.data.length > 0){
                    let items = response.data;
                    let content = ``;
                    items.forEach( (value,index) => {
                        content += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${value.name}</td>
                                <td>${value.username}</td>
                                <td>${value.preffered_timezone}</td>
                            </tr>
                        `;

                    } )

                    $('#content-data').html(content);

                    
                }
            },
             error :function(xhr){
                if(xhr.status == 401){
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                }
            }

        })

    }

</script>

@endsection

