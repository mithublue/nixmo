<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Term;
use Illuminate\Http\Request;

class TermsController extends Controller
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
            $terms = Term::where('name', 'LIKE', "%$keyword%")
                ->orWhere('slug', 'LIKE', "%$keyword%")
                ->orWhere('taxonomy', 'LIKE', "%$keyword%")
                ->orWhere('post_type', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $terms = Term::latest()->paginate($perPage);
        }

        return view('admin.terms.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.terms.create');
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
        $this->validate($request, apply_filters( 'ctrl_validate_store_request',[
			'name' => 'required',
			'slug' => 'required'
		], $request, __CLASS__ ) );
        $requestData = $request->all();
        
        Term::create($requestData);

        return redirect('admin/terms')->with('flash_message', 'Term added!');
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
        $term = Term::findOrFail($id);

        return view('admin.terms.show', compact('term'));
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
        $term = Term::findOrFail($id);

        return view('admin.terms.edit', compact('term'));
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
			'name' => 'required',
			'slug' => 'required'
		], $request, __CLASS__ ) );
        $requestData = $request->all();
        
        $term = Term::findOrFail($id);
        $term->update($requestData);

        return redirect('admin/terms')->with('flash_message', 'Term updated!');
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
        Term::destroy($id);

        return redirect('admin/terms')->with('flash_message', 'Term deleted!');
    }
}
