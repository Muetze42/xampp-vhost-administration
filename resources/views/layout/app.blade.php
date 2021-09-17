<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ _asset('css/app.css') }}" rel="stylesheet">
    <title>{{ siteTitle() }}</title>
    <link href="{{ _asset('favicon.png') }}" rel="icon" type="image/png" />
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-success fixed-top py-0">
    <ul class="navbar-nav">
        @foreach($menuItems as $name => $route)
            @if(request()->route()->getName() == $route)
                <li class="nav-item btn btn-sm btn-success p-0 rounded-0">
                    <a class="nav-link active bold" aria-current="page" href="{{ route($route) }}">{!! $name !!}</a>
                </li>
            @else
                <li class="nav-item btn btn-sm btn-success p-0 rounded-0">
                    <a class="nav-link" href="{{ route($route) }}">{!! $name !!}</a>
                </li>
            @endif
        @endforeach
    </ul>
    <ul class="navbar-nav ms-auto">
        @if(request()->route()->getName() == 'hosts.index')
            <li class="nav-item btn btn-sm btn-success p-0 rounded-0">
                <form method="post" action="{{ route('update.hosts') }}">
                    <a class="nav-link" href="#" onclick="this.parentNode.submit(); return false;">
                        <i class="fas fa-sync-alt fa-fw"></i>
                        {{ __('Renew Host File') }}
                    </a>
                </form>
            </li>
            <li class="nav-item btn btn-sm btn-success p-0 rounded-0">
                <form method="post" action="{{ route('update.vhosts') }}">
                    <a class="nav-link" href="#" onclick="this.parentNode.submit(); return false;">
                        <i class="far fa-window-restore fa-fw"></i>
                        {{ __('Renew VHosts Conf') }}
                    </a>
                </form>
            </li>
        @endif
        <li class="nav-item btn btn-sm btn-success p-0 rounded-0">
            <a class="nav-link" href="http://localhost/phpmyadmin" title="phpMyAdmin" target="_blank">
                <i class="fas fa-database fa-fw"></i>
                {{ __('phpMyAdmin') }}
            </a>
        </li>
    </ul>
</nav>
<main id="app" class="flex-shrink-0">
    <div class="container">
        @yield('content')
    </div>
</main>
<script src="{{ _asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
