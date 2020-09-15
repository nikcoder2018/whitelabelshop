<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a class="{{ Request::segment(2) === 'dashboard' ? 'active' : null }}" href="{{route('dashboard')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->role == 'admin')
            <li class="sub-menu">
                <a href="javascript:;" class="{{ Request::segment(2) === 'users' ? 'active' : null }}">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('admins.index')}}">Admins</a></li>
                    <li><a href="{{route('vendors.index')}}">Vendors</a></li>
                </ul>
            </li>
            @endif
            <li class="sub-menu">
                <a href="javascript:;" class="{{ Request::segment(2) === 'pages' ? 'active' : null }}">
                    <i class="fa fa-book"></i>
                    <span>Pages</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('pages.index')}}">All Pages</a></li>
                    <li><a href="{{route('pages.create')}}">Add New Page</a></li>
                </ul>
            </li>
            <li>
                <a href="{{route('posts.index')}}" class="{{ Request::segment(2) === 'posts' ? 'active' : null }}">
                    <i class="fa fa-thumb-tack"></i>
                    <span>Posts</span>
                </a>
            </li>
            <li>
                <a href="{{route('categories.index')}}" class="{{ Request::segment(2) === 'categories' ? 'active' : null }}">
                    <i class="fa fa-list-ul"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li>
                <a href="{{route('tags.index')}}" class="{{ Request::segment(2) === 'tags' ? 'active' : null }}" >
                    <i class="fa fa-tags"></i>
                    <span>Tags</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" class="{{ Request::segment(2) === 'setting' ? 'active' : null }}">
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub">
                    <li><a href="/">General</a></li>
                    <li><a href="/">Menu</a></li>
                </ul>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->