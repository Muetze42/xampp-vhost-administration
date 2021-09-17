@extends('layout.app')
@section('content')
    <div class="card shadow">
        <div class="card-header text-center h3">
            {{ __('PHP Versions') }}
        </div>
        <ul class="list-group list-group-flush" id="list">
            @foreach($phps as $php)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            PHP
                            {{ $php->version }}<br>
                            Commands: <code>`{{ $php->cmd_php }}`</code>,
                            <code>`{{ $php->cmd_composer }}`</code>
                        </div>
                        <div class="col text-end">
                            <a class="btn btn-sm btn-primary" href="{{ route('php.edit', $php) }}">
                                <i class="fas fa-pen fa-fw"></i>
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
