<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubIndicator;
use DB;

class SubIndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'subindicator'=>'required',
            'subindicatordesc'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $parameter_id = $request->input('parameter_id');
        $indicator_id = $request->input('indicator_id');
        $subindicator_name = $request->input('subindicator');
        $subindicatordesc = $request->input('subindicatordesc');
        $subindicator = new SubIndicator;
        $subindicator->parameter_id = $parameter_id;
        $subindicator->indicator_id = $indicator_id;
        $subindicator->sub_indicator_name = $subindicator_name;
        $subindicator->sub_indicator_desc = $subindicatordesc;
        $subindicator->save();
        if ($subindicator) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Sub Indicator added successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.view_indicator.index', ['id' => $parameter_id]);
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
    public function edit($id, $pid)
    {
        //
        $subindicator = SubIndicator::select()->where('id', $id)->first();
        return view('admin.edit_sub_indicator')->with('subindicator', $subindicator)->with('parameter_id', $pid);
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
            'subindicator'=>'required',
            'subindicatordesc'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $parameter_id = $request->input('parameter_id');
        $subindicator_name = $request->input('subindicator');
        $subindicatordesc = $request->input('subindicatordesc');
        $subindicator = SubIndicator::find($id);
        $subindicator->sub_indicator_name = $subindicator_name;
        $subindicator->sub_indicator_desc = $subindicatordesc;
        $subindicator->updated_at = NOW();
        $subindicator->save();
        if ($subindicator) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Sub Indicator updated successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.view_indicator.index', ['id' => $parameter_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($action, $id)
    {
        //
        $subindicator = SubIndicator::find($id);
        if($subindicator){
            $subindicator->delete();
            session()->flash('success', 'Sub Indicator Deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->back();
    }
}
