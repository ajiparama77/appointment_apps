<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header bg-info">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
                        </span>
                    </a>

                    <a href="index" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                

            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="text-start ms-xl-2">
                                 <img class="rounded-circle header-profile-user" src="{{ URL::asset('images/animate.jpg') }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text nameUser"></span>
                               
                            </span>

                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome</h6>
                        <a class="dropdown-item" href="{{ route('profile') }}" class=""><i class="bx bx-user-circle font-size-16 align-middle me-1"></i>Edit Profile</a>
                        <a class="dropdown-item " href="javascript:void();" onclick="logoutProcess()"><i class="bx bx-power-off font-size-16 align-middle me-1"></i> <span key="t-logout">@lang('translation.logout')</span></a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<script>

    $(document).ready(function(){
        myProfile();
    })

    function logoutProcess(){
        let token = localStorage.getItem('token');
        console.log('token : ',token);

        const urls = `{{ url('api/logout') }}`;
        $.ajax({
            url : urls,
            method : "POST",
            headers : {
                "Authorization" : "Bearer " + token 
            },
            success :function(response){
                console.log('resp',response);
                if(response.success == true){
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                }
            },
            error : function(xhr){
                if(xhr.status === 401){
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                }
            }
        })

    }


    function myProfile(){
            let token = localStorage.getItem('token');
            if(!token){
                window.location.href = '/login';
                return;
            }

            const urls = `{{ url('api/profile/get') }}`;
            $.ajax({
                url           :urls,
                method        : "GET",
                dataType      : "JSON",
                headers       : {
                    "Authorization" : "Bearer " + token
                },
                success :function(response){
                    if(response.status == 200){
                        $('.nameUser').text(response.data.name);
                    }
                },
                error : function(xhr){
                    if (xhr.status == 401) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    }
                }
            })

        }

</script>
