<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            <li class="nav-item @if (Request::path() == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            @foreach ($uniqueModules as $uniqueModule)
                <li class="nav-item">
                    <button href="#" class="nav-link">
                        <i class="link-icon" data-feather="inbox"></i>
                        <span class="menu-title">{{ $uniqueModule->name }}</span>
                        <i class="link-arrow"></i>
                    </button>
                    <div class="submenu">
                        <ul class="submenu-item">
                            @foreach ($modules as $module)
                                @if ($module->parentModule->id === $uniqueModule->id)
                                    @if (Auth::user()->type === 'admin')
                                        <li class="nav-item"><a class="nav-link"
                                                href="@if ($module->name == 'User') {{ route('user.list') }}
                                            @elseif ($module->name == 'Role') {{ route('role.list') }}
                                            @elseif ($module->name == 'Permission') {{ route('permission.list') }}
                                            @elseif ($module->name == 'Module') {{ route('module.list') }}
                                            @else {{ route('comingSoon') }} @endif ">{{ $module->name }}</a>
                                        </li>
                                    @elseif (Auth::user()->type != 'admin' &&
                                            auth()->user()->hasModulePermission(strtolower($module->name)))
                                        <li class="nav-item"><a class="nav-link"
                                                href="@if ($module->name == 'User') {{ route('user.list') }} @elseif ($module->name == 'Role') {{ route('role.list') }} @elseif ($module->name == 'Permission') {{ route('permission.list') }}@elseif ($module->name == 'Module') {{ route('module.list') }}@else {{ route('comingSoon') }} @endif">{{ $module->name }}</a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>
</nav>
