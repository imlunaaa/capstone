<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ProgramLevel;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Accreditation;


class AccreditationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id = Auth::id();
        $programLevels = ProgramLevel::join('programs', 'program_levels.program_id', '=', 'programs.id')->join('campuses', 'program_levels.campus_id', '=', 'campuses.id')->select('program_levels.*', 'program_levels.id as plID',  'campuses.*', 'campuses.name AS cname', 'programs.program AS prog', 'programs.*')->get();
        $campuses = Campus::select()->get();
        $accreditations = [];
        if(Auth::user()->user_type == "admin"){
            $accreditations = Accreditation::join('program_levels', 'accreditations.program_level_id', '=', 'program_levels.id')->join('programs', 'program_levels.program_id', '=', 'programs.id')->join('campuses', 'program_levels.campus_id', '=', 'campuses.id')->select('program_levels.*', 'program_levels.id as plID', 'program_levels.level as prog_level',  'campuses.*', 'campuses.name AS cname', 'programs.program AS prog', 'programs.*', 'accreditations.*')->get();
        }else{
            $accreditations = Accreditation::join('program_levels', 'accreditations.program_level_id', '=', 'program_levels.id')->join('programs', 'program_levels.program_id', '=', 'programs.id')->join('campuses', 'program_levels.campus_id', '=', 'campuses.id')->join('members', 'accreditations.id', '=', 'members.accreditation_id')->select('program_levels.*', 'program_levels.id as plID', 'program_levels.level as prog_level',  'campuses.*', 'campuses.name AS cname', 'programs.program AS prog', 'programs.*', 'accreditations.*')->where('members.user_id', $user_id)->get();
        }
        
        return view('admin.manage_accreditation')->with('accreditations', $accreditations)->with('programLevels', $programLevels)->with('campuses', $campuses);
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
            'accreditation_name' => 'required',
            'program' => 'required',
            'acc_type' => 'required',
            'inter_date_start' => 'required|before:inter_date_end|date',
            'inter_date_end' => 'required|after:inter_date_start|date',
            'exter_date_start' => 'required|after:inter_date_end|before:exter_date_end|date',
            'exter_date_end' => 'required|after:exter_date_start|date',
        ];

        $customMessages = [
            'required' => '*This field is required.',
            'date' => '*This field must be a valid date.',
            'before' => '*The :attribute must be before :date.',
            'after' => '*The :attribute must be after :date.',
        ];

        $attributes = [
            'inter_date_start' => 'Internal Accreditaion Start Date',
            'inter_date_end' => 'Internal Accreditaion End Date',
            'exter_date_start' => 'External Accreditaion Start Date',
            'exter_date_end' => 'External Accreditaion End Date',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);
        $validator->setAttributeNames($attributes);

        if ($validator->fails()) {
            // Handle validation failure
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $acc_name = $request->input('accreditation_name');
        $program = $request->input('program');
        $acc_type = $request->input('acc_type');
        $inter_date_start = $request->input('inter_date_start');
        $inter_date_end = $request->input('inter_date_end');
        $exter_date_start = $request->input('exter_date_start');
        $exter_date_end = $request->input('exter_date_end');
        $accreditation = new Accreditation();
        $accreditation->accreditation_name = $acc_name;
        $accreditation->program_level_id = $program;
        $accreditation->accreditation_type = $acc_type;
        $accreditation->internal_accreditation_date_start = $inter_date_start;
        $accreditation->internal_accreditation_date_end = $inter_date_end;
        $accreditation->external_accreditation_date_start = $exter_date_start;
        $accreditation->external_accreditation_date_end = $exter_date_end;
        $accreditation->save();

        if ($accreditation) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Accretitation added successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        $accreditation_id = $accreditation->id;
        return redirect()->route('admin.manage_member.show', ['id'=>$accreditation_id]);

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
        $accreditation = Accreditation::find($id);
        if($accreditation)
        {
            $accreditation->delete();
            session()->flash('success', 'Accreditation deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Program not found.');
        }
        return redirect()->back();
    }
}
