<div class="navigation">
    <form action="" method="GET" class="search">
        <input type="text" name="search" placeholder="Search" autocomplete="off">
        <span class="fa fa-search"></span>
    </form>
    <div class="navigation-item">
        <div class="quick-links">
            <a href="#"><span class="fa fa-bell"></span> <span class="badge badge-warning">5</span></a>
            <a href="#"><span class="fa fa-envelope"></span> <span class="badge badge-primary">5</span></a>
        </div>
        <div class="dropdown">
            <a class="user dropdown-toggle" href="javascript:void(0)">
                <div class="user-img">
                    <img src="{{ asset('assets/images/rahul.jpg') }}">
                </div>
                <div class="user-title">
                    <strong class="user-name">{{ auth()->user()->name }}</strong>
                    <span class="user-role">{{ auth()->user()->roles()->first()->role->name }}</span>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-right">
                <li class="dropdown-item"><a href="#"><span class="fa fa-user"></span> Profile</a></li>
                <li class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><a href="javascript:;"><span class="fa fa-sign-out"></span> Logout</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </div>
</div>