@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Terms</div>
                    <div class="card-body">
                        @can( 'create', \App\Post::class)
                            <a href="{{ \App\Includes\Classes\Router()->get_route( 'create', null, 'taxonomy', $common['taxonomy'] ) }}" class="btn btn-success btn-sm" title="Add New Term">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add New
                            </a>
                        @endcan

                        <form method="GET" action="{{ \App\Includes\Classes\Router()->get_route( 'browse', null, 'taxonomy', $common['taxonomy'] ) }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th><th>Name</th><th>Slug</th><th>Taxonomy</th><th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($terms as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td><td>{{ $item->slug }}</td><td>{{ $item->taxonomy }}</td>
                                        <td>
                                            @can('read',$item)
                                                <a href="{{ \App\Includes\Classes\Router()->get_route( 'read', $item->id, 'taxonomy', $common['taxonomy'] ) }}" title="View Term"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            @endcan
                                            @can('edit',$item)
                                                <a href="{{ \App\Includes\Classes\Router()->get_route( 'edit', $item->id, 'taxonomy', $common['taxonomy'] ) }}" title="Edit Term"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            @endcan
                                            @can('delete',$item)
                                                <form method="POST" action="{{ \App\Includes\Classes\Router()->get_route( 'delete', $item->id, 'taxonomy', $common['taxonomy'] ) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Term" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $terms->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
