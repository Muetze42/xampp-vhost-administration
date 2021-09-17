@extends('layout.app')
@section('content')
    <form method="post" action="{{ route('php.update', $php) }}">
        <input type="hidden" name="_method" value="PUT">
        @csrf
        <div class="card shadow">
            <div class="card-header text-center h3">
                PHP
                {{ $php->version }}
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
            @if ($errors->any())
                <div class="alert alert-danger mb-0 rounded-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <label for="cmd_php" class="form-label">{{ __('PHP Command') }}</label>
                    <input type="text" class="form-control" id="cmd_php" name="cmd_php" value="{{ old('cmd_php') ? old('cmd_php') : $php->cmd_php }}" required>
                </li>
                <li class="list-group-item">
                    <label for="cmd_composer" class="form-label">{{ __('Composer Command') }}</label>
                    <input type="text" class="form-control" id="cmd_composer" name="cmd_composer" value="{{ old('cmd_composer') ? old('cmd_composer') : $php->cmd_composer }}" required>
                </li>
                @foreach($editable as $edit)
                    <li class="list-group-item">
                        <label for="{{ __($edit) }}" class="form-label">{{ __($edit) }}</label>
                        <input type="text" class="form-control" id="{{ $edit }}" name="{{ $edit }}" value="{{ old($edit) ? old($edit) : $ini->getValue($edit) }}" required>
                    </li>
                @endforeach
            </ul>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Update PHP Version') }}
                </button>
            </div>
        </div>
    </form>
@endsection
