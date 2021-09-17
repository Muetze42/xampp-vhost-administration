@extends('layout.app')
@section('content')
    <form method="post" action="{{ $formAction }}">
        @csrf
        <div class="card shadow">
            <div class="card-header text-center h3">
                {{ $title }}
            </div>
            @if ($errors->any())
                <div class="alert alert-danger mb-0 rounded-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <ul class="list-group list-group-flush" id="ul-form">
                <li class="list-group-item">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                </li>
                @yield('installer')
                <li class="list-group-item">
                    <select class="form-select" aria-label="{{ __('Default select example') }}" id="version" name="version">
                        @foreach($versions as $version)
                            <option value="{{ $version->id }}" @if(old('version') == $version->id) selected @endif>
                                PHP {{ $version->version }}
                                @if(config('tool.options.show-php-folder'))
                                    ({{ basename($version->path) }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </li>
                <li class="list-group-item">
                    <label for="path" class="form-label">{{ __('Path') }}<span class="small text-danger">*</span></label>
                    <input type="text" class="form-control" name="path" id="path" required value="{{ old('path') }}">
                </li>
                <li class="list-group-item">
                    <label for="domain" class="form-label">{{ __('Domain') }}<span class="small text-danger">*</span></label>
                    <input type="text" class="form-control" name="domain" id="domain" required value="{{ old('domain') }}">
                </li>
                @if(old('subdomains'))
                    @foreach(old('subdomains') as $subdomain)
                        <li class="list-group-item">
                            <label for="subdomains" class="form-label">{{ __('Subdomain') }}</label>
                            <input type="text" class="form-control" name="subdomains[]" id="subdomains" value="{{ $subdomain }}">
                        </li>
                    @endforeach
                @endif
                <li class="list-group-item">
                    <label for="subdomains" class="form-label">{{ __('Subdomain') }}</label>
                    <input type="text" class="form-control" name="subdomains[]" id="subdomains">
                    <div class="text-center mt-1" id="add-button">
                        <a class="btn btn-sm btn-secondary" onclick="addSubdomain()">{{ __('Add Subdomain') }}</a>
                    </div>
                </li>
            </ul>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Create Virtual Host') }}
                </button>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
    <script>
        function addSubdomain() {
            let element = document.getElementById("add-button");
            element.remove();

            let ele = document.getElementById("ul-form");
            let newHtml = '<li class="list-group-item">';
            newHtml += '<label for="subdomains" class="form-label">{{ __('Subdomain') }}</label>';
            newHtml += '<input type="text" class="form-control" name="subdomains[]" id="subdomains">';
            newHtml += '</li>';
            newHtml += '<div class="text-center mt-1" id="add-button">';
            newHtml += '<a class="btn btn-sm btn-secondary" onclick="addSubdomain()">{{ __('Add Subdomain') }}</a>';
            newHtml += '</div>';
            ele.insertAdjacentHTML('beforeend', newHtml);
        }
    </script>
@endpush
