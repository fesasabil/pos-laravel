<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use File;
use Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'DESC')->paginate(10);
        $categories = Category::all();
        return view('Product.index', compact('products', 'categories'));
    }

    public function create()
    {
        $products = Product::all();
        $categories = Category::orderBy('category', 'ASC')->get();
        return view('Product.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        //form validate
        $this->validate($request, [
            'code' => 'required|string|max:10|unique:products',
            'name' => 'required|string|max:50',
            'description' => 'required|string|nullable|max:100',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'mimes:jpg,png,jpeg|nullable',
        ]);

        try{
            $photo = null;
            if($request->hasFile('photo')) {
                $photo = $this->saveFile($request->name, $request->file('photo'));
            }

            $product = Product::create([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'photo' => $photo,
            ]);
            return redirect(route('product.index'))->with('success', 'Product ' . $product->name . ' Added');
        }catch(Exception $e){
            return redirect()->back()->with(['Error' => $e->getMessage()]);
        }
    }

    private function saveFile($name, $photo)
    {
        $images = str_slug($name) . time() . '.' . $photo->getClientOriginalExtension();
        $path = public_path('uploads/product');

        if(!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        Image::make($photo)->save($path . '/' .$images);
        return $images;
    }

    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        if(!empty($products->photo)) {
            File::delete(public_path('uploads/product/' . $products->photo));
        }
        $products->delete();
        return redirect()->back()->with(['success', 'Product ' . $products->name . ' Deleted']);

    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('category', 'ASC')->get();
        return view('Product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        //form validate
        $this->validate($request, [
            'code' => 'required|string|max:10|unique:products',
            'name' => 'required|string|max:50',
            'description' => 'required|string|nullable|max:100',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'mimes:jpg,png,jpeg|nullable',
        ]);

        try{
            $product = Product::findOrFail($id);
            $photo = $product->photo;

            if($request->hasFile('photo')) {
                !empty($photo) ? File::delete(public_path('uploads/product/' . $products->photo)):null;
                $photo = $this->saveFile($request->name, $request->file('photo'));
            }

            $product = Product::update([
                'code' => $request->code,
                'name' => $request->name,
                'decription' => $request->description,
                'stock' => $request->stock,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'photo' => $photo,
            ]);
            return redirect(route('Product.index'))->with('success', 'Product ' . $product->name . ' Updated');
        }catch(Exception $e){
            return redirect()->back()->with(['Error' => $e->getMessage()]);
        }

    }
}
