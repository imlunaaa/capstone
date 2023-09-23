<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Instrument;
use DB;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $areas = Area::select()->OrderBy('area_name')->where('instrument_id', $id)->get();
        $instrument = Instrument::join('programs', 'instruments.program_id', '=', 'programs.id')->select('programs.id as prog_id', 'instruments.id as ins_id', 'instruments.*', 'programs.*')->where('instruments.id', $id)->first();
        return view('admin.area_list')->with('areas', $areas)->with('instrument', $instrument);
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
            'areaname'=>'required',
            'areatitle'=>'required',
        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);

        $instrument_id = $request->input('instrument_id');
        $areaname = $request->input('areaname');
        $areatitle = $request->input('areatitle');
        $area = new Area();
        $area->id = null;
        $area->instrument_id = $instrument_id;
        $area->area_name = $areaname;
        $area->area_title = $areatitle;
        $area->save();
        if ($area) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Area added successfully.');
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
        $area = DB::select('SELECT * FROM areas WHERE id = ?', [$id]);
        return view('admin.edit_area')->with('area', $area);
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
            'areaname'=>'required',
            'areatitle'=>'required',
        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);

        $areaname = $request->input('areaname');
        $areatitle = $request->input('areatitle');
        $area = Area::find($id);
        $area->area_name = $areaname;
        $area->area_title = $areatitle;
        $area->updated_at = NOW();
        $area->save();
        if ($area) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Area Saved successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect('/area_list');
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
        $area = Area::find($id);
        if ($area) {
            $area->delete();
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Area deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Area not found.');
        }

        return redirect()->back();
    }
}
