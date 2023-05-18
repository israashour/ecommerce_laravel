<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id')->simplePaginate(15);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'string|required',
            'icon' => 'nullable|image|mimes:jpg,png',
            'status' => 'in:1,0',
        ]);

        Category::create($request->all());
        $category = new Category();
        if($request->has('icon')){
            $cover = $request->file('icon');
            $imagename = time().$category->name.'.'.$cover->getClientOriginalExtension();
            $request->file('icon')->storePubliclyAs('Categories',$cover,['disk'=>'public']);
            $category->image = $imagename;
        }

        return redirect()->route('categories.index')->with('success', 'category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'string|required',
            'icon' => 'nullable|image|mimes:jpg,png',
            'status' => 'in:1,0',
        ]);

        $updated = Category::whereId($id)->update($validatedData);

        Category::create($request->all());
        $category = new Category();
        if($request->has('image')){
            $cover = $request->file('image');
            $imagename = time().$category->name.'.'.$cover->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('Categories',$cover,['disk'=>'public']);
            $category->image = $imagename;
        }

        if ($updated) {
            return redirect()->route('categories.index')->with('success', 'category created successfully');
        } else {
            return HttpResponse::HTTP_BAD_REQUEST;
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleted = Category::findOrFail($id)->delete();

        if ($deleted) {
            return redirect()->route('categroies.index')->with('success', 'Category deleted successfully');
        } else {
            return HttpResponse::HTTP_BAD_REQUEST;
        }
    }
}
