<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubIndicatorComponent;

class SubComponentController extends Controller
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
            'subcomponent'=>'required',
            'subcomponentdesc'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $parameter_id = $request->input('parameter_id');
        $subindicator_id = $request->input('sub_indicator_id');
        $subcomponent_name = $request->input('subcomponent');
        $subcomponentdesc = $request->input('subcomponentdesc');
        $subcomponent = new SubIndicatorComponent;
        $subcomponent->parameter_id = $parameter_id;
        $subcomponent->sub_indicator_id = $subindicator_id;
        $subcomponent->component_name = $subcomponent_name;
        $subcomponent->component_desc = $subcomponentdesc;
        $subcomponent->save();
        if($subcomponent) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Sub Indicator Component added successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        };
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
    public function edit($id, $pid)
    {
        //
        $subcomponent = SubIndicatorComponent::select()->where('id', $id)->first();
        return view('admin.edit_sub_component')->with('subcomponent', $subcomponent)->with('parameter_id', $pid);
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
            'subcomponent'=>'required',
            'subcomponentdesc'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $parameter_id = $request->input('parameter_id');
        $subcomponent_name = $request->input('subcomponent');
        $subcomponentdesc = $request->input('subcomponentdesc');
        $subcomponent = SubIndicatorComponent::find($id);
        $subcomponent->component_name = $subcomponent_name;
        $subcomponent->component_desc = $subcomponentdesc;
        $subcomponent->updated_at = NOW();
        $subcomponent->save();
        if($subcomponent) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Sub Indicator Component updated successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        };
        return redirect()->route('admin.view_indicator.index', ['id' => $parameter_id]);
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
        $subcomponent = SubIndicatorComponent::find($id);
        if($subcomponent) {
            // Add a flash message to indicate successful deletion
            $subcomponent->delete();
            session()->flash('success', 'Sub Indicator Component deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        };
        return redirect()->back();
    }
}
