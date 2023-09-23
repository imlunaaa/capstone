<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Area;
use DB;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        //$parameters = Parameter::join('areas', 'parameters.area_id', '=', 'areas.id')->Select('parameters.id AS paramID', 'parameters.*', 'areas.*')->where('areas.id', $aid)->OrderBy('parameters.parameter')
        $user_id = Auth::id();
        // $parameters = Parameter::join('areas', 'parameters.area_id', '=', 'areas.id')->Select('parameters.id AS paramID', 'parameters.*', 'areas.*')->OrderBy('areas.area_name')->OrderBy('parameters.parameter')->when($request->area, function ($query) use ($request) {
        //         $query->where('area_id', $request->area);
        //     })->paginate(10);
        $areas = Area::select()->OrderBy('area_name')->where('id', $id)->first();
        $parameters = Parameter::join('areas', 'parameters.area_id', '=', 'areas.id')->Select('parameters.id AS paramID', 'parameters.*', 'areas.*')->OrderBy('areas.area_name')->OrderBy('parameters.parameter')->where('area_id', $id)->paginate(10);
        
        if(Auth::user()->user_type == 'admin'){
            return view('admin.parameter_list')->with('parameters', $parameters)->with('areas', $areas)->with('request', $request);
        }
        if(Auth::user()->user_type == 'user' || Auth::user()->isAreamember == 1){
            return view('area chair.parameters')->with('parameters', $parameters)->with('areas', $areas)->with('request', $request);
        }
        
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
            'area'=>'required',
            'parameter'=>'required',
            'parametertitle'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $area = $request->input('area');
        $parametername = $request->input('parameter');
        $parametertitle = $request->input('parametertitle');
        $parameter = new Parameter();
        $parameter->area_id = $area;
        $parameter->parameter = $parametername;
        $parameter->parameter_title = $parametertitle;
        $parameter->save();
        if ($parameter) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Parameter added successfully.');
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
        $parameter = DB::Select('SELECT * FROM parameters WHERE id = ?', [$id]);
        $areas = Area::select()->get();
        return view('admin.edit_parameter')->with('parameter', $parameter)->with('areas', $areas);
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
            'area'=>'required',
            'parameter'=>'required',
            'parametertitle'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $area = $request->input('area');
        $parametername = $request->input('parameter');
        $parametertitle = $request->input('parametertitle');
        $parameter = Parameter::find($id);
        $parameter->area_id = $area;
        $parameter->parameter = $parametername;
        $parameter->parameter_title = $parametertitle;
        $parameter->updated_at = NOW();
        $parameter->save();
        if ($parameter) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Updated successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect('/parameter_list');
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
        $parameter= Parameter::find($id);
        if ($parameter) {
            $parameter->delete();
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Parameter deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Parameter not found.');
        }

        return redirect()->back();
    }
}
