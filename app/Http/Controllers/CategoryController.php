<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->paginate(5);
        return view('Categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi form
        $this->validate($request, [
            'category' => 'required|string|max:50',
            'description' => 'required|nullable|string',
        ]);
        
        try{
            $categories = Category::Create([
                'category' => $request->category,
                'description' => $request->description
            ]);
            return redirect()->back()->with(['success' => 'Category: ' . $categories->category . ' Added']);
        }catch(Exeption $e) {
            return redirect()->back()->with(['error'=> $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('Categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validasi form
        $this->validate($request, [
            'category' => 'required|string|max:50',
            'description' => 'required|nullable|string',
        ]);

        try{
            $categories = Category::findOrFail($id);
            $categories->update([
                'category' => $request->category,
                'description' => $request->description
            ]);
            return redirect('/category')->with(['success' => 'Category: ' . $categories->category . ' Updated']);
        }catch(Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();
        return redirect()->back()->with(['success' => 'Category: ' . $categories->category . ' Deleted']);
    }
}
