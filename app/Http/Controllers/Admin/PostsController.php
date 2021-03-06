<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Includes\Classes\PostType;
use function App\Includes\Classes\Router;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    protected $common = [];

    /**
     * PostsController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->common = [
            'post_type' =>  $request->segment(3),
            'model' => (new Post()),
        ];

        view()->share( ['common' => $this->common ] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $posts = $this->common['model']->where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('post_type', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->orWhere('excerpt', 'LIKE', "%$keyword%")
                ->orWhere('comment_status', 'LIKE', "%$keyword%")
                ->orWhere('password', 'LIKE', "%$keyword%")
                ->orWhere('slug', 'LIKE', "%$keyword%")
                ->orWhere('parent_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $posts = $this->common['model']->where( 'post_type', $this->common['post_type'] )->latest()->paginate($perPage);
        }

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.posts.create', [ 'post' => $this->common['model'] ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $flash_message = '';

        $this->validate($request, apply_filters( 'ctrl_validate_store_request', [
            'title' => 'required'
        ], $request, __CLASS__ ) );
        $requestData = $request->all();
        $fillables = $this->common['model']->getFillable();
        $model = $this->common['model'];

        foreach ( $fillables as $k => $fillable ) {
            if ( isset( $requestData[$fillable] ) ) {
                $model->{$fillable} = $requestData[$fillable];
            }
        }

        //set post type
        if( !isset( $model->post_type ) ) {
            $model->post_type = $this->common['post_type'];
        }

        //user_id
        if( !isset( $model->user_id ) ) {
            $model->user_id = Auth::user()->id;
        }

        do_action( 'ctrl-before_save_post', $this->common, $model );

        $res = $model->save();

        if( $res ) {

            $flash_message = 'Post added!';

            do_action( 'ctrl-save_post', $this->common, $model );

            //save meta fields
            $metaFillables = $model->getMetaFillable();

            foreach ( $metaFillables as $k => $metaFillable ) {

                if( isset( $requestData[$metaFillable] ) ) {
                    $model->setMeta( $metaFillable, $requestData[$metaFillable] );
                }
            }

        }

        $flash_message = 'Post could not be added!';

        return redirect( Router()->get_route( 'browse', null, 'post_type', $this->common['post_type']) )->with( 'flash_message', $flash_message );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $post = $this->common['model']->findOrFail($id);

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $post = $this->common['model']->findOrFail($id);

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, apply_filters( 'ctrl_validate_update_request', [
            'title' => 'required'
        ], $request, __CLASS__ ) );
        $requestData = $request->all();
        
        $post = $this->common['model']->findOrFail($id);
        $post->update($requestData);

        return redirect( Router()->get_route( 'browse', null, 'post_type', $this->common['post_type']) )->with('flash_message', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->common['model']->where( 'id', $id )->delete();
        return redirect(Router()->get_route( 'browse', null, 'post_type', $this->common['post_type']) )->with('flash_message', 'Post deleted!');
    }
}
