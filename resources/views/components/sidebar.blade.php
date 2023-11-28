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
                @if (count($uniqueModule->childModules) > 0)
                    <li class="nav-item">
                        <button href="" class="nav-link">
                            <i class="link-icon" data-feather="inbox"></i>
                            <span class="menu-title">{{ $uniqueModule->name }}</span>
                            <i class="link-arrow"></i>
                        </button>
                        <div class="submenu">
                            <ul class="submenu-item">
                                @foreach ($modules as $module)
                                    @php
                                        $isActive = '';
                                    @endphp
                                    @if (Request::is(strtolower($module->code) . '/list') ||
                                            Request::is(strtolower($module->code) . '/create') ||
                                            Request::is(strtolower($module->code) . '/edit/*') ||
                                            Request::is(strtolower($module->code) . '/show/*'))
                                        @php
                                            $isActive = 'active';
                                        @endphp
                                    @endif

                                    @if ($module->parentModule->id === $uniqueModule->id)
                                        @if (Auth::user()->type === 'admin')
                                            <li class="nav-item {{ $isActive }}">
                                                <a class="nav-link"
                                                    href="@if ($module->code == 'user') {{ route('user.list') }}
                                            @elseif ($module->code == 'role') {{ route('role.list') }}
                                            @elseif ($module->code == 'perm') {{ route('perm.list') }}
                                            @elseif ($module->code == 'module') {{ route('module.list') }}
                                            @elseif ($module->code == 'demo') {{ route('demo.list') }}
                                            @else {{ route('comingSoon') }} @endif ">{{ $module->name }}</a>
                                            </li>
                                        @elseif (Auth::user()->type != 'admin' &&
                                                auth()->user()->hasAccess(strtolower($module->code), ''))
                                            <li class="nav-item {{ $isActive }}"><a class="nav-link"
                                                    href="@if ($module->code == 'user') {{ route('user.list') }} @elseif ($module->code == 'role') {{ route('role.list') }} @elseif ($module->code == 'perm') {{ route('perm.list') }}@elseif ($module->code == 'module') {{ route('module.list') }} @elseif ($module->code == 'demo') {{ route('demo.list') }}@else {{ route('comingSoon') }} @endif">{{ $module->name }}</a>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    @if (Auth::user()->type === 'admin' || auth()->user()->hasAccess(strtolower($uniqueModule->code), ''))
                        <li class="nav-item">
                            <a href="@if ($uniqueModule->code == 'user') {{ route('user.list') }}
                        @elseif ($uniqueModule->code == 'role') {{ route('role.list') }}
                        @elseif ($uniqueModule->code == 'perm') {{ route('perm.list') }}
                        @elseif ($uniqueModule->code == 'module') {{ route('module.list') }}
                        @elseif ($uniqueModule->code == 'demo') {{ route('demo.list') }}
                        @else {{ route('comingSoon') }} @endif "
                                class="nav-link">
                                <i class="link-icon" data-feather="hash"></i>
                                <span class="menu-title">{{ $uniqueModule->name }}</span></a>
                        </li>
                    @endif
                @endif
            @endforeach

        </ul>
    </div>
</nav>
