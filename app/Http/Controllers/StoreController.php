<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::orderBy('id')->simplePaginate(15);
        return view('dashboard.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.stores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'location' => 'required|string',
            'description' => 'string|required',
            'image' => 'nullable|image|mimes:jpg,png',
            'status' => 'in:1,0',
        ]);

        Store::create($request->all());
        $store = new Store();
        if($request->has('image')){
            $cover = $request->file('image');
            $imagename = time().$store->name.'.'.$cover->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('Stores',$cover,['disk'=>'public']);
            $store->image = $imagename;
        }


        return redirect()->route('stores.index')->with('success', 'store created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stores = Store::findOrFail($id);
        return view('dashboard.stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stores = Store::findOrFail($id);
        return view('dashboard.stores.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'location' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'status' => 'in:1,0',
            'image' => 'nullable|image|mimes:jpg,png'
        ]);

        $updated = Store::whereId($id)->update($validatedData);
        $stores = new Store();

        if($request->has('image')){
            $cover = $request->file('image');
            $imagename = time().$stores->name.'.'.$cover->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('stores',$cover,['disk'=>'public']);
            $stores->image = $imagename;
        }
        if ($updated) {
            return redirect()->route('stores.index')->with('success', 'Store updated successfully');
        } else {
            return HttpResponse::HTTP_BAD_REQUEST;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleted = Store::findOrFail($id)->delete();

        if ($deleted) {
            return redirect()->route('stores.index')->with('success', 'Store deleted successfully');
        } else {
            return HttpResponse::HTTP_BAD_REQUEST;
        }
    }
}
