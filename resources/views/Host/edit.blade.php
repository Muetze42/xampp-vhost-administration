@extends('layout.app')
@section('content')
    <form method="post" action="{{ route('hosts.update', $host) }}">
        <input type="hidden" name="_method" value="PUT">
        @csrf
        <div class="card shadow">
            <div class="card-header text-center h3">
                {{ __('Edit Host „:host“', ['host' => $host->name]) }}
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
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name', $host->name) }}">
                </li>
                <li class="list-group-item">
                    <select class="form-select" aria-label="Default select example" id="version" name="version">
                        @foreach($versions as $version)
                            <option value="{{ $version->id }}" @if(old('version', $host->php->id) == $version->id) selected @endif>
                                PHP {{ $version->version }}
                                @if(config('tool.options.show-php-folder'))
                                    ({{ basename($version->path) }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </li>
                <li class="list-group-item">
                    <label for="path" class="form-label">Path<span class="small text-danger">*</span></label>
                    <input type="text" class="form-control" name="path" id="path" placeholder="Path" required value="{{ old('path', $host->path) }}">
                </li>
                <li class="list-group-item">
                    <label for="domain" class="form-label">Domain<span class="small text-danger">*</span></label>
                    <input type="text" class="form-control" name="domain" id="domain" placeholder="Domain" required value="{{ old('domain', $host->domain) }}">
                </li>
                @foreach(old('subdomains', $host->subdomains) as $subdomain)
                    <li class="list-group-item">
                        <label for="subdomains" class="form-label">Subdomain</label>
                        <input type="text" class="form-control" name="subdomains[]" id="subdomains" placeholder="Subdomain" value="{{ $subdomain }}">
                    </li>
                @endforeach
                <li class="list-group-item">
                    <label for="subdomains" class="form-label">Subdomain</label>
                    <input type="text" class="form-control" name="subdomains[]" id="subdomains" placeholder="Subdomain">
                    <div class="text-center mt-1" id="add-button">
                        <a class="btn btn-sm btn-secondary" onclick="addSubdomain()">{{ __('Add Subdomain') }}</a>
                    </div>
                </li>
            </ul>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Update Virtual Host') }}
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
            newHtml += '<label for="subdomains" class="form-label">Subdomain</label>';
            newHtml += '<input type="text" class="form-control" name="subdomains[]" id="subdomains" placeholder="Subdomain">';
            newHtml += '</li>';
            newHtml += '<div class="text-center mt-1" id="add-button">';
            newHtml += '<a class="btn btn-sm btn-secondary" onclick="addSubdomain()">{{ __('Add Subdomain') }}</a>';
            newHtml += '</div>';
            ele.insertAdjacentHTML('beforeend', newHtml);
        }
    </script>
@endpush
