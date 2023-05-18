<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::orderBy('id')->simplePaginate(15);
        return view('dashboard.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'symbol' => 'nullable|image|mimes:jpg,png',
            'status' => 'in:1,0',
        ]);

        Currency::create($request->all());
        $currency = new Currency();
        if($request->has('symbol')){
            $cover = $request->file('symbol');
            $imagename = time().$currency->name.'.'.$cover->getClientOriginalExtension();
            $request->file('symbol')->storePubliclyAs('Currencies',$cover,['disk'=>'public']);
            $currency->symbol = $imagename;
        }

        return redirect()->route('currencies.index')->with('success', 'currency created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('dashboard.currencies.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        return view('dashboard.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'symbol' => 'nullable|image|mimes:jpg,png',
            'status' => 'in:1,0',
        ]);

        $updated = Currency::whereId($id)->update($validatedData);

        Currency::create($request->all());
        $currency = new Currency();
        if($request->has('symbol')){
            $cover = $request->file('symbol');
            $imagename = time().$currency->name.'.'.$cover->getClientOriginalExtension();
            $request->file('symbol')->storePubliclyAs('Currencies',$cover,['disk'=>'public']);
            $currency->symbol = $imagename;
        }
        if ($updated) {
            return redirect()->route('currencies.index')->with('success', 'currency created successfully');
        } else {
            return HttpResponse::HTTP_BAD_REQUEST;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleted = Currency::findOrFail($id)->delete();

        if ($deleted) {
            return redirect()->route('Currencies.index')->with('success', 'Currency deleted successfully');
        } else {
            return HttpResponse::HTTP_BAD_REQUEST;
        }
    }
}
