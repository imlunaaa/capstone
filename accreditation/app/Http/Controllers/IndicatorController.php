<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Indicator;
use App\Models\SubIndicator;
use App\Models\SubIndicatorComponent;
use App\Models\IndicatorCategory;
use App\Models\Area;
use DB;

class IndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $parameters = Parameter::select()->get();
        $param = Parameter::select()->where('id', $id)->first();
        $indicators = Indicator::select()->where('parameter_id', $id)->OrderBy('indicator_name')->get();
        $counter = Indicator::select()->where('parameter_id', $id)->where('indicator_category_id', 4)->count();
        $subindicators = SubIndicator::select()->get();
        $subcomponents = SubIndicatorComponent::select()->get();
        $categories = IndicatorCategory::select()->get();
        $areas = Area::select()->get();
        if(Auth::user()->user_type == "admin"){
            return view('admin.view_indicator')->with('parameters', $parameters)->with('param', $param)->with('indicators', $indicators)->with('id', $id)->with('subindicators', $subindicators)->with('subcomponents', $subcomponents)->with('categories', $categories)->with('areas'. $areas)->with('counter', $counter);
        }
        if(Auth::user()->user_type == "user"){
            return view('area chair.view_indicator_areachair')->with('parameters', $parameters)->with('param', $param)->with('indicators', $indicators)->with('id', $id)->with('subindicators', $subindicators)->with('subcomponents', $subcomponents)->with('categories', $categories)->with('areas'. $areas)->with('counter', $counter);
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
            'indicator'=>'required',
            'indicatordesc'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $parameter_id = $request->input('parameter_id');
        $category_id = $request->input('category');
        $indicator_name = $request->input('indicator');
        $indicatordesc = $request->input('indicatordesc');
        $indicator = new Indicator();
        $indicator->parameter_id = $parameter_id;
        $indicator->indicator_category_id = $category_id;
        $indicator->indicator_name = $indicator_name;
        $indicator->indicator_desc = $indicatordesc;
        $indicator->save();
        if ($indicator) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Indicator added successfully.');
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
        $categories = IndicatorCategory::select()->get();
        $indicator = DB::Select('SELECT * FROM indicators WHERE id = ?', [$id]);
        return view('admin.edit_indicator')->with('indicator', $indicator)->with('id', $id)->with('categories', $categories);
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
            'indicator'=>'required',
            'indicatordesc'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $parameter_id = $request->input('parameter_id');
        $category_id = $request->input('category');
        $indicator_name = $request->input('indicator');
        $indicatordesc = $request->input('indicatordesc');
        $indicator = Indicator::find($id);
        $indicator->indicator_category_id = $category_id;
        $indicator->indicator_name = $indicator_name;
        $indicator->indicator_desc = $indicatordesc;
        $indicator->updated_at = NOW();
        $indicator->save();
        if ($indicator) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Indicator updateds successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.view_indicator.index', ['id' => $indicator->parameter_id]);
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
        $indicator= Indicator::find($id);
        if ($indicator) {
            $indicator->delete();
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Indicator deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Indicator not found.');
        }

        return redirect()->back();
    }
}
