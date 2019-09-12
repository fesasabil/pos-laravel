<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>

        @role('admin')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Management Users</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('role.index') }}"><i class="fa fa-circle-o"></i> Role</a></li>
            <li><a href="{{ route('users.role_permission') }}"><i class="fa fa-circle-o"></i> Role Permissions</a></li>
            <li><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i>Users</a></li>
          </ul>
        </li>
        @endrole

        @if(auth()->user()->can('show products') || auth()->user()->can('delete products') || auth()->user()->can('create products'))
        <li class="treeview">
          <a href="#">
            <i class="fa fa-server"></i>
            <span>Manajement Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('category.index') }}"><i class="fa fa-circle-o"></i> Category</a></li>
            <li><a href="{{ route('product.index') }}"><i class="fa fa-circle-o"></i> Product</a></li>
          </ul>
        </li>
        @endif

        @role('kasir')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> 
            <span>Transaction</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
          </ul>
        </li>
        @endrole
        
        <li class="treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-shopping-bag"></i> <span>Manajement Order</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('order.index') }}"><i class="fa fa-circle-o"></i> Order</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        
        <li class="nav-item has-treeview">
            <a href="{{ route('logout')}}" class="nav-link"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <p>
                {{ __('Logout') }}
              </p>
            </a>

            <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display-none;">
            @csrf
            </form>
          </li>
          
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>