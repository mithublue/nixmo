<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Post_Term;
use Illuminate\Http\Request;

class Post_TermController extends Controller
{
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
            $post_term = Post_Term::where('term_id', 'LIKE', "%$keyword%")
                ->orWhere('post_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $post_term = Post_Term::latest()->paginate($perPage);
        }

        return view('admin.post_-term.index', compact('post_term'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.post_-term.create');
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
        
        $requestData = $request->all();
        
        Post_Term::create($requestData);

        return redirect('admin/post_-term')->with('flash_message', 'Post_Term added!');
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
        $post_term = Post_Term::findOrFail($id);

        return view('admin.post_-term.show', compact('post_term'));
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
        $post_term = Post_Term::findOrFail($id);

        return view('admin.post_-term.edit', compact('post_term'));
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
        
        $requestData = $request->all();
        
        $post_term = Post_Term::findOrFail($id);
        $post_term->update($requestData);

        return redirect('admin/post_-term')->with('flash_message', 'Post_Term updated!');
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
        Post_Term::destroy($id);

        return redirect('admin/post_-term')->with('flash_message', 'Post_Term deleted!');
    }
}
