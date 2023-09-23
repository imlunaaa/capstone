<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use DB;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $programs = Program::select()->get();
        return view('admin.program_list')->with('programs', $programs);
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
            'program'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        
        $pname = $request->input('program');
        $program = new Program;
        $program->id = null;
        $program->program = $pname;
        $program->save();
        if ($program) {
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
        $program = DB::select('SELECT * FROM programs WHERE id = ?', [$id]);
        return view('admin.edit_program')->with('program', $program);;
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
            'program'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $pname = $request->input('program');
        $program = DB::update('UPDATE programs SET program = ?, updated_at = ? WHERE id = ?', [$pname, NOW(), $id]);
        if ($program) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Update successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect('/program_list');
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
        $program = Program::find($id);
        if ($program) {
            $program->delete();
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Program deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Program not found.');
        }

        return redirect()->back();
    }
}
