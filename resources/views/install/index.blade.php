@extends('install.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('app.App Installer')</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul style="list-style: none">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('process_install') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" name="db_name" placeholder="@lang('app.DB Name')" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="db_host" placeholder="@lang('app.DB Host')" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="db_user" placeholder="@lang('app.DB Username')" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="db_password" placeholder="@lang('app.DB Password')" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="site_name" placeholder="@lang('app.Site Name')" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="site_username" placeholder="@lang('app.Site Username')" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="@lang('app.Email')" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="@lang('app.Password')" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="@lang('app.Submit')" class="btn-block btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
