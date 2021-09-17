@extends('Host.create')
@section('installer')
    <li class="list-group-item">
        <select class="form-select" aria-label="{{ __('Select Installer') }}" id="installer" name="installer">
            @foreach($installers as $installer)
                <option value="{{ $installer }}" @if(old('installer') == $installer) selected @endif>{{ $installer }}</option>
            @endforeach
        </select>
    </li>
@endsection
