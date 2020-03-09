<?php
    if(!isset($page)){
        $page = '';
        $pages = '';
    }
    else{

        if($page == 'createstudent' || $page == 'viewstudent'){
            $pages = 'managestudent';
        }
        else if($page == 'home'){
            $pages ='dashboard';
        }
        else if($page == 'createroom' || $page == 'viewroom' || $page == 'fillvacent'){
            $pages = 'manageroom';
        }
        else if($page == 'monthlycost'){
            $pages = 'monthlycost';
        }
        else if($page == 'employee'){
            $pages = 'employee';
        }
        else if($page == 'transaction'){
            $pages = 'transaction';
        }
        else if($page == 'setting'){
            $pages = 'setting';
        }
        else if($page == 'allmeal' || $page == 'singlemeal' || $page == 'empallmeal'){
            $pages = 'meal';
        }
        else{
            $pages = '';
        }
    }
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('dashboard')}}" class="brand-link">
    <img src="{{asset('assets/img/bauet.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">BAUET</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('assets/dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{route('dashboard')}}" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link @if ($pages == 'dashboard')
                                active
                            @endif">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>

        <li class="nav-item has-treeview @if ($pages == 'managestudent')
                          menu-open
                      @endif">
          <a href="#" class="nav-link @if ($pages == 'managestudent')
                            active
                        @endif">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>
              Student
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('view.student')}}" class="nav-link @if ($page == 'viewstudent')
                            active
                        @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Student List</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview @if ($pages == 'manageroom')
                          menu-open
                      @endif">
          <a href="#" class="nav-link @if ($pages == 'manageroom')
                            active
                        @endif">
            <i class="nav-icon fas fa-hotel"></i>
            <p>
              Manage Room
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/createroom" class="nav-link @if ($page == 'createroom')
                            active
                        @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Room</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('view.room')}}" class="nav-link @if ($page == 'viewroom')
                            active
                        @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>All Room</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('fill.vacent')}}" class="nav-link @if ($page == 'fillvacent')
                            active
                        @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Fill/Vacent History</p>
              </a>
            </li>
          </ul>
        </li>


        <li class="nav-item has-treeview @if ($pages == 'meal')
                          menu-open
                      @endif">
          <a href="#" class="nav-link @if ($pages == 'meal')
                            active
                        @endif">
            <i class="nav-icon fas fa-utensils"></i>
            <p>
              Manage Meal
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('view.monthpage')}}" class="nav-link @if ($page == 'allmeal')
                            active
                        @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Student Meal</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('search.single_student_meal')}}" class="nav-link @if ($page == 'singlemeal')
                            active
                        @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Search Student Meal</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('view.empmonthpage')}}" class="nav-link @if ($page == 'empallmeal')
                            active
                        @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Employee Meal</p>
              </a>
            </li>

          </ul>
        </li>


        <li class="nav-item">
          <a href="{{route('monthly.cost')}}" class="nav-link @if ($pages == 'monthlycost')
                        active
                    @endif">
            <i class="nav-icon far fa-money-bill-alt"></i>
            <p>
              Monthly Cost
            </p>
          </a>
        </li>

        <li class="nav-item">
            <a href="{{route('view.transaction')}}" class="nav-link @if ($pages == 'transaction')
                                active
                            @endif">
                <i class="nav-icon far fa-money-bill-alt"></i>
                <p>
                    Transaction History
                </p>
            </a>
        </li>

        <li class="nav-item">
          <a href="{{route('manage.employee')}}" class="nav-link @if ($pages == 'employee')
                        active
                    @endif">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Manage Employee
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('setting')}}" class="nav-link @if ($pages == 'setting')
                        active
                    @endif">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Setting
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
