@extends('install.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('app.App Installer')</div>
                    <div class="card-body bg-success">
                        <p>@lang('app.App Installed Successfully')</p>
                        <a href="{{ route('login') }}">@lang('app.Return to Login')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
