<!--header start-->
<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <i class="fa fa-bars"></i>
    </div>
  <!--logo start-->
  <a href="{{route('dashboard')}}" class="logo">Noname<span>Shop</span></a>
  <!--logo end-->

  <div class="top-nav ">
      <!--search & user info start-->
      <ul class="nav pull-right top-menu">
          <!-- user login dropdown start-->
          <li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                  <img alt="" src="{{asset('img/avatar1_small.jpg')}}">
                  <span class="username">{{Auth::user()->firstname}}</span>
                  <b class="caret"></b>
              </a>
              <ul class="dropdown-menu extended logout dropdown-menu-right">
                  <div class="log-arrow-up"></div>
                  <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                  <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                  <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-key"></i> Log Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
              </ul>
          </li>
          <!-- user login dropdown end -->
      </ul>
      <!--search & user info end-->
  </div>
</header>
<!--header end-->