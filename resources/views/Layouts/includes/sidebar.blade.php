<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
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
          <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                  <i class="nav-icon fa fa-dashboard"></i>
                  <p>
                      Dashboard
                  </p>
              </a>
          </li>
        @if(auth()->user()->can('show products') || auth()->user()->can('delete products') || auth()->user()->can('create products'))
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
              <i class="nav-icon fa fa-server"></i>
              <p>
                  Manajemen Produk
                  <i class="right fa fa-angle-left"></i>
              </p>
          </a>

        <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="{{ route('category.index')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Category</p>
              </a>
          </li>

          <li class="nav-item">
              <a href="{{ route('product.index') }}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Product</p>
              </a>
          </li>
          </ul>
        </li>
        @endif
        
        @role('admin')
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-user"></i>
            <p>
              Manajement Users
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('role.index') }}" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Role</p>
              </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('users.role_permission') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>Role Permission</p>
                </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
          </ul>
        </li>
        @endrole

        @role('kasir')
        <li class="nav-item">
          <a href="{{ route('order.transaction') }}" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i>
            <p>
              Transaction
            </p>
          </a>
        </li>
        @endrole

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
    </section>
    <!-- /.sidebar -->
  </aside>