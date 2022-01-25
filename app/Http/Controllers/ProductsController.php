<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = categories::all();
        $products = products::all();
        return view('products.products', compact('cats', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required||max:255',
            'cat_id'     =>  'required',
            'description' => 'required',

        ], [
            'product_name.required'   => 'أسم المنتج  مطلوب',
            'cat_id.required'     =>  'يرجي اختيار القسم',
            'description.required'  => 'يرجي ادخال وصف للمنتج'
        ]);
        products::insert([
            'product_name' => $request->product_name,
            'cat_id'       => $request->cat_id,
            'description'  => $request->description
        ]);
        session()->flash('Add', 'تم أضافه المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = categories::where('cat_name', $request->cat_name)->first()->id;
        $this->validate($request, [

            'product_name' => 'required|max:255,product_nmae,' . $id,
            'cat_name'     =>  'required',
            'description' => 'required',
        ], [

            'product_name.required'   => 'أسم المنتج مطلوب ',
            'cat_id.required'     =>  'يرجي اختيار القسم',
            'description.required'  => 'يرجي ادخال وصف للمنتج'

        ]);
        $product = products::findOrFail($request->id);
        $product->update([
            'product_name' => $request->product_name,
            //'cat_name'        => $request->cat_name,
            'description'  => $request->description,
            'cat_id'       => $id

        ]);
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        products::find($id)->delete();
        session()->flash('Delete', 'تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
