@extends('layout.app')
@section('content')
    <div class="card shadow">
        <div class="card-header">
            @include('list-search')
        </div>
        @if(session()->has('success'))
            <x-alert type="success" :message="session('success')" class="mb-0 rounded-0"/>
            @push('scripts')
                <script>
                    setTimeout(function () {
                        let successAlert = new bootstrap.Alert(document.querySelector('.alert'))
                        successAlert.close()
                    }, 1200);
                </script>
            @endpush
        @endif
        <ul class="list-group list-group-flush" id="list">
            @foreach($hosts as $host)
                @if(isLaravel($host->path))
                    @php($usage = 'Laravel')
                @elseif(isWordPress($host->path))
                    @php($usage = 'WordPress')
                @else
                    @php($usage = null)
                @endif
                <li class="list-group-item">
                    <div class="card-title d-inline-block">
                        <a href="http://{{ $host->domain }}" class="h3 text-success">
                            {{ $host->name }}
                        </a>
                        <sup class="badge {{ $host->php->default ? 'bg-php border shadow-sm' : 'bg-php2 shadow-sm' }}">
                            PHP {{ explode('.', $host->php->version)[0] }}
                            @if(config('tool.options.show-php-folder'))
                                [{{ basename($host->php->path) }}]
                            @endif
                        </sup>
                    </div>
                    <form class="float-end" method="post" action="{{ route('hosts.destroy', $host) }}" onsubmit="return confirm('{{ __('Really delete this host?') }}');">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                        @if($usage)
                            <span class="visually-hidden">{{ __($usage) }}</span>
                            <span class="fa-stack" style="vertical-align: top; cursor: help;" title="{{ __($usage) }}">
                                <i class="fas fa-circle fa-stack-2x text-light"></i>
                                <i class="fab fa-{{ strtolower($usage) }} fa-stack-1x text-{{ strtolower($usage) }}"></i>
                            </span>
                        @endif
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-primary" href="{{ route('hosts.edit', $host) }}">
                                <i class="fas fa-pen fa-fw"></i>
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-minus-circle fa-fw"></i>
                            </button>
                            <a class="btn btn-info text-light" data-bs-toggle="collapse" href="#collapse{{ $host->id }}" role="button" aria-expanded="false" aria-controls="collapse{{ $host->id }}">
                                <i class="fas fa-info fa-fw"></i>
                            </a>
                        </div>
                    </form>
                    <div class="collapse" id="collapse{{ $host->id }}">
                        <p>
                            <code>{{ $host->path }}<br>http://{{ $host->domain }}</code>
                        </p>
                        <div class="mt-2">
                            <a href="http://{{ $host->domain }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-home fa-fw"></i>
                            </a>
                            @if(count($host->subdomains))
                                <div class="btn-group">
                                    @foreach($host->subdomains as $subdomain)
                                        <a href="http://{{ $subdomain }}.{{ $host->domain }}" class="btn btn-sm btn-info">{{ $subdomain }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
