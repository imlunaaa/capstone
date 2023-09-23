<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndicatorCategory;

class IndicatorCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = IndicatorCategory::select()->get();
        return view('admin.indicator_category_list')->with('categories', $categories);
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
        //

        $rules = [
            'category_name'=>'required',
        ];

        $customMessage = [
            'required'=>'Category Name must not be empty',

        ];
        $this->validate($request, $rules, $customMessage);
        $category_name = $request->input('category_name');
        $category = new IndicatorCategory();
        $category->category_name = $category_name;
        $category->save();
        if ($category) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Indicator category added successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = IndicatorCategory::select()->where('id', $id)->first();
        return view('admin.edit_indicator_category')->with('category', $category);
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
        //
        $rules = [
            'category_name'=>'required',
        ];

        $customMessage = [
            'required'=>'Category Name must not be empty',

        ];
        $this->validate($request, $rules, $customMessage);
        $category_name = $request->input('category_name');
        $category = IndicatorCategory::find($id);
        $category->category_name = $category_name;
        $category->updated_at = NOW();
        $category->save();
        if ($category) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Indicator category updated successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect('/indicator_category_list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = IndicatorCategory::find($id);
        if ($category) {
            // Add a flash message to indicate successful deletion
            $category->delete();
            session()->flash('success', 'Indicator category deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect('/indicator_category_list');
    }
}
