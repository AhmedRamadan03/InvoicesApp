<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = categories::all();
        return view('categories.categories', compact('categories'));
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
            'cat_name' => 'required|unique:categories|max:255',
            'description' => 'required',
        ], [
            'cat_name.unique'       => 'أسم القسم موجود مسبقا',
            'description.required'  => 'يرجي ادخال وصف للقسم'
        ]);
        categories::insert([
            'cat_name' => $request->cat_name,
            'description' => $request->description,
            'Created_by' => (Auth::user()->name)
        ]);

        session()->flash('Add', 'تم أضافه القسم بنجاح');
        return redirect('/categories');
        // $input = $request->all();

        // $b_exists = categories::where('cat_name', '=', $input['cat_name'])->exists();
        // if ($b_exists) {
        //     session()->flash('Error', ' خطأ القسم مسجل مسبقا');
        //     return redirect('/categories');
        // } else {
        //     categories::insert([
        //         'cat_name' => $request->cat_name,
        //         'description' => $request->description,
        //         'Created_by' => (Auth::user()->name)
        //     ]);
        //     session()->flash('Add', 'تم أضافه القسم بنجاح');
        //     return redirect('/categories');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [

            'cat_name' => 'required|max:255|unique:categories,cat_name,' . $id,
            'description' => 'required',
        ], [

            'cat_name.required' => 'يرجي ادخال اسم القسم',
            'cat_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال وصف للقسم',

        ]);
        $cat = categories::find($id);
        $cat->update([
            'cat_name'     => $request->cat_name,
            'description'  => $request->description,
            'Created_by' => (Auth::user()->name)
        ]);

        session()->flash('Edit', 'تم تعديل القسم بنجاح');
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        categories::find($id)->delete();
        session()->flash('Delete', 'تم حذف القسم بنجاح');
        return redirect('/categories');
    }
}
