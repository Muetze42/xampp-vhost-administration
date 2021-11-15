@extends('Host.create')
@section('installer')
    <li class="list-group-item">
        <select class="form-select" aria-label="{{ __('Select Installer') }}" id="installer" name="installer">
            @foreach($installers as $installer)
                <option value="{{ $installer }}" @if(old('installer') == $installer) selected @endif>{{ $installer }}</option>
            @endforeach
        </select>
    </li>
    <li class="list-group-item">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="create-database" id="create-database">
            <label class="form-check-label" for="create-database">
                {{ __('Create Database') }}
            </label>
        </div>
    </li>
@endsection
