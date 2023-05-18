<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id')->simplePaginate(15);
        return view('dashboard.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'icon' => 'required|string',
            'description' => 'string|required',
            'image' => 'nullable|image|mimes:jpg,png',
            'price' => 'required|string',
            'status' => 'in:1,0',
        ]);

        Product::create($request->all());
        $products = new Product();
        if($request->has('image')){
            $cover = $request->file('image');
            $imagename = time().$products->name.'.'.$cover->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('Categories',$cover,['disk'=>'public']);
            $products->image = $imagename;
        }

        return redirect()->route('products.index')->with('success', 'product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $products = Product::findOrFail($id);
        return view('dashboard.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $products = Product::findOrFail($id);
        return view('dashboard.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'icon' => 'required|string',
            'description' => 'string|required',
            'image' => 'nullable|image|mimes:jpg,png',
            'price' => 'required|string',
            'status' => 'in:1,0',
        ]);

        $updated = Product::whereId($id)->update($validatedData);

        Product::create($request->all());
        $products = new Product();
        if($request->has('image')){
            $cover = $request->file('image');
            $imagename = time().$products->name.'.'.$cover->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('products',$cover,['disk'=>'public']);
            $products->image = $imagename;
        }

        if ($updated) {
            return redirect()->route('products.index')->with('success', 'product created successfully');
        } else {
            return HttpResponse::HTTP_BAD_REQUEST;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleted = Product::findOrFail($id)->delete();

        if ($deleted) {
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } else {
            return HttpResponse::HTTP_BAD_REQUEST;
        }
    }
}
