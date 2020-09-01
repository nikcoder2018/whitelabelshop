<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a class="active" href="{{route('dashboard')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->role == 'admin')
            <li class="sub-menu">
                <a href="javascript:;" >
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
                <a href="javascript:;" >
                    <i class="fa fa-book"></i>
                    <span>Pages</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('pages.index')}}">All Pages</a></li>
                    <li><a href="{{route('pages.create')}}">Add New Page</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-shopping-cart"></i>
                    <span>Products</span>
                </a>
                <ul class="sub">
                    <li><a href="{{route('products.index')}}">All Products</a></li>
                    <li><a href="{{route('products.create')}}">Add Product</a></li>
                    <li><a href="{{route('categories.index')}}">Categories</a></li>
                    <li><a href="{{route('tags.index')}}">Tags</a></li>
                    <li><a href="{{route('attributes.index')}}">Attributes</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
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