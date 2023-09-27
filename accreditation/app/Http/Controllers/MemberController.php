<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Accreditation;
use App\Models\Member;
use App\Models\AreaMember;
use App\Models\User;
use App\Models\Area;
use App\Models\AccreditationArea;
use DB;
use Session;
use Log;

class Roles
{
    public $isCoordinator;
    public $isExternal;
    public $isInternal;
}

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        // $members = Member::join()->select()->where('accreditation_id', $id);
        // return view('admin.manage_user')->with('members', $members)->with('id', $id);
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
            'members'=>'required',
        ];

        $customMessage = [
            'required'=>'select a user to add',
        ];

        $this->validate($request, $rules, $customMessage);

        $acc_members = $request->input('members');
        $acc_id = $request->input('acc_id');

        $members = new Member();
        foreach($acc_members AS $member)
        {
            $members = DB::insert('INSERT INTO `members` (`accreditation_id`, `user_id`, `created_at`, `updated_at`) VALUES ( ?, ?, ?, ?)', [ $acc_id, $member, NOW(), NOW()]);
        }
        if ($members) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Member/s added successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.manage_member.show', ['id'=>$acc_id]);
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
        $uid = Auth::user()->id; // Assuming 'id' is the user identifier
        Log::info("User ID: $uid");

        $members = Member::join('users', 'members.user_id',  '=', 'users.id')
        ->select('users.firstname AS fname', 'users.lastname AS lname', 'members.user_id AS uid', 'members.id AS mid', 'users.*', 'members.*')
        ->where('accreditation_id', $id)
        ->OrderBy('lastname')
        ->get();

        $users = DB::table('users')
        ->select('users.*', 'users.id as user_id', 'campuses.id as campus_id', 'campuses.name as campus_name', 'programs.program as program')
        ->join('campuses', 'users.campus_id', '=', 'campuses.id')
        ->join('programs', 'users.program_id', '=', 'programs.id')
        ->where('user_type', '!=', 'admin')
        ->whereNotExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                ->from('members')
                ->whereRaw('members.user_id = users.id')
                ->where('accreditation_id', '=', $id);
        })
        ->orderBy('lastname', 'ASC')
        ->get();



        $accreditation = Accreditation::join('program_levels', 'accreditations.program_level_id', '=', 'program_levels.id')->join('programs', 'program_levels.program_id', '=', 'programs.id')->select('programs.id as prog_id', 'accreditations.*')->where('accreditations.id', $id)->first();

        $acc_areas = Area::join('instruments', 'areas.instrument_id', '=', 'instruments.id')
        ->join('programs', 'instruments.program_id', '=', 'programs.id')
        ->join('accreditation_areas', 'areas.id', '=', 'accreditation_areas.area_id')
        ->select('areas.*', 'areas.id as aid', 'instruments.*', 'accreditation_areas.id as acc_areaId')
        ->where('instruments.program_id', $accreditation->prog_id)
        ->where('accreditation_areas.accreditation_id', $id)
        ->OrderBy('areas.area_name')
        ->get();
        $acc_areasId = $acc_areas->pluck('id');

        
        $areas = Area::join('instruments', 'areas.instrument_id', '=', 'instruments.id')
        ->join('programs', 'instruments.program_id', '=', 'programs.id')
        ->leftJoin('accreditation_areas', function ($join) use ($id) {
            $join->on('areas.id', '=', 'accreditation_areas.area_id')
                ->where('accreditation_areas.accreditation_id', $id);
        })
        ->select('areas.*', 'areas.id as aid', 'instruments.*', 'accreditation_areas.id as acc_areaId')
        ->where('instruments.program_id', $accreditation->prog_id)
        ->whereNull('accreditation_areas.id') // Exclude areas that have an entry in accreditation_areas
        ->orderBy('areas.area_name')
        ->get();


        $roles = (object) array(
            'isCoordinator' => 0,
            'isExternal' => 0,
            'isInternal' => 0,
        );

        if (Auth::user()->user_type == 'user') {
            $member = Member::select()->where('user_id', $uid)->first();

            //dd($member);
            
            if ($member) {
                Log::info("Member found: isCoordinator=$member->isCoordination, isExternal=$member->isExternal, isInternal=$member->isInternal");
                $roles->isCoordinator = $member->isCoordinator;
                $roles->isExternal = $member->isExternal;
                $roles->isInternal = $member->isInternal;
            } else {
                Log::info("Member not found for user ID: $uid");
            }
        }


        $area_members = AreaMember::join('users', 'area_members.user_id', '=', 'users.id')
        ->select('users.firstname AS fname', 'users.lastname AS lname', 'users.*', 'area_members.*', 'area_members.id as amId')
        ->where('area_members.accreditation_id', $id)
        ->get();

        $unfilteredUser = User::join('campuses', 'users.campus_id', '=', 'campuses.id')
        ->join('programs', 'users.program_id', '=', 'programs.id')
        ->select('users.*', 'users.id as user_id', 'campuses.id as campus_id', 'campuses.name as campus_name', 'programs.program as program')
        ->where('user_type', '!=', 'admin')
        ->get();


        return view('admin.manage_member')
        ->with('members', $members)
        ->with('id', $id)
        ->with('users', $users)
        ->with('roles', $roles)
        ->with('acc_areas', $acc_areas)
        ->with('areas', $areas)
        ->with('unfilteredUser', $unfilteredUser)
        ->with('area_members',$area_members)
        ->with('accreditation', $accreditation);
    }

    public function addArea(Request $request)
    {
        $id = $request->input('acc_id');
        $areas = $request->input('area');
        foreach($areas as $area)
        {
            $accArea = new AccreditationArea;
            $accArea->accreditation_id=$id;
            $accArea->area_id =$area;
            $accArea->save();
        }
        if ($accArea) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Area Added successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.manage_member.show', ['id' => $id]);
    }
    public function removeArea($id)
    {
        $area = AccreditationArea::find($id);
        if ($area) {
            // Add a flash message to indicate successful deletion
            $area->delete();
            session()->flash('success', 'Area Removed successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->back();
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
        $mid = $request->input('id');
        $member = Member::where('id', $id)->update([
            'isExternal' => $request->has('external') ? 1 : 0,
            'isInternal' => $request->has('internal') ? 1 : 0,
            'isCoordinator' => $request->has('coordinator') ? 1 : 0,
        ]);

        if ($member) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'Role updated successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.manage_member.show', ['id' => $mid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $member = Member::find($id);
        if($member){
            $member->delete();
            session()->flash('success', 'Member removed successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->back();

    }
}
