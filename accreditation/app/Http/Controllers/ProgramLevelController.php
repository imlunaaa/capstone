<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Campus;
use App\Models\ProgramLevel;
use App\Rules\ProgramRule;
use DB;

class ProgramLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $programs = Program::select()->OrderBy('program')->get();
        $campuses = Campus::select()->OrderBy('name')->get();
        $programLevels = ProgramLevel::join('programs', 'program_levels.program_id', '=', 'programs.id')->join('campuses', 'program_levels.campus_id', '=', 'campuses.id')->select('program_levels.*', 'program_levels.id as plID',  'campuses.*', 'campuses.name AS cname', 'programs.program AS prog', 'programs.*')->when($request->area, function ($query) use ($request) {
                $query->where('campus_id', $request->area);})->paginate(10);

        return view('admin.program_level_list')->with('campuses', $campuses)->with('programs', $programs)->with('programLevels', $programLevels)->with('request', $request);
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
        $campus_id = $request->input('campus');
        $program_id = $request->input('program');
        $cid = DB::table('program_levels')->where('campus_id', $campus_id)->value('campus_id');
        $pid = DB::table('program_levels')->where('program_id', $program_id)->value('program_id');
        $level = $request->input('level');
        $validity_from = $request->input('validity_from');
        $validity_to = $request->input('validity_to'); 
        $rules = [
            'program'=>['required', new ProgramRule($campus_id, $pid, $cid)],
            'campus'=>'required',
            'level'=>'required',
            'validity_from'=>'required|date|before:validity_to',
            'validity_to'=>'required|date|after:validity_from',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',
            'date'=>':attribute must a date',
            'validity_from.after'=> 'Please choose a date in the future',
            'validity_from.before'=> 'Please choose a date before the validity to date',


        ];

        $this->validate($request, $rules, $customMessage);

        $programLevel = new ProgramLevel();
        $programLevel->campus_id = $campus_id;
        $programLevel->program_id = $program_id;
        $programLevel->level = $level;
        $programLevel->validity_from = $validity_from;
        $programLevel->validity_to = $validity_to;
        $programLevel->save();
        if ($programLevel) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Program added successfully.');
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
        $programs = Program::select()->get();
        $campuses = Campus::select()->get();
        $programLevel = ProgramLevel::select()->where('id', $id)->get();
        return view('admin.edit_program_level')->with('campuses', $campuses)->with('programs', $programs)->with('programLevel', $programLevel);
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
        $campus_id = $request->input('campus');
        $program_id = $request->input('program');
        $level = $request->input('level');
        $validity_from = $request->input('validity_from');
        $validity_to = $request->input('validity_to'); 
        $rules = [
            'program'=>'required',
            'campus'=>'required',
            'level'=>'required',
            'validity_from'=>'required|date',
            'validity_to'=>'required|date',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',
            'date'=>':attribute must a date',

        ];

        $this->validate($request, $rules, $customMessage);

        $programLevel = ProgramLevel::find($id);
        $programLevel->campus_id = $campus_id;
        $programLevel->program_id = $program_id;
        $programLevel->level = $level;
        $programLevel->validity_from = $validity_from;
        $programLevel->validity_to = $validity_to;
         $programLevel->updated_at = NOW();
        $programLevel->save();
        if ($programLevel) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Program Level update successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect('/program_level_list');
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
        $programLevel= ProgramLevel::find($id);
        if ($programLevel) {
            $programLevel->delete();
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Program Level deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Program not found.');
        }

        return redirect()->back();
    }
}
