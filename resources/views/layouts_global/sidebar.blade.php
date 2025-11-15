
<div class="app-menu navbar-menu bg-info">
    <br>
    <div class="navbar-brand-box">
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar" style="padding-top:10px;">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title text-white"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link bg-info" href="{{url('')}}">
                        <i class="ri-home-2-line text-white"></i> <span class="text-white">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link bg-info" href="{{route('show-users')}}">
                        <i class='bx  bx-user text-white'></i>  <span class="text-white">Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link bg-info" href="{{ route('appointment') }}">
                        <i class="ri-calendar-line text-white"></i> <span class="text-white">My Appointment</span>
                    </a>
                </li>
              
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>