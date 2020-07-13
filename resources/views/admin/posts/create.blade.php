@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-10">
                <div class="row">
                    <div class="col-sm-12">
                        <h5>@lang('app.Create New Post')</h5>
                    </div>
                </div>
                <a href="{{ \App\Includes\Classes\Router()->get_route( 'browse', null, 'post_type', $common['post_type'] ) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ \App\Includes\Classes\Router()->get_route('store', null, 'post_type', $common['post_type'] ) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @include ('admin.posts.form', ['formMode' => 'create'])
                </form>

            </div>
        </div>
    </div>
@endsection
