@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="http://placehold.it/160x160/00a65a/ffffff/&text={{ Auth::user()->name[0] }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">{{ trans('backpack::base.administration') }}</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
            

          <!-- ======================================= -->
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/elfinder') }}"><i class="fa fa-files-o"></i> <span>Файлменеджер</span></a></li>
            <li><a href="{{ url('admin/log') }}"><i class="fa fa-terminal"></i> <span>Logs</span></a></li>
            <li><a href="{{ url('admin/setting') }}"><i class="fa fa-cog"></i> <span>Установки</span></a></li>
            <li><a href="{{ url('admin/page') }}"><i class="fa fa-file-o"></i> <span>Страницы</span></a></li>
    
            <li class="treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Пользователи, Роли</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
                    <li><a href="{{ url('admin/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>

                </ul>
            </li>
            {{--<li class="treeview">--}}
                {{--<a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>--}}
                    {{--<li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>--}}
                    {{--<li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <li><a href="{{ url('admin/menu-item') }}"><i class="fa fa-list"></i> <span>Меню</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-newspaper-o"></i> <span>Новости</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/article') }}"><i class="fa fa-newspaper-o"></i> <span>Статьи</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/category') }}"><i class="fa fa-list"></i> <span>Категории</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/tag') }}"><i class="fa fa-tag"></i> <span>Теги</span></a></li>
                </ul>
            </li>
    
            <li class="treeview">
                <a href="#"><i class="fa fa-dropbox"></i> <span>Склад</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/product') }}"><i class="fa fa-list"></i> <span>Склад</span></a></li>
                    <li><a href="{{ url('admin/import') }}"><i class="fa fa-download"></i> <span>Импорт</span></a></li>
                </ul>
            </li>
            <li><a href="{{ url('admin/order') }}"><i class="fa fa-download"></i> <span>Заказы</span></a></li>
			 <li><a href="{{ url('admin/userattach') }}"><i class="fa fa-download"></i> <span>Заявки</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-dropbox"></i> <span>Фильтры TeckDoc</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/brands') }}"><i class="fa fa-list"></i> <span>Бренды производителей</span></a></li>
                    <li><a href="{{ url('admin/models_niss') }}"><i class="fa fa-download"></i> <span>Список моделей Nissan</span></a></li>
                    <li><a href="{{ url('admin/models_infin') }}"><i class="fa fa-download"></i> <span>Список моделей Infiniti</span></a></li>
                </ul>
            </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
