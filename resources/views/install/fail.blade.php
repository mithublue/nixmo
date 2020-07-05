@extends('install.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('app.Whoops!')</div>
                    <div class="card-body bg-danger">
                        <p>@lang('app.Something went wrong !')</p>
                        <a href="{{ route('install') }}">@lang('app.Try again')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
