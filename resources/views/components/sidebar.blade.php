<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            <li class="nav-item @if (Request::path() == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            {{-- User SideBar Link --}}
            <li class="nav-item {{ (Request::is('user/create') || Request::is('user/list') || Request::is('user/edit/*') || Request::is('user/show/*') ) ? 'active' : '' }}">
                <a href="{{ route('user.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="menu-title">Users</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link {{ Request::is('user/list') ? 'active' : '' }}" href="{{ route('user.list') }}">List User</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('user/create') ? 'active' : '' }}" href="{{ route('user.addForm') }}">Add User</a></li>
                    </ul>
                </div>
            </li>

            {{-- Role SideBar Link --}}
            <li class="nav-item {{ (Request::is('role/create') || Request::is('role/list') || Request::is('role/edit/*') || Request::is('role/show/*') ) ? 'active' : '' }}">
                <a href="{{ route('role.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="at-sign"></i>
                    <span class="menu-title">Role</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link {{ Request::is('role/list') ? 'active' : '' }}" href="{{ route('role.list') }}">List Role</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('role/create') ? 'active' : '' }}" href="{{ route('role.addForm') }}">Add Role</a></li>
                    </ul>
                </div>
            </li>

            {{-- Permission SideBar Link --}}
            <li class="nav-item {{ (Request::is('permission/create') || Request::is('permission/list') || Request::is('permission/edit/*') || Request::is('permission/show/*')) ? 'active' : '' }}">
                <a href="{{ route('permission.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="unlock"></i>
                    <span class="menu-title">Permission</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link {{ Request::is('permission/list') ? 'active' : '' }}" href="{{ route('permission.list') }}">List
                                Permission</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('permission/create') ? 'active' : '' }}" href="{{ route('permission.addForm') }}">Add
                                Permission</a></li>
                    </ul>
                </div>
            </li>

            {{-- Module SideBar Link --}}
            <li class="nav-item {{ (Request::is('module/create') || Request::is('module/list') || Request::is('module/edit/*') || Request::is('module/show/*')) ? 'active' : '' }}">
                <a href="{{ route('module.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="menu-title">Module</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link {{ Request::is('module/list') ? 'active' : '' }}"
                                href="{{ route('module.list') }}">List Module</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('module/create') ? 'active' : '' }}"
                                href="{{ route('module.addForm') }}">Add Module</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
