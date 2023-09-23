<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campus;
use DB;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $campuses = Campus::select()->get();
        return view('admin.campus_list')->with('campuses', $campuses);
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
            'campus'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        
        $cname = $request->input('campus');
        $campus = new Campus;
        $campus->id = null;
        $campus->name = $cname;
        $campus->save();
        if ($campus) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Campus added successfully.');
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
        $campus = DB::select('SELECT * FROM campuses WHERE id = ?', [$id]);
        return view('admin.edit_campus')->with('campus', $campus);;
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
            'campus'=>'required',

        ];

        $customMessage = [
            'required'=>':attribute must be filled',

        ];
        $this->validate($request, $rules, $customMessage);
        $cname = $request->input('campus');
        $campus = DB::update('UPDATE campuses SET name = ?, updated_at = ? WHERE id = ?', [$cname, NOW(), $id]);
        if ($campus) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Update successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect('/campus_list');

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
        $campus = Campus::find($id);
        if ($campus) {
            $campus->delete();
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Campus deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Campus not found.');
        }

        return redirect()->back();
    }
}
